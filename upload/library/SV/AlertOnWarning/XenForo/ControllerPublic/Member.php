<?php

class SV_AlertOnWarning_XenForo_ControllerPublic_Member extends XFCP_SV_AlertOnWarning_XenForo_ControllerPublic_Member
{
    public function actionWarn()
    {
        SV_AlertOnWarning_XenForo_DataWriter_Warning::$SendWarningAlert = $this->_input->filterSingle('send_warning_alert', XenForo_Input::BOOLEAN);

        return parent::actionWarn();    
    }
}