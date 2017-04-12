<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SchemaInstall
 *
 * @author ramesh
 */
 namespace Core\Modules\CoreDevelopmentsettings\Setup;
class SchemaInstall
{
    //put your code here
    function __construct() 
    {
        $this->setUp();
    }
    protected function setUp()
    {
        $nodesArray=array(
            // Node Actions            
            "CoreActionType"=>"CoreActionType",
            "CoreNodeActions"=>"CoreNodeActions",
            //Node Management
            "CoreRegisternode"=>"CoreRegisternode",
            "CoreNodeSettings"=>"CoreNodeSettings",            
            "CoreElementDisplaytype"=>"CoreElementDisplaytype",
            "CoreUniquefieldset"=>"CoreUniquefieldset",
            "CoreDefaultvalues"=>"CoreDefaultvalues",
            // Attributes 
            "CoreRootAttributes"=>"CoreRootAttributes",
            "CoreNodeAttributes"=>"CoreNodeAttributes",
            "CoreNodeFieldattributes"=>"CoreNodeFieldattributes",
            // Custom Attributes 
            "CoreAttributeOption"=>"CoreAttributeOption",
            "CoreNodeAttributeOption"=>"CoreNodeAttributeOption",
            "CoreNodeAttributeOptionList"=>"CoreNodeAttributeOptionList",
            "CoreNodeAttributeOptionValue"=>"CoreNodeAttributeOptionValue",
            "CoreNodeAttributeset"=>"CoreNodeAttributeset",
            //File Management
            "CoreFileTypes"=>"CoreFileTypes",
            "CoreCmsUploadfolders"=>"CoreCmsUploadfolders",
            "CoreCmsImageSettings"=>"CoreCmsImageSettings",
            "CoreCmsMediatype"=>"CoreCmsMediatype",
            "CoreNodeFiletypes"=>"CoreNodeFiletypes",            
            // Relation Settings
            "CoreRelationType"=>"CoreRelationType",
            "CoreNodeRelations"=>"CoreNodeRelations",
            // Form Settings
            "CoreFormSettings"=>"CoreFormSettings",
            "CoreFormLayout"=>"CoreFormLayout",            
            //Report Settings
            "CoreOrderclausetype"=>"CoreOrderclausetype",
            "CoreAggregateFunction"=>"CoreAggregateFunction",
            "CoreQueryclause"=>"CoreQueryclause",
            "CoreOutputType"=>"CoreOutputType",
            "CoreReportOutputtypes"=>"CoreReportOutputtypes",
            "CoreReportDetails"=>"CoreReportDetails",
            "CoreReportsdetailsSettings"=>"CoreReportsdetailsSettings",            
            // CoreAppSettings
            "CoreAppSettings"=>"CoreAppSettings",
            // Archive Settings
            "CoreArchiveData"=>"CoreArchiveData",
            "CoreNodeHistory"=>"CoreNodeHistory",
            //backup
            "CoreBackupType"=>"CoreBackupType",
            "CoreBackupdetails"=>"CoreBackupdetails",
            // Email Settings
            "CoreEmailSettings"=>"CoreEmailSettings", 
            "CoreEmailNotifications"=>"CoreEmailNotifications",
            "CoreEmailVerify"=>"CoreEmailVerify",
                       
            //Label Settings
            "CoreLabelDetails"=>"CoreLabelDetails",
            
            // Report Templates
            "CoreReportTemplate"=>"CoreReportTemplate",            
            // Sequence Settings
            "CoreSettingsSequence"=>"CoreSettingsSequence",
            // Socail Media Settings
            "CoreSocialnetworkingsites"=>"CoreSocialnetworkingsites", 
            // Admin Theme Settings
            "CoreAdminthemeSettings"=>"CoreAdminthemeSettings",
            // SMS Settings 
            "CoreSmsSettings"=>"CoreSmsSettings",
            "CoreSmsNotifications"=>"CoreSmsNotifications",
            "CoreSmsLog"=>"CoreSmsLog",
            "CoreSmsVerify"=>"CoreSmsVerify",
            "CoreWhatsappSettings"=>"CoreWhatsappSettings",
            // table for url rewrite
            "CoreUrlRewrite"=>"CoreUrlRewrite",
            
            // Organization             
            "CoreOrganization"=>"CoreOrganization",
            "CoreOrganizationHistory"=>"CoreOrganizationHistory",
            "CoreOrganizationSocialnetworkingsites"=>"CoreOrganizationSocialnetworkingsites",
            
            // Portal Theme Settings
            "CoreCmsThemesettings"=>"CoreCmsThemesettings",
            
            // General Settings
            "CoreCountry"=>"CoreCountry",
            "CoreAttendanceStatus"=>"CoreAttendanceStatus",
            "CoreListCity"=>"CoreListCity",
            "CoreListLocation"=>"CoreListLocation",
            "CoreListState"=>"CoreListState",
            "CorePaymentType"=>"CorePaymentType",
            "CoreWeekDetails"=>"CoreWeekDetails",
            "CoreAddressType"=>"CoreAddressType",
            
        );
        foreach ($nodesArray as $node) 
        {
            $nodeClass=str_replace("'","","\Core\Modules\CoreDevelopmentsettings\Setup"."\'".$node);
            $nodeClass=str_replace("'","",$nodeClass);
            $rnode=new $nodeClass();
            $rnode->execute();
        }               
    }
}
