# ClouDNS SDK for HTTP API

## Introduction

This is the SDK for ClouDNS HTTP API. The document provides guidelines and examples on how to implement and use the ClouDNS SDK for our HTTP API. You can read more about the API at [cloudns.net](https://www.cloudns.net).

The SDK is based on the methods used in the [HTTP API](https://www.cloudns.net/wiki/article/41/).

## Table of contents
<!--ts-->
* [Basic integration and requirements](#basic-integration-and-requirements)
* [Installation](#installation)
* [Initialization](#initialization)
* [SDK Functions](#sdk-functions)
  * [DNS](#dns)
  * [Domain](#domain)
  * [SSL](#ssl)
  * [Sub](#sub)
<!--te-->

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
$exampleVar = new ClouDNS_SDK('example@email.tld', '123456789', true);

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

#### <details><summary>1. Available name servers.</summary>

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

### Domain

<details><summary>1. Check availability.</summary>


- **Description**: Check if a domain name is available for registration.

- **Example**:
  
```
<?php
$exampleVar->domainCheckAvailability('domain', array ('com', 'net', ... , 'tld'));

?>
```

**where**:
- `'domain'` - the name of the domain, that will be checked for availability (without the .TLD).
- `array ('com', 'net', ... , 'tld')` - array with TLD's, that will be checked in combination with the `'domain'`.

</details>
<br />

<details><summary>2. Domains price list.</summary>


- **Description**: Shows the price list of domain names.

- **Example**:
  
```
<?php
$exampleVar->domainsPriceList();

?>
```

</details>
<br />

<details><summary>3. Register new domain.</summary>


- **Description**: Submit an order for registration of new domain name.

- **Example**:
  
```
<?php
$exampleVar->domainsRegisterNewDomain('domain', 'tld', 'period', 'example@mail.tld', 'John Doe', 'Company Name LTD', 'Address', 'City', 'State', '10000', 'Country', '000', '123456789', '111', '987654321', array ('ns1.nameserver.tld', 'ns2.nameserver.tld', ... , 'nsn.nameserver.tld'), 'registrant-type', 'registrant-type-id', 'registrant-policy', 'birth-date', 'country-code', 'birth-city', 'city-postal-code', 'publication', 'VAT-number', 'Siren-number', 'DUNS-number', 'trademark', 'Waldec-number', 'organization-type', 'privacy-protection', 'code', 'publicity', 'kpp', 'passport-number', 'passport-issued-by', 'passport-issued-on');

?>
```

**where**:
- `'domain'` - the name of the domain.
- `'tld'` - the TLD of the domain.
- `'period'` - the registration period of the domain. The value entered is in years. The available periods can be obtained from the **List domain information** function.
- `'example@mail.tld' - the email address of the registrant.
- `'John Doe'` - the name of the registrant.
- `'Company Name LTD'` - the name of the company.
- `'Address'` - the address of the registrant/company.
- `'City'` - the city of the registrant/company.
- `'State'` - the state, e.g. Texas.
- `'10000'` - the zip code.
- `'Country'` - the country of the registrant/company, which must be entered only with 2 letters according to ISO 3166:
For .de domain names it must be DE

For .uk domain names it must be one of the following: GB (United Kingdom), IM (Isle of Man), JE (Jersey) or GG (Guernsey).

For *.br domains (com.br, net.br, pro.br, arq.br, eco.br, ind.br, art.br, eng.br, adv.br, mus.br, blog.br) it must be BR.
- `'000'` - the calling code of the phone number. Can be between 1 and 3 digits.
- `'123456789'` - the phone number.
- `'111'` - **optional**. The calling code of the fax number. Can be between 1 and 3 digits.
- `'987654321'` - **optional**. The fax number.
- `array ('ns1.nameserver.tld', 'ns2.nameserver.tld', ... , 'nsn.nameserver.tld')` - **optional**. The name servers, that the domain will be pointed at upon finishing the registration.
- `'registrant-type'` - **optional**. Required field for specific TLDs.

Required for .fr/.re/.pm/.tf/.wf/.yt domain names. Possible values:

INDIVIDUAL - additional fields need to be added for this type
COMPANY - company name is a mandatory field when the registrant type is COMPANY
TRADEMARK - company name and an additional field for the trademark name need to be added for this type
ASSOCIATION - company (associacion) name and additional field for the waldec should be added
OTHER - company (organization) name and additional field for the registrant type should be added
Required for .com.au and .net.au domain names. Possible values:

ACN - Australian Company Number
ABN - Australian Business Number
VIC_BN - Victoria Business Number
NSW_BN - New South Wales Business Number
SA_BN - South Australia Business Number
NT_BN - Northern Territory Business Number
WA_BN - Western Australia Business Number
TAS_BN - Tasmania Business Number
ACT_BN - Australian Capital Territory Business Number
QLD_BN - Queensland Business Number
TM - Trademark number
ARBN - Registrant's Australian Registered Body Number
Other
Required for .it domain names. Possible values:

1 -  Italian and foreign natural persons
2 - Companies/one man companies
3 - Freelance workers/professionals
4 - Non-profit organizations
5 - Public organizations
6 - Other subjects
7 - Foreigners who match 2-6  
Required for .ru domain names. Possible values:

ORG
PRS
Required for .ca domain names. Possible values:

CCO - Corporation (Canada or Canadian province or territory)
CCT - Canadian citizen
RES - Permanent Resident of Canada
GOV - Government or government entity in Canada
EDU - Canadian Educational institution
ASS - Canadian Unincorporated Association
HOP - Canadian Hospital
PRT - Partnership Registered in Canada
TDM - Trade-mark registered in Canada (by a non-Canadian owner)
TRD - Canadian Trade union
PLT - Canadian Political party
LAM - Canadian Library, Archive or Museum
TRS - Trust established in Canada
ABO - Aboriginal Peoples (individuals or groups) indigenous to Canada
INB - Indian Band recognized by the Indian Act of Canada
LGR - Legal Representative of a Canadian Citizen or Permanent Resident
OMK - Official mark registered in Canada
MAJ - Her Majesty the Queen
Required for .com.au and .net.au domain names. Possible values:

ACN - This is the Registrant's Australian Company Number.
ABN - This is the Registrant's Australian Business Number.
VIC BN - This is the Registrant's Victoria Business Number.
NSW BN - This is the Registrant's New South Wales Business Number.
SA BN - This is the Registrant's South Australia Business Number.
NT BN - This is the Registrant's Northern Territory Business Number.
WA BN - This is the Registrant's Western Australia Business Number.
TAS BN - This is the Registrant's Tasmania Business Number.
ACT BN - This is the Registrant's Australian Capital Territory Business Number.
QLD BN - This is the Registrant's Queensland Business Number.
TM - This is the Registrant's Trademark number.
ARBN - This is the Registrant's Registrant's Australian Registered Body Number (ARBN).
Required for .es domain names. Possible values:

1 - Natural person or individual
39 - Economic Interest Grouping
47 - Association
59 - Sports Association
68 - Trade Association
124 - Savings Bank
150 - Community Property
152 - Condominium
164 - Religious Order or Institution
181 - Consulate
197 - Public Law Association
203 - Embassy
229 - Municipality
269 - Sports Federation
286- Foundation
365 - Mutual Insurance Company
434 - Provincial Government Body
436 - National Government Body
439 - Political Party
476 - Trade Union
510 - Farm Partnership
524 - Public Limited Company / Corporation
525 - Sports Public Limited Company
554 - Partnership
560 - General Partnership
562 - Limited Partnership
566 - Cooperative
608 - Worker-owned Company
612 - Limited Liability Company
713 - Spanish (company) Branch
717 - Temporary Consortium / Joint Venture
744 - Worker-owned Limited Company
745 - Provincial Government Entity
746 - National Government Entity
747 - Local Government Entity
877 - Others
878 - Designation of Origin Regulatory Council
879 - Natural Area Management Entity
Required for *.br domain names. Possible values:

ORG for a company
PRS for a private person
Required for *.cn domain names. Possible values:

cnhosting for site, hosted in Mainland China
nocnhosting for site, hosted outside Mainland China
Required for *.ro domain names. Possible values:

p - Person
ap - Authorized person
nc - Non-commercial
c - Commercial
gi - Government Institution
pi - Public Institution
o - Other

- `'registrant-type-id'` - **optional**. Required for specific TLD's.

Required for .com.au and .net.au domain names. Should contain the ID of the number choosen registrant type in the registrant_type parameter.

Required field for .es domain names. Possible values:

1 - DNI or NIF - Provide either the Spanish National Personal ID or company VAT ID number.
3 - NIE - Provide the Spanish resident alien ID number
0 - Other ID - If you do not have any of the above mentioned IDs, provide either your Passport number, any Foreign ID document number, Company Registration number, Driver's License number, etc.
Required field for .ro domain names, if country is RO.

An identification number for pesons (personal ID, passport number, driving license, etc), fiscal code for companies or other unique identification number or sequence of characters for juridical entities. Mandatory for Romanian entities. Optional for foreigners. Max Length: 40 chars. Min. Length: 5 chars.

- `'registrant-policy'` - **optional** - Required for specific TLD's.

Required for .com.au and .net.au domain names. Possible values:

1 - if Domain Name is an Exact Match OR Abbreviation OR Acronym of your Entity or Trading Name.
2 - if Close and substantial connection between the domain name and the operations of your Entity.

- `'birth-date'` - **optional**. The birth date of the registrant.
- `'country-code'` - **optional**. Birth country code.

Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL.

Optional field for .it (for Registrant contact only) Must be one of the  ISO 3166-1 codes (e.g.: IT, FR, NL, ..). If the Registrant is not a natural person (registrant_type <> 1) it must be equal to the registrant country code value. If the Registrant is a natural  person (registrant_type = 1), the registrant country code and the birth_cc fields may differ but at least one of them must correspond to the ISO 3166-1 code of a country belonging to the European Union.

Format: US

- `'birth-city'` - **optional**. Birth city name. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL.
- `'city-postal-code'` - **optional**. Postal code of the birth city. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL.
- `'publication'` - **optional**. Restricted or Non-Restricted publication of the individual details. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL. Possible values:

0 - Non-Restricted
1 - Restricted

- `'VAT-number'` - **optional**. EU VAT number. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is COMPANY, TRADEMARK or ASSOCIATION.
- `'Siren-number'` - **optional**. Siren number of the company (organization). Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is COMPANY, TRADEMARK or ASSOCIATION.
- `'DUNS-number'` - **optional**. DUNS number of the company (organization). Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is COMPANY, TRADEMARK or ASSOCIATION.
- `'trademark'` - **optional**. Only for specific TLDs.

Required field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is TRADEMARK. The parameter should contain the name of the trademark.

Required field for .com.au and .net.au domain names when the registrant_type is TM. The parameter should be "Trademark Owner" or "Pending TM Owner".

- `'Waldec-number'` - **optional**. Waldec number of the association. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is ASSOCIATION.
- `'organization-type'` - **optional**. Type of the organization. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is OTHER.
- `'privacy-protection'` - **optional**. Enabling/disabling Privacy Protection for the domain. 0=disabled and 1=enabled. By default the Privacy Protection is disabled.
- `'code'` - **optional**. 

Optional field for .it domains. Identification code | Entering wrong information in this field may lead to cancelation of your domain.

If the requester is an Italian natural person it contains his/her tax code (Codice Fiscale).

For foreign natural persons it can contain a document number (like passport number or ID card number).

For Italian associations without VAT number and numeric tax code must be equal to 'n.a.'.

In all the other cases must be equal to VAT number (in the 11 numbers format if Nationality is Italian) or the numeric tax code.
Optional field for .ru domain names. This value is the Taxpayer Identification Number (TIN). This is a 10 digit number and is mandatory for Organization Contact Type, when the Country is Russia.

Required filed for .es domain names. Depending upon which registrant_type_id you provided, mention that ID's number as a value.

Required filed for *.br domain names. CPF number for Individuals and CNPJ number for Organizations.

Required filed for *.cn domain names. Organization ID.

Required for *.ro domain names. Mandatory for Commercial Romanian entities (where person_type is 'c'). Optional for foreigners or other Romanian entities. Max Length: 40 chars. 

- `'publicity'` - **optional**. Available for .it domain names.  (Consent to the processing of personal data for registration) Possible field values: 1=yes, 0=NO. If NO is used the request will fail.
- `'kpp'` - **optional**. Available for .ru domain names. His value is the Territory-linked Taxpayer number. This is a 9 digit number and is mandatory for the Organization Contact Type, when the Country is Russia.
- `'passport-number'` - **optional**. Available for .ru domain names. Document Number.
- `'passport-issued-by'` - **optional**. Available for .ru domain names. Document issued by (123 police station of Moscow).
- `'passport-issued-on` - **optional**. Available for .ru domain names. Passport issued date. Format: DD.MM.YYYY.

</details>
<br />

<details><summary>4. Renew domain.</summary>


- **Description**: Submit an order for a renewal of domain name.

- **Example**:
  
```
<?php
$exampleVar->domainsRenewDomain('domain.tld', 1);

?>
```
**where**:

- `'domain.tld'` - the domain name that will be renewed.
- `'1'` - the period, for which the domain name will be renewed.

</details>
<br />

<details><summary>5. Transfer domain.</summary>


- **Description**: Start the transfer process of a domain name.

- **Example**:
  
```
<?php
$exampleVar->domainsTransferDomain('domain', 'tld', 'example@mail.tld', 'John Doe', 'Company Name LTD', 'Address', 'City', 'State', '10000', 'Country', '000', '123456789', '111', '987654321', 'transfer-code', 'registrant-type', 'birth-date', 'country-code', 'birth-city', 'city-postal-code', 'publication', 'VAT-number', 'Siren-number', 'DUNS-number', 'trademark', 'Waldec-number', 'organization-type', 'privacy-protection', 'code', 'registrant-type-id', 'publicity', 'ns', 'kpp', 'passport-number', 'passport-issued-by', 'passport-issued-on');
;

?>
```
**where**:

- `'domain'` - the name of the domain.
- `'tld'` - the TLD of the domain.
- `'example@mail.tld'` - the email address of the registrant.
- `'John Doe'` - the name of the registrant.
- `'Company Name LTD'` - the name of the company.
- `'Address'` - the address of the registrant/company.
- `'City'` - the city of the registrant/company.
- `'State'` - the state, e.g. Texas.
- `'10000'` - the zip code.
- `'Country'` - the country of the registrant/company, which must be entered only with 2 letters according to ISO 3166:
For .de domain names it must be DE

For .uk domain names it must be one of the following: GB (United Kingdom), IM (Isle of Man), JE (Jersey) or GG (Guernsey).

For *.br domains (com.br, net.br, pro.br, arq.br, eco.br, ind.br, art.br, eng.br, adv.br, mus.br, blog.br) it must be BR.
- `'000'` - the calling code of the phone number. Can be between 1 and 3 digits.
- `'123456789'` - the phone number.
- `'111'` - **optional**. The calling code of the fax number. Can be between 1 and 3 digits.
- `'987654321'` - **optional**. The fax number.
- `'transfer-code'` - **optional**. Transfer code given by the current registrar, if it is required for the TLD.
- `'registrant-type'` - **optional**. Required field for specific TLDs.

Required for .fr/.re/.pm/.tf/.wf/.yt domain names. Possible values:

INDIVIDUAL - additional fields need to be added for this type
COMPANY - company name is a mandatory field when the registrant type is COMPANY
TRADEMARK - company name and an additional field for the trademark name need to be added for this type
ASSOCIATION - company (associacion) name and additional field for the waldec should be added
OTHER - company (organization) name and additional field for the registrant type should be added
Required for .com.au and .net.au domain names. Possible values:

ACN - Australian Company Number
ABN - Australian Business Number
VIC_BN - Victoria Business Number
NSW_BN - New South Wales Business Number
SA_BN - South Australia Business Number
NT_BN - Northern Territory Business Number
WA_BN - Western Australia Business Number
TAS_BN - Tasmania Business Number
ACT_BN - Australian Capital Territory Business Number
QLD_BN - Queensland Business Number
TM - Trademark number
ARBN - Registrant's Australian Registered Body Number
Other
Required for .it domain names. Possible values:

1 -  Italian and foreign natural persons
2 - Companies/one man companies
3 - Freelance workers/professionals
4 - Non-profit organizations
5 - Public organizations
6 - Other subjects
7 - Foreigners who match 2-6  
Required for .ru domain names. Possible values:

ORG
PRS
Required for .ca domain names. Possible values:

CCO - Corporation (Canada or Canadian province or territory)
CCT - Canadian citizen
RES - Permanent Resident of Canada
GOV - Government or government entity in Canada
EDU - Canadian Educational institution
ASS - Canadian Unincorporated Association
HOP - Canadian Hospital
PRT - Partnership Registered in Canada
TDM - Trade-mark registered in Canada (by a non-Canadian owner)
TRD - Canadian Trade union
PLT - Canadian Political party
LAM - Canadian Library, Archive or Museum
TRS - Trust established in Canada
ABO - Aboriginal Peoples (individuals or groups) indigenous to Canada
INB - Indian Band recognized by the Indian Act of Canada
LGR - Legal Representative of a Canadian Citizen or Permanent Resident
OMK - Official mark registered in Canada
MAJ - Her Majesty the Queen
Required for .com.au and .net.au domain names. Possible values:

ACN - This is the Registrant's Australian Company Number.
ABN - This is the Registrant's Australian Business Number.
VIC BN - This is the Registrant's Victoria Business Number.
NSW BN - This is the Registrant's New South Wales Business Number.
SA BN - This is the Registrant's South Australia Business Number.
NT BN - This is the Registrant's Northern Territory Business Number.
WA BN - This is the Registrant's Western Australia Business Number.
TAS BN - This is the Registrant's Tasmania Business Number.
ACT BN - This is the Registrant's Australian Capital Territory Business Number.
QLD BN - This is the Registrant's Queensland Business Number.
TM - This is the Registrant's Trademark number.
ARBN - This is the Registrant's Registrant's Australian Registered Body Number (ARBN).
Required for .es domain names. Possible values:

1 - Natural person or individual
39 - Economic Interest Grouping
47 - Association
59 - Sports Association
68 - Trade Association
124 - Savings Bank
150 - Community Property
152 - Condominium
164 - Religious Order or Institution
181 - Consulate
197 - Public Law Association
203 - Embassy
229 - Municipality
269 - Sports Federation
286- Foundation
365 - Mutual Insurance Company
434 - Provincial Government Body
436 - National Government Body
439 - Political Party
476 - Trade Union
510 - Farm Partnership
524 - Public Limited Company / Corporation
525 - Sports Public Limited Company
554 - Partnership
560 - General Partnership
562 - Limited Partnership
566 - Cooperative
608 - Worker-owned Company
612 - Limited Liability Company
713 - Spanish (company) Branch
717 - Temporary Consortium / Joint Venture
744 - Worker-owned Limited Company
745 - Provincial Government Entity
746 - National Government Entity
747 - Local Government Entity
877 - Others
878 - Designation of Origin Regulatory Council
879 - Natural Area Management Entity
Required for *.br domain names. Possible values:

ORG for a company
PRS for a private person
Required for *.cn domain names. Possible values:

cnhosting for site, hosted in Mainland China
nocnhosting for site, hosted outside Mainland China
Required for *.ro domain names. Possible values:

p - Person
ap - Authorized person
nc - Non-commercial
c - Commercial
gi - Government Institution
pi - Public Institution
o - Other

- `'birth-date'` - **optional**. The birth date of the registrant.
- `'country-code'` - **optional**. Birth country code.

Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL.

Optional field for .it (for Registrant contact only) Must be one of the  ISO 3166-1 codes (e.g.: IT, FR, NL, ..). If the Registrant is not a natural person (registrant_type <> 1) it must be equal to the registrant country code value. If the Registrant is a natural  person (registrant_type = 1), the registrant country code and the birth_cc fields may differ but at least one of them must correspond to the ISO 3166-1 code of a country belonging to the European Union.

Format: US

- `'birth-city'` - **optional**. Birth city name. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL.
- `'city-postal-code'` - **optional**. Postal code of the birth city. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL.
- `'publication'` - **optional**. Restricted or Non-Restricted publication of the individual details. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is INDIVIDUAL. Possible values:

0 - Non-Restricted
1 - Restricted

- `'VAT-number'` - **optional**. EU VAT number. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is COMPANY, TRADEMARK or ASSOCIATION.
- `'Siren-number'` - **optional**. Siren number of the company (organization). Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is COMPANY, TRADEMARK or ASSOCIATION.
- `'DUNS-number'` - **optional**. DUNS number of the company (organization). Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is COMPANY, TRADEMARK or ASSOCIATION.
- `'trademark'` - **optional**. Only for specific TLDs.

Required field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is TRADEMARK. The parameter should contain the name of the trademark.

Required field for .com.au and .net.au domain names when the registrant_type is TM. The parameter should be "Trademark Owner" or "Pending TM Owner".

- `'Waldec-number'` - **optional**. Waldec number of the association. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is ASSOCIATION.
- `'organization-type'` - **optional**. Type of the organization. Optional field for .fr/.re/.pm/.tf/.wf/.yt domain names when the registrant_type is OTHER.
- `'privacy-protection'` - **optional**. Enabling/disabling Privacy Protection for the domain. 0=disabled and 1=enabled. By default the Privacy Protection is disabled.
- `'code'` - **optional**. 

Optional field for .it domains. Identification code | Entering wrong information in this field may lead to cancelation of your domain.

If the requester is an Italian natural person it contains his/her tax code (Codice Fiscale).

For foreign natural persons it can contain a document number (like passport number or ID card number).

For Italian associations without VAT number and numeric tax code must be equal to 'n.a.'.

In all the other cases must be equal to VAT number (in the 11 numbers format if Nationality is Italian) or the numeric tax code.
Optional field for .ru domain names. This value is the Taxpayer Identification Number (TIN). This is a 10 digit number and is mandatory for Organization Contact Type, when the Country is Russia.

Required filed for .es domain names. Depending upon which registrant_type_id you provided, mention that ID's number as a value.

Required filed for *.br domain names. CPF number for Individuals and CNPJ number for Organizations.

Required filed for *.cn domain names. Organization ID.

Required for *.ro domain names. Mandatory for Commercial Romanian entities (where person_type is 'c'). Optional for foreigners or other Romanian entities. Max Length: 40 chars. 
- `'registrant-type-id'` - **optional**. Required for specific TLD's.

Required for .com.au and .net.au domain names. Should contain the ID of the number choosen registrant type in the registrant_type parameter.

Required field for .es domain names. Possible values:

1 - DNI or NIF - Provide either the Spanish National Personal ID or company VAT ID number.
3 - NIE - Provide the Spanish resident alien ID number
0 - Other ID - If you do not have any of the above mentioned IDs, provide either your Passport number, any Foreign ID document number, Company Registration number, Driver's License number, etc.
Required field for .ro domain names, if country is RO.

An identification number for pesons (personal ID, passport number, driving license, etc), fiscal code for companies or other unique identification number or sequence of characters for juridical entities. Mandatory for Romanian entities. Optional for foreigners. Max Length: 40 chars. Min. Length: 5 chars.
- `'publicity'` - **optional**. Available for .it domain names.  (Consent to the processing of personal data for registration) Possible field values: 1=yes, 0=NO. If NO is used the request will fail.
- `'ns'` - **optional**. Required for **.be** domain names.
- `'kpp'` - **optional**. Available for .ru domain names. His value is the Territory-linked Taxpayer number. This is a 9 digit number and is mandatory for the Organization Contact Type, when the Country is Russia.
- `'passport-number'` - **optional**. Available for .ru domain names. Document Number.
- `'passport-issued-by'` - **optional**. Available for .ru domain names. Document issued by (123 police station of Moscow).
- `'passport-issued-on` - **optional**. Available for .ru domain names. Passport issued date. Format: DD.MM.YYYY.

</details>
<br />

<details><summary>6. List registered domains.</summary>


- **Description**: Get a list with registered domains. Can be combined with a certain criteria (keyword), which the result will be based on.

- **Example**:
  
```
<?php
$exampleVar->domainsListRegisteredDomains(10, 1, 'keyword');

?>
```
**where**:

- `'10'` - amount of results per page. It can be 10, 20, 30, 50 or 100.
- `'1'` - the current page of your zone list;
- `'keyword'` - **optional**. A specific criteria (keyword), that the results will be based on.

</details>
<br />

<details><summary>7. Get pages count.</summary>


- **Description**: Amount of pages with registered domains currently in your account. It can be combined to give results based on criteria (keyword).

- **Example**:

```
<?php
$exampleVar->domainsGetPagesCount('10', 'keyword');

?>
```

**where**:
- `'10'` - amount of results per page. It can be 10, 20, 30, 50 or 100.
- `'keyword'` - **optional**. A specific criteria (keyword), that your results will be based on.
</details>
<br />

<details><summary>8. Domain information.</summary>


- **Description**: Gives information about the domain name.

- **Example**:

```
<?php
$exampleVar->domainsDomainInfo('domain.tld');

?>
```

**where**:
- `'domain.tld'` - name of the registered domain, which the information will be given for.

</details>
<br />

<details><summary>9. Contact details.</summary>


- **Description**: Shows the contact details of a registered domain in four groups: Registrant Details, Administrative Contact, Technical contact and Billing Contact.

- **Example**:

```
<?php
$exampleVar->domainsGetContacts('domain.tld');

?>
```

**where**:
- `'domain.tld'` - the registered domain name, which contact details will be shown for.

</details>
<br />

<details><summary>10. Modify contacts.</summary>


- **Description**: Shows the contact details of a registered domain in four groups: Registrant Details, Administrative Contact, Technical contact and Billing Contact.

- **Example**:

```
<?php
$exampleVar->domainsModifyContacts('domain', 'tld', 'details type', 'example@mail.tld', 'John Doe', 'Company Name LTD', 'Address', 'City', 'State', '10000', 'Country', 000, '123456789', 111, 987654321);

?>
```

**where**:
- `'domain'` - the name of the domain.
- `'tld'` - the TLD of the domain.
- `'details type'` - the type of contacts, that will be modified. They can be obtained from the **Contact details** function. 
- `'example@mail.tld'` - the email address of the registrant.
- `'John Doe'` - the name of the registrant.
- `'Company Name LTD'` - the name of the company.
- `'Address'` - the address of the registrant/company.
- `'City'` - the city of the registrant/company.
- `'State'` - the state, e.g. Texas.
- `'10000'` - the zip code.
- `'Country'` - the country of the registrant/company, which must be entered only with 2 letters according to ISO 3166:
For .de domain names it must be DE

For .uk domain names it must be one of the following: GB (United Kingdom), IM (Isle of Man), JE (Jersey) or GG (Guernsey).

For *.br domains (com.br, net.br, pro.br, arq.br, eco.br, ind.br, art.br, eng.br, adv.br, mus.br, blog.br) it must be BR.
- `'000'` - the calling code of the phone number. Can be between 1 and 3 digits.
- `'123456789'` - the phone number.
- `'111'` - **optional**. The calling code of the fax number. Can be between 1 and 3 digits.
- `'987654321'` - **optional**. The fax number.

</details>
<br />

<details><summary>11. List name servers.</summary>


- **Description**: Shows a list with name servers for a registered domain name.

- **Example**:

```
<?php
$exampleVar->domainsListNameServers('domain.tld');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.

</details>
<br />

<details><summary>12. Modify name servers.</summary>


- **Description**: Modifiy (edit) the name servers for a registered domain name.

- **Example**:

```
<?php
$exampleVar->domainsModifyNameServers('domain.tld', array ('ns1.nameserver.tld', 'ns2.nameserver.tld', ... 'nsn.nameserver.tld));

?>
```

**where**:
- `'domain.tld'` - the registered domain name.
- `'array ('ns1.nameserver.tld', 'ns2.nameserver.tld', ... 'nsn.nameserver.tld)'` - array with name servers, that will be modified for the domain name.

</details>
<br />

<details><summary>13. Get child name servers.</summary>


- **Description**: Shows a list of child name servers (Glue records) for the domain name.

- **Example**:

```
<?php
$exampleVar->domainsGetChildNameServers('domain.tld');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.

</details>
<br />

<details><summary>14. Add child name servers.</summary>


- **Description**: Add a child name server to a domain name.

- **Example**:

```
<?php
$exampleVar->domainsAddChildNameServers('domain.tld', 'nshost', '1.2.3.4');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.
- `'nshost'` - host of the child name server.
- `'1.2.3.4'` - IP of the child name server.

</details>
<br />

<details><summary>15. Delete child name servers.</summary>


- **Description**: Delete a child name server from a domain name.

- **Example**:

```
<?php
$exampleVar->domainsDeleteChildNameServers('domain.tld', 'nshost', '1.2.3.4');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.
- `'nshost'` - host of the child name server.
- `'1.2.3.4'` - IP of the child name server.

</details>
<br />

<details><summary>16. Modify child name servers.</summary>


- **Description**: Modify a child name server of a domain name.

- **Example**:

```
<?php
$exampleVar->domainsModifyChildNameServers('domain.tld', 'nshost', '1.2.3.4', '4.3.2.1');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.
- `'nshost'` - host of the child name server.
- `'1.2.3.4'` - old IP of the child name server.
- `'4.3.2.1'` - new IP of the child name server.

</details>
<br />

<details><summary>17. Modify Privacy Protection.</summary>


- **Description**: Enables/Disables the Privacy Protection of a domain name. The current state of it can be obtained from the **Domain information** function.

- **Example**:

```
<?php
$exampleVar->domainsModifyPrivacyProtection('domain.tld', '1');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.
- `'1'` - Privacy Protection status - **1** for enable and **0** for disable.

</details>
<br />

<details><summary>18. Modify transfer lock.</summary>


- **Description**: Enables/Disables the transfer lock of a domain name. The current state of it can be obtained from the **Domain information** function.

- **Example**:

```
<?php
$exampleVar->domainsModifyTransferLock('domain.tld', '1');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.
- `'1'` - transfer lock status - **1** for enable and **0** for disable.

</details>
<br />

<details><summary>19. Get transfer code.</summary>


- **Description**: Shows the transfer code (auth code) of the domain name.

- **Example**:

```
<?php
$exampleVar->domainsGetTransferCode('domain.tld');

?>
```

**where**:
- `'domain.tld'` - the registered domain name, for which the transfer code will be shown.

</details>
<br />

<details><summary>20. Resent RAA verification.</summary>


- **Description**: Resend the verification e-mail to the administrative contact of the domain name.

- **Example**:

```
<?php
$exampleVar->domainsResendRAAVerification('domain.tld');

?>
```

**where**:
- `'domain.tld'` - the registered domain name.

</details>
<br />

### SSL

<details><summary>1. Order new SSL.</summary>


- **Description**: Places an order for a new SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslOrderNewSSL('domain.tld', '1', '2');

?>
```

**where**:
- `'domain.tld'` - domain name, which the SSL certificate will be ordered for.
- `'1'` - the period of the SSL certificate. The value is in years.
- `'2'` - type of the SSL certificate - **2 - Wildcard Positive SSL**, **3 - Positive SSL**.

</details>
<br />

<details><summary>2. List certificates.</summary>


- **Description**: Get a list of ordered and owned SSL certificates.

- **Example**:

```
<?php
$exampleVar->sslListOrderedCertificates('1', '10');

?>
```

**where**:
- `'1'` - the page, your SSL list is currently on.
- `'10'` - the amount of results per page. It can be **10**, **20**, **30**, **50** or **100**.

</details>
<br />

<details><summary>3. Get pages count.</summary>


- **Description**: Shows the number of pages for your SSL certificates.

- **Example**:

```
<?php
$exampleVar->sslGetPagesCount('10');

?>
```

**where**:
- `'10'` - the amount of results per page. It can be **10**, **20**, **30**, **50** or **100**.

</details>
<br />

<details><summary>4. SSL Information.</summary>


- **Description**: Shows information about the SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslInformation('ssl_id');

?>
```

**where**:
- 'ssl_id' - the ID of the SSL certificate. It can be obtained from the **List certificates** function.

</details>
<br />

<details><summary>5. Submit CSR.</summary>


- **Description**: Submit CSR key for an SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslSubmitCSR('ssl_id', 'example@mail.tld', '-----BEGIN CERTIFICATE REQUEST----- ... -----END CERTIFICATE REQUEST-----');

?>
```

**where**:
- `'ssl_id'` - the ID of the SSL certificate. It can be obtained from the **List certificates** function.
- `'example@mail.tld'` - email address, which the owner of the certificate has access to.
- `'-----BEGIN CERTIFICATE REQUEST----- ... -----END CERTIFICATE REQUEST-----'` - the CSR key.

</details>
<br />

<details><summary>6. Renew SSL.</summary>


- **Description**: Renew an SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslRenew('ssl_id', '1');

?>
```

**where**:
- `'ssl_id'` - the ID of the SSL certificate. It can be obtained from the **List certificates** function.
- `'1'` - the period, which the sertificate will be renewed for.

</details>
<br />

<details><summary>7. Change SSL verification e-mail.</summary>


- **Description**: Changes the verification e-mail of the SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslChangeVerificationMail('ssl_id', 'example@mail.tld');

?>
```

**where**:
- `'ssl_id'` - the ID of the SSL certificate. It can be obtained from the **List certificates** function.
- `'example@mail.tld'` - the new email address, which the owner of the certificate has access to.

</details>
<br />

<details><summary>8. Reissue SSL.</summary>


- **Description**: Reissue an SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslReissue('ssl_id', 'example@mail.tld', '-----BEGIN CERTIFICATE REQUEST----- ... -----END CERTIFICATE REQUEST-----');

?>
```

**where**:
- `'ssl_id'` - the ID of the SSL certificate. It can be obtained from the **List certificates** function.
- `'example@mail.tld'` - email address, which the owner of the certificate has access to.
- `'-----BEGIN CERTIFICATE REQUEST----- ... -----END CERTIFICATE REQUEST-----'` - the CSR key.

</details>
<br />

<details><summary>9. List SSL verification e-mails.</summary>


- **Description**: Shows a list of all the allowed verification e-mails for an SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslListVerificationMails('ssl_id');

?>
```

**where**:
- `'ssl_id'` - the ID of the SSL certificate. It can be obtained from the **List certificates** function.

</details>
<br />

### Sub

<details><summary>1. Add new sub user.</summary>


- **Description**: Adds a new API sub user.

- **Example**:

```
<?php
$exampleVar->subAddNewUser('123456789', '0', '0', '0.0.0.0');

?>
```

**where**:
- `'123456789'` - the password for the API sub user.
- `'0'` - amount of DNS zones, that the sub user will be allowed to use/create.
- `'0'` - amount of Mail forwards, that the sub user will be allowed to use/create.
- `'0.0.0.0'` - **optional**. The IP address to be whitelisted, which the sub user will only have access from. If no IP address is provided (the argument is skipped), access from all IP's will be allowed.

</details>
<br />

<details><summary>2. Get sub user's information.</summary>


- **Description**: Shows information for an API sub user.

- **Example**:

```
<?php
$exampleVar->subGetUserInfo('id');

?>
```

**where**:
- `'id'` - ID of the sub user.

</details>
<br />

<details><summary>3. Get pages count.</summary>


- **Description**: Shows the number of pages with sub users.

- **Example**:

```
<?php
$exampleVar->subGetPagesCount('10');

?>
```

**where**:
- `'10'` - the amount of results per page. It can be **10**, **20**, **30**, **50** or **100**.

</details>
<br />

<details><summary>4. Get pages count.</summary>


- **Description**: Shows a list with all the API sub users.

- **Example**:

```
<?php
$exampleVar->subListSubUsers('1', '10');

?>
```

**where**:
- `'1'` - the page, your sub user list is currently on.
- `'10'` - the amount of results per page. It can be **10**, **20**, **30**, **50** or **100**.

</details>
<br />

<details><summary>5. Modify zones limit.</summary>


- **Description**: Modifies (edits) the amount of zones available for the sub user.

- **Example**:

```
<?php
$exampleVar->subModifyZonesLimit('id', '0');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'0'` - amount of DNS zones, that the sub user will be allowed to use/create.

</details>
<br />

<details><summary>6. Modify mail forwards limit.</summary>


- **Description**: Modifies (edits) the amount of mail forwards available for the sub user.

- **Example**:

```
<?php
$exampleVar->subModifyMailForwardsLimit('id', '0');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'0'` - amount of DNS zones, that the sub user will be allowed to use/create.

</details>
<br />

<details><summary>7. Add new IP.</summary>


- **Description**: Adds new IP address to the whitelist, which the sub user will have access from.

- **Example**:

```
<?php
$exampleVar->subAddIP('id', '0.0.0.0');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'0.0.0.0'` - the IP address to be whitelisted.

</details>
<br />

<details><summary>8. Remove IP.</summary>


- **Description**: Removes an IP address from the whitelist.

- **Example**:

```
<?php
$exampleVar->subRemoveIP('id', '0.0.0.0');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'0.0.0.0'` - the IP address to be removed whitelisted.

</details>
<br />

<details><summary>9. Modify status.</summary>


- **Description**: Activate/Deactivate API sub user.

- **Example**:

```
<?php
$exampleVar->subModifyStatus('id', '0');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'0'` - sub user status - **1** for active, **0** for inactive.

</details>
<br />

<details><summary>10. Modify password.</summary>


- **Description**: Modify (change) the password of an API sub user.

- **Example**:

```
<?php
$exampleVar->subModifyPassword('id', '123456789');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'123456789'` - the new passowrd of the API sub user.

</details>
<br />

<details><summary>11. Delegate zone.</summary>


- **Description**: Delegate the management of a DNS zone to an API sub user.

- **Example**:

```
<?php
$exampleVar->subDelegateZone('id', 'domain.tld');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'domain.tld'` - name of the DNS zone, that the API sub user will gain access to.

</details>
<br />

<details><summary>12. Remove zone delegation.</summary>


- **Description**: Removes a delegated DNS zone from an API sub user.

- **Example**:

```
<?php
$exampleVar->subRemoveZoneDelegation('id', 'domain.tld');

?>
```

**where**:
- `'id'` - ID of the sub user.
- `'domain.tld'` - name of the delageted DNS zone, that will be removed from the API sub user.

</details>
<br />

<details><summary>13. Delete sub user.</summary>


- **Description**: Deletes an API sub user.

- **Example**:

```
<?php
$exampleVar->subDeleteSubUser('id');

?>
```

**where**:
- `'id'` - ID of the sub user.

</details>
<br />
