<?php

class SV_AlertOnWarning_Listener
{
    public static function install($existingAddOn, $addOnData)
    {
        $db = XenForo_Application::getDb();

        $db->query("
            INSERT IGNORE INTO xf_content_type
                (content_type, addon_id, fields)
            VALUES
                ('".SV_AlertOnWarning_AlertHandler_Warning::ContentType."', 'SV_AlertOnWarning', '')
        ");

        $db->query("
            INSERT IGNORE INTO xf_content_type_field
                (content_type, field_name, field_value)
            VALUES
                ('".SV_AlertOnWarning_AlertHandler_Warning::ContentType."', 'alert_handler_class', 'SV_AlertOnWarning_AlertHandler_Warning')
        ");

        return true;
    }

    public static function uninstall()
    {
        $db = XenForo_Application::get('db');

        $db->query("
            DELETE FROM xf_content_type_field
            WHERE xf_content_type_field.field_value = 'SV_AlertOnWarning_AlertHandler_Warning'
        ");

        $db->query("
            DELETE FROM xf_content_type
            WHERE xf_content_type.addon_id = 'SV_AlertOnWarning'
        ");
        return true;
    }

    public static function load_class($class, array &$extend)
    {
        switch ($class)
        {
 
            case 'XenForo_ControllerPublic_Account':
                $extend[] = 'SV_AlertOnWarning_XenForo_ControllerPublic_Account';
                break;       
            case 'XenForo_Model_Warning':
                $extend[] = 'SV_AlertOnWarning_XenForo_Model_Warning';
                break;
            case 'XenForo_DataWriter_Warning':
                $extend[] = 'SV_AlertOnWarning_XenForo_DataWriter_Warning';
                break;
        }
    }

}
