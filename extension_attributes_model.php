<?php

use CFPropertyList\CFPropertyList;

class Extension_attributes_model extends \Model
{
    public function __construct($serial = '')
    {
        parent::__construct('id', 'extension_attributes'); // Primary key, tablename
        $this->rs['id'] = '';
        $this->rs['serial_number'] = $serial;
        $this->rs['displayname'] = null;
        $this->rs['result'] = null;
        $this->rs['displayincategory'] = null;
        $this->rs['datatype'] = null;
    }


    // ------------------------------------------------------------------------
    /**
     * Process data sent by postflight
     *
     * @param string data
     *
     **/
    public function process($data)
    {
        // If data is empty, echo out error
        if (! $data) {
            echo ("Error Processing extension attributes: No data found");
        } else { 
            
            // Delete previous entries
            $this->deleteWhere('serial_number=?', $this->serial_number);

            // Process incoming extension_attributes.plist
            $parser = new CFPropertyList();
            $parser->parse($data, CFPropertyList::FORMAT_XML);
            $plist = $parser->toArray();
            
            // Process each extension attribute
            foreach ($plist as $single_ae) {
                foreach (array('displayname', 'result', 'displayincategory', 'datatype') as $item) {
                    // If key does not exist in $single_ae, null it
                    if ( ! array_key_exists($item, $single_ae) || $single_ae[$item] == '') {
                        $this->$item = null;
                    // Set the db fields to be the same as those for the attribute
                    } else {
                        $this->$item = $single_ae[$item];
                    }
                }
                
            // Save the data, wash your hands
            $this->id = '';
            $this->save(); 
            }
        }
    }
}