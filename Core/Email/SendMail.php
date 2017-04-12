<?php
namespace Core\Email;
use \Core\Email\Mailer;
class SendMail extends Mailer
{
    protected $_emailSettings=array();
    protected $_toMails=NULL;
    protected $_ccMails=NULL;
    protected $_bccMails=NULL;
    protected $_subject=NULL;
    protected $_message=NULL;
    protected $_attachmentFiles=array();
    function __construct() 
    {
        $emailSettings=CoreClass::getModel("core_email_settings");
        $emailSettings->addCustomFilter("active_status='1'");
        $emailSettings->getCollection();
                
        if(\Core::countArray($emailSettings->_collections)>0)
        {
            foreach ($emailSettings->_collections as $collection)
            {
                $this->_emailSettings=$collection;
		break;
            }
        }        
    }
    public function setToMail($toMail)
    {
        
	if($this->_toMails)
	{
		$this->_toMails.=",";
	}
	$this->_toMails.=$toMail;
    }
    public function setCcMail($ccMail)
    {
        $this->_ccMails=$ccMail;
    }
    public function setBccMail($bccMail)
    {
        $this->_bccMails=$bccMail;
    }
    public function setSubject($subject)
    {
        $this->_subject=$subject;
    }
    public function setMessage($message)
    {
        $this->_message=$message;
    }
    public function setAttachment($filePath,$name)
    {
        $this->_attachmentFiles[]['path']=$filePath;
        $this->_attachmentFiles[]['name']=$name;
    }
    public function sendDefaultMail($tomail=NULL,$subject=NULL,$message=NULL)
    {
        if($tomail)
        {
            if($this->_toMails)
            {
                $this->_toMails.=",";
            }
            $this->_toMails.=$tomail;
        }
        if($subject)
        {
            $this->_subject=$subject;
        }
        if($message)
        {
            $this->_message=$message;
        }
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <'.$this->_emailSettings['fromemail'].'>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";
        mail($this->_toMails,$this->_subject,"Hi",$headers);
        
    }

    //put your code here
    public function sendmail($tomail=NULL,$subject=NULL,$message=NULL)
    {    
        if($tomail)
        {
            if($this->_toMails)
            {
                $this->_toMails.=",";
            }
            $this->_toMails.=$tomail;
        }
        if($subject)
        {
            $this->_subject=$subject;
        }
        if($message)
        {
            $this->_message=$message;
        }
        try
        {
          
            $this->IsSMTP();
            $this->SMTPAuth=true;
            $this->SMTPDebug=0;
            $this->SMTPSecure=$this->_emailSettings['host_securetype'];
            $this->Port=$this->_emailSettings['host_port'];
            $this->Host=$this->_emailSettings['host_name'];
            $this->Username=$this->_emailSettings['host_username'];
            $this->Password=$this->_emailSettings['host_password'];
            $this->SetFrom($this->_emailSettings['fromemail'],$this->_emailSettings['fromname']);
            $list=explode(",", $this->_toMails);
            foreach ($list as $email)
            {
                $this->AddAddress($email);
            }
            if($this->_ccMails)
            {
                $list=explode(",", $this->_ccMails);
                if(count($list)>0)
                {
                    foreach ($list as $email)
                    {
                        $this->AddCC($email);
                    }
                }
            }
            if($this->_bccMails)
            {
                $list=explode(",", $this->_bccMails);
                if(count($list)>0)
                {
                    foreach ($list as $email)
                    {
                        $this->AddBCC($email);
                    }
                }
            }
            if(\Core::countArray($this->_attachmentFiles)>0)
            {
                foreach ($this->_attachmentFiles as $fileData)
                {
                    $this->AddAttachment($fileData['path'],$fileData['name']);
                }
            }
            $this->Subject = $this->_subject;
            $this->Body = $this->_message;
            $this->IsHTML(true); 
            $this->Send();
          return "Message Sent OK</p>\n";
        }
        catch (Core_Email_MailerException $e)
        {
          return $e->errorMessage(); //Pretty error messages from PHPMailer
        }
        catch (Exception $e)
        {
          return $e->getMessage(); //Boring error messages from anything else!
        }
        return true;
    }
}
