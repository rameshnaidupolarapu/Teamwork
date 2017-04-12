<?php
namespace Core\Model;
class NodeProperties  
{
    public $_nodeName;
    public $_globalNodeStructure;
    public $_profileId=NULL;
    public $_routerName=NULL;
    public function __construct($nodeName=NULL)
    {
        $this->_nodeName=$nodeName;        
    }
    public function nodeSettings()
    {
        $filename=\Core::createFolder(NULL, "C")."/nodestructure.json";
        $data=\Core::getFileContent($filename);
        if($data)
        {
            return \Core::JsontoArray($data);            
        }
        else
        {
            return array();
        }        
    }    
    public function getDefaultLabels()
    {
        $filename=\Core::createFolder(NULL, "C")."/language.json";
        $data=\Core::getFileContent($filename);
        if($data)
        {
            return \Core::JsontoArray($data);            
        }
        else
        {
            return array();
        }        
    }
    public function getCurrentProfilePermission($profile_id="ROOT")
    {
        $filePath=\Core::getCachefilePathProfile($profile_id);        
        if($filePath)
        {
            return \Core::JsontoArray(\Core::getFileContent($filePath));
        }
        else 
        {
            return array();
        }
    }
    public function getCurrentProfilePermissionNodeAction()
    {
        $filePath=\Core::getCachefilePathProfile($this->_profileId,$this->_nodeName);        
        if($filePath)
        {
            $actions=\Core::JsontoArray(\Core::getFileContent($filePath));
            return $actions['action_name_code'];
        }
        else 
        {
            return "";
        }
       
    }
    public function getLableNames()
    {
        $filename=\Core::createFolder(NULL, "C")."english.json";
        $data=\Core::getFileContent($filename);
        if($data)
        {
            return \Core::JsontoArray($data);            
        }
        else
        {
            return array();
        }        
        return true;
    }
    public function setNode($node)
    {        
        $this->_nodeName=$node;        
    }
    public function setRouterName($router)
    {        
        $this->_routerName=$router;        
    }
    public function setProfile($profile)
    {
        $this->_profileId=$profile;
    }
    public function currentNodeStructure()
    {
        
        $filePath=\Core::getCachefilePath($this->_nodeName, "S");
        $nodeStructure=\Core::getFileContent($filePath);
        if($nodeStructure)
        {
            return \Core::JsontoArray($nodeStructure);
            
        }
        else
        {
            return array();
        }        
    }
    public function getNodeDetails()
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "N");
        $nodeStructure=\Core::getFileContent($filePath);
        if($nodeStructure)
        {
            return \Core::JsontoArray($nodeStructure);            
        }
        else
        {
            return array();
        }         
    }    
    public function getActionType($action=NULL)
    {            
        $filename=\Core::createFolder(NULL, "C")."/actiontype.json";
        $data=\Core::getFileContent($filename);
        if($data)
        {
            $data=\Core::JsontoArray($data);
            return $data[$action];            
        }
        else
        {
            return array();
        }        
    }  
    public function getChildRelations() 
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "CR");
        $childRelations=\Core::getFileContent($filePath);
        if($childRelations)
        {
            return \Core::JsontoArray($childRelations);            
        }
        else
        {
            return array();
        } 
    }
    public function getFieldAttributes() 
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "FA");
        $fieldAttributes=\Core::getFileContent($filePath);
        if($fieldAttributes)
        {
            return \Core::JsontoArray($fieldAttributes);            
        }
        else
        {
            return array();
        } 
    }
    public function setRelationDependency() 
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "D");
        $relationDependency=\Core::getFileContent($filePath);
        if($relationDependency)
        {
            return \Core::JsontoArray($relationDependency);            
        }
        else
        {
            return array();
        } 
    }
    public function getDefaultValues() 
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "DF");
        $defaultValues=\Core::getFileContent($filePath);
        if($defaultValues)
        {
            return \Core::JsontoArray($defaultValues);            
        }
        else
        {
            return array();
        } 
    }
    public function getUniqueSetValues() 
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "UFS");
        $uniqueFields=\Core::getFileContent($filePath);
        if($uniqueFields)
        {
            return \Core::JsontoArray($uniqueFields);            
        }
        else
        {
            return array();
        } 
    }
    public function getFieldAttributesValues() 
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "FA");
        $uniqueFields=\Core::getFileContent($filePath);
        if($uniqueFields)
        {
            return \Core::JsontoArray($uniqueFields);            
        }
        else
        {
            return array();
        } 
    }
    public function getFilePath() 
    {
        $filePath=\Core::getCachefilePath($this->_nodeName, "FP");
        $uniqueFields=\Core::getFileContent($filePath);
        if($uniqueFields)
        {
            return \Core::JsontoArray($uniqueFields);            
        }
        else
        {
            return array();
        } 
    }   
    public function getNodeDetailsBasedonRouter()
    {
	$nodeData=array();
        $cc = new \CoreClass();
        $node=$cc->getObject("\Core\Model\Node");
	$node->setNodeName("core_registernode");
	$node->addCustomFilter("nodefile='".$this->_routerName."'");
	$node->addCustomFilter("is_module='0'");	
	$node->getCollection();		
	$registerNodeData=$node->getRecord();
	if(\Core::countArray($registerNodeData)>0)
	{
		$nodeData['nodename']=$registerNodeData['nodename'];
		$nodeData['module']=$registerNodeData['core_module_id'];
		$nodeData['rootmodule']=$registerNodeData['core_root_module_id'];
		$nodeData['moduledisplay']=$registerNodeData['core_module_display_id'];
	}
	return $nodeData;		
    }  
    
}