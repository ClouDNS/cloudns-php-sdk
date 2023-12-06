<?php

namespace ClouDNS;

class ClouDNS_SDK {

	protected $id;
	protected $password;
	protected $user_type;

	function __construct($auth_id, $auth_password, $is_subuser = false) {
		if ($is_subuser == false) {
			$this->user_type = 'auth-id';
		} else {
			if (is_numeric($auth_id)) {
				$this->user_type = 'sub-auth-id';
			} else {
				$this->user_type = 'sub-auth-user';
			}
		}
		$this->id = $auth_id;
		$this->password = $auth_password;
	}

	private function apiRequest($api_data, $api_url) {

		$init = curl_init();
		curl_setopt($init, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($init, CURLOPT_URL, 'https://api.cloudns.net/' . $api_url . '.json');
		curl_setopt($init, CURLOPT_POST, true);
		curl_setopt($init, CURLOPT_POSTFIELDS, $this->user_type . '=' . $this->id . '&auth-password=' . $this->password . $api_data);

		$content = curl_exec($init);

		curl_close($init);

		return json_decode($content, true);
	}

	public function apiLogin() {
		$url = 'dns/login';

		return $this->apiRequest(false, $url);
	}

	public function dnsRegisterDomainZone($domain_name, $zone_type, $ns = false, $master_ip = false) {

		$data = '&domain-name=' . urlencode($domain_name) . '&zone-type=' . urlencode($zone_type);

		if (is_array($ns)) {
			if (empty($ns)) {
				$data .= '&ns[]=';
			} else {
				foreach ($ns as $value) {
					$data .= '&ns[]=' . urlencode($value);
				}
			}
		}

		if (!empty($master_ip)) {
			$data .= '&master-ip=' . urlencode($master_ip);
		}
		$url = 'dns/register';

		return $this->apiRequest($data, $url);
	}

	public function dnsAvailableNameServers() {
		$url = 'dns/available-name-servers';

		return $this->apiRequest(false, $url);
	}

	public function dnsDeleteDomainZone($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/delete';

		return $this->apiRequest($data, $url);
	}

	public function dnsListZones($page, $rows_per_page, $search = false, $groupId = "") {
		$data = '&page=' . urlencode($page) . '&rows-per-page=' . urlencode($rows_per_page) .
            ($search !== false ? '&search=' . urlencode($search) : "") . ($groupId != "" ? '&group-id='.urlencode($groupId) : "");
		$url = 'dns/list-zones';

		return $this->apiRequest($data, $url);
	}

	public function dnsGetPagesCount($rows_per_page, $search = false) {
		$data = '&rows-per-page=' . urlencode($rows_per_page) . '&search=' . urlencode($search);
		$url = 'dns/get-pages-count';

		return $this->apiRequest($data, $url);
	}

	public function dnsGetZonesStatistics() {
		$url = 'dns/get-zones-stats';

		return $this->apiRequest(false, $url);
	}

	public function dnsGetMailForwardsStatistics() {
		$url = 'dns/get-mail-forwards-stats';

		return $this->apiRequest(false, $url);
	}

	public function dnsGetZoneInformation($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/get-zone-info';

		return $this->apiRequest($data, $url);
	}

	public function dnsUpdateZone($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/update-zone';

		return $this->apiRequest($data, $url);
	}

	public function dnsUpdateStatus($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/update-status';

		return $this->apiRequest($data, $url);
	}

	public function dnsIsUpdated($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/is-updated';

		return $this->apiRequest($data, $url);
	}

	public function dnsChangeZonesStatus($domain_name, $status = false) {
		$data = '&domain-name=' . urlencode($domain_name) . '&status=' . urlencode($status);
		$url = 'dns/change-status';

		return $this->apiRequest($data, $url);
	}

	public function dnsListRecords($domain_name, $host = false, $type = false) {
		$data = '&domain-name=' . urlencode($domain_name);
		if (!empty($host)) {
			$data .= '&host=' . urlencode($host);
		}
		if (!empty($type)) {
			$data .= '&type=' . urlencode($type);
		}

		$url = 'dns/records';

		return $this->apiRequest($data, $url);
	}

	public function dnsAddRecord(
        $domain_name,
        $record_type,
        $host,
        $record,
        $ttl,
        $priority = false,
        $weight = false,
        $port = false,
        $frame = false,
        $frame_title = false,
        $frame_keywords = false,
        $frame_description = false,
        $save_path = false,
        $redirect_type = false,
        $mail = false,
        $txt = false,
        $algorithm = false,
        $fptype = false,
        $status = true,
        $geodns_location = false,
        $caa_flag = false,
        $caa_type = false,
        $caa_value = false,
        $mobile_meta = false,
        $tlsa_usage = false,
        $tlsa_selector = false,
        $tlsa_matching_type = false,
        $key_tag = false,
        $digest_type = false,
        $order = false,
        $pref = false,
        $flag = false,
        $params = false,
        $regexp = false,
        $replace = false,
        $cert_type = false,
        $cert_key_tag = false,
        $cert_algorithm = false,
        $lat_deg = false,
        $lat_min = false,
        $lat_sec = false,
        $lat_dir = false,
        $long_deg = false,
        $long_min = false,
        $long_sec = false,
        $long_dir = false,
        $altitude = false,
        $size = false,
        $h_precision = false,
        $v_precision = false,
        $cpu = false,
        $os = false
    ) {

        $data = '&domain-name=' . urlencode($domain_name) .
            '&record-type=' . urlencode($record_type) .
            '&host=' . urlencode($host) .
            '&record=' . urlencode($record) .
            '&ttl=' . urlencode($ttl) .
            '&priority=' . urlencode($priority) .
            '&weight=' . urlencode($weight) .
            '&port=' . urlencode($port) .
            '&frame=' . urlencode($frame) .
            '&frame-title=' . urlencode($frame_title) .
            '&frame-keywords=' . urlencode($frame_keywords) .
            '&frame-description=' . urlencode($frame_description) .
            '&save-path=' . urlencode($save_path) .
            '&redirect-type=' . urlencode($redirect_type) .
            '&mail=' . urlencode($mail) .
            '&txt=' . urlencode($txt) .
            '&algorithm=' . urlencode($algorithm) .
            '&fptype=' . urlencode($fptype) .
            '&status=' . urlencode($status) .
            '&geodns-location=' . urlencode($geodns_location) .
            '&caa_flag=' . urlencode($caa_flag) .
            '&caa_type=' . urlencode($caa_type) .
            '&caa_value=' . urlencode($caa_value) .
            '&mobile-meta=' . urlencode($mobile_meta) .
            '&tlsa_usage=' . urlencode($tlsa_usage) .
            '&tlsa_selector=' . urlencode($tlsa_selector) .
            '&tlsa_matching_type=' . urlencode($tlsa_matching_type) .
            '&key-tag=' . urlencode($key_tag) .
            '&digest-type=' . urlencode($digest_type) .
            '&order=' . urlencode($order) .
            '&pref=' . urlencode($pref) .
            '&flag=' . urlencode($flag) .
            '&params=' . urlencode($params) .
            '&regexp=' . urlencode($regexp) .
            '&replace=' . urlencode($replace) .
            '&cert-type=' . urlencode($cert_type) .
            '&cert-key-tag=' . urlencode($cert_key_tag) .
            '&cert-algorithm=' . urlencode($cert_algorithm) .
            '&lat-deg=' . urlencode($lat_deg) .
            '&lat-min=' . urlencode($lat_min) .
            '&lat-sec=' . urlencode($lat_sec) .
            '&lat-dir=' . urlencode($lat_dir) .
            '&long-deg=' . urlencode($long_deg) .
            '&long-min=' . urlencode($long_min) .
            '&long-sec=' . urlencode($long_sec) .
            '&long-dir=' . urlencode($long_dir) .
            '&altitude=' . urlencode($altitude) .
            '&size=' . urlencode($size) .
            '&h-precision=' . urlencode($h_precision) .
            '&v-precision=' . urlencode($v_precision) .
            '&cpu=' . urlencode($cpu) .
            '&os=' . urlencode($os);

		$url = 'dns/add-record';

		return $this->apiRequest($data, $url);
	}

	public function dnsDeleteRecord($domain_name, $record_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&record-id=' . urlencode($record_id);
		$url = 'dns/delete-record';

		return $this->apiRequest($data, $url);
	}

	public function dnsModifyRecord(
        $domain_name,
        $record_id,
        $host,
        $record,
        $ttl,
        $priority = false,
        $weight = false,
        $port = false,
        $frame = false,
        $frame_title = false,
        $frame_keywords = false,
        $frame_description = false,
        $save_path = false,
        $redirect_type = false,
        $mail = false,
        $txt = false,
        $algorithm = false,
        $fptype = false,
        $status = false,
        $geodns_location = false,
        $caa_flag = false,
        $caa_type = false,
        $caa_value = false,
        $mobile_meta = false,
        $tlsa_usage = false,
        $tlsa_selector = false,
        $tlsa_matching_type = false,
        $key_tag = false,
        $digest_type = false,
        $order = false,
        $pref = false,
        $flag = false,
        $params = false,
        $regexp = false,
        $replace = false,
        $cert_type = false,
        $cert_key_tag = false,
        $cert_algorithm = false,
        $lat_deg = false,
        $lat_min = false,
        $lat_sec = false,
        $lat_dir = false,
        $long_deg = false,
        $long_min = false,
        $long_sec = false,
        $long_dir = false,
        $altitude = false,
        $size = false,
        $h_precision = false,
        $v_precision = false,
        $cpu = false,
        $os = false
    ) {

        $data = '&domain-name=' . urlencode($domain_name) .
            '&record-id=' . urlencode($record_id) .
            '&host=' . urlencode($host) .
            '&record=' . urlencode($record) .
            '&ttl=' . urlencode($ttl) .
            '&priority=' . urlencode($priority) .
            '&weight=' . urlencode($weight) .
            '&port=' . urlencode($port) .
            '&frame=' . urlencode($frame) .
            '&frame-title=' . urlencode($frame_title) .
            '&frame-keywords=' . urlencode($frame_keywords) .
            '&frame-description=' . urlencode($frame_description) .
            '&save-path=' . urlencode($save_path) .
            '&redirect-type=' . urlencode($redirect_type) .
            '&mail=' . urlencode($mail) .
            '&txt=' . urlencode($txt) .
            '&algorithm=' . urlencode($algorithm) .
            '&fptype=' . urlencode($fptype) .
            '&status=' . urlencode($status) .
            '&geodns-location=' . urlencode($geodns_location) .
            '&caa_flag=' . urlencode($caa_flag) .
            '&caa_type=' . urlencode($caa_type) .
            '&caa_value=' . urlencode($caa_value) .
            '&mobile-meta=' . urlencode($mobile_meta) .
            '&tlsa_usage=' . urlencode($tlsa_usage) .
            '&tlsa_selector=' . urlencode($tlsa_selector) .
            '&tlsa_matching_type=' . urlencode($tlsa_matching_type) .
            '&key-tag=' . urlencode($key_tag) .
            '&digest-type=' . urlencode($digest_type) .
            '&order=' . urlencode($order) .
            '&pref=' . urlencode($pref) .
            '&flag=' . urlencode($flag) .
            '&params=' . urlencode($params) .
            '&regexp=' . urlencode($regexp) .
            '&replace=' . urlencode($replace) .
            '&cert-type=' . urlencode($cert_type) .
            '&cert-key-tag=' . urlencode($cert_key_tag) .
            '&cert-algorithm=' . urlencode($cert_algorithm) .
            '&lat-deg=' . urlencode($lat_deg) .
            '&lat-min=' . urlencode($lat_min) .
            '&lat-sec=' . urlencode($lat_sec) .
            '&lat-dir=' . urlencode($lat_dir) .
            '&long-deg=' . urlencode($long_deg) .
            '&long-min=' . urlencode($long_min) .
            '&long-sec=' . urlencode($long_sec) .
            '&long-dir=' . urlencode($long_dir) .
            '&altitude=' . urlencode($altitude) .
            '&size=' . urlencode($size) .
            '&h-precision=' . urlencode($h_precision) .
            '&v-precision=' . urlencode($v_precision) .
            '&cpu=' . urlencode($cpu) .
            '&os=' . urlencode($os);

        $url = 'dns/mod-record';

		return $this->apiRequest($data, $url);
	}

	public function dnsCopyRecords($domain_name, $from_domain, $delete_current_records = false) {
		$data = '&domain-name=' . urlencode($domain_name) . '&from-domain=' . urlencode($from_domain) .
			'&delete-current-records=' . urlencode($delete_current_records);
		$url = 'dns/copy-records';

		return $this->apiRequest($data, $url);
	}

	public function dnsImportRecords($domain_name, $format, $content, $delete_existing_records = false) {
		$data = '&domain-name=' . urlencode($domain_name) . '&format=' . urlencode($format) .
			'&content=' . urlencode($content) . '&delete-existing-records=' . urlencode($delete_existing_records);
		$url = 'dns/records-import';

		return $this->apiRequest($data, $url);
	}

	public function dnsExportRecordsBIND($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/records-export';

		return $this->apiRequest($data, $url);
	}

	public function dnsGetAvailableRecords($zone_type) {
		$data = '&zone-type=' . urlencode($zone_type);
		$url = 'dns/get-available-record-types';

		return $this->apiRequest($data, $url);
	}

	public function dnsGetAvailableTTL() {
		$url = 'dns/get-available-ttl';

		return $this->apiRequest(false, $url);
	}

	public function dnsGetSOA($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/soa-details';

		return $this->apiRequest($data, $url);
	}

	public function dnsModifySOA($domain_name, $primary_ns, $admin_mail, $refresh, $retry, $expire, $default_ttl) {
		$data = '&domain-name=' . urlencode($domain_name) . '&primary-ns=' . urlencode($primary_ns) .
			'&admin-mail=' . urlencode($admin_mail) . '&refresh=' . urlencode($refresh) .
			'&retry=' . urlencode($retry) . '&expire=' . urlencode($expire) . '&default-ttl=' . urlencode($default_ttl);
		$url = 'dns/modify-soa';

		return $this->apiRequest($data, $url);
	}

	public function dnsGetDynamicURL ($domain_name, $record_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&record-id=' . urlencode($record_id);
		$url = 'dns/get-dynamic-url';

		return $this->apiRequest($data, $url);
	}

	public function dnsDisableDynamicURL($domain_name, $record_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&record-id=' . urlencode($record_id);
		$url = 'dns/disable-dynamic-url';

		return $this->apiRequest($data, $url);
	}

	public function dnsChangeDynamicURL($domain_name, $record_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&record-id=' . urlencode($record_id);
		$url = 'dns/change-dynamic-url';

		return $this->apiRequest($data, $url);
	}

	public function dnsImportViaTransfer($domain_name, $server) {
		$data = '&domain-name=' . urlencode($domain_name) . '&server=' . urlencode($server);
		$url = 'dns/axfr-import';

		return $this->apiRequest($data, $url);
	}

	public function dnsChangeRecordStatus($domain_name, $record_id, $status = false) {
		$data = '&domain-name=' . urlencode($domain_name) . '&record-id=' . urlencode($record_id) .
			'&status=' . urlencode($status);
		$url = 'dns/change-record-status';

		return $this->apiRequest($data, $url);
	}

	public function dnsAddMasterServer($domain_name, $master_ip) {
		$data = '&domain-name=' . urlencode($domain_name) . '&master-ip=' . urlencode($master_ip);
		$url = 'dns/add-master-server';

		return $this->apiRequest($data, $url);
	}

	public function dnsDeleteMasterServer($domain_name, $master_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&master-id=' . urlencode($master_id);
		$url = 'dns/delete-master-server';

		return $this->apiRequest($data, $url);
	}

	public function dnsListMasterServer($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/master-servers';

		return $this->apiRequest($data, $url);
	}

	public function dnsMailForwardsStats() {
		$url = 'dns/get-mail-forwards-stats.json';

		return $this->apiRequest(false, $url);
	}

	public function dnsAvailableMailForwards() {
		$url = 'dns/get-mailforward-servers';

		return $this->apiRequest(false, $url);
	}

	public function dnsAddMailForward($domain_name, $box, $host, $destination) {
		$data = '&domain-name=' . urlencode($domain_name) . '&box=' . urlencode($box) . '&host=' . urlencode($host) .
			'&destination=' . urlencode($destination);
		$url = 'dns/add-mail-forward';

		return $this->apiRequest($data, $url);
	}

	public function dnsDeleteMailForward($domain_name, $mail_forward_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&mail-forward-id=' . urlencode($mail_forward_id);
		$url = 'dns/delete-mail-forward';

		return $this->apiRequest($data, $url);
	}

	public function dnsModifyMailForward($domain_name, $box, $host, $destination, $mail_forward_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&box=' . urlencode($box) . '&host=' . urlencode($host) .
			'&destination=' . urlencode($destination) . '&mail-forward-id=' . urlencode($mail_forward_id);
		$url = 'dns/modify-mail-forward';

		return $this->apiRequest($data, $url);
	}

	public function dnsListMailForwards($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/mail-forwards';

		return $this->apiRequest($data, $url);
	}

	public function dnsAddCloudDomain($domain_name, $cloud_domain_name) {
		$data = '&domain-name=' . urlencode($domain_name) . '&cloud-domain-name=' . urlencode($cloud_domain_name);
		$url = 'dns/add-cloud-domain';

		return $this->apiRequest($data, $url);
	}

	public function dnsDeleteCloudDomain($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/delete-cloud-domain';

		return $this->apiRequest($data, $url);
	}

	public function dnsChangeCloudMaster($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/set-master-cloud-domain';

		return $this->apiRequest($data, $url);
	}

	public function dnsListCloudDomains($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/list-cloud-domains';

		return $this->apiRequest($data, $url);
	}

	public function dnsAllowNewIP($domain_name, $ip) {
		$data = '&domain-name=' . urlencode($domain_name) . '&ip=' . urlencode($ip);
		$url = 'dns/axfr-add';

		return $this->apiRequest($data, $url);
	}

	public function dnsDeleteAllowedIP($domain_name, $id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&id=' . urlencode($id);
		$url = 'dns/axfr-remove';

		return $this->apiRequest($data, $url);
	}

	public function dnsListAllowedIP($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/axfr-list';

		return $this->apiRequest($data, $url);
	}

	public function dnsHourlyStatistics($domain_name, $year, $month, $day) {
		$data = '&domain-name=' . urlencode($domain_name) . '&year=' . urlencode($year) .
			'&month=' . urlencode($month) . '&day=' . urlencode($day);
		$url = 'dns/statistics-hourly';

		return $this->apiRequest($data, $url);
	}

	public function dnsDailyStatistics($domain_name, $year, $month) {
		$data = '&domain-name=' . urlencode($domain_name) . '&year=' . urlencode($year) . '&month=' . urlencode($month);
		$url = 'dns/statistics-daily';

		return $this->apiRequest($data, $url);
	}

	public function dnsMonthlyStatistics($domain_name, $year) {
		$data = '&domain-name=' . urlencode($domain_name) . '&year=' . urlencode($year);
		$url = 'dns/statistics-monthly';

		return $this->apiRequest($data, $url);
	}

	public function dnsYearlyStatistics($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/statistics-yearly';

		return $this->apiRequest($data, $url);
	}

	public function dnsLast30DaysStatistics($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/statistics-last-30-days';

		return $this->apiRequest($data, $url);
	}

	public function dnsGetParkedTemplates() {
		$url = 'dns/get-parked-templates';

		return $this->apiRequest(false, $url);
	}

	public function dnsGetParkedSettings($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/get-parked-settings';

		return $this->apiRequest($data, $url);
	}

	public function dnsModifyParkedSettings($domain_name, $template, $title = false, $description = false, $keywords = false, $contact_form = false) {
		$data = '&domain-name=' . urlencode($domain_name) . '&template=' . urlencode($template) .
			'&title=' . urlencode($title) . '&description=' . urlencode($description) .
			'&keywords=' . urlencode($keywords) . '&contact-form=' . urlencode($contact_form);
		$url = 'dns/set-parked-settings';

		return $this->apiRequest($data, $url);
	}

	public function dnsListGeoDNSLocations($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'dns/get-geodns-locations';

		return $this->apiRequest($data, $url);
	}

	public function dnsAddGroup($domain_name, $name) {
		$data = '&domain-name=' . urlencode($domain_name) . '&name=' . urlencode($name);
		$url = 'dns/add-group';

		return $this->apiRequest($data, $url);
	}

	public function dnsChangeGroup($domain_name, $group_id) {
		$data = '&domain-name=' . urlencode($domain_name) . '&group-id=' . urlencode($group_id);
		$url = 'dns/change-group';

		return $this->apiRequest($data, $url);
	}

	public function dnsListGroups() {
		$url = 'dns/list-groups';

		return $this->apiRequest(false, $url);
	}

	public function dnsDeleteGroup($group_id) {
		$data = '&group-id=' . urlencode($group_id);
		$url = 'dns/delete-group';

		return $this->apiRequest($data, $url);
	}

	public function dnsRenameGroup($group_id, $new_name) {
		$data = '&group-id=' . urlencode($group_id) . '&new-name=' . urlencode($new_name);
		$url = 'dns/rename-group';

		return $this->apiRequest($data, $url);
	}

	public function domainCheckAvailability($name, $tld = array()) {
		$data = '&name=' . urlencode($name);
		if (is_array($tld)) {
			foreach ($tld as $value) {
				$data = $data . '&tld[]=' . urlencode($value);
			}
			$url = 'domains/check-available';

			return $this->apiRequest($data, $url);
		}
		return "Invalid array!";
	}

	public function domainsPriceList() {
		$url = 'domains/pricing-list';

		return $this->apiRequest(false, $url);
	}

	public function domainsRegisterNewDomain($domain_name, $tld, $period, $mail, $name, $address, $city, $state, $zip, $country, $telnocc, $telno, $company = false, $faxnocc = false, $faxno = false, $ns = false, $registrant_type = false, $registrant_type_id = false, $registrant_policy = false, $birth_date = false, $birth_cc = false, $birth_city = false, $birth_zip = false, $publication = false, $vat = false, $siren = false, $duns = false, $trademark = false, $waldec = false, $registrant_type_other = false, $privacy_protection = false, $code = false, $publicity = false, $kpp = false, $passport_number = false, $passport_issued_by = false, $passport_issued_on = false) {
		if (!is_array($ns) && ($ns != false)) {
			return "Invalid ns array!";
		}
		$data = '&domain-name=' . urlencode($domain_name) . '&tld=' . urlencode($tld) . '&period=' . urlencode($period) .
			'&mail=' . urlencode($mail) . '&name=' . urlencode($name) . '&address=' .
			urlencode($address) . '&city=' . urlencode($city) . '&state=' . urlencode($state) . '&zip=' . urlencode($zip) .
			'&country=' . urlencode($country) . '&telnocc=' . urlencode($telnocc) . '&telno=' . urlencode($telno) . '&company=' . urlencode($company) .
			'&faxnocc=' . urlencode($faxnocc) . '&faxno=' . urlencode($faxno);
		if ($ns != false) {
			foreach ($ns as $value) {
				$data = $data . '&ns[]=' . urlencode($value);
			}
		} else {
			$data = $data . '&ns=' . urlencode($ns);
		}
		$data = $data . '&registrant_type=' . urlencode($registrant_type) .
			'&registrant_type_id=' . urlencode($registrant_type_id) . '&registrant_policy=' . urlencode($registrant_policy) .
			'&birth_date=' . urlencode($birth_date) . '&birth_cc=' . urlencode($birth_cc) . '&birth_city=' . urlencode($birth_city) .
			'&birth_zip=' . urlencode($birth_zip) . '&publication=' . urlencode($publication) . '&vat=' . urlencode($vat) . '&siren=' . urlencode($siren) .
			'&duns=' . urlencode($duns) . '&trademark=' . urlencode($trademark) . '&waldec=' . urlencode($waldec) . '&registrant_type_other=' . urlencode($registrant_type_other) .
			'&privacy_protection=' . urlencode($privacy_protection) . '&code=' . urlencode($code) . '&publicity=' . urlencode($publicity) . '&kpp=' . urlencode($kpp) .
			'&passport_number=' . urlencode($passport_number) . '&passport_issued_by=' . urlencode($passport_issued_by) .
			'&passport_issued_on=' . urlencode($passport_issued_on);
		$url = 'domains/order-new-domain';

		return $this->apiRequest($data, $url);
	}

	public function domainsRenewDomain($domain_name, $period) {
		$data = '&domain-name=' . urlencode($domain_name) . '&period=' . urlencode($period);
		$url = 'domains/order-renew-domain';

		return $this->apiRequest($data, $url);
	}

	public function domainsTransferDomain($domain_name, $tld, $mail, $name, $address, $city, $state, $zip, $country, $telnocc, $telno, $company, $faxnocc = false, $faxno = false, $transfer_code = false, $registrant_type = false, $birth_date = false, $birth_cc = false, $birth_city = false, $birth_zip = false, $publication = false, $vat = false, $siren = false, $duns = false, $trademark = false, $waldec = false, $registrant_type_other = false, $privacy_protection = false, $code = false, $registrant_type_id = false, $publicity = false, $ns = false, $kpp = false, $passport_number = false, $passport_issued_by = false, $passport_issued_on = false) {
		if (!is_array($ns) && ($ns != false)) {
			return "Invalid ns array!";
		}
		$data = '&domain-name=' . urlencode($domain_name) . '&tld=' . urlencode($tld) . '&mail=' . urlencode($mail) .
			'&name=' . urlencode($name) .  '&address=' . urlencode($address) .
			'&city=' . urlencode($city) . '&state=' . urlencode($state) . '&zip=' . urlencode($zip) . '&country=' . urlencode($country) .
			'&telnocc=' . urlencode($telnocc) . '&telno=' . urlencode($telno) . '&company=' . urlencode($company) . '&faxnocc=' . urlencode($faxnocc) . '&faxno=' . urlencode($faxno) .
			'&transfer-code=' . urlencode($transfer_code) . '&registrant_type=' . urlencode($registrant_type) . '&birth_date=' . urlencode($birth_date) .
			'&birth_cc=' . urlencode($birth_cc) . '&birth_city=' . urlencode($birth_city) . '&birth_zip=' . urlencode($birth_zip) . '&publication=' . urlencode($publication) .
			'&vat=' . urlencode($vat) . '&siren=' . urlencode($siren) . '&duns=' . urlencode($duns) . '&trademark=' . urlencode($trademark) . '&waldec=' . urlencode($waldec) .
			'&registrant_type_other=' . urlencode($registrant_type_other) . '&privacy_protection=' . urlencode($privacy_protection) . '&code=' . urlencode($code) .
			'&registrant_type_id=' . urlencode($registrant_type_id) . '&publicity=' . urlencode($publicity);
		if ($ns != false) {
			foreach ($ns as $value) {
				$data = $data . '&ns[]=' . urlencode($value);
			}
		} else {
			$data = $data . '&ns=' . urlencode($ns);
		}
		$data = $data . '&kpp=' . urlencode($kpp) . '&passport_number=' . urlencode($passport_number) . '&passport_issued_by=' . urlencode($passport_issued_by) .
			'&passport_issued_on=' . urlencode($passport_issued_on);
		$url = 'domains/order-transfer-domain';

		return $this->apiRequest($data, $url);
	}

	public function domainsListRegisteredDomains($rows_per_page, $page, $search = false) {
		$data = '&rows-per-page=' . urlencode($rows_per_page) . '&page=' . urlencode($page) . '&search=' . urlencode($search);
		$url = 'domains/list-domains';

		return $this->apiRequest($data, $url);
	}

	public function domainsGetPagesCount($rows_per_page, $search = false) {
		$data = '&rows-per-page=' . urlencode($rows_per_page) . '&search=' . urlencode($search);
		$url = 'domains/get-pages-count';

		return $this->apiRequest($data, $url);
	}

	public function domainsDomainInfo($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'domains/domain-info';

		return $this->apiRequest($data, $url);
	}

	public function domainsGetContacts($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'domains/get-contacts';

		return $this->apiRequest($data, $url);
	}

	public function domainsModifyContacts($domain_name, $type, $mail, $name, $company, $address1, $city, $state, $zip, $country, $telnocc, $telno, $address2 = false, $address3 = false, $faxnocc = false, $faxno = false) {
		$data = '&domain-name=' . urlencode($domain_name) . '&type=' . urlencode($type) . '&mail=' . urlencode($mail) . '&name=' . urlencode($name) . '&company=' .
			urlencode($company) . '&address1=' . urlencode($address1) . '&city=' . urlencode($city) . '&state=' . urlencode($state) . '&zip=' . urlencode($zip) .
			'&country=' . urlencode($country) . '&telnocc=' . urlencode($telnocc) . '&telno=' . urlencode($telno) . '&address2=' . urlencode($address2) .
			'&address3=' . urlencode($address3) . '&faxnocc=' . urlencode($faxnocc) . '&faxno=' . urlencode($faxno);
		$url = 'domains/set-contacts';

		return $this->apiRequest($data, $url);
	}

	public function domainsListNameServers($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'domains/get-nameservers';

		return $this->apiRequest($data, $url);
	}

	public function domainsModifyNameServers($domain_name, $nameservers) {
		$data = '&domain-name=' . urlencode($domain_name);
		if (!is_array($nameservers)) {
			return "Invalid array!";
		}
		foreach ($nameservers as $value) {
			$data = $data . '&nameservers[]=' . urlencode($value);
		}
		$url = 'domains/set-nameservers';

		return $this->apiRequest($data, $url);
	}

	public function domainsGetChildNameServers($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'domains/get-child-nameservers';

		return $this->apiRequest($data, $url);
	}

	public function domainsAddChildNameServers($domain_name, $host, $ip) {
		$data = '&domain-name=' . urlencode($domain_name) . '&host=' . urlencode($host) . '&ip=' . urlencode($ip);
		$url = 'domains/add-child-nameservers';

		return $this->apiRequest($data, $url);
	}

	public function domainsDeleteChildNameServers($domain_name, $host, $ip) {
		$data = '&domain-name=' . urlencode($domain_name) . '&host=' . urlencode($host) . '&ip=' . urlencode($ip);
		$url = 'domains/delete-child-nameservers';

		return $this->apiRequest($data, $url);
	}

	public function domainsModifyChildNameServers($domain_name, $host, $old_ip, $new_ip) {
		$data = '&domain-name=' . urlencode($domain_name) . '&host=' .urlencode($host) . '&old-ip=' . urlencode($old_ip) . '&new-ip=' . urlencode($new_ip);
		$url = 'domains/modify-child-nameservers';

		return $this->apiRequest($data, $url);
	}

	public function domainsModifyPrivacyProtection($domain_name, $status) {
		$data = '&domain-name=' . urlencode($domain_name) . '&status=' . urlencode($status);
		$url = 'domains/edit-privacy-protection';

		return $this->apiRequest($data, $url);
	}

	public function domainsModifyTransferLock($domain_name, $status) {
		$data = '&domain-name=' . urlencode($domain_name) . '&status=' . urlencode($status);
		$url = 'domains/edit-transfer-lock';

		return $this->apiRequest($data, $url);
	}

	public function domainsGetTransferCode($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'domains/get-transfer-code';

		return $this->apiRequest($data, $url);
	}

	public function domainsGetRAAStatus($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'domains/get-raa-status';

		return $this->apiRequest($data, $url);
	}

	public function domainsResendRAAVerification($domain_name) {
		$data = '&domain-name=' . urlencode($domain_name);
		$url = 'domains/resend-raa-verification';

		return $this->apiRequest($data, $url);
	}

	public function sslOrderNewSSL($domain_name, $period, $type) {
		$data = '&domain-name=' . urlencode($domain_name) . '&period=' . urlencode($period) . '&type=' . urlencode($type);
		$url = 'ssl/order-new';

		return $this->apiRequest($data, $url);
	}

	public function sslListOrderedCertificates($page, $rows_per_page) {
		$data = '&page=' . urlencode($page) . '&rows-per-page=' . urlencode($rows_per_page);
		$url = 'ssl/list';

		return $this->apiRequest($data, $url);
	}

	public function sslGetPagesCount($rows_per_page) {
		$data = '&rows-per-page=' . urlencode($rows_per_page);
		$url = 'ssl/get-pages-count';

		return $this->apiRequest($data, $url);
	}

	public function sslInformation($ssl_id) {
		$data = '&ssl-id=' . $ssl_id;
		$url = 'ssl/info';

		return $this->apiRequest($data, $url);
	}

	public function sslSubmitCSR($ssl_id, $mail, $csr) {
		$data = '&ssl-id=' . urlencode($ssl_id) . '&mail=' . urlencode($mail) . '&csr=' . urlencode($csr);
		$url = 'ssl/submit-csr';

		return $this->apiRequest($data, $url);
	}

	public function sslRenew($ssl_id, $period) {
		$data = '&ssl-id=' . urlencode($ssl_id) . '&period=' . urlencode($period);
		$url = 'ssl/order-renew';

		return $this->apiRequest($data, $url);
	}

	public function sslChangeVerificationMail($ssl_id, $mail) {
		$data = '&ssl-id=' . urlencode($ssl_id) . '&mail=' . urlencode($mail);
		$url = 'ssl/change-verification-mail';

		return $this->apiRequest($data, $url);
	}

	public function sslReissue($ssl_id, $mail, $csr) {
		$data = '&ssl-id=' . urlencode($ssl_id) . '&mail=' . urlencode($mail) . '&csr=' . urlencode($csr);
		$url = 'ssl/reissue';

		return $this->apiRequest($data, $url);
	}

	public function sslListVerificationMails($ssl_id) {
		$data = '&ssl-id=' . urlencode($ssl_id);
		$url = 'ssl/get-verification-mails';

		return $this->apiRequest($data, $url);
	}

	public function subAddNewUser($password, $zones, $mail_forwards, $ip = false) {
		$data = '&password=' . urlencode($password) . '&zones=' . urlencode($zones) . '&mail-forwards=' . urlencode($mail_forwards) . '&ip=' . urlencode($ip);
		$url = 'sub-users/add';

		return $this->apiRequest($data, $url);
	}

	public function subGetUserInfo($id) {
		$data = '&id=' . urlencode($id);
		$url = 'sub-users/get-info';

		return $this->apiRequest($data, $url);
	}

	public function subGetPagesCount($rows_per_page) {
		$data = '&rows-per-page=' . urlencode($rows_per_page);
		$url = 'sub-users/get-pages-count';

		return $this->apiRequest($data, $url);
	}

	public function subListSubUsers($page, $rows_per_page) {
		$data = '&page=' . urlencode($page) . '&rows-per-page=' . urlencode($rows_per_page);
		$url = 'sub-users/list-sub-users';

		return $this->apiRequest($data, $url);
	}

	public function subModifyZonesLimit($id, $zones) {
		$data = '&id=' . urlencode($id) . '&zones=' . urlencode($zones);
		$url = 'sub-users/modify-zones-limit';

		return $this->apiRequest($data, $url);
	}

	public function subModifyMailForwardsLimit($id, $mail_forwards) {
		$data = '&id=' . urlencode($id) . '&mail-forwards=' . urlencode($mail_forwards);
		$url = 'sub-users/modify-mail-forwards-limit';

		return $this->apiRequest($data, $url);
	}

	public function subAddIP($id, $ip) {
		$data = '&id=' . urlencode($id) . '&ip=' . urlencode($ip);
		$url = 'sub-users/add-ip';

		return $this->apiRequest($data, $url);
	}

	public function subRemoveIP($id, $ip) {
		$data = '&id=' . urlencode($id) . '&ip=' . urlencode($ip);
		$url = 'sub-users/remove-ip';

		return $this->apiRequest($data, $url);
	}

	public function subModifyStatus($id, $status) {
		$data = '&id=' . urlencode($id) . '&status=' . urlencode($status);
		$url = 'sub-users/modify-status';

		return $this->apiRequest($data, $url);
	}

	public function subModifyPassword($id, $password) {
		$data = '&id=' . urlencode($id) . '&password=' . urlencode($password);
		$url = 'sub-users/modify-password';

		return $this->apiRequest($data, $url);
	}

	public function subZones($id) {
		$data = '&id=' . urlencode($id);
		$url = 'sub-users/zones';

		return $this->apiRequest($data, $url);
	}

	public function subDelegateZone($id, $zone) {
		$data = '&id=' . urlencode($id) . '&zone=' . urlencode($zone);
		$url = 'sub-users/delegate-zone';

		return $this->apiRequest($data, $url);
	}

	public function subRemoveZoneDelegation($id, $zone) {
		$data = '&id=' . urlencode($id) . '&zone=' . urlencode($zone);
		$url = 'sub-users/remove-zone-delegation';

		return $this->apiRequest($data, $url);
	}

	public function subDeleteSubUser($id) {
		$data = '&id=' . urlencode($id);
		$url = 'sub-users/delete';

		return $this->apiRequest($data, $url);
	}

}
