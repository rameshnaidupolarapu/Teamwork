<?php
namespace Core\Controllers;
use \Core\Pages\Render;
class NodeController extends Render
{
    
    public $_nodeName=NULL;
    public $_currentAction="Admin";
    public $_websiteAdminUrl=NULL;
    public $_websiteHostUrl=NULL;
    public $_websiteRootHostUrl=NULL;
    public $_methodType=NULL;    
    public $_performMraAction=NULL;
    public $_removeActionRecords=array();
    public $_scriptAdd=NULL;
    
    function __construct($nodeName,$action) 
    {
        global $rootObj;
        $wp=$rootObj;                
        $this->setNodeName($nodeName);
        $this->setActionName($action);
        $this->_websiteHostUrl=$wp->websiteAdminUrl.$this->getNodeName()."/";
        $this->_websiteAdminUrl=$wp->websiteAdminUrl;
        $this->_websiteRootHostUrl=$wp->websiteUrl;
        $this->setShowAttributes();
        parent::__construct();
    }
    public function setScriptAction()
    {        
        $this->_scriptAdd=1;
    }
    public function setMethodType($Type)
    {        
        $this->_methodType=$Type;
    }
    public function setMraActionPerform()
    {
        $this->_performMraAction=1;
    }    
    public function adminAction()
    {        
        $this->gridContent();        
    }
    public function noAction()
    {
        if($this->_methodType=='POST')
        {
            
            $output=array();
            $output['status']="error";
            $output['errors']=$this->getLabel($this->_currentAction)." is Not Existing";
            echo json_encode($output);
            exit;
        }
        else
        {
            $this->loadLayout("noActionFound.phtml");
        }
    }
    
