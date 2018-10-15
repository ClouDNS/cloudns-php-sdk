# ClouDNS SDK for HTTP API

## Introduction

This is the SDK for ClouDNS HTTP API. The document provides guidelines and examples on how to implement and use the ClouDNS SDK for our HTTP API. You can read more about the API at [cloudns.net](https://www.cloudns.net).

The SDK is based on the methods used in the [HTTP API](https://www.cloudns.net/wiki/article/41/).

## Table of contents

## Basic integration and requirements

These are the minimal requirements to use/implement the ClouDNS SDK:

- PHP 5.3 or above;
- Access to the ClouDNS HTTP API;

### Installation

1. [Download](https://github.com/ClouDNS/cloudns-php-sdk/archive/master.zip) the SDK file..
2. Add the SDK file to your project's folder.
3. Include it in your project. Here is a basic exmaple on how to do so:

```
<?php
include "ClouDNS_SDK.php";

...

?>
```
### Initialization

To gain access and use the methods, included in the SDK, the HTTP API credentials needs to be entered and verified:

- For API users:

```
<?php
$testVar = new ClouDNS_SDK('0000', '123456789', false);

?>
```

where `0000` is the ID of the API user (atuh-id), `123456789` is the password of the API user (auth-password) and `false` indicates the type of the API user.

- For API sub-users with authorization ID (sub-auth-id):

```
<?php
$testVar = new ClouDNS_SDK('0000', '123456789', true);

?>
```

where `0000` is the ID of the API sub-user (sub-atuh-id), `123456789` is the password of the API sub-user (auth-password) and `true` indicates the type of the API user.

- For API sub-users with user authorization (sub-auth-user):

```
<?php
$testVar = new ClouDNS_SDK('example@email.com', '123456789', true);

?>
```

where `example@email.com` is the email address set for the API sub-user (sub-atuh-user), `123456789` is the password of the API sub-user (auth-password) and `true` indicates the type of the API user.

## SDK Methods

Here you will find examples for every method, used in the SDK. The methods are presented as PHP function calls and are divided into four main categories - DNS (for DNS zones, records, etc.), Domain (for registered domains), SSL (for SSL certificates) and Sub (for sub-users). They can be used only after a succesfful login to the API.

The basic construction of the functions is as follows:


```
exampleFunction (arg1, arg2, arg3, ... , argN);

```

where `exampleFunction` is the name of the function, that will be called, `(arg1, arg2, arg3, ... , argN)` are the arguments, required for the current function. Besides the required arguments, there are also **optional** ones, which are used only in certain cases and as such they are always at the end of the function. If the **optional** arguments are not required for a certain function they can be entered as empty or **NULL** value. Here is a function, where **arg1** and **arg2** are required arguments, while **arg3** and **arg4** are optional ones:


```
exampleFunction (arg1, arg2, NULL, " ");

```

As you can see the **optional** arguments are located at the end of the function and can be entered as **NULL** and/or empty value.

### DNS

1. Available name servers.

- **description**: Get a list with available domain name servers.

- **example**:

```

<?php
var_dump($exampleVar->dnsAvailableNameServers());

?>
```

2. Create a new DNS zone.

- **description**: Create/add a new DNS zone to your account. Works with Master, Slave, Parked, GeoDNS and Reverse DNS zone.


- **example**:

```

<?php
var_dump($exampleVar->dnsResgisterDomainZone('domain.tld', 'master/slave/parked/geodns/reverse', array ('ns1.nameserver.tld', 'ns2.nameserver.tld'), '1.2.3.4'));;

?>
```

**where**:
	- `'domain.tld'` - the registered domain name, that the DNS zone will be created for;
	- `'master/slave/parked/geodns/reverse'` - the type of the DNS zone;
	- `array ('ns1.nameserver.tld', 'ns2.nameserver.tld')` - **optional**. An array with all the name servers, that will be configured and added for the NS record(s) upon creation of the DNS zone;
	- `'1.2.3.4'` - **optional**. The IP address of the Master server, required **only** for Slave zones;

3. Delete a DNS zone.

- **description**: Delete an existing DNS zone. Works with Master, Slave and Reverse zones as well as cloud/bulk domains.


- **example**:
```
<?php
var_dump($exampleVar->dnsDeleteDomainZone('domain.tld'));

?>
```

**where**:
	- `'domain.tld'` - the domain name of the DNS zone, that will be deleted;

4. List DNS zones.