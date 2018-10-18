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
