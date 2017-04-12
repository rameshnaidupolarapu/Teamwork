<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataInstall
 *
 * @author ramesh
 */
namespace Core\Modules\CoreDevelopmentsettings\Data;
class DataInstall 
{
    //put your code here
    function __construct() 
    {
        $this->setDataUp();
    }
    protected function setDataUp()
    {
        $nodesArray=array(
            "CoreModuleCreate"=>"CoreModuleCreate",
            "CoreRegisternode"=>"CoreRegisternode",
            "CoreNodeSettings"=>"CoreNodeSettings",
            "CoreActionType"=>"CoreActionType",
            "CoreAdminthemesettings"=>"CoreAdminthemesettings",
            "CoreCmsUploadfolders"=>"CoreCmsUploadfolders",
            "CoreNodeActions"=>"CoreNodeActions",
            "CoreRootAttributes"=>"CoreRootAttributes",
            "CoreUniquefieldset"=>"CoreUniquefieldset",
            "CoreQueryClause"=>"CoreQueryClause",
            "CoreOrderClausetype"=>"CoreOrderClausetype",
            "CoreAggregateFunction"=>"CoreAggregateFunction",
            "CoreOutputType"=>"CoreOutputType",
            "CoreNodeHistory"=>"CoreNodeHistory",
            "CoreElementDisplaytype"=>"CoreElementDisplaytype",
            "CoreFormSettings"=>"CoreFormSettings",
            "CoreBackupType"=>"CoreBackupType",
            "CoreRelationType"=>"CoreRelationType",
            "CoreNodeRelations"=>"CoreNodeRelations",
            "CoreFormLayout"=>"CoreFormLayout",
            "CoreDefaultvalues"=>"CoreDefaultvalues",
            "CoreNodeFieldattributes"=>"CoreNodeFieldattributes",
            "CoreCmsImageSettings"=>"CoreCmsImageSettings",
            "CoreCmsMediatype"=>"CoreCmsMediatype",            
            "CoreFileTypes"=>"CoreFileTypes",
            "CoreLabelDetails"=>"CoreLabelDetails",
            "CoreNodeAttributes"=>"CoreNodeAttributes",
            "CoreNodeFiletypes"=>"CoreNodeFiletypes",
            "CoreReportTemplate"=>"CoreReportTemplate",
            "CoreSettingsSequence"=>"CoreSettingsSequence",
            "CoreSocialnetworkingsites"=>"CoreSocialnetworkingsites",
            "CoreEmailSettings"=>"CoreEmailSettings",
            "CoreEmailNotifications"=>"CoreEmailNotifications",
            "CoreEmailVerify"=>"CoreEmailVerify",
            "CoreSmsSettings"=>"CoreSmsSettings",            
            "CoreSmsNotifications"=>"CoreSmsNotifications",
            "CoreSmsVerify"=>"CoreSmsVerify",            
            "CoreAppSettings"=>"CoreAppSettings",
            "CorePaymenType"=>"CorePaymenType",
            "CoreOrganization"=>"CoreOrganization",
            "CoreListLocation"=>"CoreListLocation",
            "CoreOrganizationSocialnetworkingsites"=>"CoreOrganizationSocialnetworkingsites",
            "CoreArchiveData"=>"CoreArchiveData",
            "CoreReportsdetailsSettings"=>"CoreReportsdetailsSettings",
            "CoreSmsLog"=>"CoreSmsLog",
            "CoreReportsengine"=>"CoreReportsengine",
            "CoreReportsdetails"=>"CoreReportsdetails",
            "CoreBackupdetails"=>"CoreBackupdetails",
            "CoreCodeBackup"=>"CoreCodeBackup",
            "CoreDbbackfile"=>"CoreDbbackfile",
            "CoreReportOutputtypes"=>"CoreReportOutputtypes",
            "CoreUsedashboard"=>"CoreUsedashboard",
            "CoreListCity"=>"CoreListCity",
            "CoreListState"=>"CoreListState",
            "CoreAttendanceStatus"=>"CoreAttendanceStatus",
            "CoreCountry"=>"CoreCountry",
            // node for url rewrite
            "CoreUrlRewrite"=>"CoreUrlRewrite",
            "CoreWhatsappSettings"=>"CoreWhatsappSettings",
            "CoreAttributeOption"=>"CoreAttributeOption",
            "CoreNodeAttributeset"=>"CoreNodeAttributeset",
            "CoreNodeAttributeOption"=>"CoreNodeAttributeOption",
            "CoreNodeAttributeOptionList"=>"CoreNodeAttributeOptionList",
            "CoreNodeAttributeOptionValue"=>"CoreNodeAttributeOptionValue",
            "CoreWeekDetails"=>"CoreWeekDetails",
            "CoreAddressType"=>"CoreAddressType",
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass=str_replace("'","","\Core\Modules\CoreDevelopmentsettings\Data\'".$node);
            $rnode=new $nodeClass();
            $rnode->execute();
        } 
        
    }
}
