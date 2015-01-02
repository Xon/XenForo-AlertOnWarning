<?php

class SV_AlertOnWarning_XenForo_DataWriter_Warning extends XFCP_SV_AlertOnWarning_XenForo_DataWriter_Warning
{
    public static $SendWarningAlert = true;

    protected function _postSave()
    {
        parent::_postSave();

        if ($this->isInsert() && self::$SendWarningAlert)
        {
            $options = XenForo_Application::getOptions();
            $user_id = 0;
            $username = '';
            if (!$options->sv_alert_warning_anonymise)
            {
                $warning_user = $this->_getUserModel()->getUserById($this->get('warning_user_id'));    
                if ($warning_user && isset($warning_user['user_id']))
                {
                    $user_id = $warning_user['user_id'];
                    $username  = $warning_user['username'];
                }
            }
            XenForo_Model_Alert::alert(
                $this->get('user_id'),
                $user_id, $username,
                SV_AlertOnWarning_AlertHandler_Warning::ContentType,
                $this->get('warning_id'),
                'warning');
        }
    }
    
    protected function _postDelete()
    {
        parent::_postDelete();
        
        $this->getModelFromCache('XenForo_Model_Alert')->deleteAlerts('warning', $this->get('warning_id'));
    }
    
}