    function checkSession()
    {
        if($this->_currentAction!='validateLogin' && $this->_currentAction!='logout' && $this->_currentAction!='login')
        {            
            $session=new \Core\Session();
            $session->setApi($this->_isAPI);
            $session=$session->getSessionMaganager();
        }
        return true;
    }
    public function logoutAction() 
    {
        $cc = new \CoreClass();
        $session=$cc->getObject("\Core\Session");
        $session->destroySession();
        global $rootObj;
        $wp=$rootObj;                
        \Core::redirectUrl($wp->websiteAdminUrl."core_users/login");
    }
    public function addAction()
    {       
        
        $backUrl=$this->_websiteHostUrl;
        $actionflag=isset($this->_requestedData['actionflag'])?$this->_requestedData['actionflag']:"";
        if($this->_parentNode)
        {
            $backUrl=$this->_websiteAdminUrl.$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector."/MTO/".$this->_nodeName;
        }
        $this->getDefaultAttributeValues();
        $requestedData=$this->_requestedData;
        if($this->_methodType=="REQUEST")
        {            
            $this->setCurrentNodeName($this->_nodeName);
            $this->getAdminLayout();
            $this->renderLayout();
        }
        else
        {
            try
            {
                
                $errorsArray=$this->nodeDataValidate("add",$this);
                if(\Core::countArray($errorsArray)>0)
                {   
                    $output['status']="error";
                    $output['errors']=$errorsArray;
                    $output['redirecturl']=$backUrl;  
                    if($this->_scriptAdd)
                    {
                        return $output;
                    }
                    echo json_encode($output);                   
                }
                else
                {                    
                    $data=array();                  
                                
                    foreach($this->_showAttributes as $FieldName)
                    {                
                        $fieldNameValue=\Core::convertArrayToString(\Core::getValueFromArray($requestedData,$FieldName));
                        $data[$FieldName]=$fieldNameValue;                        
                    } 
                    $data=$this->beforeDataUpdate($data);
                    $methodName=\Core::convertStringToMethod($this->_nodeName."_beforeDataUpdate");
                    if(\Core::methodExists($this, $methodName))
                    {
                        $data=$this->$methodName($data);
                    }
                    $nodeSave=new \Core\Model\NodeSave();
                    $nodeSave->setNode($this->_nodeName);
                    foreach ($data as $key=>$value)
                    {
                        $nodeSave->setData($key,$value);
                    }
                    $this->_requestedData['id']=$nodeSave->save();   
                    $method=\Core::convertStringToMethod($this->_nodeName."_afterDataUpdate");                    
                  
                    if(\Core::methodExists($this, $method))
                    {                       
                        $errorsArray=$this->$method();
                        if(\Core::isArray($errorsArray))
                        {
                            $output['status']="error";
                            $output['errors']=$errorsArray;
                            $output['redirecturl']=$backUrl;                 
                            echo json_encode($output);
                            exit;
                        }
                    }     
                    $method=\Core::convertStringToMethod($this->_nodeName."_commitDataUpdate"); 	
                    if(\Core::methodExists($this, $method))
                    {                       
                        $errorsArray=$this->$method();
                        if(\Core::isArray($errorsArray))
                        {
                            $output['status']="error";
                            $output['errors']=$errorsArray;
                            $output['redirecturl']=$backUrl;                 
                            echo json_encode($output);
                            exit;
                        }
                    }
                    if($actionflag=='continue')
                    {
                        if($this->_parentNode)
                        {
                            $backUrl=$this->_websiteAdminUrl.$this->_nodeName."/"."edit/".$this->_requestedData[$this->_primaryKey]."/".$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector;
                        }
                        else 
                        {
                            $backUrl.="edit/".$this->_requestedData[$this->_primaryKey];
                        }                                                
                    }
                    else if($actionflag=='next')
                    {
                        if($this->_parentNode)
                        {
                            $backUrl=$this->_websiteAdminUrl.$this->_nodeName."/"."add/0"."/".$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector;
                        }
                        else 
                        {
                            $backUrl.="add";
                        }
                    }					
                    $output=array();
                    $output['status']="success";
                    $output['primaryId']=$this->_requestedData[$this->_primaryKey];
                    $output['redirecturl']=$backUrl;   
                    if($this->_scriptAdd)
                    {
                        return $output;
                    }
                    echo json_encode($output);
                }
                
                
            }
            catch (Exception $ex)
            {
                \Core::Log(__METHOD__.$ex->getMessage(), $this->_nodeName."_add");
            }
        }
        
    }
    public function editAction()
    {       
        $requestedData=$this->_requestedData;
        $actionflag=isset($this->_requestedData['actionflag'])?$this->_requestedData['actionflag']:"";
        $backUrl=$this->_websiteHostUrl;
        if($this->_parentNode)
        {
                $backUrl=$this->_websiteAdminUrl.$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector."/MTO/".$this->_nodeName;
        }
        
        if($this->_methodType=="REQUEST")
        {
            
            $this->getRecordLoad();
            $this->setCurrentNodeName($this->_nodeName);
            $this->getAdminLayout();
            $this->renderLayout();
        }
        else
        { 
            
            try
            {
                $errorsArray=$this->nodeDataValidate("edit",$this);
                if(count($errorsArray)>0)
                {   
                    $output['status']="error";
                    $output['errors']=$errorsArray;
                    $output['redirecturl']=$backUrl;   
                    if($this->_scriptAdd)
                    {
                        return $output;
                    }
                    echo json_encode($output);                   
                }
                else
                {
                    $data=array();                  
                                
                    foreach($this->_showAttributes as $FieldName)
                    {      
                        $fieldNameValue=\Core::convertArrayToString(\Core::getValueFromArray($requestedData,$FieldName));
                        //rameshmodified
                        if($this->_scriptAdd)
                        {
                            if(\Core::keyInArray($FieldName, $requestedData))
                            {
                                $data[$FieldName]=$fieldNameValue;   
                            }
                        }
                        else
                        {
                            
                            $data[$FieldName]=$fieldNameValue;   
                        }
                                             
                    } 
                    $data=$this->beforeDataUpdate($data);
                    $methodName=\Core::convertStringToMethod($this->_nodeName."_beforeDataUpdate");
                    if(\Core::methodExists($this, $methodName))
                    {
                        $data=$this->$methodName($data);
                    }
                    $nodeSave=new \Core\Model\NodeSave();
                    $nodeSave->setNode($this->_nodeName);
                    $nodeSave->setData("id",$requestedData["id"]);
                    foreach ($data as $key=>$value)
                    {
                        $nodeSave->setData($key,$value);
                    }
                    $output=$nodeSave->save();
                    $method=\Core::convertStringToMethod($this->_nodeName."_afterDataUpdate");                    
                  
                    if(\Core::methodExists($this, $method))
                    {
                        $errorsArray=$this->$method();
                        if(\Core::isArray($errorsArray))
                        {
                            $output['status']="error";
                            $output['errors']=$errorsArray;
                            $output['redirecturl']=$backUrl;
                            if($this->_scriptAdd)
                            {
                                return $output;
                            }
                            echo json_encode($output);
                            exit;
                        }
                    }          
                    $method=\Core::convertStringToMethod($this->_nodeName."_commitDataUpdate"); 	
                    if(\Core::methodExists($this, $method))
                    {                       
                        $errorsArray=$this->$method();
                        if(\Core::isArray($errorsArray))
                        {
                            $output['status']="error";
                            $output['errors']=$errorsArray;
                            $output['redirecturl']=$backUrl;                 
                            echo json_encode($output);
                            exit;
                        }
                    }
                    if($actionflag=='continue')
                    {
                        if($this->_parentNode)
                        {
                            $backUrl=$this->_websiteAdminUrl.$this->_nodeName."/"."edit/".$this->_requestedData[$this->_primaryKey]."/".$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector;
                        }
                        else 
                        {
                            $backUrl.="edit/".$this->_requestedData[$this->_primaryKey];
                        }                        
                    }                    
                    $output=array();
                    $output['status']="success";
                    $output['primaryId']=$this->_requestedData[$this->_primaryKey];
                    $output['redirecturl']=$backUrl;    
                    if($this->_scriptAdd)
                    {
                        return $output;
                    }
                    echo json_encode($output);
                }
            }
            catch (Exception $ex)
            {
                \Core::Log(__METHOD__.$ex->getMessage(), $this->_nodeName."_edit");
            }
        }
        
    }
    public function viewAction()
    {
        if($this->_methodType=="REQUEST")
        {
            
            $this->getRecordLoad();
            $this->setCurrentNodeName($this->_nodeName);
            $this->getAdminLayout();
            $this->renderLayout();
        }        
        
    }
    public function checkDetleteData()
    {
        return true;
        $np=new \Core\Model\NodeProperties();
        $np->setNode($this->_nodeName);
        $childrelations=$np->getChildRelations();
        if(\Core::countArray($childrelations)>0)
        {
            foreach($childrelations as $node=>$colNameArray)
            {
                $np=new \Core\Model\NodeProperties();
                $np->setNode($node);
                $nodeStructure=$np->currentNodeStructure();
                $nodetablename=$nodeStructure['tablename'];
                $nodeprimkey=$nodeStructure['primkey'];
                $db=new \Core\DataBase\ProcessQuery();
                $db->setTable($nodetablename,$node);                
                $where=array();
                foreach($colNameArray as $colName)
                {
                    $where[]=$node.".".$colName." = '".$this->_currentSelector."'";
                }
                $db->addWhere("(".\Core::convertArrayToString($where, " || ").")");
                //$db->buildDelete();                
               // $db->executeQuery();
                $db->buildSelect();
                $count=$db->getValue();
                if($count>0)
                {
                  //  return  FALSE;
                }
            }
        }        
        return TRUE;
    }
    public function deleteAction()
    {
		if($this->_methodType=='REQUEST')
        {
            $this->loadLayout("dataprocessing.phtml");
        }
        try
        {
            if($this->_currentSelector)
            {
                $backUrl=$this->_websiteHostUrl;
                if($this->_parentNode)
                {
                    $backUrl=$this->_websiteAdminUrl.$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector."/MTO/".$this->_nodeName;
                }
                $deleteCheck=$this->checkDetleteData();
                if($deleteCheck)
                {   
                    $nodeDelete=new \Core\Model\NodeDelete();
                    $nodeDelete->setNode($this->_nodeName);
                    $nodeDelete->setPkValue($this->_currentSelector);
                    $nodeDelete->addFilterCondition("(".$this->_tableName.".".$this->_primaryKey." = '".$this->_currentSelector."'".")");           
                    $nodeDelete->delete();
                    $output=array();
                    $output['status']="success";
                    $output['redirecturl']=$backUrl;         
                    if($this->_methodType=='REQUEST')
                    {
                        \Core::redirectUrl($backUrl);
                    }
                    else
                    {
                        if($this->_performMraAction)
                        {
                            return json_encode($output);
                        }
                        else
                        {//karteek modified
							if($this->_scriptAdd)
							{
								return $output;
							}
							echo json_encode($output);
                        }
                    }
                }
                else 
                {
                    $output=array();
                    $output['status']="error";                    
                    $output['redirecturl']=$backUrl;
                    $message=" Record Con't Deleted ";
                    $output['error']=$message;
                    if($this->_methodType=='REQUEST')
                    {
                        \Core::redirectUrl($backUrl,$message);
                    }
                    else
                    {
                        if($this->_performMraAction)
                        {
                            return json_encode($output);
                        }
                        else
                        {
                            echo json_encode($output);
                        }
                    }                    
                }
            }
            
        }
        catch (Exception $ex) 
        {
            \Core::Log(__METHOD__."  ".$ex->getMessage());
        }
        return;
    }
    public function descriptorAction()
    {            
       
        try
        {
            $nodeRelations=$this->_nodeMTORelations;
            $requestedData=$this->_requestedData;        
            $sourceNode=$this->_requestedData['node'];
            $DestinationNode=$this->_requestedData['destinationNode'];         
            $FieldName=$this->_requestedData['idname'];  
            $noderesult=$this->_requestedData['noderesult'];
            $methodName=\CoreClass::getMethod($this,"descriptorAction",$sourceNode,$FieldName); 
            $idName=$this->_requestedData['idname'];  
            $active_status=\Core::inArray("active_status", $this->_boolAttributes);                
            if($methodName) 
            {           
                $this->$methodName();
            }
            else            
            {
                if($noderesult!="")
                {
                    $noderesult=  json_decode($noderesult,true);
                }
                else
                {
                    $noderesult=array();
                }
                $defaultValue=\Core::getValueFromArray($noderesult,$FieldName);               
                $readonlyAttributes=$this->readonlyAttributes($requestedData['action']);   
                $sourceNodeObj=\CoreClass::getModel($sourceNode, $requestedData['action']);
                $sourceNodeObjExists=0;
                if($sourceNodeObj)
                {
                    $sourceNodeObjExists=1;
                }
                
                if($sourceNodeObjExists==1)
                {
                    $sourceNodeObj->setNodeName($sourceNode);
                    $sourceNodeObj->setActionName($requestedData['action']);
                    $sourceNodeObj->setActionName($requestedData['action']);
                    $sourceNodeObj->setActionName($requestedData['action']);
                    $sourceNodeObj->getDefaultAttributeValues();
                    $sourceNodeObj->setRequestedData($requestedData);
                    $sourceNodeStructure=$sourceNodeObj->_currentNodeStructure;
                    $onchangeEvents=$sourceNodeObj->defaultOnchangeEvents($FieldName);
                    $eventmethod=lcfirst(str_replace(" ","",ucwords(str_replace("_", " ",$sourceNode)))."Onchange");            
                    if(\Core::methodExists($sourceNodeObj, $eventmethod))
                    {
                        $customonchangeEvents=$sourceNodeObj->$eventmethod(); 
                        if(count($customonchangeEvents)>0)
                        {
                            foreach ($customonchangeEvents as $key => $value) 
                            {
                               if(\Core::keyInArray($key, $onchangeEvents)) 
                               {
                                   $onchangeEvents[$key]=$onchangeEvents[$key].$value;
                               }
                               else
                               {
                                   $onchangeEvents[$key]=$value;
                               }
                            }
                        }
                    }    
                }
                $parentCol=0;
                if(\Core::keyInArray("parentformNode", $requestedData))
                {
                    if($requestedData['parentformvalue']!="" && $idName==$requestedData['parentformkey'])
                    {
                        $defaultValue=$requestedData['parentformvalue'];
                        $parentCol=1;
                    }
                }
                $multiSelectedValues=array();
                if(\Core::isArray($sourceNodeStructure))
                {            
                    $readonlyAttributes=\Core::convertStringToArray(\Core::getValueFromArray($sourceNodeStructure,'readonly_'.$requestedData['action']));   
                    $mandotatoryAttributes=\Core::convertStringToArray(\Core::getValueFromArray($sourceNodeStructure,'mandotatory_'.$requestedData['action']));   
                    $multiSelectedValues=\Core::convertStringToArray(\Core::getValueFromArray($sourceNodeStructure,'multivalues'));   
                }

                $db=new \Core\DataBase\ProcessQuery();
                $db->setTable($this->_tableName, $this->_nodeName);
                $db->addField($this->_nodeName.".".$this->_primaryKey." as pid");            
                if(\Core::keyInArray($this->_descriptor, $nodeRelations))
                {                
                    $np=new \Core\Model\NodeProperties();
                    $np->setNode($nodeRelations[$this->_descriptor]);
                    $parentNodeStructure=$np->currentNodeStructure();
                    $db->addFieldArray(array($nodeRelations[$this->_descriptor].".".$parentNodeStructure['descriptor']=>"pds"));
                    $joinCondition=$this->_nodeName.".".$this->_descriptor."=".$nodeRelations[$this->_descriptor].".".$parentNodeStructure['primkey'];
                    $db->addJoin($this->_descriptor,$parentNodeStructure['tablename'],$nodeRelations[$this->_descriptor],$joinCondition);               
                }
                else 
                {
                    $db->addFieldArray(array($this->_nodeName.".".$this->_descriptor=>"pds"));
                }
                if($requestedData['action']=='add' && $defaultValue=="")
                {
                    if($sourceNodeObjExists==1)
                    {
                        if(\Core::keyInArray($idName, $sourceNodeObj->_defaultValues))
                        {
                            $defaultValue=$sourceNodeObj->_defaultValues[$idName];
                        }                        
                    }
                }
                if(in_array($FieldName,$readonlyAttributes) || $requestedData['action']=='view' || $parentCol==1)
                {
                    $defaultValue_list=\Core::convertStringToArray($defaultValue,"|");
                    $db->addWhere("LOWER(".$this->_nodeName.".".$this->_primaryKey.") in ('".implode("','",$defaultValue_list)."')");
                }   
                $queryExecuteFlag=1; 
                if($sourceNodeObjExists==1)
                {
                    $depentparentList=$sourceNodeObj->defaultDependeeFilter($FieldName); 
                               
                    if(\Core::countArray($depentparentList)>0)
                    {
                        foreach ($depentparentList as $parentDependentColname) 
                        {
                            if(\Core::keyInArray($parentDependentColname, $requestedData))
                            {
                                if($requestedData[$parentDependentColname]=="")
                                {
                                    $queryExecuteFlag=0;                            
                                }
                                else
                                {
                                    $methodName=\CoreClass::getMethod($sourceNodeObj,"descriptionFilter",$sourceNode,$FieldName); 
                                    if($methodName) 
                                    { 
                                        $db->addWhere($sourceNodeObj->$methodName());
                                    }
                                    else
                                    {
                                        if(\Core::keyInArray($parentDependentColname, $this->_NodeFieldsList))
                                        {
                                            $db->addWhere($this->_nodeName.".".$parentDependentColname."='".$requestedData[$parentDependentColname]."'");
                                        }
                                    }
                                }                       
                            }

                        }                
                    }
                }
                if($active_status && $this->_currentAction=='add')
                {
                    $db->addWhere($this->_nodeName.".active_status='1'");
                }                
                $methodName=\Core::convertStringToMethod($FieldName."_addSingleFilter");
                if(\Core::methodExists($sourceNodeObj,$methodName))
                {
                    $db->addWhere($sourceNodeObj->$methodName());
                }
                if($sourceNodeObjExists==1)
                {
                    $methodName=\CoreClass::getMethod($this,"filter",$sourceNode,$FieldName);
                    if($methodName) 
                    {
                        if(\Core::methodExists($this,$methodName))
                        {
                            $db->addWhere($this->$methodName());
                        }                        
                    }
                }
                $db->addOrderBy($this->_descriptor);
                $db->buildSelect();
                if($queryExecuteFlag)
                {
                    $result=$db->getRows();        
                }
                else
                {
                    $result=array();
                }
                if(\Core::getValueFromArray($this->_requestedData,'dataType')=="json")
                {
                    echo \Core::convertArrayToJson($result); exit;
                }
                try
                {       

                    if(in_array($idName,  $multiSelectedValues))
                    {
                        $attributeType="checkbox";
                    }
                    else 
                    {
                        $attributeType="select";
                    }    

                    $attributeDetails=new \Core\Attributes\LoadAttribute($attributeType);				
                    $attributeClass="\Core\Attributes\'".$attributeDetails->_attributeName;
                    $attributeClass=  str_replace("'", "", $attributeClass);
                    $attribute=new $attributeClass;
                    $attribute->setIdName($idName);
                    $attribute->setOptions($result);
                    $attribute->setValue($defaultValue);
                    if(\Core::keyInArray($FieldName, $onchangeEvents))
                    {
                        $attribute->setOnchange($onchangeEvents[$FieldName]);
                    }
		    if(in_array($FieldName, $multiSelectedValues))
                    {
                        $attribute->setMultiValues(1);
                    }
                    $attribute->setAction($this->_requestedData['action']);
                    if(in_array($FieldName,$mandotatoryAttributes))
                    {
                        $attribute->setRequired();
                    }            
                    if(in_array($FieldName,$readonlyAttributes) || $requestedData['action']=='view' || $parentCol==1)
                    {                
                        $attribute->setReadonly();
                    }
                    $attribute->loadAttributeTemplate($attributeType,$FieldName);
                }
                catch (Exception $ex)
                {
                    \Core::Log(__METHOD__.$ex->getMessage());
                }
            } 
        }
        catch (Exception $ex)
        {
            \Core::Log(__METHOD__.$ex->getMessage());
        }
        
    }

