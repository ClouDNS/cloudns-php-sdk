# ClouDNS SDK for HTTP API

## Introduction

This is the SDK for ClouDNS HTTP API. The document provides guidelines and examples on how to implement and use the ClouDNS SDK for our HTTP API. You can read more about the API at [cloudns.net](https://www.cloudns.net).

The SDK is based on the methods used in the [HTTP API](https://www.cloudns.net/wiki/article/41/).

## Table of contents

## Basic integration and requirements

These are the minimal requirements to use/implement the ClouDNS SDK:

- PHP 5 or above;
- Access to the ClouDNS HTTP API;

### Installation

1. [Download](https://github.com/ClouDNS/cloudns-php-sdk/archive/master.zip) the SDK file.
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
$exampleVar = new ClouDNS_SDK('0000', '123456789', false);

?>
```

where `0000` is the ID of the API user (atuh-id), `123456789` is the password of the API user (auth-password) and `false` indicates the type of the API user.

- For API sub-users with authorization ID (sub-auth-id):

```
<?php
$exampleVar = new ClouDNS_SDK('0000', '123456789', true);

?>
```

where `0000` is the ID of the API sub-user (sub-atuh-id), `123456789` is the password of the API sub-user (auth-password) and `true` indicates the type of the API user.

- For API sub-users with user authorization (sub-auth-user):

```
<?php
$exampleVar = new ClouDNS_SDK('example@email.com', '123456789', true);

?>
```

where `example@email.com` is the email address set for the API sub-user (sub-atuh-user), `123456789` is the password of the API sub-user (auth-password) and `true` indicates the type of the API user.

## SDK Functions

Here you will find examples for every method, used in the SDK. The methods are presented as PHP function calls and are divided into four main categories - DNS (for DNS zones, records, etc.), Domain (for registered domains), SSL (for SSL certificates) and Sub (for sub-users). They can be used only after a successful login to the API.

The basic construction of the functions is as follows:


```
exampleFunction (arg1, arg2, arg3, ... , argN);

```

where `exampleFunction` is the name of the function, that will be called, `(arg1, arg2, arg3, ... , argN)` are the arguments, required for the current function. Besides the required arguments, there are also **optional** ones, which are used only in certain cases and as such they are always at the end of the function. If the **optional** arguments are not required for a certain function they can be entered as empty, **NULL** value or can be skipped. Here is a function, where **arg1** and **arg2** are required arguments, while **arg3** and **arg4** are optional ones:


```
exampleFunction (arg1, arg2, NULL, " ");

```

or

```
exampleFunction (arg1, arg2);

```

As you can see the **optional** arguments are located at the end of the function and can be entered as **NULL** and/or empty value and/or skipped.

Note, that there are cases, where you will have to enter some of the **optional** arguments and ignore others - for example ignore **arg3** and enter **arg4**. In situations such as this one you can enter **arg3** as `NULL` or empty `' '` value, but you can not skip it.

### DNS

<details><summary>1. Available name servers.</summary>

- **Description**: Get a list with available domain name servers.

- **Example**:

```

<?php
$exampleVar->dnsAvailableNameServers();

?>
```
</details>
<br />

<details><summary>2. Create a new DNS zone.</summary>

- **Description**: Create/add a new DNS zone to your account. Works with Master, Slave, Parked, GeoDNS and Reverse DNS zone.

- **Example**:

```

<?php
$exampleVar->dnsResgisterDomainZone('domain.tld', 'master/slave/parked/geodns/reverse', array ('ns1.nameserver.tld', 'ns2.nameserver.tld'), '1.2.3.4');

?>
```

**where**:
- `'domain.tld'` - the registered domain name, that the DNS zone will be created for;
- `'master/slave/parked/geodns/reverse'` - the type of the DNS zone;
- `array ('ns1.nameserver.tld', 'ns2.nameserver.tld')` - **optional**. An array with all the name servers, that will be configured and added for the NS record(s) upon creation of the DNS zone;
- `'1.2.3.4'` - **optional**. The IP address of the Master server, required **only** for Slave zones;
</details>
<br />

<details><summary>3. Delete a DNS zone.</summary>

- **Description**: Delete an existing DNS zone. Works with Master, Slave and Reverse zones as well as cloud/bulk domains.

- **Example**:

```
<?php
$exampleVar->dnsDeleteDomainZone('domain.tld');

?>
```

**where**:
- `'domain.tld'` - the domain name of the DNS zone, that will be deleted;
</details>
<br />

<details><summary>4. List DNS zones.</summary>

- **Description**: Get a list of all DNS zones in your account or only the ones matching a certain criteria (keyword).

- **Example**:

```
<?php
$exampleVar->dnsListZones('1', '10', 'keyword');

?>
```

**where**:
- `'1'` - the current page of your zone list;
- `'10'` - amount of results per page. It can be 10, 20, 30, 50 or 100.
- `'keyword'` - **optional**. A specific criteria (keyword), that your results will be based on.
</details>
<br />

<details><summary>5. Get pages count.</summary>

- **Description**: Amount of pages with DNS zones currently in your account. It can be combined to give results based on criteria (keyword).

- **Example**:

```
<?php
$exampleVar->dnsGetPagesCount('10', 'keyword'));;

?>
```

**where**:
- `'10'` - amount of results per page. It can be 10, 20, 30, 50 or 100.
- `'keyword'` - **optional**. A specific criteria (keyword), that your results will be based on.
</details>
<br />

<details><summary>6. Get zones statistics.</summary>

- **Description**: Shows information about the amount of DNS zones currently in the account and the zone limit, that is available for the account's subscription plan.

- **Example**:

```
<?php
$exampleVar->dnsGetZonesStatistics();

?>
```
</details>
<br />

<details><summary>7. Get zone information.</summary>


- **Description**: Shows information about the DNS zone - status, type.

- **Example**:
  
 ```
<?php
$exampleVar->dnsGetZoneInformation('domain.tld');

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, that you want to get information for.
</details>
<br />

<details><summary>8. Update zone.</summary>


- **Description**: Updates a DNS zone.

- **Example**:
  
 ```
<?php
$exampleVar->dnsUpdateZone('domain.tld');

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone that will be updated.
</details>
<br />

<details><summary>9. Update status.</summary>


- **Description**: Shows information for update status of the DNS zone and a list of name servers.

- **Example**:
  
 ```
<?php
$exampleVar->dnsUpdateStatus('domain.tld');

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, that the update status and name servers will be shown for.
</details>
<br />

<details><summary>10. Is updated.</summary>


- **Description**: Shows the update status of the DNS zone for a list of name servers - **TRUE** if it is updated on all servers and **FALSE** if not.

- **Example**:
  
 ```
<?php
$exampleVar->dnsIsUpdated('domain.tld');

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, that the update status and name servers will be shown for.
</details>
<br />

<details><summary>11. Change zone's status.</summary>


- **Description**: Change the status of the DNS zone - active/inactive.

- **Example**:
  
 ```
<?php
$exampleVar->dnsChangeZonesStatus('domain.tld', '1');

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, that the status will be changed for (active or inactive).
- `'1'` - **optional**. Status indicator - **1** to activate the DNS zone and **0** to deactivate it. If the argument is skipped the status will be toggled.
</details>
<br />

<details><summary>12. List records.</summary>


- **Description**: Shows a list of records currently in the DNS zone. The results can also be based on host name and/or record type.

- **Example**:
  
 ```
<?php
$exampleVar->dnsListRecords('domain.tld', 'host', 'A');

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, which the records list will be shown for.
- `'host'` - **optional**. The host, which the list will be based on.
- `''A'` - **optional**. Type of record, which the list will be based on. For available record types, see "Get the available record types" function.
</details>
<br />

<details><summary>13. Add record.</summary>


- **Description**: Adds a record to the DNS zone.

- **Example**:
  
 ```
<?php
$exampleVar->dnsAddRecord("domain.tld", "A", "host", "requirements", 3600, priority, weight, port, frame, frame-title, frame-keywords, frame-description, save-path, redirect-type, mail, txt, algorithm, fptype, status, geodns-location, caa-flag, caa-type, caa-value);

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, which the record will be add for.
- `'A'` - type of the record, that will be added. The available record types are: A, AAAA, MX, CNAME, TXT, NS, SRV, WR, RP, SSHFP, ALIAS, CAA for domain names and NS and PTR for reversed zones.
- `'host'` - the host name of the record.
- `'requirements'` - the value or string that is required for the record. For example IP address for A/AAAA record, mail server for MX record, name server for NS record, etc.
- `'3600'` - the TTL of the record. The available TTL's are as follows:
60 = 1 minute
300 = 5 minutes
900 = 15 minutes
1800 = 30 minutes
3600 = 1 hour
21600 = 6 hours
43200 = 12 hours
86400 = 1 day
172800 = 2 days
259200 = 3 days
604800 = 1 week
1209600 = 2 weeks
2592000 = 1 month
- `'priority'` - **optional**. Only required when setting a priority for MX or SRV records.
- `'weight'` - **optional**. Only required when setting weight for SRV record.
- `'port'` - **optional**. Only required for setting port for SRV record.
- `'frame'` - **optional**. Toggling the redirect with frame option for Web Redirect record - **0** for disable, **1** for enable.
- `'frame-title'` - **optional**. Add title if redirect with frame is enabled for the Web Redirect record.
- `'frame-keywords'` - **optional**. Add keywords if redirect with frame is enabled for the Web Redirect record.
- `'frame-description'` - **optional**. Add description if redirect with frame is enabled for the Web Redirect record.
- `'save-path'` - **optional**. Saves the path when redirecting with Web Redirect record - **0** for disable, **1** for enable.
- `'redirect-type'` - **optional**. Unmasked redirects for Web Redirect record if the redirect with frame is disabled - **301** for constant type or **302** for temporary type.
- `'mail'` - **optional**. E-mail address for RP records.
- `'txt'` - **optional**. Domain name for TXT record used in RP records.
- `'algorithm'` - **optional**. Algorithm required to create the SSHFP fingerprint. Only used for SSHFP records.
- `'fptype'` - **optional**. Type of the SSHFP algorithm. Only used for SSHFP records.
- `'status'` - **optional**. Status of the record - **1** for active and **0** for inactive. If omitted the record will be set as active.
- `'geodns-location'` - **optional**. ID of the GeoDNS location that can be set for A, AAAA and CNAME records. The location's ID can be obtained from the **List GeoDNS locations** function.
- `'caa-flag'` - **optional**. Flag used only for CAA records - **0** for Non critical and **128** for Critical.
- `'caa-type'` - **optional**. Type of the CAA record, which can be **issue**, **issuewild** and **iodef**.
- `'caa-value'` - **optional**. Value of the CAA record. Depending on the type of the CAA record, '`caa-type'`, it can be set as follows:
if `'caa-type'` is issue the `'caa-value'` can be hostname or ";".
if `'caa-type'` is issuewild the `'caa-value'` can be hostname or ";".
if `'caa-type'` is iodef the `'caa-value'` "mailto:someemail@address.tld, http://example.tld or http://example.tld.
</details>
<br />

<details><summary>14. Delete record.</summary>


- **Description**: Deletes a record in the DNS zone.

- **Example**:
  
 ```
<?php
$exampleVar->dnsDeleteRecord('domain.tld', "12345");

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, which the record will be deleted from.
- `'12345'` - ID of the record. The ID can be found using the **List records** function.
</details>
<br />

<details><summary>15. Modify record.</summary>


- **Description**: Modify (edit) a record.

- **Example**:
  
 ```
<?php
$exampleVar->dnsModifyRecord("domain.tld", "12345", "host", "requirements", 3600, priority, weight, port, frame, frame-title, frame-keywords, frame-description, save-path, redirect-type, mail, txt, algorithm, fptype, geodns-location, caa-flag, caa-type, caa-value);

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, which the record will be add for.
- `'12345'` - ID of the record. The ID can be found using the **List records** function.
- `'host'` - the host name of the record.
- `'requirements'` - the value or string that is required for the record. For example IP address for A/AAAA record, mail server for MX record, name server for NS record, etc.
- `'3600'` - the TTL of the record. The available TTL's are as follows:
60 = 1 minute
300 = 5 minutes
900 = 15 minutes
1800 = 30 minutes
3600 = 1 hour
21600 = 6 hours
43200 = 12 hours
86400 = 1 day
172800 = 2 days
259200 = 3 days
604800 = 1 week
1209600 = 2 weeks
2592000 = 1 month
- `'priority'` - **optional**. Only required when setting a priority for MX or SRV records.
- `'weight'` - **optional**. Only required when setting weight for SRV record.
- `'port'` - **optional**. Only required for setting port for SRV record.
- `'frame'` - **optional**. Toggling the redirect with frame option for Web Redirect record - **0** for disable, **1** for enable.
- `'frame-title'` - **optional**. Add title if redirect with frame is enabled for the Web Redirect record.
- `'frame-keywords'` - **optional**. Add keywords if redirect with frame is enabled for the Web Redirect record.
- `'frame-description'` - **optional**. Add description if redirect with frame is enabled for the Web Redirect record.
- `'save-path'` - **optional**. Saves the path when redirecting with Web Redirect record - **0** for disable, **1** for enable.
- `'redirect-type'` - **optional**. Unmasked redirects for Web Redirect record if the redirect with frame is disabled - **301** for constant type or **302** for temporary type.
- `'mail'` - **optional**. E-mail address for RP records.
- `'txt'` - **optional**. Domain name for TXT record used in RP records.
- `'algorithm'` - **optional**. Algorithm required to create the SSHFP fingerprint. Only used for SSHFP records.
- `'fptype'` - **optional**. Type of the SSHFP algorithm. Only used for SSHFP records.
- `'geodns-location'` - **optional**. ID of the GeoDNS location that can be set for A, AAAA and CNAME records. The location's ID can be obtained from the **List GeoDNS locations** function.
- `'caa-flag'` - **optional**. Flag used only for CAA records - **0** for Non critical and **128** for Critical.
- `'caa-type'` - **optional**. Type of the CAA record, which can be **issue**, **issuewild** and **iodef**.
- `'caa-value'` - **optional**. Value of the CAA record. Depending on the type of the CAA record, '`caa-type'`, it can be set as follows:
if `'caa-type'` is issue the `'caa-value'` can be hostname or ";".
if `'caa-type'` is issuewild the `'caa-value'` can be hostname or ";".
if `'caa-type'` is iodef the `'caa-value'` "mailto:someemail@address.tld, http://example.tld or http://example.tld.
</details>
<br />

<details><summary>16. Copy records.</summary>


- **Description**: Copies all the records from a specific zone.

- **Example**:
  
```
<?php
$exampleVar->dnsCopyRecords('domain.tld', 'domain2.tld', 1);

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, which the records will be copied to.
- `'domain2.tld'` - name of the DNS zone, which the records will be copied from.
- `'1'` - **optional**. If entered (set to 1), deletes all the existing records in the DNS zozo, which the records will be copied to.
</details>
<br />

<details><summary>17. Import records.</summary>


- **Description**: Copies all the records from a specific zone.

- **Example**:
  
```
<?php
$exampleVar->dnsCopyRecords('domain.tld', 'bind', '@ 3600 IN TXT "v=spf1 a mx include:_spf.google.com ~all"
@ 3600 IN MX ASPMX.L.GOOGLE.COM.', 1);

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, which the records will be imported to.
- `'bind'` - the format, which will be used to import the records. The available formats are **bind** and **tinydns**.
- `'@ 3600 IN TXT "v=spf1 a mx include:_spf.google.com ~all"
    @ 3600 IN MX ASPMX.L.GOOGLE.COM.'` - list of the records based on the chosen format. The records must be added one per row.
- `'1'` - **optional**. If entered (set to 1), deletes all the existing records in the DNS zozo, which the records will be imported to.
</details>
<br />

<details><summary>18. Export records in BIND format.</summary>


- **Description**: Exports the zone records in BIND format.

- **Example**:
  
```
<?php
$exampleVar->dnsExportRecordsBIND('domain.tld');

?>
```

**where**:
- `'domain.tld'` - name of the DNS zone, which the records will be exported from in BIND format.
</details>
<br />

<details><summary>19. Get the available record types.</summary>


- **Description**: Shows the available record types, that can be set up, based on the DNS zone type.

- **Example**:
  
```
<?php
$exampleVar->dnsGetAvailableRecords('domain');

?>
```

**where**:
- `'domain'` - type of the DNS zone. The value can be **domain** for Master DNS zones, **reverse** for Reverse DNS zones and **parked** for Parked DNS zones.
</details>
<br />

<details><summary>20. Get the available TTL.</summary>


- **Description**: Shows the available TTL, that can be set for the records.

- **Example**:
  
```
<?php
$exampleVar->dnsGetAvailableTTL();

?>
```

</details>
<br />

<details><summary>21. Get SOA details.</summary>


- **Description**: Shows the SOA details of the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsGetSOA('domain.tld');

?>
```

**where**:
- `'domain.tld'` - is the name of the DNS zone, that the SOA details will be shown for.

</details>
<br />

<details><summary>22. Modify SOA details.</summary>


- **Description**: Modify (edit) the SOA details of the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsModifySOA('domain.tld', 'ns1.nameserver.tld', 'example@email.tld', 2000, 3000, 2000000, 3600);

?>
```

**where**:
- `'domain.tld'` - is the name of the DNS zone, that the SOA details will be modified (edited) for.
- `'ns1.nameserver.tld'` - host name of the primary name server.
- `'example@email.tld'` - DNS admin email.
- `'2000'` - the refresh rate. The value must be between **1200** and **43200** seconds.
- `'3000'` - the retry rate. The value must be between **180** and **2419200** seconds.
- `'2000000'` - the expire rate. The value must be between **1209600** and **2419200** seconds.
- `'3600'` - the default TTL. The value must be between **60** and **2419200** seconds.
</details>
<br />

<details><summary>23. Get DynamicURL.</summary>


- **Description**: Returns the DynamicURL of an A or AAAA record.

- **Example**:
  
```
<?php
$exampleVar->dnsGetDynamicURL('domain.tld', 12345);

?>
```

**where**:
- `'domain.tld'` - the DNS zone of the A or AAAA record.
- `'12345'` - the ID of the A or AAAA record. It can be acquired from the **List records** function.

</details>
<br />

<details><summary>24. Disable DynamicURL.</summary>


- **Description**: Disable the DynamicURL of an A or AAAA record.

- **Example**:
  
```
<?php
$exampleVar->dnsDisableDynamicURL('domain.tld', '12345');

?>
```

**where**:
- `'domain.tld'` - the DNS zone of the A or AAAA record.
- `'12345'` - the ID of the A or AAAA record. It can be acquired from the **List records** function.

</details>
<br />

<details><summary>25. Change DynamicURL.</summary>


- **Description**: Change the DynamicURL of an A or AAAA record.

- **Example**:
  
```
<?php
$exampleVar->dnsDisableDynamicURL('domain.tld', '12345');

?>
```

**where**:
- `'domain.tld'` - the DNS zone of the A or AAAA record.
- `'12345'` - the ID of the A or AAAA record. It can be obtained from the **List records** function.

</details>
<br />

<details><summary>26. Change record's status.</summary>


- **Description**: Changes the status of the record to active/inactive.

- **Example**:
  
```
<?php
$exampleVar->dnsChangeRecordStatus('domain.tld', '12345', 1);

?>
```

**where**:
- `'domain.tld'` - the DNS zone, where the records will be imported to.
- `'12345'` - the ID of the record. It can be obtained from the **List records** function.
- `'1'` - **optional**. Status indicator - **1** to activate the record and **0** to deactivate it. If the argument is skipped the status will be toggled.

</details>
<br />

<details><summary>27. Add master server.</summary>


- **Description**: Add new master server to a DNS zone. Only available for Slave DNS zones and Slave Reverse DNS zones.

- **Example**:
  
```
<?php
$exampleVar->dnsAddMasterServer('domain.tld', '1.2.3.4');

?>
```

**where**:
- `'domain.tld'` - the Slave or Slave Reverse DNS zone, which the new master server will be added for.
- `'1.2.3.4'` - the IP address of the new master server.

</details>
<br />

<details><summary>28. Delete master server.</summary>


- **Description**: Delete master server of a DNS zone. Only available for Slave DNS zones and Slave Reverse DNS zones.

- **Example**:
  
```
<?php
$exampleVar->dnsDeleteMasterServer('domain.tld', '12345');

?>
```

**where**:
- `'domain.tld'` - the Slave or Slave Reverse DNS zone, which the master server will be deleted for.
- `'12345'` - the ID of the master server. It can be obtained from the **List master servers** function.

</details>
<br />

<details><summary>29. List master servers.</summary>


- **Description**: List the master servers of the DNS zone. Only available for Slave DNS zones and Slave Reverse DNS zones.

- **Example**:
  
```
<?php
$exampleVar->dnsListMasterServer('domain.tld');

?>
```
- `'domain.tld'` - the Slave or Slave Reverse DNS zone, which the master server will be listed for.

</details>
<br />

<details><summary>30. Get mail forwards statistics.</summary>


- **Description**: Gives details about the amount of mail servers and the mail forwards limit that is available for the account.

- **Example**:
  
```
<?php
$exampleVar->dnsMailForwardsStats();

?>
```

</details>
<br />

<details><summary>31. Available mail forward servers.</summary>


- **Description**: Shows the available mail forward servers for the account.

- **Example**:
  
```
<?php
$exampleVar->dnsAvailableMailForwards();

?>
```

</details>
<br />

<details><summary>32. Add mail forward.</summary>


- **Description**: Add new mail forward to the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsAddMailForward('domain.tld', 'apitest', 'mail', 'anzhelo@cloudns.net');

?>
```

</details>
<br />

<details><summary>33. Delete mail forward.</summary>


- **Description**: Delete a mail forward in the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsDeleteMailForward('domain.tld', '12345');

?>
```

**where**:
- `'domain.tld'` - the DNS zone, which the new mail forward will be added for.
- `'12345'` - the ID of the mail forward. It can be obtained from the **List mail forwards** function.

</details>
<br />

<details><summary>34. Modify (edit) mail forward.</summary>


- **Description**: Delete a mail forward in the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsModifyMailForward('domain.tld', 'box', 'host', 'example@email.tld', '12345');

?>
```

**where**:
- `'domain.tld'` - the DNS zone of the mail forward, which will be modified (edited).
- `'box'` - the mail box of the mail forward (e.g. admin, support, service, etc.).
- `'host'` - the host, which is configured for mail server (generally the one, that MX record(s) are added for).
- `'example@email.tld'` - the email address, which the email messages will be forwarded to.
- `'12345'` - the ID of the mail forward. It can be obtained from the **List mail forwards** function.

</details>
<br />

<details><summary>35. List mail forwards.</summary>


- **Description**: List the mail forwards of the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsListMailForwards('domain.tld');

?>
```

**where**:
- `'domain.tld'` - the DNS zone, which the mail forwards will be listed for.

</details>
<br />

<details><summary>36. Add cloud domain.</summary>


- **Description**: Adds a cloud domain.

- **Example**:
  
```
<?php
$exampleVar->dnsAddCloudDomain('domain.tld', 'cloud-domain.tld');

?>
```

**where**:
- `'domain.tld'` - master domain of the cloud.
- `'cloud-domain.tld'` - the new domain in the cloud.

</details>
<br />

<details><summary>37. Delete cloud domain.</summary>


- **Description**: Deletes a cloud domain.

- **Example**:
  
```
<?php
$exampleVar->dnsDeleteCloudDomain('cloud-domain.tld');

?>
```

**where**:
- `'cloud-domain.tld'` - the cloud domain that will be deleted.

</details>
<br />

<details><summary>38. Change cloud master.</summary>


- **Description**: Sets a new master of the cloud.

- **Example**:
  
```
<?php
$exampleVar->dnsChangeCloudMaster('domain.tld');

?>
```

**where**:
- `'domain.tld'` - domain name of the new cloud master.

</details>
<br />

<details><summary>39. List cloud domains.</summary>


- **Description**: Lists all domains in the cloud.

- **Example**:
  
```
<?php
$exampleVar->dnsListCloudDomains('domain.tld');

?>
```

**where**:
- `'domain.tld'` - domain name of the cloud master.

</details>
<br />

<details><summary>40. Add new IP.</summary>


- **Description**: Adds new IP address of a slave server for zone transfers.

- **Example**:
  
```
<?php
$exampleVar->dnsAllowNewIP('domain.tld', '1.2.3.4');

?>
```

**where**:
- `'domain.tld'` - domain name, for which the new IP address of a slave server will be add for zone transfers.
- `'1.2.3.4'` - IP address of the slave server.

</details>
<br />

<details><summary>41. Allow new IP.</summary>


- **Description**: Adds (allows) new IP address of a slave server for zone transfers.

- **Example**:
  
```
<?php
$exampleVar->dnsAllowNewIP('domain.tld', '1.2.3.4');

?>
```

**where**:
- `'domain.tld'` - domain name, for which the new IP address of a slave server will be added (allowed) for zone transfers.
- `'1.2.3.4'` - IP address of the slave server.

</details>
<br />

<details><summary>42. Delete an allowed IP.</summary>


- **Description**: Removes slave server's IP address for zone transfers.

- **Example**:
  
```
<?php
$exampleVar->dnsDeleteAllowedIP('domain.tld', '12345');

?>
```

**where**:
- `'domain.tld'` - domain name, for which the IP address of a slave server will be removed for zone transfers.
- `'12345'` - ID of the slave server. It can be obtained from the **List the allowed IPs** funciton.

</details>
<br />

<details><summary>43. List the allowed IP's.</summary>


- **Description**: List all of the allowed IP addresses for zone transfers.

- **Example**:
  
```
<?php
$exampleVar->dnsListAllowedIP('domain.tld');

?>
```

**where**:
- `'domain.tld'` - domain name, for which the allowed IP address for zone transfer will be listed.

</details>
<br />

<details><summary>44. Hourly statistics.</summary>


- **Description**: Shows hourly statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsHourlyStatistics('domain.tld', '2018', '12', '31');

?>
```

**where**:
- `'domain.tld'` - domain name, which the statistics will be shown for.
- `'2018'` - the year, which the statistics will be shown for.
- `'12'` - the month, which the statistics will be shown for.
- `'31'` - the day, which the statistics will be shown for.

</details>
<br />

<details><summary>45. Daily statistics.</summary>


- **Description**: Shows daily statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsDailyStatistics('domain.tld', '2018', '12');

?>
```

**where**:
- `'domain.tld'` - domain name, which the statistics will be shown for.
- `'2018'` - the year, which the statistics will be shown for.
- `'12'` - the month, which the statistics will be shown for.

</details>
<br />

<details><summary>46. Monthly statistics.</summary>


- **Description**: Shows monthly statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsMonthlyStatistics('domain.tld', '2018');

?>
```

**where**:
- `'domain.tld'` - domain name, which the statistics will be shown for.
- `'2018'` - the year, which the statistics will be shown for.

</details>
<br />

<details><summary>47. Yearly statistics.</summary>


- **Description**: Shows yearly statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsYearlyStatistics('domain.tld');

?>
```

**where**:
- `'domain.tld'` - domain name, which the statistics will be shown for.

</details>
<br />

<details><summary>48. Staistics for the last 30 days.</summary>


- **Description**: Shows statistics of the DNS zone for the last 30 days.

- **Example**:
  
```
<?php
$exampleVar->dnsLast30DaysStatistics('domain.tld');

?>
```

**where**:
- `'domain.tld'` - domain name, which the statistics will be shown for.

</details>
<br />

<details><summary>49. Get templates for parked pages.</summary>


- **Description**: Shows the templates, that we provide, fo.

- **Example**:
  
```
<?php
$exampleVar->dnsGetParkedTemplates();

?>
```

</details>
<br />

<details><summary>50. Get parked zones settings.</summary>


- **Description**: Shows the settings of the parked zone.

- **Example**:
  
```
<?php
$exampleVar->dnsGetParkedSettings('domain.tld');

?>
```

**where**:
- `'domain.tld'` - domain name of the parked zone.

</details>
<br />

<details><summary>51. Modify parked zones settings.</summary>


- **Description**: Modify (edit) the settings of a parked zone.

- **Example**:
  
```
<?php
$exampleVar->dnsModifyParkedSettings('domain.tld', '1', 'title', 'description', 'keywords', 'contact-form');

?>
```

**where**:
- `'domain.tld'` - domain name of the parked zone.
- `'1'` - id of the template for the parked zone. It can be **1**, **2**, **3** or **4**. The available templates can be obtained from the "Get templates for parked pages" function.
- `'title'` - **optional**. Title of the parked page.
- `'keywords'` - **optional**. Keywords of the parked page.
- `'contact-form'` - **optional**. Enables or disables the contact form of the parked page - **1** for enabled, **2** for disabled and **0** is the default value.

</details>
<br />

<details><summary>52. List GeoDNS locations.</summary>


- **Description**: Lists all the GeoDNS locations.

- **Example**:
  
```
<?php
$exampleVar->dnsListGeoDNSLocations('domain.tld');

?>
```

**where**:
- `'domain.tld'` - domain name of the GeoDNS zone.

</details>
<br />
