Extension Attributes Module
==============

This module allows MunkiReport to take advantage of Jamf's Extensionextension Attributes. Put Jamf extension attribute XML files in `/usr/local/munkireport/extension_attributes/` with the permissions of `root:wheel` and `755`. MunkiReport will process the extension attribute and upload the result to the server. You can see examples of these xml files on the Jamf GitHub page: [https://github.com/jamf/Jamf-Nation-Extension-Attributes](https://github.com/jamf/Jamf-Nation-Extension-Attributes)

You can also put your own data into the cache file for MunkiReport to collect and upload for viewing. Each attribute in the cache file is a dict within the plist's array. The dict must contain two keys: `displayname` and `result` Those two keys correspond with the two columns in MunkiReport. 

You can have scripts add data by using PlistBuddy and the three lines below to create the new dict and add keys to it replacing `$NameOfAttribute` and `$result` with the attribute name and its result


`/usr/libexec/PlistBuddy -c "Add :0 dict" /usr/local/munkireport/preflight.d/cache/extension_attributes.plist`

`/usr/libexec/PlistBuddy -c "Add :0:displayname string $NameOfAttribute" /usr/local/munkireport/preflight.d/cache/extension_attributes.plist`

`/usr/libexec/PlistBuddy -c "Add :0:result string $result" /usr/local/munkireport/preflight.d/cache/extension_attributes.plist`



The theoretical maximum data you can have for a single attribute entry is about 15MB worth of text. Less is better as too big of an attribute may cause response problems.

Here is an example cache file: 

```<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<array>
	<dict>
		<key>displayname</key>
		<string>WiFi Power</string>
		<key>result</key>
		<string>On</string>
	</dict>
</array>
</plist>
```



Table Schema
----

* displayname - VARCHAR(255) - Name of the attribute
* result - TEXT - Attribute result
* displayincategory - VARCHAR(255) - Category of attribute
* datatype - VARCHAR(255)  - Attribute data type