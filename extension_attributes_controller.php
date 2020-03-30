<?php
/**
 * extension_attributes module class
 *
 * @package munkireport
 * @author tuxudo
 **/
class Extension_attributes_controller extends Module_controller
{
    
    /*** Protect methods with auth! ****/
    public function __construct()
    {
        // Store module path
        $this->module_path = dirname(__FILE__);
    }
    
    /**
    * Default method
    *
    * @author AvB
    **/
    public function index()
    {
        echo "You've loaded the extension_attributes module!";
    }
    
    /**
    * Retrieve data in json format
    *
    * @return void
    * @author tuxudo
    **/
    public function get_tab_data($serial_number = '')
    {
        $obj = new View();
        
        $sql = "SELECT displayname, result
                    FROM extension_attributes 
                    WHERE serial_number = '$serial_number'";
        
        $queryobj = new Extension_attributes_model();
        $extension_attributes_tab = $queryobj->query($sql);
        $obj->view('json', array('msg' => current(array('msg' => $extension_attributes_tab)))); 
    }
} // END class Extension_attributes_controller