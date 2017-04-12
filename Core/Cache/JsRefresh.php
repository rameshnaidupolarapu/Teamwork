<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Cache;

/**
 * Description of JsRefresh
 *
 * @author Venkatesh
 */
class JsRefresh {

    //put your code here
    public function refreshVarAdminJs() {
        $this->moveJsBaseFiles(1);
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $fileSearch = "view".DIRECTORY_SEPARATOR."adminhtml".DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR."require_config.js";
        $filesList = $cp->searchFiles($fileSearch);
        $tempconfile = \Core::getTempAdminThemePath() . "js".DIRECTORY_SEPARATOR."requirejs".DIRECTORY_SEPARATOR."config.js";
        \Core::deleteFile($tempconfile);
        global $wp;
        $content = "(function () {
    
    var config = {
        baseUrl: '" . \Core::getTempAdminThemeUrl() . "js'  
    };
    require.config(config);
})();";
        if (\Core::countArray($filesList) > 0) {
            foreach ($filesList as $file) {
                $file = $wp->documentRoot . ltrim($file,DIRECTORY_SEPARATOR);

                $content.=\Core::getFileContent($file);
            }
            \Core::createFolder(\Core::getTempAdminThemePath() . "js".DIRECTORY_SEPARATOR."requirejs");            
            \Core::createFile($tempconfile, 0, $content);
        }
        $this->moveJsAdminFiles();
        //$this->moveJsAdminThemeFiles();
    }

    public function refreshVarFrontendJs() {
        $this->moveJsBaseFiles();
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $fileSearch = "view".DIRECTORY_SEPARATOR."frontend".DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR."require_config.js";
        $filesList = $cp->searchFiles($fileSearch);
        $tempconfile = \Core::getTempFrontendThemePath() . "js".DIRECTORY_SEPARATOR."requirejs".DIRECTORY_SEPARATOR."config.js";
        \Core::deleteFile($tempconfile);
        global $wp;
        $content = "(function () {
    
    var config = {
        baseUrl: '" . \Core::getTempFrontendThemeUrl() . "js'  
    };
    require.config(config);
})();";
        if (\Core::countArray($filesList) > 0) {
            foreach ($filesList as $file) {
                $file = $wp->documentRoot . ltrim($file, DIRECTORY_SEPARATOR);
                $content.=\Core::getFileContent($file);
            }
            \Core::createFolder(\Core::getTempFrontendThemePath() . "js".DIRECTORY_SEPARATOR."requirejs");            
            $this->createJsFile($tempconfile,$content);
        }
        $this->moveJsFrontendFiles();
        $this->moveJsFrontendThemeFiles();
    }

    public function moveJsAdminFiles() {
        global $wp;
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = "view".DIRECTORY_SEPARATOR."adminhtml".DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR."js";
        $directoryList = $cp->searchDirectory($directorySearch);
        if (\Core::countArray($directoryList) > 0) {
            foreach ($directoryList as $directory) {
                $list = \Core::convertStringToArray(str_replace(DIRECTORY_SEPARATOR . $directorySearch, "", $directory), DIRECTORY_SEPARATOR);
                $moduleName = \Core::getValueFromArray($list, 2);              
             
                $directorySearch = $wp->documentRoot . ltrim($directory,DIRECTORY_SEPARATOR);
              
                $searchFiles = $cp->dirToFilesArray($directorySearch);
                $filecount = \Core::countArray($searchFiles);
                if ($filecount > 0) {
                    for ($i = $filecount - 1; $i >= 0; $i--) {
                        $path = $searchFiles[$i];
                        $adminDirectoryPath="";
                        $adminDirectoryPath = \Core::createFolder(\Core::getTempAdminThemePath() . "js".DIRECTORY_SEPARATOR."" . $moduleName);                                               
                        $extentionfilePath = str_ireplace($directorySearch, "", $path);
                        $temppath = $adminDirectoryPath . $extentionfilePath;
                        if (is_dir($path)) {
                            \Core::createFolder($temppath);
                        } else {
                            $this->createJsFile($temppath,\Core::getFileContent($path));
                        }
                    }
                }
            }
        }
    }

    public function moveJsFrontendFiles() {
        global $wp;
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = "view".DIRECTORY_SEPARATOR."frontend".DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR."js";
        $directoryList = $cp->searchDirectory($directorySearch);
        if (\Core::countArray($directoryList) > 0) {
            foreach ($directoryList as $directory) {
                $list = \Core::convertStringToArray(str_replace(DIRECTORY_SEPARATOR . $directorySearch, "", $directory), DIRECTORY_SEPARATOR);
                $moduleName = \Core::getValueFromArray($list, 2);              
                $directorySearch = $wp->documentRoot . ltrim($directory,DIRECTORY_SEPARATOR);
                $searchFiles = $cp->dirToFilesArray($directorySearch);
                $filecount = \Core::countArray($searchFiles);
                if ($filecount > 0) {
                    for ($i = $filecount - 1; $i >= 0; $i--) {
                        $path = $searchFiles[$i];
                        $adminDirectoryPath="";
                        $adminDirectoryPath = \Core::createFolder(\Core::getTempFrontendThemePath() . "js".DIRECTORY_SEPARATOR."" . $moduleName);                                               
                        $extentionfilePath = str_ireplace($directorySearch, "", $path);
                        $temppath = $adminDirectoryPath . $extentionfilePath;
                        if (is_dir($path)) {
                            \Core::createFolder($temppath);
                        } else {
                            $this->createJsFile($temppath,\Core::getFileContent($path));
                        }
                    }
                }
            }
        }        
    }

    public function moveJsBaseFiles($flag = NULL) {
        global $wp;
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = $wp->documentRoot . "js".DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."base";        
        $searchFiles = $cp->dirToFilesArray($directorySearch);      
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                if ($flag) {
                    $temppath = \Core::getTempAdminThemePath() . "js" . $extentionfilePath;
                } else {
                    $temppath = \Core::getTempFrontendThemePath() . "js" . $extentionfilePath;
                }
                if (is_dir($path)) {                   
                    \Core::createFolder($temppath);
                } else {
                    $this->createJsFile($temppath,\Core::getFileContent($path));
                }
            }
        }
        $source="frontend";
        if($flag)
        {
            $source="adminhtml";
        }
        $directorySearch = $wp->documentRoot . "js".DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR.$source;        
        $searchFiles = $cp->dirToFilesArray($directorySearch); 
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                if ($flag) {
                    $temppath = \Core::getTempAdminThemePath() . "js" . $extentionfilePath;
                } else {
                    $temppath = \Core::getTempFrontendThemePath() . "js" . $extentionfilePath;
                }
                if (is_dir($path)) {                   
                    \Core::createFolder($temppath);
                } else {
                    $this->createJsFile($temppath,\Core::getFileContent($path));
                }
            }
        }
    }
    public function moveJsAdminThemeFiles() {
        
        global $wp;
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = $wp->documentRoot."pages".DIRECTORY_SEPARATOR."adminhtml".DIRECTORY_SEPARATOR."".$wp->themeName."".DIRECTORY_SEPARATOR."js";  
        $searchFiles = $cp->dirToFilesArray($directorySearch);
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $adminDirectoryPath=\Core::getTempAdminThemePath() . "js";
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                $temppath = $adminDirectoryPath . $extentionfilePath;
                if (is_dir($path)) {
                    \Core::createFolder($temppath);
                } else {
                    $this->createJsFile($temppath,\Core::getFileContent($path));
                }                       
            }
        }       
    }
    public function moveJsFrontendThemeFiles() {
        global $wp;
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = $wp->documentRoot."pages".DIRECTORY_SEPARATOR."frontend".DIRECTORY_SEPARATOR."".$wp->themeName."".DIRECTORY_SEPARATOR."js";  
        $searchFiles = $cp->dirToFilesArray($directorySearch);
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $adminDirectoryPath=\Core::getTempFrontendThemePath() . "js";
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                $temppath = $adminDirectoryPath . $extentionfilePath;
                if (is_dir($path)) {
                    \Core::createFolder($temppath);
                } else {     
                    $this->createJsFile($temppath,\Core::getFileContent($path));
                }                       
            }
        }
        
    }
    function createJsFile($path,$content)
    {
        \Core::createFile($path, 1,$content);       
    }

}
