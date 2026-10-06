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
    * Get attribute data for widget
    *
    * @param string $attribute
    **/
    public function attributesWidget($attribute = '')
    {
        // Protect this handler
        if (! $this->authorized()) {
            redirect('auth/login');
        }
        $attribute = rawurldecode($attribute);

        // Detect wildcard character
        if (preg_match('/[_%]/', $attribute)) {
            $comparator = 'like';
        } else {
            $comparator = '=';
        }

        // Remove non-attribute characters
        $attribute = preg_replace("/[^A-Za-z0-9_\-]/", '', $attribute);

        $sql = "SELECT COUNT(*) AS count, result 
                    FROM extension_attributes
                    LEFT JOIN reportdata USING (serial_number)
                    ".get_machine_group_filter()."
                    AND displayname $comparator '$attribute'
                    GROUP BY result
                    ORDER BY result DESC";

        $obj = new View();
        $queryobj = new Extension_attributes_model();
        $obj->view('json', array('msg' => current(array('msg' => $queryobj->query($sql)))));
    }

    /**
    * Retrieve data in json format
    *
    * @return void
    * @author tuxudo
    **/
    public function get_tab_data($serial_number = '')
    {
        // Remove non-serial number characters
        $serial_number = preg_replace("/[^A-Za-z0-9_\-]/", '', $serial_number);

        $obj = new View();
        
        $sql = "SELECT displayname, result
                    FROM extension_attributes 
                    LEFT JOIN reportdata USING (serial_number)
                    ".get_machine_group_filter()."
                    AND serial_number = '$serial_number'";

        $queryobj = new Extension_attributes_model();
        $obj->view('json', array('msg' => current(array('msg' => $queryobj->query($sql)))));
    }
} // END class Extension_attributes_controller