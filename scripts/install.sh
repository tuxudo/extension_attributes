#!/bin/bash

# extension_attributes controller
CTL="${BASEURL}index.php?/module/extension_attributes/"

# Get the scripts in the proper directories
"${CURL[@]}" "${CTL}get_script/extension_attributes" -o "${MUNKIPATH}preflight.d/extension_attributes"

# Check exit status of curl
if [ $? = 0 ]; then
	# Make executable
	chmod a+x "${MUNKIPATH}preflight.d/extension_attributes"

	# Set preference to include this file in the preflight check
	setreportpref "extension_attributes" "${CACHEPATH}extension_attributes.plist"

else
	echo "Failed to download all required components!"
	rm -f "${MUNKIPATH}preflight.d/extension_attributes"

	# Signal that we had an error
	ERR=1
fi