    public function gridContent()
    {       
        if($this->_isDefaultCollection==1)
        {
            $this->setSingleActions();  
            $this->setIndividualActions();
            $this->setMraActions();
            $this->getCollection();
            $this->setCurrentNodeName($this->_nodeName);
            $this->actionRestriction();            
        }
        $this->getAdminLayout();
        $this->renderLayout();
    }    
    public function adminRefreshAction()
    {       
        $this->setSingleActions();  
        $this->setIndividualActions();
        $this->setMraActions();
        $this->getCollection();
        $this->setCurrentNodeName($this->_nodeName);
        $this->actionRestriction();
        $this->getAdminLayout();
        $this->renderLayout();
    }

    public function setSingleActions()
    {        
        return parent::setSingleActions();
    }
    public function nodeDataValidate($action,$nodeObject)
    {        
        $errorsArray=array();
        $requestedData=$nodeObject->_requestedData;
        $NodeFieldAttributes=$this->_NodeFieldAttributes;
        $nodeResult=  json_decode(\Core::getValueFromArray($requestedData, "noderesult"),true);     
        $mandotatoryAttributes =$this->mandotatoryAttributes();
        $methodName=\Core::convertStringToMethod($this->_nodeName."_nodeDataValidateBefore");
        
        if(\Core::methodExists($this, $methodName))
        {
            $errorsArray=$this->$methodName($errorsArray);
        }
        if(\Core::countArray($mandotatoryAttributes)>0)
        {
            foreach ($mandotatoryAttributes as $fieldName)
            {
                if($fieldName!="" && \Core::inArray($fieldName, $this->_showAttributes))
                {
                    
                    if($requestedData[$fieldName]=="")
                    {
                        $attributeType="";
                        if(\Core::keyInArray($fieldName, $NodeFieldAttributes))
                        {
                            $attributeType=$NodeFieldAttributes[$fieldName];
                        }
                        if($attributeType=='file')
                        {
                            if($nodeResult[$fieldName]=="")
                            {
                                if($this->_filesData[$fieldName]['name']=="")
                                {
                                    $errorsArray[$fieldName]=" Please Upload  ".$this->getLabel($fieldName);
                                }
                            }
                            else 
                            {
                                if($this->_requestedData['check_'.$fieldName]==1)
                                {
                                    if($this->_filesData[$fieldName]['name']=="")
                                    {
                                        $errorsArray[$fieldName]=" Please Upload  ".$this->getLabel($fieldName);
                                    }
                                }
                            }
                        }
                        else
                        {
                            $errorsArray[$fieldName]=" Please Enter ".$this->getLabel($fieldName);                
                        }
                    }
                    else
                    {
                        if(\Core::inArray($fieldName, $this->_numberAttributes))
                        {
                            if(!is_numeric($requestedData[$fieldName]))
                            {
                                $errorsArray[$fieldName]=" Please Enter Numbers Only ";
                            }                    
                        }
                    }
                }

            }    
        }
        if(count($errorsArray)==0)
        {
            foreach($this->_uniqueAttributes as $fieldName)
            {
                if(\Core::getValueFromArray($requestedData, "$fieldName")!="")
                {
                    $db=new \Core\DataBase\ProcessQuery();            
                    $db->setTable($this->_tableName); 
                    $db->addField("count(".$this->_tableName.".$this->_primaryKey)");
                    $db->addWhere($fieldName."='".$requestedData[$fieldName]."'");
                            $db->addWhere($this->_primaryKey."!='".\Core::getValueFromArray($nodeResult, $this->_primaryKey)."'");
                    
                    $db->buildSelect();       
                    
                    $existingCount=$db->getValue();
                    if($existingCount>0)
                    {
                        $errorsArray[$fieldName]=" Value is already Existing ";
                    }
                }
            }
            $UnqueFieldSetAttributes=$this->getUnqueFieldSetAttributes();
            if(\Core::countArray($UnqueFieldSetAttributes)>0)
            {
                foreach ($UnqueFieldSetAttributes as $UnqueFieldSet) 
                {
                    $db=new \Core\DataBase\ProcessQuery();            
                    $db->setTable($this->_tableName); 
                    $db->addField("count(".$this->_tableName.".$this->_primaryKey)");
                    $UnqueFieldSet_list= \Core::convertStringToArray($UnqueFieldSet);
                    $UnqueFieldSet_list_label=array();
                    foreach($UnqueFieldSet_list as $fieldName)
                    {            
                        $UnqueFieldSet_list_label[]=$this->getLabel($fieldName);
                        $db->addWhere($fieldName."='".$requestedData[$fieldName]."'");
                    }
                    $db->addWhere($this->_primaryKey."!='".$nodeResult[$this->_primaryKey]."'");                    
                    $db->buildSelect();                    
                    $existingCount=$db->getValue();
                    if($existingCount>0)
                    {
                        $errorsArray[$fieldName]=" Value must be Unque for Combination :: (".\Core::convertArrayToString($UnqueFieldSet_list_label,",").") ";
                    }
                }
            }
            
        }   
        
        $methodName=\Core::convertStringToMethod($this->_nodeName."_nodeDataValidateAfter");
        if(\Core::methodExists($this, $methodName))
        {
            $errorsArray=$this->$methodName($errorsArray);
        }
        return $errorsArray;
    }
    public function beforeDataUpdate($data)
    {        
        
        $node=$this->_nodeName;
        $node_properties=$this->_currentNodeStructure;        
        $requestedData=$this->_requestedData;
        $filesData=$this->_filesData;
        $action=$this->_currentAction;
        $table=$this->_tableName;
        $fileattribute=$node_properties['file'];
        $fileattribute_list=array();
        $filesettings_array=array();
        $file_types=array();
        $filePath=$this->_filePath;
        $existingResult=\Core::convertJsonToArray(\Core::getValueFromArray($requestedData, "noderesult"));
        if(\Core::keyInArray("parent_level",$this->_NodeFieldsList))
        {
            $parent_level=1;
            if($requestedData['parent']!="")
            {
                $db=new \Core\DataBase\ProcessQuery();
                $db->setTable($table);
                $db->addField("parent_level");
                $db->addWhere($table.".".$this->_primaryKey."='".$requestedData['parent']."'");
                $parent_level=$db->getValue()+1;
            }
            $data['parent_level']=$parent_level;
        }
        foreach ($this->_NodeFieldAttributes as $key=>$type)
        {
           
            if($this->_currentAction=='edit')
            {
		if(!$this->_scriptAdd)
		{
			if($type=='PSD'&& $data[$key]=="")
			{
				$fileName=$existingResult[$key];
				$data[$key]=$fileName;
			}
		}
            }
        }
        
        if($fileattribute!="")
        {           
            $fileattribute_list=\Core::convertStringToArray($fileattribute);            
              
            if(count($fileattribute_list)>0)
            {
                
                foreach($fileattribute_list as $key)
                {
                    

                    if(\Core::keyInArray($key,$filesData))
                    {

                            $columnnamedata=$filesData[$key];
                            if($columnnamedata['name']!="")
                            {
                                $uploadfolder="";
                                $storagefolder="";
                                if(\Core::keyInArray($key, $filePath))
                                {
                                    $uploadfolder=$filePath[$key]['storagefolder'];
                                    $storagefolder=$filePath[$key]['storagefolder'];
                                }
                                $uploadfilepath=$columnnamedata['tmp_name'];
                                $list=explode(".",$columnnamedata['name']);
                                $extentioncount=count($list);
                                $extention=$list[$extentioncount-1];
				$uploadfolder=\Core::createFolder($uploadfolder, "U");
                                $filename=str_replace(array(" ","_"),array("",""),$list['0'].".".strtolower($extention));
				$temppath=$uploadfolder.$filename;
				if(\Core::fileExists($temppath))
				{
					$filename=str_replace(array(" ","_"),array("",""),$list['0']."_".strtotime(date('Y-m-d h:i:s')).".".strtolower($extention));
				}
                                $data[$key]=$filename;
                                $filepath.=$uploadfolder.$filename;
                                try
                                {
                                    move_uploaded_file($uploadfilepath,$filepath);		    
                                }
                                catch (Exception $ex)
                                {
                                    \Core::Log($ex->getMessage());
                                }
                                $imageproperties=$requestedData[$key];  
				$tempfolder=\Core::createFolder($storagefolder."/Crop", "U");              
								
				$thumbfile=$tempfolder.$data[$key];                
				if($imageproperties['w'])
				{
					$params = array('w' => $imageproperties['w'],
											'h' => $imageproperties['h'],
											'aspect_ratio' => false,
											'crop' => false
						 ,'x1'=>$imageproperties['x1'],'y1'=>$imageproperties['y1'],'x2'=>$imageproperties['x2'],'y2'=>$imageproperties['y2']);
					$this->cropimage($filepath, $thumbfile, $params);                    
				}
				else
				{
					copy($filepath,$thumbfile);
				}
                                $filepath=$thumbfile;  
								$imagesettings=[];
                                $db=new \Core\DataBase\ProcessQuery();
                                $db->setTable("core_cms_image_settings");                                
                                $db->addFieldArray(array("core_cms_image_settings.name"=>"tempname"));
                                $db->addFieldArray(array("core_cms_image_settings.witdthvalue"=>"witdthvalue"));
                                $db->addFieldArray(array("core_cms_image_settings.heightvalue"=>"heightvalue"));
                                $db->addWhere("core_cms_image_settings.id in('".\Core::convertArrayToString(\Core::convertStringToArray($filePath[$key]['imagesizeid']),"','")."')");
                                $db->buildSelect();
                                $filesettings=$db->getRows();
                                if(count($filesettings)>0)
                                {
                                    foreach($filesettings as $fs)
                                    {
										$imagesettings[$fs['tempname']]=$fs;
                                    }
                                }
                                
                                if(count($imagesettings)>0)
                                {
                                        foreach($imagesettings as $tempname=>$tempdata)
                                        {              
                                            if($storagefolder)
                                            {
                                                $tempfolder=$storagefolder."/".$tempname;
                                            }
                                            else 
                                            {
                                                $tempfolder=$tempname;
                                            }
                                            $tempfolder=\Core::createFolder($tempfolder, "U");
                                            $thumbfile=$tempfolder.$filename;                                                    			
                                            $params = array(
                                            'width' => $tempdata['witdthvalue'],
                                            'height' => $tempdata['heightvalue'],
                                            'aspect_ratio' => false,
                                            'crop' => false);
                                            $this->img_resize($filepath, $thumbfile, $params);
                                        }
                                }  		    		    		    
                            }
                            else
                            {
                                if($this->_currentAction=='edit')
                                {
                                    if(\Core::getValueFromArray($requestedData,'check_'.$key)!=1)
                                    {
										$fileName=$existingResult[$key];
                                        $data[$key]=$fileName;
                                    }                                     
                                }
                            }
                    }  
                    else 
                    {
		    	if(!$this->_scriptAdd)
                        {
				if($this->_currentAction=='edit')
				{
					$fileName=$existingResult[$key];
					$data[$key]=$fileName;
				}
			}
                    }

                }  
            }
        }
        $attributes=array();
        $nodeModel=\CoreClass::getModel("core_node_attribute_option");
        $nodeModel->addCustomFilter("core_node_settings_id='".$this->_nodeName."'");        
        $nodeModel->getCollection();
        if($nodeModel->_totalRecordsCount>0)
        {
            foreach ($nodeModel->_collections as $record)
            {                
                        if(\Core::keyInArray($record['core_attribute_option_id'], $requestedData))
                        {
                            $data[$record['core_attribute_option_id']]=$requestedData[$record['core_attribute_option_id']];
                        }
            }
        }
        return $data;
    }
    public function actionRestriction()
    {
        
        if(count($this->_individualActions)>0)
        {
            foreach ($this->_individualActions as $actionData)
            {                 
                $methodName=$actionData['code']."_".$this->_nodeName."_actionRestriction";
                $methodName=\Core::convertStringToMethod($methodName);
                if(\Core::methodExists($this, $methodName))
                {
                    $this->$methodName();
                }
                else
                {
                    $methodName=$actionData['code']."_actionRestriction";
                    $methodName=\Core::convertStringToMethod($methodName);    
                    if(\Core::methodExists($this, $methodName))
                    {
                        $this->$methodName();
                    }
                }
            }
        }        
    }
    protected  function deleteActionRestriction()
    {
        $primaryKeys=array_keys($this->_collections);
        $processkeys=$primaryKeys;        
        $restrictionKeys=array();        
        /*if(count($processkeys)>0)
        {            
            if(count($this->_nodeOTMRelations)>0)
            {
                foreach ($this->_nodeOTMRelations as $node=>$parentKey)
                {          
                    if(count($processkeys)>0)
                    {
                        $np=new \Core\Model\NodeProperties();
                        $np->setNode($node);
                        $currentNodeStructure=$np->currentNodeStructure();
                        $tableName=$currentNodeStructure['tablename'];

                        $db=new \Core\DataBase\ProcessQuery();
                        $db->setTable($tableName);
                        $db->addFieldArray(array("distinct(".$tableName.".".$parentKey.")"=>$parentKey));
                        $db->addWhere($tableName.".".$parentKey." in ('".\Core::convertArrayToString($processkeys, "','")."')");
                        $db->buildSelect();                          
                        $childRecords=$db->getRows($parentKey);  
                        $parentKeysContainsRecords=\Core::getKeysFromArray($childRecords);
                        if(count($parentKeysContainsRecords)>0)
                        {                            
                            $processkeys=\Core::diffArray($processkeys, $parentKeysContainsRecords);
                            $restrictionKeys=\Core::mergeArrays($restrictionKeys,$parentKeysContainsRecords);
                        }
                    }
                    else
                    {
                        break;
                    }
                }
            }
        }*/
        $this->_removeActionRecords['delete']=$restrictionKeys;        
    }
    function recordActionPerform($action,$primaryKeyValue)
    {
        $removeActionRecords=\Core::getValueFromArray($this->_removeActionRecords,$action);
        if(\Core::countArray($removeActionRecords)>0)
        {
            if(\Core::inArray($primaryKeyValue, $removeActionRecords))
            {
                return false;
            }
        }              
        return true;
        
    }
    function mradeleteAction()
    {
		$backUrl=$this->_websiteHostUrl;
        $actionflag=isset($this->_requestedData['actionflag'])?$this->_requestedData['actionflag']:"";
        if($this->_parentNode)
        {
            $backUrl=$this->_websiteAdminUrl.$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector."/MTO/".$this->_nodeName;
        }
        
        $pidname=$this->_nodeName.'_selector';
        $primaryids=\Core::convertStringToArray($this->_requestedData[$pidname],'|');
        foreach ($primaryids as $pid) 
        {
            $node=\CoreClass::getController($this->_nodeName,$this->_currentNodeModule,"delete");     
            $node->setNodeName($this->_nodeName);
            $node->setActionName("delete");
            $node->setParentNode($this->_parentNode);
            $node->setParentValue($this->_parentSelector);
            $node->setParentAction($this->_parentAction);
            $node->setCurrentSelector($pid);
            $node->setMethodType("POST"); 
            $node->setMraActionPerform();
            $node->checkSession();
            $functionName="deleteAction";
            $node->$functionName();
            
        }
        $output=array();
        $output['status']="success";
        $output['redirecturl']=$backUrl;            
        echo json_encode($output);
    }
    public function checkActionPerform()
    {
        if($this->_parentAction=='edit' || $this->_parentAction=="" )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function checkMraActionPerform()
    {
        if(\Core::countArray($this->_mraActions)>0)
        {        
            return true;
        }
        else
        {
            return FALSE;
        }
         
    }
    public function checkMultiEditAction()
    {
        $multiEditFields=  $this->_currentNodeStructure['editlist'];  
        if(\Core::countArray(\Core::convertStringToArray($multiEditFields)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function checkMultiEditActionInProgress()
    {
        if(\Core::keyInArray($this->_nodeName.'_multiedit', $this->_requestedData))
        {
            if($this->_requestedData[$this->_nodeName.'_multiedit']==1)
            {
                return true;
            }
            return false;
        }
        return false;
    }
    public function getMultiEditAttributes() 
    {
        return \Core::convertStringToArray($this->_currentNodeStructure['editlist']);        
    }
    public function multiEditSaveAction() 
    {
        
            $mandatoryAttributes=$this->mandotatoryAttributes('edit');            
            $backUrl=$this->_websiteHostUrl;
            if($this->_parentNode)
            {
                    $backUrl=$this->_websiteAdminUrl.$this->_parentNode."/".$this->_parentAction."/".$this->_parentSelector."/MTO/".$this->_nodeName;
            }
            $nodeName=$this->_nodeName;
            $multiFormData=$this->_requestedData[$nodeName.'_save'];
            $errors=array();
            
            $method=\Core::convertStringToMethod($this->_nodeName."_beforeMRADataValidate"); 
            if(\Core::methodExists($this, $method))
            {
                $errors=$this->$method();
            }            
            if(\Core::countArray($mandatoryAttributes)>0 && \Core::countArray($errors)==0)
            {
                foreach ($multiFormData as $primaryValue=>$primaryData)
                {
                        foreach($primaryData as $FieldName=>$FieldValue)
                        {
                            if(\Core::inArray($FieldName, $mandatoryAttributes))
                            {
                                if($FieldValue=="")
                                {
                                    $errors['error_'.$this->_nodeName.'_'.$primaryValue.'_'.$FieldName]="Please Enter ".$this->getLabel($FieldName);
                                }
                            }
                        }
                }
            }
            if(\Core::countArray($errors)==0)
            {
                $method=\Core::convertStringToMethod($this->_nodeName."_afterMRADataValidate"); 
                if(\Core::methodExists($this, $method))
                {
                    $errors=$this->$method;
                }
            }
            if(\Core::countArray($errors)==0)
            {
                $output=array();
                foreach ($multiFormData as $primaryValue=>$primaryData)
                {
                        $data=array();    
                        $data[$this->_primaryKey]=$primaryValue;
                        foreach($primaryData as $FieldName=>$FieldValue)
                        {                
                            $fieldNameValue=$FieldValue;
                            $data[$FieldName]=$fieldNameValue;                        
                        } 
                        $data=$this->beforeDataUpdate($data);

                        $nodeSave=new \Core\Model\NodeSave();
                        $nodeSave->setNode($this->_nodeName);
                        $nodeSave->setData($this->_primaryKey,$primaryValue);
                        foreach ($data as $key=>$value)
                        {
                            $nodeSave->setData($key,$value);
                        }
                        $nodeSave->save();
                        $method=\Core::convertStringToMethod($this->_nodeName."_afterDataUpdate");                    

                        if(\Core::methodExists($this, $method))
                        {
                            $errorsArray=$this->$method();
                            if(\Core::isArray($errorsArray))
                            {
                                $output['status']="error";
                                $output['errors']=$errorsArray;
                                $output['redirecturl']=$backUrl;                                             
                            }
                        }
                        $output['status']="success";
                        $output['redirecturl']=$backUrl;
                }
                $output=array();
                $output['status']="success";
                $output['redirecturl']=$backUrl;
                echo json_encode($output);
            }
            else 
            {
                $output=array();
                $output['status']="error";
                $output['errors']=$errors;
                echo json_encode($output);
            }
    }
    public function getMRATemplateAction()
    {		
        $this->getAdminLayout();
        $this->renderLayout();
    }    
    public function finalAction()
    {
        
        $method=\Core::convertStringToMethod($this->_nodeName."_beforeFinal");
        if(\Core::methodExists($this, $method))
        {
           $errorsArray=$this->$method();
        }
        if(\Core::countArray($errorsArray)==0)
        {
            $nodeSave=new \Core\Model\NodeSave();
            $nodeSave->setNode($this->_nodeName);
            $nodeSave->setData($this->_primaryKey,$this->_currentSelector);
            $nodeSave->setData("is_final","1");   
            $nodeSave->setForceUpdate();
            $nodeSave->save();
            $method=\Core::convertStringToMethod($this->_nodeName."_afterFinal");
            if(\Core::methodExists($this, $method))
            {
               $errorsArray=$this->$method();
            }
        }                
        $output=array();
        $output['status']="success";
        $output['redirecturl']=$backUrl;
        if($this->_performMraAction)
        {
            return json_encode($output);
        }
        else
        {
            echo json_encode($output);
        }
    }
    public function unfinalAction()
    {
        $method=\Core::convertStringToMethod($this->_nodeName."_beforeunFinal");
        if(\Core::methodExists($this, $method))
        {
           $errorsArray=$this->$method();
        }
        if(\Core::countArray($errorsArray)==0)
        {
            $nodeSave=new \Core\Model\NodeSave();
            $nodeSave->setNode($this->_nodeName);
            $nodeSave->setData($this->_primaryKey,$this->_currentSelector);
            $nodeSave->setData("is_final","0");           
            $nodeSave->save();
            $method=\Core::convertStringToMethod($this->_nodeName."_afterunFinal");
            if(\Core::methodExists($this, $method))
            {
               $errorsArray=$this->$method();
            }
        }                
        $output=array();
        $output['status']="success";
        $output['redirecturl']=$backUrl;
        if($this->_performMraAction)
        {
            return json_encode($output);
        }
        else
        {
            echo json_encode($output);
        }
    }
    public function mrafinalAction()
    {
        $recordStatus=array();
        $pidname=$this->_nodeName.'_selector';
        $primaryids=\Core::convertStringToArray($this->_requestedData[$pidname],'|');
        foreach ($primaryids as $pid) 
        {
            $node=\CoreClass::getController($this->_nodeName,$this->_currentNodeModule,"final"); 
            $node->setNodeName($this->_nodeName);
            $node->setActionName("final");
            $node->setParentNode($parentNode);
            $node->setParentValue($parentValue);
            $node->setParentAction($parentAction);
            $node->setCurrentSelector($pid);
            $node->setMethodType("POST"); 
            $node->setMraActionPerform();
            $node->checkSession();
            $functionName="finalAction";
            $recordStatus[$pid]=$node->$functionName();           
        }
        $output=array();
        $output['status']="success";
        $output['redirecturl']=$this->_websiteHostUrl;            
        echo json_encode($output);
    }
    public function mraunfinalAction()
    {
        $pidname=$this->_nodeName.'_selector';
        
        $primaryids=\Core::convertStringToArray($this->_requestedData[$pidname],'|');
        foreach ($primaryids as $pid) 
        {
            $node=\CoreClass::getController($this->_nodeName,$this->_currentNodeModule,"unfinal"); 
            $node->setNodeName($this->_nodeName);
            $node->setActionName("unfinal");
            $node->setParentNode($parentNode);
            $node->setParentValue($parentValue);
            $node->setParentAction($parentAction);
            $node->setCurrentSelector($pid);
            $node->setMethodType("POST"); 
            $node->setMraActionPerform();
            $node->checkSession();
            $functionName="unfinalAction";
            $node->$functionName();
            
        }
        $output=array();
        $output['status']="success";
        $output['redirecturl']=$this->_websiteHostUrl;            
        echo json_encode($output);
    }
    public function getDetailsAction()
    {        
        $this->getCollection();
        $output=array();
        $output['status']="success";
        $output['recordCount']=\Core::countArray($this->_collections);
        $output['fileData']=$this->_fileStoragePath;
        $output['records']=$this->_collections;
        $output['redirecturl']=$this->_websiteHostUrl;            
        echo json_encode($output);
        exit;       
    }
    public function getRecordAction()
    {  
        $this->addCustomFilter($this->_nodeName.".".$this->_primaryKey."='".$this->_currentSelector."'");
        $this->getCollection();
        $output=array();
        $output['status']="success";
        $output['recordCount']=\Core::countArray($this->_collections);
        $output['fileData']=$this->_fileStoragePath;
        $output['records']=$this->_collections;
        $output['redirecturl']=$this->_websiteHostUrl;            
        echo json_encode($output);
        exit;       
    }
    public function printAction() 
    {
        $this->loadLayout("print.phtml");
    }
    public function exportAction() 
    {
        $this->loadLayout("export.phtml");
    }
    function img_resize($ini_path, $dest_path, $params = array())
    {
	$width = !empty($params['width']) ? $params['width'] : null;
	$height = !empty($params['height']) ? $params['height'] : null;
	$constraint = !empty($params['constraint']) ? $params['constraint'] : false;
	$rgb = !empty($params['rgb']) ?  $params['rgb'] : 0xFFFFFF;
	$quality = !empty($params['quality']) ?  $params['quality'] : 100;
	$aspect_ratio = isset($params['aspect_ratio']) ?  $params['aspect_ratio'] : true;
	$crop = isset($params['crop']) ?  $params['crop'] : true;
     
	if (!file_exists($ini_path)) return false;
     
     
	if (!is_dir($dir=dirname($dest_path))) mkdir($dir);
     
	$img_info = getimagesize($ini_path);
	if ($img_info === false) return false;
     
	$ini_p = $img_info[0]/$img_info[1];
	if ( $constraint ) {
	    $con_p = $constraint['width']/$constraint['height'];
	    $calc_p = $constraint['width']/$img_info[0];
     
	    if ( $ini_p < $con_p ) {
		$height = $constraint['height'];
		$width = $height*$ini_p;
	    } else {
		$width = $constraint['width'];
		$height = $img_info[1]*$calc_p;
	    }
	} else {
	    if ( !$width && $height ) {
		$width = ($height*$img_info[0])/$img_info[1];
	    } else if ( !$height && $width ) {
		$height = ($width*$img_info[1])/$img_info[0];
	    } else if ( !$height && !$width ) {
		$width = $img_info[0];
		$height = $img_info[1];
	    }
	}
     
	preg_match('/\.([^\.]+)$/i',basename($dest_path), $match);
	$ext = $match[1];
	$output_format = ($ext == 'jpg') ? 'jpeg' : $ext;
     
	$format = strtolower(substr($img_info['mime'], strpos($img_info['mime'], '/')+1));
	$icfunc = "imagecreatefrom" . $format;
     
	$iresfunc = "image" . $output_format;
     
	if (!function_exists($icfunc)) return false;
     
	$dst_x = $dst_y = 0;
	$src_x = $src_y = 0;
	$res_p = $width/$height;
	if ( $crop && !$constraint ) {
	    $dst_w  = $width;
	    $dst_h = $height;
	    if ( $ini_p > $res_p ) {
		$src_h = $img_info[1];
		$src_w = $img_info[1]*$res_p;
		$src_x = ($img_info[0] >= $src_w) ? floor(($img_info[0] - $src_w) / 2) : $src_w;
	    } else {
		$src_w = $img_info[0];
		$src_h = $img_info[0]/$res_p;
		$src_y    = ($img_info[1] >= $src_h) ? floor(($img_info[1] - $src_h) / 2) : $src_h;
	    }
	} else {
	    if ( $ini_p > $res_p ) {
		$dst_w = $width;
		$dst_h = $aspect_ratio ? floor($dst_w/$img_info[0]*$img_info[1]) : $height;
		$dst_y = $aspect_ratio ? floor(($height-$dst_h)/2) : 0;
	    } else {
		$dst_h = $height;
		$dst_w = $aspect_ratio ? floor($dst_h/$img_info[1]*$img_info[0]) : $width;
		$dst_x = $aspect_ratio ? floor(($width-$dst_w)/2) : 0;
	    }
	    $src_w = $img_info[0];
	    $src_h = $img_info[1];
	}
     
	$isrc = $icfunc($ini_path);
	$idest = imagecreatetruecolor($width, $height);
	if ( ($format == 'png' || $format == 'gif') && $output_format == $format ) {
	    imagealphablending($idest, false);
	    imagesavealpha($idest,true);
	    imagefill($idest, 0, 0, IMG_COLOR_TRANSPARENT);
	    imagealphablending($isrc, true);
	    $quality = 0;
	} else {
	    imagefill($idest, 0, 0, $rgb);
	}
	imagecopyresampled($idest, $isrc, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	$res = $iresfunc($idest, $dest_path, $quality);
     
	imagedestroy($isrc);
	imagedestroy($idest);
     
	return $res;
    }    
    public function cropimage($filename, $new_filename, $params = array())
    {        
        
        $x1=$params['x1'];
        $y1=$params['y1'];
        $x2=$params['x2'];
        $y2=$params['y2'];
        $w=$params['w'];
        $h=$params['h'];

        // Get dimensions of the original image
        list($current_width, $current_height) = getimagesize($filename);

        //die(print_r($_POST));
        // This will be the final size of the image 
        $crop_width = $w;
        $crop_height = $h;

        // Create our small image
        $new = imagecreatetruecolor($crop_width, $crop_height);
        // Create original image
        $current_image = imagecreatefromjpeg($filename);
        // resamling (actual cropping)
        imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $w, $h);
        // creating our new image
        imagejpeg($new, $new_filename, 95);
    }
}
