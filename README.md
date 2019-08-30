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
$exampleVar->dnsResgisterDomainZone('domain.tld', 'zone type', array ('ns1', 'ns2', 'nsn'...), '1.2.3.4');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |
| zone type | String/Required | The type of the DNS zone - master/slave/parked/geodns/reverse. |
| array ('ns1', 'ns2', 'nsn'...) | Array/**Optional**| Array with name servers, that will be added as NS records in the zone. |
| 1.2.3.4 | String/**Optional** | IP address of the Master server, for Slave zones;|
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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |

</details>
<br />

<details><summary>4. List DNS zones.</summary>

- **Description**: Get a list of all DNS zones in your account or only the ones matching a certain criteria (keyword).

- **Example**:

```
<?php
$exampleVar->dnsListZones('current page', 'results per page', 'keyword');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| current page | Integer/Required | The current page of your zone list. |
| results per page | Integer/Required | Number of results per page, can be 10, 20, 30, 50 or 100. |
| keyword | String/**Optional** | Criteria, which the results will be based on. |

</details>
<br />

<details><summary>5. Get pages count.</summary>

- **Description**: Amount of pages with DNS zones currently in your account. It can be combined to give results based on criteria (keyword).

- **Example**:

```
<?php
$exampleVar->dnsGetPagesCount('results per page', 'keyword'));;

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| results per page | Integer/Required | Number of results per page, can be 10, 20, 30, 50 or 100. |
| keyword | String/**Optional** | Criteria, which the results will be based on. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |

</details>
<br />

<details><summary>11. Change zone's status.</summary>


- **Description**: Change the status of the DNS zone - active/inactive.

- **Example**:
  
 ```
<?php
$exampleVar->dnsChangeZonesStatus('domain.tld', 'status');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| status | Integer/**Optional** | Status indicator, **1** to activate, **0** to deactivate. If the argument is skipped, the status will be toggled |

</details>
<br />

<details><summary>12. List records.</summary>


- **Description**: Shows a list of records currently in the DNS zone. The results can also be based on host name and/or record type.

- **Example**:
  
 ```
<?php
$exampleVar->dnsListRecords('domain.tld', 'host', 'record type');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| host | String/**Optional** | Host, which the records will be shown for |
| record type | String/**Optional** | Specify the type of record to be listed. For available record types, see "Get the available record types" function. |

</details>
<br />

<details><summary>13. Add record.</summary>


- **Description**: Adds a record to the DNS zone.

- **Example**:
  
 ```
<?php
$exampleVar->dnsAddRecord("domain.tld", "record type", "host", "record", ttl, priority, weight, port, frame, "frame-title", "frame-keywords", "frame-description", save-path, redirect-type, "mail", "txt", algorithm, fptype, status, geodns-location, caa-flag, "caa-type", "caa-value");

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| record type | String/Required | Type of the DNS record. For available record types, see "Get the available record types" function. |
| host | String/Required | Host name of the record. Leave empty for root hoss. |
| record | String/Required | The specific requirements for the record - where to be pointed at (e.g. IP, hostname, server), strings, authentications, etc. |
| ttl | Integer/Required | The TTL of the record. The available TTL's are as follows: 60 = 1 minute 300 = 5 minutes 900 = 15 minutes, 1800 = 30 minutes, 3600 = 1 hour, 21600 = 6 hours, 43200 = 12 hours, 86400 = 1 day, 172800 = 2 days, 259200 = 3 days, 604800 = 1 week, 1209600 = 2 weeks, 2592000 = 1 month |
| priority | Integer/**Optional** | Priority option for MX and SRV records. |
| weight | Integer/**Optional** | Weight option for SRV record |
| port | Integer/**Optional** | Port option for SRV record |
| frame | Integer/**Optional** | Toggles the redirect with frame option for Web Redirect record: **0** for disable, **1** for enable. |
| frame-title | String/**Optional** | Title for the redirect with frame option for Web Redirect record. |
| frame-keywords | String/**Optional** | Keywords for the redirect with frame option for Web Redirect record. |
| frame-description | String/**Optional** | Description for the redirect with frame option for Web Redirect record. |
| save-path | Integer/**Optional** | Save path option for redirecting with Web Redirect record - **0** for disable, **1** for enable. |
| redirect-type | Integer/**Optional** | Unmasked redirects for Web Redirect record if the redirect with frame is disabled - **301** for constant type or **302** for temporary type. |
| mail | String/**Optional** | E-mail address for RP records. |
| txt | String/**Optional** | Domain name for TXT record used in RP records. |
| algorithm | Integer/**Optional** | Algorithm required to create for SSHFP records. |
| fptype | Integer/**Optional** | Type of the SSHFP algorithm. |
| status | Integer/**Optional** | Status of the record - **1** for active and **0** for inactive. If skipped, the record will be set as active. |
| geodns-location | Integer/**Optional** | ID of the GeoDNS location that can be set for A, AAAA, CNAME, NAPTR or SRV records. The location's ID can be obtained from the **List GeoDNS locations** function. |
| caa-flag | Integer/**Optional** | Flag option for CAA records - **0** for Non critical and **128** for Critical. |
| caa-type | String/**Optional** | Type of the CAA record, which can be **issue**, **issuewild** and **iodef**. |
| caa-value | String/**Optional** | Value of the CAA record. Depending on the type of the CAA record, '`caa-type'`, it can be set as follows: if `'caa-type'` is issue the `'caa-value'` can be hostname or ";". If `'caa-type'` is issuewild the `'caa-value'` can be hostname or ";". If `'caa-type'` is iodef the `'caa-value'` "mailto:someemail@address.tld, http://example.tld or http://example.tld. |

</details>
<br />

<details><summary>14. Delete record.</summary>


- **Description**: Deletes a record in the DNS zone.

- **Example**:
  
 ```
<?php
$exampleVar->dnsDeleteRecord('domain.tld', "recordID");

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| recordID | Integer/Required | ID of the record. The ID can be found using the **List records** function. |
</details>
<br />

</details>
<br />

<details><summary>15. Modify record.</summary>


- **Description**: Modify (edit) a record.

- **Example**:
  
 ```
<?php
$exampleVar->dnsModifyRecord("domain.tld", "recordID", "host", "record", ttl, priority, weight, port, frame, "frame-title", "frame-keywords", "frame-description", save-path, redirect-type, "mail", "txt", algorithm, fptype, geodns-location, caa-flag, "caa-type", "caa-value");

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| recordID | Integer/Required | ID of the record. The ID can be found using the **List records** function. |
| host | String/Required | Host name of the record. Leave empty for root hoss. |
| record | String/Required | The specific requirements for the record - where to be pointed at (e.g. IP, hostname, server), strings, authentications, etc. |
| ttl | Integer/Required | The TTL of the record. The available TTL's are as follows: 60 = 1 minute 300 = 5 minutes 900 = 15 minutes, 1800 = 30 minutes, 3600 = 1 hour, 21600 = 6 hours, 43200 = 12 hours, 86400 = 1 day, 172800 = 2 days, 259200 = 3 days, 604800 = 1 week, 1209600 = 2 weeks, 2592000 = 1 month |
| priority | Integer/**Optional** | Priority option for MX and SRV records. |
| weight | Integer/**Optional** | Weight option for SRV record |
| port | Integer/**Optional** | Port option for SRV record |
| frame | Integer/**Optional** | Toggles the redirect with frame option for Web Redirect record: **0** for disable, **1** for enable. |
| frame-title | String/**Optional** | Title for the redirect with frame option for Web Redirect record. |
| frame-keywords | String/**Optional** | Keywords for the redirect with frame option for Web Redirect record. |
| frame-description | String/**Optional** | Description for the redirect with frame option for Web Redirect record. |
| save-path | Integer/**Optional** | Save path option for redirecting with Web Redirect record - **0** for disable, **1** for enable. |
| redirect-type | Integer/**Optional** | Unmasked redirects for Web Redirect record if the redirect with frame is disabled - **301** for constant type or **302** for temporary type. |
| mail | String/**Optional** | E-mail address for RP records. |
| txt | String/**Optional** | Domain name for TXT record used in RP records. |
| algorithm | Integer/**Optional** | Algorithm required to create for SSHFP records. |
| fptype | Integer/**Optional** | Type of the SSHFP algorithm. |
| status | Integer/**Optional** | Status of the record - **1** for active and **0** for inactive. If skipped, the record will be set as active. |
| geodns-location | Integer/**Optional** | ID of the GeoDNS location that can be set for A, AAAA, CNAME, NAPTR or SRV records. The location's ID can be obtained from the **List GeoDNS locations** function. |
| caa-flag | Integer/**Optional** | Flag option for CAA records - **0** for Non critical and **128** for Critical. |
| caa-type | String/**Optional** | Type of the CAA record, which can be **issue**, **issuewild** and **iodef**. |
| caa-value | String/**Optional** | Value of the CAA record. Depending on the type of the CAA record, '`caa-type'`, it can be set as follows: if `'caa-type'` is issue the `'caa-value'` can be hostname or ";". If `'caa-type'` is issuewild the `'caa-value'` can be hostname or ";". If `'caa-type'` is iodef the `'caa-value'` "mailto:someemail@address.tld, http://example.tld or http://example.tld. |

</details>
<br />

<details><summary>16. Copy records.</summary>


- **Description**: Copies all the records from a specific zone.

- **Example**:
  
```
<?php
$exampleVar->dnsCopyRecords('domain.tld', 'domain2.tld', delete-records);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the records will be copied to. |
| domain-2.tld | String/Required | Domain name of the DNS zone, which the records will be copied from. |
| delete-records | Integer/**Optional** | If entered (set to 1), deletes all the current records, if such exists, from domain.tld. |

</details>
<br />

<details><summary>17. Import records.</summary>


- **Description**: Copies all the records from a specific zone.

- **Example**:
  
```
<?php
$exampleVar->dnsCopyRecords('domain.tld', 'format', 'records-list", delete-records);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the records will be imported to. |
| format | String/Required | The format, which will be used to import the records. The available formats are **bind** and **tinydns**. |
| records-list | String/Required | List of the records based on the chosen format. The records must be added one per row. |
| delete-records | Integer/**Optional** | If entered (set to 1), deletes all the current records, if such exists, from domain.tld. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the records will be exported from in BIND format. |

</details>
<br />

<details><summary>19. Get the available record types.</summary>


- **Description**: Shows the available record types, that can be set up, based on the DNS zone type.

- **Example**:
  
```
<?php
$exampleVar->dnsGetAvailableRecords('zone-type');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| zone-type | String/Required | type of the DNS zone. The value can be **domain** for Master DNS zones, **reverse** for Reverse DNS zones and **parked** for Parked DNS zones. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the SOA details will be shown for. |

</details>
<br />

<details><summary>22. Modify SOA details.</summary>


- **Description**: Modify (edit) the SOA details of the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsModifySOA('domain.tld', 'ns.nameserver.tld', 'example@email.tld', refresh, retry, expire, ttl);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the SOA details will be modified for. |
| ns.nameserver.tld | String/Required | Host name of the primary name server. |
| example@email.tld | Integer/Required | DNS admin email. |
| refresh | Integer/Required | Refresh rate. The value must be between **1200** and **43200** seconds. |
| retry | Integer/Required | Retry rate. The value must be between **180** and **2419200** seconds. |
| expire | Integer/Required | Expire rate. The value must be between **1209600** and **2419200** seconds. |
| ttl | Integer/Required | Default TTL. The value must be between **60** and **2419200** seconds. |

</details>
<br />

<details><summary>23. Get DynamicURL.</summary>


- **Description**: Returns the DynamicURL of an A or AAAA record.

- **Example**:
  
```
<?php
$exampleVar->dnsGetDynamicURL('domain.tld', recordID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |
| recordID | Integer/Required | ID of the A or AAAA record. The ID can be found using the **List records** function. |

</details>
<br />

<details><summary>24. Disable DynamicURL.</summary>


- **Description**: Disable the DynamicURL of an A or AAAA record.

- **Example**:
  
```
<?php
$exampleVar->dnsDisableDynamicURL('domain.tld', recordID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |
| recordID | Integer/Required | ID of the A or AAAA record. The ID can be found using the **List records** function. |

</details>
<br />

<details><summary>25. Change DynamicURL.</summary>


- **Description**: Change the DynamicURL of an A or AAAA record.

- **Example**:
  
```
<?php
$exampleVar->dnsDisableDynamicURL('domain.tld', recordID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |
| recordID | Integer/Required | ID of the A or AAAA record. The ID can be found using the **List records** function. |

</details>
<br />

<details><summary>26. Change record's status.</summary>


- **Description**: Changes the status of the record to active/inactive.

- **Example**:
  
```
<?php
$exampleVar->dnsChangeRecordStatus('domain.tld', recordID, status);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |
| recordID | Integer/Required | ID of record. The ID can be found using the **List records** function. |
| status | Integer/**Optional** | Status of the record - **1** for active and **0** for inactive. If skipped, the record will be toggled. |

</details>
<br />

<details><summary>27. Add master server.</summary>


- **Description**: Add new master server to a DNS zone. Only available for Secondary DNS zones and Secondary Reverse DNS zones.

- **Example**:
  
```
<?php
$exampleVar->dnsAddMasterServer('domain.tld', 'IP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |
| IP | String/Required | IP address of the new master server. |

</details>
<br />

<details><summary>28. Delete master server.</summary>


- **Description**: Delete master server of a DNS zone. Only available for Slave DNS zones and Slave Reverse DNS zones.

- **Example**:
  
```
<?php
$exampleVar->dnsDeleteMasterServer('domain.tld', masterID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |
| masterID | Integer/Required | ID of the master server. It can be obtained from the **List master servers** function. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone. |

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


- **Description**: Add new mail forward to a DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsAddMailForward('domain.tld', 'box', 'host', 'destination-mail');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the mail forward will be added for. |
| box | String/Required | Name of the mailbox for the mail forward. |
| host | String/Required | Host of the mailbox. If empty, the mail forward will be created for the main domain name. | 
| destination-mail | String/Required | Existing email address, where the mail forwards will be received from. |
</details>
<br />

<details><summary>33. Delete mail forward.</summary>


- **Description**: Delete a mail forward for a specified DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsDeleteMailForward('domain.tld', mailID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the mail forward will be removed from. |
| mailID | Integer/Required | ID of the mail forward. It can be obtained from the **List mail forwards** function. |

</details>
<br />

<details><summary>34. Modify (edit) mail forward.</summary>


- **Description**: Modify a mail forward of a DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsModifyMailForward('domain.tld', 'box', 'host', 'destination-mail', mailID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the mail forward will be added for. |
| box | String/Required | Name of the mailbox for the mail forward. |
| host | String/Required | Host of the mailbox. If empty, the mail forward will be created for the main domain name. | 
| destination-mail | String/Required | Existing email address, where the mail forwards will be received from. |
| mailID | Integer/Required | ID of the mail forward. It can be obtained from the **List mail forwards** function. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone, which the mail forwards will be listed for. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Master domain of the cloud. |
| cloud-domain.tld | String/Required | The new domain in the cloud. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| cloud-domain.tld | String/Required | Cloud domain that will be deleted. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required |  Domain name of the new cloud master. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Master domain of the cloud. |

</details>
<br />

<details><summary>40. Allow new IP.</summary>


- **Description**: Allow new IP address of a slave server for zone transfers.

- **Example**:
  
```
<?php
$exampleVar->dnsAllowNewIP('domain.tld', 'IP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name, which the slave server's IP address will be added for zone transfers. |
| IP | String/Required | IP address of the slave server. |

</details>
<br />

<details><summary>41. Delete an allowed IP.</summary>


- **Description**: Removes slave server's IP address for zone transfers.

- **Example**:
  
```
<?php
$exampleVar->dnsDeleteAllowedIP('domain.tld', serverID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| IP | Integer/Required | IP address of the slave server. |

</details>
<br />

<details><summary>42. List allowed IP's.</summary>


- **Description**: List all of the allowed IP addresses for zone transfers.

- **Example**:
  
```
<?php
$exampleVar->dnsListAllowedIP('domain.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |

</details>
<br />

<details><summary>43. Hourly statistics.</summary>


- **Description**: Shows hourly statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsHourlyStatistics('domain.tld', year, month, day);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| year | Integer/Required | The year, which the statistics will be shown for. |
| month | Integer/Required | The month, which the statistics will be shown for. |
| day | Integer/Required | The day, which the statistics will be shown for. |

</details>
<br />

<details><summary>44. Daily statistics.</summary>


- **Description**: Shows daily statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsDailyStatistics('domain.tld', year, month);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| year | Integer/Required | The year, which the statistics will be shown for. |
| month | Integer/Required | The month, which the statistics will be shown for. |

</details>
<br />

<details><summary>45. Monthly statistics.</summary>


- **Description**: Shows monthly statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsMonthlyStatistics('domain.tld', year);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |
| year | Integer/Required | The year, which the statistics will be shown for. |

</details>
<br />

<details><summary>46. Yearly statistics.</summary>


- **Description**: Shows yearly statistics for the DNS zone.

- **Example**:
  
```
<?php
$exampleVar->dnsYearlyStatistics('domain.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |

</details>
<br />

<details><summary>47. Staistics for the last 30 days.</summary>


- **Description**: Shows statistics of the DNS zone for the last 30 days.

- **Example**:
  
```
<?php
$exampleVar->dnsLast30DaysStatistics('domain.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the DNS zone |

</details>
<br />

<details><summary>48. Get templates for parked pages.</summary>


- **Description**: Shows the templates, that we provide, fo.

- **Example**:
  
```
<?php
$exampleVar->dnsGetParkedTemplates();

?>
```

</details>
<br />

<details><summary>49. Get parked zones settings.</summary>


- **Description**: Shows the settings of the parked zone.

- **Example**:
  
```
<?php
$exampleVar->dnsGetParkedSettings('domain.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the parked DNS zone |

</details>
<br />

<details><summary>50. Modify parked zones settings.</summary>


- **Description**: Modify (edit) the settings of a parked zone.

- **Example**:
  
```
<?php
$exampleVar->dnsModifyParkedSettings('domain.tld', templateID, 'title', 'description', 'keywords', contact-form);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the parked DNS zone |
| templateID | Integer/Required | ID of the template for the parked zone. It can be **1**, **2**, **3** or **4**. The available templates can be obtained from the "Get templates for parked pages" function. |
| title | String/**Optional** | Title of the parked page. |
| description | String/**Optional** | Description of the parked page. |
| keywords | String/**Optional** | Keywords of the parked page. |
| contact-form | Integer/**Optional** | Enables or disables the contact form of the parked page - **1** for enabled, **2** for disabled and **0** is the default value. |

</details>
<br />

<details><summary>51. List GeoDNS locations.</summary>


- **Description**: Lists all the GeoDNS locations.

- **Example**:
  
```
<?php
$exampleVar->dnsListGeoDNSLocations('domain.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name of the GeoDNS zone. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain | String/Required | Domain name that will be checked. |
| 'com', 'net', ... , 'tld' | Array/Required | Array with TLD's, that will be checked in combination with the domain. |

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
$exampleVar->domainsRegisterNewDomain('domain', 'tld', period, 'example@mail.tld', 'Name', 'Address', 'City', 'State', 'zip', 'Country', phone-code, phone-number, 'Company', fax-code, fax-number, array ('ns1.nameserver.tld', ... , 'nsn.nameserver.tld'), 'registrant-type', 'registrant-type-id', registrant-policy, 'birth-date', 'birth-cc', 'birth-city', 'city-postal-code', 'publication', 'VAT-number', 'Siren-number', 'DUNS-number', 'trademark', 'Waldec-number', 'organization-type', 'privacy-protection', code, 'publicity', 'kpp', 'passport-number', 'passport-issued-by', 'passport-issued-on');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain | String/Required | Name of the domain. |
| tld | String/Required | TLD of the domain. |
| period | Integer/Required | The registration period of the domain. The value entered is in years. The available periods can be obtained from the **List domain information** function. |
| example@mail.tld | String/Required | The email address of the registrant. |
| Name | String/Required | The name of the registrant. |
| Address | String/Required | The address of the registrant/company. |
| City | String/Required | The city of the registrant/company. |
| State | String/Required | The state, e.g. Texas. |
| zip | Integer/Required | The zip code. |
| Country | String/Required | The country of the registrant/company, which must be entered as a country code according to ISO 3166. (DE, UK, BR, etc.) |
| phone-code | Integer/Required | Calling code of the phone number. Can be between 1 and 3 digits.|
| phone-number | Integer/Required | The phone number. |
| Company | String/**Optional** | The name of the company. Required if the registrant type is a company. |
| fax-code | Integer/**Optional** | Calling code of the fax number. Can be between 1 and 3 digits.|
| fax-number | Integer/**Optional** | The fax number. |
| 'ns1.nameserver.tld', ... , 'nsn.nameserver.tld' | Array/**Optional** | The name servers, that the domain will be pointed at upon finishing the registration. |
| registrant-type | String/**Optional** | Required field for specific TLDs. For more information [a link](https://www.cloudns.net/wiki/article/97/), registrant_type row. |
| registrant-type-id | String/**Optional** | Required field for specific TLDs. For more information [a link](https://www.cloudns.net/wiki/article/97/), registrant_type_id row. |
| registrant-policy | Integer/**Optional** | Required for specific TLD's, such as .com.au and .net.au domain names. Possible values: **1** - if Domain Name is an Exact Match OR Abbreviation OR Acronym of your Entity or Trading Name, **2** - if Close and substantial connection between the domain name and the operations of your Entity. |
| birth-date | String/**Optional** | The birth date of the registrant. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_date row. |
| birth-cc | String/**Optional** | Birth country code, optional for certain TLD's. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_cc row. |
| birth-city | String/**Optional** | Birth city name. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_city row. |
| city-postal-code | String/**Optional** | Postal code of the birth city. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_zip row. |
| publication | String/**Optional** | Possible values: **0** - Non-Restricted, **1** - Restricted, publication of the individual details. |
| VAT-number | String/**Optional** | EU VAT number. |
| Siren-number | String/**Optional** | Siren number of the company (organization). |
| DUNS-number | String/**Optional** | UNS number of the company (organization). |
| trademark | String/**Optional** | Only for specific TLD's, for more information [a link](https://www.cloudns.net/wiki/article/97/), trademark row. |
| Waldec-number | String/**Optional** | Waldec number of the association. |
| organization-type-other | String/**Optional** | Type of the organization. Optional field when the **registrant_type** is OTHER. |
| privacy-protection | Integer/**Optional** | Privacy Protection for the domain: **0** for disabled and **1** for enabled. By default, Privacy Protection is disabled. |
| code | Integer/**Optional** | Optional field for specific TLD's, for more information [a link](https://www.cloudns.net/wiki/article/97/), code row. |
| publicity | Integer/**Optional** | Available for .it domain names, with possible values: **1** for yes and **0** for no. |
| kpp | Integer/**Optional** | A nine digit number available for .ru domain names. |
| passport-number | String/**Optional** | Available for .ru domain names. Document Number. |
| passport-issued-by | String/**Optional** | Available for .ru domain names. Document issued by (123 police station of Moscow). |
| passport-issued-on | String/**Optional** | Available for .ru domain names. Passport issued date. Format: DD.MM.YYYY. |

</details>
<br />

<details><summary>4. Renew domain.</summary>


- **Description**: Submit an order for a renewal of domain name.

- **Example**:
  
```
<?php
$exampleVar->domainsRenewDomain('domain.tld', period);

?>
```
**where**:
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the domain, that will be renewed. |
| period | Integer/Required | The period, for which the domain name will be renewed. The value entered is in years. The available periods can be obtained from the **List domain information** function. |

- `'domain.tld'` - the domain name that will be renewed.
- `'1'` - the period, for which the domain name will be renewed.

</details>
<br />

<details><summary>5. Transfer domain.</summary>


- **Description**: Start the transfer process of a domain name.

- **Example**:
  
```
<?php
$exampleVar->domainsTransferDomain('domain', 'tld', 'example@mail.tld', 'Name', 'Address', 'City', 'State', zip, 'Country', phone-code, phone-number, 'Company', fax-code, fax-number, transfer-code, 'registrant-type', 'birth-date', 'birth-cc', 'birth-city', 'city-postal-code', 'publication', 'VAT-number', 'Siren-number', 'DUNS-number', 'trademark', 'Waldec-number', 'organization-type-other', 'privacy-protection', 'code', 'registrant-type-id', 'publicity', array('ns'), 'kpp', 'passport-number', 'passport-issued-by', 'passport-issued-on');
;

?>
```
**where**:
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain | String/Required | Name of the domain. |
| tld | String/Required | TLD of the domain. |
| example@mail.tld | String/Required | The email address of the registrant. |
| Name | String/Required | The name of the registrant. |
| Address | String/Required | The address of the registrant/company. |
| City | String/Required | The city of the registrant/company. |
| State | String/Required | The state, e.g. Texas. |
| zip | Integer/Required | The zip code. |
| Country | String/Required | The country of the registrant/company, which must be entered as a country code according to ISO 3166. (DE, UK, BR, etc.) |
| phone-code | Integer/Required | Calling code of the phone number. Can be between 1 and 3 digits.|
| phone-number | Integer/Required | The phone number. |
| Company | String/**Optional** | The name of the company. Required if the registrant type is a company. |
| fax-code | Integer/**Optional** | Calling code of the fax number. Can be between 1 and 3 digits.|
| fax-number | Integer/**Optional** | The fax number. |
| transfer-code | Integer/**Optional** | Transfer code given by the current registrar, if it is required for the TLD. |
| registrant-type | String/**Optional** | Required field for specific TLDs. For more information [a link](https://www.cloudns.net/wiki/article/97/), registrant_type row. |
| birth-date | String/**Optional** | The birth date of the registrant. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_date row. |
| birth-cc | String/**Optional** | Birth country code, optional for certain TLD's. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_cc row. |
| birth-city | String/**Optional** | Birth city name. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_city row. |
| city-postal-code | String/**Optional** | Postal code of the birth city. For more information [a link](https://www.cloudns.net/wiki/article/97/), birth_zip row. |
| publication | String/**Optional** | Possible values: **0** - Non-Restricted, **1** - Restricted, publication of the individual details. |
| VAT-number | String/**Optional** | EU VAT number. |
| Siren-number | String/**Optional** | Siren number of the company (organization). |
| DUNS-number | String/**Optional** | UNS number of the company (organization). |
| trademark | String/**Optional** | Only for specific TLD's, for more information [a link](https://www.cloudns.net/wiki/article/97/), trademark row. |
| Waldec-number | String/**Optional** | Waldec number of the association. |
| organization-type-other | String/**Optional** | Type of the organization. Optional field when the **registrant_type** is OTHER. |
| privacy-protection | Integer/**Optional** | Privacy Protection for the domain: **0** for disabled and **1** for enabled. By default, Privacy Protection is disabled. |
| code | Integer/**Optional** | Optional field for specific TLD's, for more information [a link](https://www.cloudns.net/wiki/article/97/), code row. |
| registrant-type-id | String/**Optional** | Required field for specific TLDs. For more information [a link](https://www.cloudns.net/wiki/article/97/), registrant_type_id row. |
| publicity | Integer/**Optional** | Available for .it domain names, with possible values: **1** for yes and **0** for no. |
| ns | Array/**Optional** | Requred for .be domain names. |
| kpp | Integer/**Optional** | A nine digit number available for .ru domain names. |
| passport-number | String/**Optional** | Available for .ru domain names. Document Number. |
| passport-issued-by | String/**Optional** | Available for .ru domain names. Document issued by (123 police station of Moscow). |
| passport-issued-on | String/**Optional** | Available for .ru domain names. Passport issued date. Format: DD.MM.YYYY. |

</details>
<br />

<details><summary>6. List registered domains.</summary>


- **Description**: Get a list with registered domains. Can be combined with a certain criteria (keyword), which the result will be based on.

- **Example**:
  
```
<?php
$exampleVar->domainsListRegisteredDomains(rows-per-page, page, 'keyword');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| rows-per-page | Integer/Required | Amount of results per page. It can be 10, 20, 30, 50 or 100. |
| page | Integer/Required | Current page of your zone list. |
| keyword | String/**Optional** | A specific criteria (keyword), that the results will be based on. |

</details>
<br />

<details><summary>7. Get pages count.</summary>


- **Description**: Amount of pages with registered domains currently in your account. It can be combined to give results based on criteria (keyword).

- **Example**:

```
<?php
$exampleVar->domainsGetPagesCount('rows-per-page', 'keyword');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| rows-per-page | Integer/Required | Amount of results per page. It can be 10, 20, 30, 50 or 100. |
| keyword | String/**Optional** | A specific criteria (keyword), that the results will be based on. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain |

</details>
<br />

<details><summary>10. Modify contacts.</summary>


- **Description**: Shows the contact details of a registered domain in four groups: Registrant Details, Administrative Contact, Technical contact and Billing Contact.

- **Example**:

```
<?php
$exampleVar->domainsModifyContacts('domain', 'tld', 'details-type', 'example@mail.tld', 'John Doe', 'Company', 'Address', 'City', 'State', zip, 'Country', phone-code, phone-number, fax-code, fax-number);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain | String/Required | Name of the domain. |
| tld | String/Required | TLD of the domain. |
| details-type | String/Required | the type of contacts, that will be modified. They can be obtained from the **Contact details** function. |
| example@mail.tld | String/Required | Email address of the registrant. |
| Name | String/Required | Name of the registrant. |
| Company | String/Required | Name of the company. |
| Address | String/Required | Address of the registrant/comapny. |
| City | String/Required | City of the registrant/company. |
| State | String/Required | State, e.g. Texas. |
| zip | Integer/Required | Zip code |
| Country | String/Required | The country of the registrant/company, which must be entered as a country code according to ISO 3166. (DE, UK, BR, etc.) |
| phone-code | Integer/Required | Calling code of the phone number. Can be between 1 and 3 digits.|
| phone-number | Integer/Required | The phone number. |
| fax-code | Integer/**Optional** | Calling code of the fax number. Can be between 1 and 3 digits.|
| fax-number | Integer/**Optional** | The fax number. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |

</details>
<br />

<details><summary>12. Modify name servers.</summary>


- **Description**: Modifiy (edit) the name servers for a registered domain name.

- **Example**:

```
<?php
$exampleVar->domainsModifyNameServers('domain.tld', array ('ns1.nameserver.tld', ... , 'nsn.nameserver.tld));

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |
| 'ns1.nameserver.tld', ... , 'nsn.nameserver.tld' | Array/Required | Array with the name servers |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |

</details>
<br />

<details><summary>14. Add child name servers.</summary>


- **Description**: Add a child name server to a domain name.

- **Example**:

```
<?php
$exampleVar->domainsAddChildNameServers('domain.tld', 'host', 'IP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |
| host | String/Required | Host of the child name server. |
| IP | String/Required | IP of the child name server. |

</details>
<br />

<details><summary>15. Delete child name servers.</summary>


- **Description**: Delete a child name server from a domain name.

- **Example**:

```
<?php
$exampleVar->domainsDeleteChildNameServers('domain.tld', 'host', 'IP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |
| host | String/Required | Host of the child name server. |
| IP | String/Required | IP of the child name server. |

</details>
<br />

<details><summary>16. Modify child name servers.</summary>


- **Description**: Modify a child name server of a domain name.

- **Example**:

```
<?php
$exampleVar->domainsModifyChildNameServers('domain.tld', 'host', 'IP', 'newIP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |
| host | String/Required | Host of the child name server. |
| IP | String/Required | Current IP of the child name server. |
| newIP | String/Required | New IP of the child name server. |

</details>
<br />

<details><summary>17. Modify Privacy Protection.</summary>


- **Description**: Enables/Disables the Privacy Protection of a domain name. The current state of it can be obtained from the **Domain information** function.

- **Example**:

```
<?php
$exampleVar->domainsModifyPrivacyProtection('domain.tld', status);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |
| status | Integer/Required | Privacy Protection status - **1** for enable and **0** for disable. |

</details>
<br />

<details><summary>18. Modify transfer lock.</summary>


- **Description**: Enables/Disables the transfer lock of a domain name. The current state of it can be obtained from the **Domain information** function.

- **Example**:

```
<?php
$exampleVar->domainsModifyTransferLock('domain.tld', status);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Name of the registered domain. |
| status | Integer/Required | Transfer lock status - **1** for enable and **0** for disable. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Registered domain name. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Registered domain name. |

</details>
<br />

### SSL

<details><summary>1. Order new SSL.</summary>


- **Description**: Places an order for a new SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslOrderNewSSL('domain.tld', period, type);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| domain.tld | String/Required | Domain name, which the SSL certificate will be ordered for. |
| period | Integer/Required | Period of the SSL certificate. The value is in years. |
| type | Integer/Required | Type of the SSL certificate - **2 - Wildcard Positive SSL**, **3 - Positive SSL**. |

</details>
<br />

<details><summary>2. List certificates.</summary>


- **Description**: Get a list of ordered and owned SSL certificates.

- **Example**:

```
<?php
$exampleVar->sslListOrderedCertificates('page', rows-per-page);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| page | String/Required | The page, your SSL list is currently on. |
| rows-per-page | Integer/Required | Amount of results per page. It can be **10**, **20**, **30**, **50** or **100**. |

</details>
<br />

<details><summary>3. Get pages count.</summary>


- **Description**: Shows the number of pages for your SSL certificates.

- **Example**:

```
<?php
$exampleVar->sslGetPagesCount(rows-per-page);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| rows-per-page | Integer/Required | Amount of results per page. It can be **10**, **20**, **30**, **50** or **100**. |

</details>
<br />

<details><summary>4. SSL Information.</summary>


- **Description**: Shows information about the SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslInformation(sslID);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| sslID | Integer/Required | ID of the SSL certificate. It can be obtained from the **List certificates** function. |

</details>
<br />

<details><summary>5. Submit CSR.</summary>


- **Description**: Submit CSR key for an SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslSubmitCSR(sslID, 'example@mail.tld', 'csr');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| sslID | Integer/Required | ID of the SSL certificate. It can be obtained from the **List certificates** function. |
| example@mail.tld | String/Required | Email address of the owner of the certificate |
| 'csr' | String/Required | The CSR key. |

</details>
<br />

<details><summary>6. Renew SSL.</summary>


- **Description**: Renew an SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslRenew('sslID', period);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| sslID | Integer/Required | ID of the SSL certificate. It can be obtained from the **List certificates** function. |
| period | Integer/Required | Period, which the sertificate will be renewed for. The value is in years. |

</details>
<br />

<details><summary>7. Change SSL verification e-mail.</summary>


- **Description**: Changes the verification e-mail of the SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslChangeVerificationMail('sslID', 'example@mail.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| sslID | Integer/Required | ID of the SSL certificate. It can be obtained from the **List certificates** function. |
| example@mail.tld | String/Required | New email address of the owner of the certificate |

</details>
<br />

<details><summary>8. Reissue SSL.</summary>


- **Description**: Reissue an SSL certificate.

- **Example**:

```
<?php
$exampleVar->sslReissue('sslID', 'example@mail.tld', 'csr');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| sslID | Integer/Required | ID of the SSL certificate. It can be obtained from the **List certificates** function. |
| example@mail.tld | String/Required | Email address of the owner of the certificate |
| 'csr' | String/Required | The CSR key. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| sslID | Integer/Required | ID of the SSL certificate. It can be obtained from the **List certificates** function. |

</details>
<br />

### Sub

<details><summary>1. Add new sub user.</summary>


- **Description**: Adds a new API sub user.

- **Example**:

```
<?php
$exampleVar->subAddNewUser('password', zone-amount, mf-amount, 'IP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| password | String/Required | Password for the API sub user. |
| zone-amount | Integer/Required | Amount of DNS zones, available for the sub user. |
| mf-amount | Integer/Required | Amount of mail forwards, available for the sub user. |
| IP | String/Required | String/**Optional** | Whitelisted IP address. If argument is skipped, access from all IP's will be allowed. |

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
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |

</details>
<br />

<details><summary>3. Get pages count.</summary>


- **Description**: Shows the number of pages with sub users.

- **Example**:

```
<?php
$exampleVar->subGetPagesCount(rows-per-page);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| rows-per-page | Integer/Required | Amount of results per page. It can be **10**, **20**, **30**, **50** or **100**. |

</details>
<br />

<details><summary>4. List sub users.</summary>


- **Description**: Shows a list with all the API sub users.

- **Example**:

```
<?php
$exampleVar->subListSubUsers(page, rows-per-page);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| page | Integer/Required | The page, your sub user list is currently on. |
| rows-per-page | Integer/Required | Amount of results per page. It can be **10**, **20**, **30**, **50** or **100**. |

</details>
<br />

<details><summary>5. Modify zones limit.</summary>


- **Description**: Modifies (edits) the amount of zones available for the sub user.

- **Example**:

```
<?php
$exampleVar->subModifyZonesLimit(id, zone-amount);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| zone-amount | Integer/Required | Amount of DNS zones, available for the sub user. |

</details>
<br />

<details><summary>6. Modify mail forwards limit.</summary>


- **Description**: Modifies (edits) the amount of mail forwards available for the sub user.

- **Example**:

```
<?php
$exampleVar->subModifyMailForwardsLimit(id, mf-amount);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| mf-amount | Integer/Required | Amount of mail forwards, available for the sub user. |

</details>
<br />

<details><summary>7. Add new IP.</summary>


- **Description**: Adds new IP address to the whitelist, which the sub user will have access from.

- **Example**:

```
<?php
$exampleVar->subAddIP(id, 'IP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| IP | String/Required | String/Required | Whitelisted IP address. |

</details>
<br />

<details><summary>8. Remove IP.</summary>


- **Description**: Removes an IP address from the whitelist.

- **Example**:

```
<?php
$exampleVar->subRemoveIP('id', 'IP');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| IP | String/Required | String/Required | Whitelisted IP address. |

</details>
<br />

<details><summary>9. Modify status.</summary>


- **Description**: Activate/Deactivate API sub user.

- **Example**:

```
<?php
$exampleVar->subModifyStatus(id, status);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| status | Integer/Required | Sub user status - **1** for active, **0** for inactive. |

</details>
<br />

<details><summary>10. Modify password.</summary>


- **Description**: Modify (change) the password of an API sub user.

- **Example**:

```
<?php
$exampleVar->subModifyPassword(id, 'password');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| password | String/Required | New password for the API sub user. |

</details>
<br />

<details><summary>11. Delegate zone.</summary>


- **Description**: Delegate the management of a DNS zone to an API sub user.

- **Example**:

```
<?php
$exampleVar->subDelegateZone(id, 'domain.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| domain.tld | String/Required | Name of the DNS zone. |

</details>
<br />

<details><summary>12. Remove zone delegation.</summary>


- **Description**: Removes a delegated DNS zone from an API sub user.

- **Example**:

```
<?php
$exampleVar->subRemoveZoneDelegation(id, 'domain.tld');

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |
| domain.tld | String/Required | Name of the DNS zone. |

</details>
<br />

<details><summary>13. Delete sub user.</summary>


- **Description**: Delete a sub user.

- **Example**:

```
<?php
$exampleVar->subDeleteSubUser(id);

?>
```
| Name            | Data type/Status| Description |
| :-------------: |:-------------:  | :-----------|
| id | Integer/Required | ID of the sub user. |

</details>
<br />

