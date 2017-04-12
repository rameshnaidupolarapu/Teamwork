<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreReportsengine
 *
 * @author ramesh
 */
 namespace Core\Modules\CoreReports\Controllers;
use \Core\Controllers\NodeController;
class CoreReportsengine extends NodeController
{
    //put your code here
    public $_reportDetails=array();
    public $_reportResult=array();    
    public $_reportNode;
    public $_reportrpp;
    public $_reportpage;
    public $_showAttributes;
    public $_totalRecordsCount;
    public $_reportDisplayName;
    public function adminAction($param=NULL) 
    {
        $this->getReportDetails();
        $this->loadLayout("reportengine.phtml");
    }
    public function getReportDetails()
    {
        $this->_reportDetails=array();
        $db=new \Core\DataBase\ProcessQuery();
        $db->setTable("core_reportsdetails","rd");
        $db->addFieldArray(array("rrnd.displayvalue"=>"root","mrnd.displayvalue"=>"md","rd.name"=>"name","rd.id"=>"id"));
        $joincondition="rnd.nodename=rd.node_id";
        $db->addJoin("node_id", "core_registernode", "rnd", $joincondition);
        $joincondition="rrnd.nodename=rnd.core_root_module_id";
        $db->addJoin("core_root_module_id", "core_registernode", "rrnd", $joincondition);
        $joincondition="mrnd.nodename=rnd.core_module_display_id";
        $db->addJoin("core_module_display_id", "core_registernode", "mrnd", $joincondition);
        $db->addWhere("rd.is_publish='1'");        
        $db->buildSelect();
        $results=$db->getRows();
        if(\Core::countArray($results)>0)
        {
            foreach ($results as $reportData)
            {
                $this->_reportDetails[$reportData['root']][$reportData['md']][$reportData['id']]=$reportData;
            }
        }        
    }
    function filterAction()
    {
        $this->loadLayout("reportfilter.phtml");
        return true;
    }
    function getReportDetailsAction()
    {        
        $db=new \Core\DataBase\ProcessQuery();
        $db->setTable("core_reportsdetails");
        $db->addWhere("core_reportsdetails.id='".$this->_requestedData['reportname']."'");
        $db->buildSelect();
        $result=$db->getRow();
        $this->_reportDisplayName=$result['name'];
        $nodeName=$result['node_id'];
        $node=new \Core\Model\Node();
        $node->setNodeName($nodeName);
        $node->setActionName("admin");
        $node->setShowAttributes();
        $rpp=$this->_requestedData['rpp'];
        $this->_reportpage=$this->_requestedData['page'];        
        
        if($result['is_custom']=="1")
        {
            $queryfile=\Core::getCachefilePathReports($nodeName,$this->_requestedData['reportname'],"S");
            $query=\Core::getFileContent($queryfile);
            $db=new \Core\DataBase\ProcessQuery();
            $db->setCustomQuery($query);
            $this->_reportResult=$db->getRows();
            
            $Fieldsfile=\Core::getCachefilePathReports($nodeName,$this->_requestedData['reportname'],"F");
            $this->_showAttributes=\Core::convertJsonToArray(\Core::getFileContent($Fieldsfile));
            $this->_totalRecordsCount=\Core::countArray($this->_reportResult);
            $this->_reportrpp=$this->_totalRecordsCount;    
        }
        else 
        {
            $node->setReport();
            $node->getTotalResultCount();
            if($this->_reportpage>0)
            {
                $node->setPage($this->_reportpage);
            }
            $node->setRpp($rpp);
            $node->getCollection();
            $this->_showAttributes=$node->_showAttributes;
            $this->_totalRecordsCount=$node->_totalRecordsCount;
            $this->_reportResult=$node->_collections;
            if($rpp=="")
            {
                $rpp=$node->_totalRecordsCount;
            }
            $this->_reportrpp=$rpp;    
            
        }
 
            
        $this->_reportNode=$node;       
        try
        {
            $this->loadLayout("reportoutput.phtml");
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage());
        }
    }
    public function exportAction() 
    {
        $requestedData=$this->_requestedData;
        $output_type=$requestedData['output_type'];
        
        $db=new \Core\DataBase\ProcessQuery();
        $db->setTable("core_reportsdetails");
        $db->addWhere("core_reportsdetails.id='".$this->_requestedData['reportname']."'");
        $db->buildSelect();
        $result=$db->getRow();
        $this->_reportDisplayName=$result['name'];
        $nodeName=$result['node_id'];
        $node=new \Core\Model\Node();
        $node->setNodeName($nodeName);
        $node->setActionName("admin");
        $node->setShowAttributes();
        $rpp=$this->_requestedData['rpp'];
        $this->_reportpage=$this->_requestedData['page'];        
        
        if($result['is_custom']=="1")
        {
            $queryfile=\Core::getCachefilePathReports($nodeName,$this->_requestedData['reportname'],"S");
            $query=\Core::getFileContent($queryfile);
            $db=new \Core\DataBase\ProcessQuery();
            $db->setCustomQuery($query);
            $this->_reportResult=$db->getRows();
            
            $Fieldsfile=\Core::getCachefilePathReports($nodeName,$this->_requestedData['reportname'],"F");
            $this->_showAttributes=\Core::convertJsonToArray(\Core::getFileContent($Fieldsfile));
            $this->_totalRecordsCount=\Core::countArray($this->_reportResult);
            $this->_reportrpp=$this->_totalRecordsCount;    
        }
        else 
        {
            $node->setReport();
            $node->getTotalResultCount();
            if($this->_reportpage>0)
            {
                $node->setPage($this->_reportpage);
            }
            $node->setRpp($rpp);
            $node->getCollection();
            $this->_showAttributes=$node->_showAttributes;
            $this->_totalRecordsCount=$node->_totalRecordsCount;
            $this->_reportResult=$node->_collections;
            if($rpp=="")
            {
                $rpp=$node->_totalRecordsCount;
            }
            $this->_reportrpp=$rpp;    
            
        }
 
            
        $this->_reportNode=$node;     
        try
        {
            if($result)
                if($output_type=='pdf')
                {
                    $this->loadLayout("reportoutputpdfexport.phtml");
                }
                else
                {
                    $this->loadLayout("reportoutputexport.phtml");
                }
        }
        catch (Exception $ex)
        {
            \Core::Log($ex->getMessage());
        }
    }
}
