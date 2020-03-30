#!/bin/bash

# Remove extension_attributes script
rm -f "${MUNKIPATH}preflight.d/extension_attributes"

# Remove extension_attributes.plist cache file
rm -f "${MUNKIPATH}preflight.d/cache/extension_attributes.plist"
