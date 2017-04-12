<?php
    namespace Core;
    define("ADMINNAME", "admin");
    define("ADMINPASS", 'Ramesh');
    class WebsiteSettings
    {
        public $websiteUrl=NULL;
        public $websiteAdminUrl=NULL;
        public $documentRoot=NULL;
        public $identity=NULL;
        public $themeName=NULL;        
        public $documentRootUpload=NULL;       
        public $adminRouteCode=NULL;   
        public $projectdefaultNode=NULL;
	public $projectRootUpload=NULL;
	public $projectRootUploadUrl=NULL;
        function __construct() 
        {
            $Config=\Core::getSiteConfig();             
            $this->websiteUrl=$Config['websitehost'];
            $this->websiteAdminUrl=$Config['websitehost'].$Config['admincode']."/";
            $this->documentRoot=$Config['documentroot'];
            $this->identity=$Config['identity'];
            $this->themeName=$Config['theme'];
            $this->rpp=$Config['rpp'];
            $this->documentRootUpload="uploads/".$this->identity;
            $this->adminRouteCode=$Config['admincode'];
            $this->projectdefaultNode=is_array($Config['projectnode'])?"":$Config['projectnode'];
            $this->projectRootUpload=$this->documentRoot."uploads/".$this->identity."/";
            $this->projectRootUploadUrl=$this->websiteUrl."uploads/".$this->identity."/";
        }
    }
?>
