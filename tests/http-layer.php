<?php
// Namespace-local cURL mocks intercept every SDK transport call. No sockets are opened.
namespace ClouDNS {
    // Permit mock-only runs without ext-curl, including a minimal PHP 5.3 CLI.
    foreach (array('CURLOPT_SSL_VERIFYPEER' => 64, 'CURLOPT_RETURNTRANSFER' => 19913,
        'CURLOPT_URL' => 10002, 'CURLOPT_POST' => 47, 'CURLOPT_POSTFIELDS' => 10015,
        'CURLOPT_CONNECTTIMEOUT' => 78, 'CURLOPT_TIMEOUT' => 13,
        'CURLINFO_HTTP_CODE' => 2097154) as $name => $value) {
        if (!defined($name)) { define($name, $value); }
    }
    class MockHttp {
        public static $body = '{"status":"Success"}';
        public static $errno = 0;
        public static $status = 200;
        public static $initFailure = false;
        public static $optionFailure = false;
        public static $last;
        public static $executions = 0;
    }
    function curl_init() {
        if (MockHttp::$initFailure) { return false; }
        $handle = new \stdClass();
        $handle->options = array();
        $handle->closed = false;
        MockHttp::$last = $handle;
        return $handle;
    }
    function curl_setopt($handle, $option, $value) {
        $handle->options[$option] = $value;
        return !MockHttp::$optionFailure;
    }
    function curl_setopt_array($handle, $options) {
        foreach ($options as $option => $value) {
            if (!curl_setopt($handle, $option, $value)) { return false; }
        }
        return true;
    }
    function curl_exec($handle) { MockHttp::$executions++; return MockHttp::$body; }
    function curl_errno($handle) { return MockHttp::$errno; }
    function curl_getinfo($handle, $option) {
        if ($option !== CURLINFO_HTTP_CODE) { throw new \Exception('Unexpected cURL info'); }
        return MockHttp::$status;
    }
    function curl_close($handle) { $handle->closed = true; }
}
namespace {
    use ClouDNS\MockHttp;
    $snapshotMode = isset($argv[1]) && $argv[1] === '--snapshot-original';
    require $snapshotMode ? $argv[2] : dirname(__DIR__) . '/ClouDNS_SDK.php';
    error_reporting(E_ALL);
    set_error_handler(function ($severity, $message, $file, $line) {
        throw new \ErrorException($message, 0, $severity, $file, $line);
    });
    $checks = 0;
    function same($expected, $actual, $label) {
        global $checks;
        $checks++;
        if ($expected !== $actual) {
            throw new \Exception($label . ': expected ' . var_export($expected, true) . ', got ' . var_export($actual, true));
        }
    }
    function errorField($sdk, $key) { $error = $sdk->getLastError(); return $error[$key]; }
    function test($name, $callback) { $callback(); echo 'PASS ' . $name . "\n"; }
    function signature($method) {
        $parameters = array();
        foreach ($method->getParameters() as $p) {
            $parameters[] = array('name' => $p->getName(), 'optional' => $p->isOptional(),
                'default' => $p->isDefaultValueAvailable() ? $p->getDefaultValue() : null,
                'reference' => $p->isPassedByReference());
        }
        return $parameters;
    }
    function argumentsFor($method, $all) {
        $args = array();
        foreach ($method->getParameters() as $p) {
            if ($p->isOptional() && !$all) { break; }
            $name = $p->getName();
            $args[] = (in_array($name, array('ns', 'nameservers')) || ($name === 'tld' && $method->getName() === 'domainCheckAvailability'))
                ? array('ns1.example.invalid', 'ns2.example.invalid') : 'value&+= %/тест';
        }
        return $args;
    }
    function requestSnapshot() {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy');
        $class = new \ReflectionClass($sdk);
        $result = array('signatures' => array(), 'requests' => array());
        foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $name = $method->getName();
            if (in_array($name, array('setTimeouts', 'getLastError'))) { continue; }
            $result['signatures'][$name] = signature($method);
            if ($name === '__construct') { continue; }
            foreach (array(false, true) as $all) {
                $args = argumentsFor($method, $all);
                $response = $method->invokeArgs($sdk, $args);
                $result['requests'][$name . ($all ? ':all' : ':required')] = array(
                    'url' => MockHttp::$last->options[CURLOPT_URL],
                    'body' => MockHttp::$last->options[CURLOPT_POSTFIELDS], 'response' => $response);
            }
        }
        return $result;
    }
    if ($snapshotMode) {
        $snapshot = requestSnapshot();
        echo "{\n";
        $sectionSeparator = '';
        foreach ($snapshot as $section => $entries) {
            echo $sectionSeparator . '  ' . json_encode($section) . ": {\n";
            $separator = '';
            foreach ($entries as $name => $entry) {
                echo $separator . '    ' . json_encode($name) . ': ' . json_encode($entry);
                $separator = ",\n";
            }
            echo "\n  }";
            $sectionSeparator = ",\n";
        }
        echo "\n}\n";
        exit(0);
    }
    test('all original public signatures, request bodies, URLs and return values', function () {
        $baseline = json_decode(file_get_contents(__DIR__ . '/fixtures/public-api.json'), true);
        $current = requestSnapshot();
        foreach ($baseline['signatures'] as $name => $signature) {
            same($signature, $current['signatures'][$name], $name . ' signature');
        }
        foreach ($baseline['requests'] as $name => $request) {
            same($request, $current['requests'][$name], $name . ' request');
        }
    });
    test('credential encoding in all three authentication modes', function () {
        foreach (array(array('id&+= %é', false, 'auth-id'), array('123', true, 'sub-auth-id'),
                       array('user&+= %é', true, 'sub-auth-user')) as $mode) {
            $password = 'dummy&auth-id=999+ =%/парола';
            $sdk = new \ClouDNS\ClouDNS_SDK($mode[0], $password, $mode[1]);
            $sdk->apiLogin();
            parse_str(MockHttp::$last->options[CURLOPT_POSTFIELDS], $parsed);
            same(array($mode[2] => $mode[0], 'auth-password' => $password), $parsed, 'credentials round trip');
        }
    });
    test('default, custom and zero timeouts; TLS default and legacy opt-out', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy');
        $sdk->apiLogin();
        same(10, MockHttp::$last->options[CURLOPT_CONNECTTIMEOUT], 'default connect');
        same(60, MockHttp::$last->options[CURLOPT_TIMEOUT], 'default total');
        same(true, MockHttp::$last->options[CURLOPT_SSL_VERIFYPEER], 'TLS default');
        same(true, MockHttp::$last->options[CURLOPT_POST], 'POST');
        same(true, MockHttp::$last->options[CURLOPT_RETURNTRANSFER], 'return body');
        same($sdk, $sdk->setTimeouts(2, 7), 'fluent setter');
        $sdk->apiLogin();
        same(2, MockHttp::$last->options[CURLOPT_CONNECTTIMEOUT], 'custom connect');
        same(7, MockHttp::$last->options[CURLOPT_TIMEOUT], 'custom total');
        $sdk->setTimeouts(0, 0)->apiLogin();
        same(0, MockHttp::$last->options[CURLOPT_CONNECTTIMEOUT], 'zero connect');
        same(0, MockHttp::$last->options[CURLOPT_TIMEOUT], 'zero total');
        $legacy = new \ClouDNS\ClouDNS_SDK('123', 'dummy', false, false);
        $legacy->apiLogin();
        same(false, MockHttp::$last->options[CURLOPT_SSL_VERIFYPEER], 'explicit legacy opt-out');
    });
    test('operation encoding and repeated or empty array parameters are preserved', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy&+=');
        $sdk->dnsAddRecord('example.invalid', 'TXT', '', 'v=a&b+c=%25', 300);
        parse_str(MockHttp::$last->options[CURLOPT_POSTFIELDS], $parsed);
        same('v=a&b+c=%25', $parsed['record'], 'record encoded once');
        same('dummy&+=', $parsed['auth-password'], 'password with operation');
        $sdk->dnsRegisterDomainZone('example.invalid', 'master', array());
        same(true, strpos(MockHttp::$last->options[CURLOPT_POSTFIELDS], '&ns[]=') !== false, 'empty ns wire format');
        $sdk->dnsRegisterDomainZone('example.invalid', 'master', array('ns1.example.invalid', 'ns2.example.invalid'));
        parse_str(MockHttp::$last->options[CURLOPT_POSTFIELDS], $parsed);
        same(array('ns1.example.invalid', 'ns2.example.invalid'), $parsed['ns'], 'repeated ns values');
    });
    test('invalid timeout settings are rejected atomically', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy');
        foreach (array(-1, 1.5, '10', null, true, array()) as $invalid) {
            foreach (array(array($invalid, 5), array(5, $invalid)) as $values) {
                $thrown = false;
                try { $sdk->setTimeouts($values[0], $values[1]); }
                catch (\InvalidArgumentException $e) { $thrown = true; }
                same(true, $thrown, 'invalid timeout rejected');
            }
        }
        $sdk->apiLogin();
        same(10, MockHttp::$last->options[CURLOPT_CONNECTTIMEOUT], 'unchanged connect');
        same(60, MockHttp::$last->options[CURLOPT_TIMEOUT], 'unchanged total');
    });
    test('timeout, DNS, connection and TLS transport errors; recovery', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy&secret');
        same(null, $sdk->getLastError(), 'initial state');
        foreach (array(28, 6, 7, 60) as $errno) {
            MockHttp::$body = false;
            MockHttp::$errno = $errno;
            same(null, $sdk->apiLogin(), 'transport returns null');
            same(array('type' => 'transport', 'code' => $errno, 'message' => 'HTTP transport failed.'),
                $sdk->getLastError(), 'safe diagnostic');
            same(true, MockHttp::$last->closed, 'closed on failure');
        }
        MockHttp::$body = '{"status":"Success"}'; MockHttp::$errno = 0;
        same(array('status' => 'Success'), $sdk->apiLogin(), 'recovery');
        same(null, $sdk->getLastError(), 'cleared error');
        same(true, MockHttp::$last->closed, 'closed on success');
    });
    test('invalid, empty, truncated, HTML, invalid UTF-8 and deep JSON', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy');
        foreach (array('', '{', '<html>bad gateway</html>', '{"a":1}trailing', "\xff", str_repeat('[', 513) . str_repeat(']', 513)) as $body) {
            MockHttp::$body = $body;
            same(null, $sdk->apiLogin(), 'invalid JSON returns null');
            same('json', errorField($sdk, 'type'), 'JSON diagnostic');
            same(true, errorField($sdk, 'code') !== JSON_ERROR_NONE, 'JSON error code');
            same(true, MockHttp::$last->closed, 'closed on invalid JSON');
        }
    });
    test('all valid JSON types and API errors keep original return semantics', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy');
        foreach (array('{}', '[]', 'null', 'false', 'true', '0', '42', '"exported zone"',
                       '{"status":"Failed","statusDescription":"Bad input"}') as $body) {
            $expected = json_decode($body, true);
            MockHttp::$body = $body;
            same($expected, $sdk->apiLogin(), 'valid JSON return');
            same(null, $sdk->getLastError(), 'no local error for valid JSON');
        }
    });
    test('HTTP failures retain valid API bodies and report status', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy');
        foreach (array(0, 301, 401, 429, 500, 503) as $status) {
            MockHttp::$status = $status;
            MockHttp::$body = '{"status":"Failed"}';
            same(array('status' => 'Failed'), $sdk->apiLogin(), 'retain API body');
            same(array('type' => 'http', 'code' => $status, 'message' => 'Unexpected HTTP status.'), $sdk->getLastError(), 'HTTP diagnostic');
        }
        MockHttp::$status = 503; MockHttp::$body = '<html>Unavailable</html>';
        same(null, $sdk->apiLogin(), 'HTTP invalid JSON');
        same('json', errorField($sdk, 'type'), 'invalid JSON takes precedence');
        MockHttp::$status = 200; MockHttp::$body = '{}'; $sdk->apiLogin();
        same(null, $sdk->getLastError(), 'HTTP error cleared');
    });
    test('initialization and configuration failures never execute a request', function () {
        $sdk = new \ClouDNS\ClouDNS_SDK('123', 'dummy');
        $before = MockHttp::$executions;
        MockHttp::$initFailure = true;
        same(null, $sdk->apiLogin(), 'init failure');
        same('transport', errorField($sdk, 'type'), 'init diagnostic');
        MockHttp::$initFailure = false; MockHttp::$optionFailure = true;
        same(null, $sdk->apiLogin(), 'option failure');
        same('transport', errorField($sdk, 'type'), 'option diagnostic');
        same(true, MockHttp::$last->closed, 'closed on option failure');
        same($before, MockHttp::$executions, 'no execution');
        MockHttp::$optionFailure = false;
    });
    $baselineCounts = json_decode(file_get_contents(__DIR__ . '/fixtures/public-api.json'), true);
    echo 'OK ' . $checks . ' assertions; ' . count($baselineCounts['signatures']) . " original public signatures; no network requests\n";
}
