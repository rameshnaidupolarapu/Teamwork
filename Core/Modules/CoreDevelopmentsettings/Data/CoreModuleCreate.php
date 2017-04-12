<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreModuleCreate
 *
 * @author ramesh
 */

namespace Core\Modules\CoreDevelopmentsettings\Data;

class CoreModuleCreate {

    //put your code here
    public function execute() {
        try {
            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_developmentsettings");
            $registerController->setNodeNameData("core_developmentsettings");
            $registerController->setDisplayValue("Development Settings");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("1");
            $registerController->setIcon("icon-cogs");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_codebasedsettings");
            $registerController->setNodeNameData("core_codebasedsettings");
            $registerController->setDisplayValue("Code Based Settings");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("2");
            $registerController->setIcon("icon-cogs");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_backup");
            $registerController->setNodeNameData("core_backup");
            $registerController->setDisplayValue("Backup");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("1");
            $registerController->setIcon("icon-download");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_general");
            $registerController->setNodeNameData("core_general");
            $registerController->setDisplayValue("General");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("Settings");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("1");
            $registerController->setIcon("");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_reports");
            $registerController->setNodeNameData("core_reports");
            $registerController->setDisplayValue("Reports");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("5");
            $registerController->setIcon("icon-bar-chart");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_settings");
            $registerController->setNodeNameData("core_settings");
            $registerController->setDisplayValue("Settings");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("3");
            $registerController->setIcon("icon-cog");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_usermanagement");
            $registerController->setNodeNameData("core_usermanagement");
            $registerController->setDisplayValue("User Management");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("3");
            $registerController->setIcon("icon-group");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_organizationsetup");
            $registerController->setNodeNameData("core_organizationsetup");
            $registerController->setDisplayValue("Organization Setup");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("6");
            $registerController->setIcon("icon-sitemap");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("core_dashboard");
            $registerController->setNodeNameData("core_dashboard");
            $registerController->setDisplayValue("Dash Board");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("1");
            $registerController->setIcon("icon-dashboard");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();

            $registerController = \CoreClass::getController("core_registernode", "core_developmentsettings");
            $registerController->setNodeFileName("attribute_settings");
            $registerController->setNodeNameData("attribute_settings");
            $registerController->setDisplayValue("Attribute Settings");
            $registerController->setIsModule("1");
            $registerController->setRootModuleId("core_developmentsettings");
            $registerController->setModuleId("");
            $registerController->setModuleDisplayId("");
            $registerController->setSortValue("4");
            $registerController->setIcon("icon-dashboard");
            $registerController->setMenu("1");
            $registerController->setIsNotification("0");
            $registerController->dataSave();
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage(), "installdata.log");
        }
    }

}
