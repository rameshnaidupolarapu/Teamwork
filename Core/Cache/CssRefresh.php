<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Cache;

/**
 * Description of CssRefresh
 *
 * @author aryan
 */
class CssRefresh {

    public $cssFilePath;

    //put your code here
    public function moveCssAdminFiles() {
        $this->cssFilePath = \Core::createFolder(\Core::getTempAdminThemePath() . "css");
        \Core::deleteFile($this->cssFilePath . "minify.css");
        global $wp;
        $this->moveCssBaseFiles(1);
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = "view" . DIRECTORY_SEPARATOR . "adminhtml" . DIRECTORY_SEPARATOR . "web" . DIRECTORY_SEPARATOR . "css";
        $directoryList = $cp->searchDirectory($directorySearch);
        if (\Core::countArray($directoryList) > 0) {
            foreach ($directoryList as $directory) {
                $list = \Core::convertStringToArray(str_replace(DIRECTORY_SEPARATOR . $directorySearch, "", $directory), DIRECTORY_SEPARATOR);
                $moduleName = \Core::getValueFromArray($list, 2);
                $directorySearch = $wp->documentRoot . ltrim($directory, DIRECTORY_SEPARATOR);
                $searchFiles = $cp->dirToFilesArray($directorySearch);
                $filecount = \Core::countArray($searchFiles);
                if ($filecount > 0) {
                    for ($i = $filecount - 1; $i >= 0; $i--) {
                        $path = $searchFiles[$i];
                        $adminDirectoryPath = \Core::createFolder(\Core::getTempAdminThemePath() . "css" . DIRECTORY_SEPARATOR . $moduleName);
                        $extentionfilePath = str_ireplace($directorySearch . DIRECTORY_SEPARATOR, "", $path);
                        $temppath = $adminDirectoryPath . $extentionfilePath;
                        if (is_dir($path)) {
                            \Core::createFolder($temppath);
                        } else {
                            $this->createCssFile($temppath, \Core::getFileContent($path));
                        }
                    }
                }
            }
        }
        $this->moveCssAdminThemeFiles();
    }

    public function moveCssFrontendFiles() {
        $this->cssFilePath = \Core::createFolder(\Core::getTempFrontendThemePath() . "css");
        \Core::deleteFile($this->cssFilePath . "minify.css");
        global $wp;
        $this->moveCssBaseFiles();
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = "view" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "web" . DIRECTORY_SEPARATOR . "css";
        $directoryList = $cp->searchDirectory($directorySearch);
        if (\Core::countArray($directoryList) > 0) {
            foreach ($directoryList as $directory) {
                $list = \Core::convertStringToArray(str_replace(DIRECTORY_SEPARATOR . $directorySearch, "", $directory), DIRECTORY_SEPARATOR);
                $moduleName = \Core::getValueFromArray($list, 2);
                $directorySearch = $wp->documentRoot . ltrim($directory, DIRECTORY_SEPARATOR);
                $searchFiles = $cp->dirToFilesArray($directorySearch);
                $filecount = \Core::countArray($searchFiles);
                if ($filecount > 0) {
                    for ($i = $filecount - 1; $i >= 0; $i--) {
                        $path = $searchFiles[$i];
                        $adminDirectoryPath = \Core::createFolder(\Core::getTempFrontendThemePath() . "css" . DIRECTORY_SEPARATOR . $moduleName);
                        $extentionfilePath = str_ireplace($directorySearch . DIRECTORY_SEPARATOR, "", $path);
                        $temppath = $adminDirectoryPath . $extentionfilePath;
                        if (is_dir($path)) {
                            \Core::createFolder($temppath);
                        } else {
                            $this->createCssFile($temppath, \Core::getFileContent($path));
                        }
                    }
                }
            }
        }
        $this->moveCssFrontendThemeFiles();
    }

    public function moveCssAdminThemeFiles() {
        global $wp;

        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = $wp->documentRoot . "pages" . DIRECTORY_SEPARATOR . "adminhtml" . DIRECTORY_SEPARATOR . $wp->themeName . DIRECTORY_SEPARATOR . "css";
        $searchFiles = $cp->dirToFilesArray($directorySearch);
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $adminDirectoryPath = \Core::getTempAdminThemePath() . "css";
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                $temppath = $adminDirectoryPath . $extentionfilePath;
                if (is_dir($path)) {
                    \Core::createFolder($temppath);
                } else {
                    $this->createCssFile($temppath, \Core::getFileContent($path));
                }
            }
        }
    }

    public function moveCssFrontendThemeFiles() {
        global $wp;
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = $wp->documentRoot . "pages" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . $wp->themeName . DIRECTORY_SEPARATOR . "css";
        $searchFiles = $cp->dirToFilesArray($directorySearch);
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $adminDirectoryPath = \Core::getTempFrontendThemePath() . "css";
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                $temppath = $adminDirectoryPath . $extentionfilePath;
                if (is_dir($path)) {
                    \Core::createFolder($temppath);
                } else {
                    $this->createCssFile($temppath, \Core::getFileContent($path));
                }
            }
        }
    }

    public function moveCssBaseFiles($flag = NULL) {
        global $wp;
        $cc = new \CoreClass();
        $cp = $cc->getObject("\Core\CodeProcess");
        $directorySearch = $wp->documentRoot . "css" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "base";
        $searchFiles = $cp->dirToFilesArray($directorySearch);
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                if ($flag) {
                    $temppath = \Core::getTempAdminThemePath() . "css" . $extentionfilePath;
                } else {
                    $temppath = \Core::getTempFrontendThemePath() . "css" . $extentionfilePath;
                }
                if (is_dir($path)) {
                    \Core::createFolder($temppath);
                } else {
                    $this->createCssFile($temppath, \Core::getFileContent($path));
                }
            }
        }
        $source = "frontend";
        if ($flag) {
            $source = "adminhtml";
        }
        $directorySearch = $wp->documentRoot . "css" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . $source;
        $searchFiles = $cp->dirToFilesArray($directorySearch);
        $filecount = \Core::countArray($searchFiles);
        if ($filecount > 0) {
            for ($i = $filecount - 1; $i >= 0; $i--) {
                $path = $searchFiles[$i];
                $extentionfilePath = str_ireplace($directorySearch, "", $path);
                if ($flag) {
                    $temppath = \Core::getTempAdminThemePath() . "css" . $extentionfilePath;
                } else {
                    $temppath = \Core::getTempFrontendThemePath() . "css" . $extentionfilePath;
                }
                if (is_dir($path)) {
                    \Core::createFolder($temppath);
                } else {
                    $this->createCssFile($temppath, \Core::getFileContent($path));
                }
            }
        }
    }

    function createCssFile($path, $content) {
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        /* remove tabs, spaces, newlines, etc. */
        $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
        \Core::createFile($path, 1, $content);
        \Core::createFile($this->cssFilePath . "minify.css", 0, $content);
    }

}
