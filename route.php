<?php
if (isset($argv)|| (\Core::keyInArray("type", $_REQUEST) && \Core::getValueFromArray($_REQUEST, "type"))) {
    if(isset($argv))
    {
        $params=$argv;
    }
    else
    {
        $params=\Core::getValuesFromArray($_REQUEST);
    }
    unset($params[0]);
    $cmd=new \Core\Command();
    $cmd->setInputParameters($params);
    $cmd->execute();
} else {
   
    $extension = substr(Core::getValueFromArray($_REQUEST,'reditectpath'), -3);
    if (Core::inArray($extension, array(".js", "css", "png", "jpg", "gif"))) {
        header("HTTP/1.0 404 File Not Exists"); 
        exit;
    }    
    global $globalnode_settings_details;
    global $nodefiledetails;
    global $currentNode;
    global $currentNodePropertices;
    global $actionRequestFrom;
    try {
        
        $currentNodePropertices = new \Core\Model\AdminSettings($_REQUEST, $_FILES);
        $parentNode = $currentNodePropertices->_parentNode;
        $parentValue = $currentNodePropertices->_parentValue;
        $parentAction = $currentNodePropertices->_parentAction;
        $currentNode = $currentNodePropertices->_currentNode;
        $currentAction = $currentNodePropertices->_currentAction;
        $currentModule = Core::getValueFromArray($currentNodePropertices->_nodeDetails, 'module');
        $currentModuleDisplay = Core::getValueFromArray($currentNodePropertices->_nodeDetails, 'moduledisplay');
        $currentRootModule = Core::getValueFromArray($currentNodePropertices->_nodeDetails, 'rootmodule');
        $currentSelector = $currentNodePropertices->_currentSelector;
        $methodType = $currentNodePropertices->_methodType;
        $apiMethod = $currentNodePropertices->_isAPI;
        $actionRequestFrom = $currentNodePropertices->_actionSource;
        $childNode = $currentNodePropertices->_childNode;
        $requestedData = $currentNodePropertices->_requestedData;
        $filesData = $currentNodePropertices->_filesData;
        $cc = new \CoreClass();
        $session=$cc->getObject("\Core\Session");
        $sessionData = $session->getSessionData();
        $session->setFrontendSessionValue("prevurl", $session->getFrontendSessionValue('currenturl'));
        $session->setFrontendSessionValue("currenturl", Core::getValueFromArray($requestedData,'reditectpath'));
        if ($methodType != 'POST' && $apiMethod == 1) {
            echo json_encode(array("status" => "error", "message" => "Please Provide Valid Url"));
            exit;
        }
        $currentProfileCode = Core::getValueFromArray($sessionData, 'profile_id');
        $header = true;
        $navigation = true;
        $footer = true;

        if ($currentAction != "") {
            $action = $currentAction;
        } else {
            if ($actionRequestFrom == 'frontend') {
                $action = "index";
            } else {
                $action = "admin";
            }
        }
        if ($actionRequestFrom == 'frontend') {
            $frontController = CoreClass::getFrontController($currentNode, $currentModule, $action);
            $frontController->setNodeName($currentNode);
            $frontController->setActionName($action);
            $frontController->setMetaUrlInfo($currentNodePropertices->_metaUrlInfo);
            $frontController->setCurrentSelector($currentSelector);
            $frontController->setRequestedData($requestedData);
            $frontController->setFilesData($filesData);
            $functionName = $action . "Action";

            if (method_exists($frontController, $functionName)) {
                $frontController->$functionName();
            } else {
                $frontController->indexAction();
            }
        } else {

            if ($action == "print" || $action == "export") {
                $header = false;
                $navigation = false;
                $footer = false;
            }
            if ($methodType == "POST" || ($currentProfileCode == "" && $actionRequestFrom == 'admin')) {
                $header = false;
                $navigation = false;
                $footer = false;
            }

            if ($currentNode != "") {
                if($apiMethod==1)
                {                    
                    $node=CoreClass::getApiController($currentNode,$currentModule,$action);
                }
                else 
                {
                    $node=CoreClass::getController($currentNode,$currentModule,$action);
                }
                $node->setNodeName($currentNode);
                $node->setAPI($apiMethod);
                $node->setChildNode($childNode);
                $node->setActionName($action);
                $node->setParentNode($parentNode);
                $node->setParentValue($parentValue);
                $node->setParentAction($parentAction);
                $node->setCurrentSelector($currentSelector);
                $node->setMethodType($methodType);
                $node->setRequestedData($requestedData);
                $node->setFilesData($filesData);
                $node->checkSession();
                $functionName = $action . "Action";

                if (method_exists($node, $functionName)) {
                    $node->$functionName();
                } else {
                    if ($methodType == 'REQUEST') {
                        $node->noAction();
                    } else {
                        
                    }
                }
            } else {
                $cc = new \CoreClass();
                $session=$cc->getObject("\Core\Session");
                $session = $session->getSessionMaganager();
                $homeController =$cc->getObject("\Core\Controllers\AdminController");
                $homeController->setNodeName($currentNode);
                $homeController->setActionName($action);
                $homeController->setRequestedData($requestedData);
                $homeController->setFilesData($filesData);
                $functionName = $action . "Action";
                if (method_exists($homeController, $functionName)) {
                    $homeController->$functionName();
                } else {
                    $homeController->indexAction();
                }
            }
        }
    } catch (Exception $ex) {
        echo $e->getMessage();
    }
}