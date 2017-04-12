<?php
namespace Core;
class CurlCall 
{
    public $_url=NULL;
    public $_postData="";
    public $_returnTransfer=false;
    public $_header=array();
    public $_postFieldCount=0;
    public $_customMethod=NULL;
    public $_sslVerifier=false;
    public $_timeout=30;
    public $_response;
    public $_status;
    public $_curlInfo;
    public $_userpwd=null;
    public $_isBasicAuth=false;
    public $_outputType="AR";
    public $_actualResponse=null;   
    public function resetProperties()
    {
        $this->_url=NULL;
        $this->_postData="";
        $this->_returnTransfer=false;
        $this->_header=array();
        $this->_postFieldCount=0;
        $this->_customMethod=NULL;
        $this->_sslVerifier=false;
        $this->_timeout=30;
        $this->_userpwd=null;
        $this->_isBasicAuth=false;
        $this->_outputType="AR";
    }    
    public function setUrl($url)
    {
        $this->resetProperties();
        $this->_url=$url;
    }
    public function setIsBasicAuth()
    {        
        $this->_isBasicAuth=true;
    }
    public function setUserpwd($userpwd)
    {        
        $this->_userpwd=$userpwd;
    }
    public function setPostData($variableName,$value)
    {
        $this->_postData.="&".$variableName."=".$value;
        $this->_postFieldCount=1;
    }
    public function setPostJsonData($jsonpostData)
    {
        $this->_postData.=$jsonpostData;
        $this->_postFieldCount=1;
    }
    public function setSslVerifier($flag)
    {
        $this->_sslVerifier=$flag;
    }
    public function setTimeOut($timeInSeconds)
    {
        $this->_timeout=$timeInSeconds;
    }
    public function setCustomMethod($methodName)
    {
        $this->_customMethod=$methodName;
    }
    public function setheaders($headers)
    {
        $this->_header=array_merge($this->_header,$headers);
    }
    public function setReturnTransfer($flag)
    {
        $this->_returnTransfer=$flag;
    }
    public function setOutputType($outputType)
    {
        $this->_outputType=$outputType;
    }
    public function callCurl()
    {
        $curl=curl_init();
        if($this->_customMethod=='GET')
        {
            $this->_url.=$this->_url.$this->_postData;
            $this->_postData="";
            $this->_postFieldCount=0;
        }
        curl_setopt($curl,CURLOPT_URL,$this->_url); 
        if($this->_isBasicAuth)
        {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }
        curl_setopt($curl,CURLOPT_HEADER,true); 
        if(count($this->_header)>0)
        {
            
            curl_setopt($curl,CURLOPT_HTTPHEADER,$this->_header); 
        }
        curl_setopt($curl,CURLOPT_TIMEOUT,$this->_timeout); 
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,$this->_returnTransfer); 
        if($this->_customMethod)
        {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST,$this->_customMethod);
        }
        else 
        {
            if($this->_postFieldCount>0)
            {
                curl_setopt($curl,CURLOPT_POST,true); 
            }          
            else
            {
            	curl_setopt($curl,CURLOPT_POST,false); 
            }  
        }
        if($this->_userpwd!="")
        {
	    curl_setopt($curl, CURLOPT_USERPWD,$this->_userpwd);
        }
        if($this->_postFieldCount>0)
        {
            curl_setopt($curl,CURLOPT_POSTFIELDS,$this->_postData);
        }
        $this->_actualResponse= curl_exec($curl); 
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($this->_actualResponse, 0, $header_size);
        $this->_response = substr($this->_actualResponse, $header_size);
        if($this->_outputType=='AR')
        {
            $this->_response=json_decode($this->_response,1);	
        }
        else
        {
        	$this->_response=$this->_actualResponse;
        }
       
        $this->_status = curl_getinfo($curl,CURLINFO_HTTP_CODE); 
        $this->_curlInfo=curl_getinfo($curl);
        curl_close($curl); 
		
        
    }
    
    
}
