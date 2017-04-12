<?php
class Core {

    static function checkMode() {
        $modeContent = \Core::getFileContent("mode.flag");
        $cc = new \CoreClass();
        if ($modeContent == 'install') {
            $new = $cc->getObject("\Core\Install\Setup");
            $ch = $cc->getObject("\Core\Cache\Refresh");
            $ch->refreshCache();
        }
        return true;
    }

    static function Log($string, $filename = NULL) {
        global $rootObj;
        $wp = $rootObj;
        if (!$filename) {
            $filename = "system.log";
        }
        $folderPath = \Core::createFolder("Errors", "L");
        $filename = $folderPath . str_replace(" ", "_", $filename) . "";
        if (!\Core::fileExists($filename)) {
            $fp = fopen($filename, "w+");
            fwrite($fp, $string);
            fclose($fp);
        } else {

            $fp = fopen($filename, "a");
            fwrite($fp, "\n");
            fwrite($fp, date('Y-m-d H:i:s') . "  :");
            fwrite($fp, $string);
            fclose($fp);
        }
    }

    static function getUploadPath() {
        global $rootObj;
        $wp = $rootObj;
        $folderName = $wp->websiteUrl . "uploads/" . $wp->identity . "/";
        return $folderName;
    }

    static function createFolder($folderName, $type = null) {
        global $rootObj;
        $wp = $rootObj;
        if ($folderName) {
            $folderName = str_replace($wp->documentRoot, "", $folderName);
        }
        $tempPath = "";
        switch ($type) {
            case "C" :
                if ($folderName) {
                    $folderName = "Var".DIRECTORY_SEPARATOR . $wp->identity .DIRECTORY_SEPARATOR. "Cache".DIRECTORY_SEPARATOR . $folderName;
                } else {
                    $folderName = "Var".DIRECTORY_SEPARATOR . $wp->identity . DIRECTORY_SEPARATOR. "Cache";
                }
                break;
            case "E" :
                $folderName = "Var".DIRECTORY_SEPARATOR . $wp->identity . DIRECTORY_SEPARATOR. "Errors";
                break;
            case "L" :
                $folderName = "Var".DIRECTORY_SEPARATOR . $wp->identity . DIRECTORY_SEPARATOR. "Logs";
                break;
            case "U" :
                if ($folderName) {
                    $folderName = "uploads".DIRECTORY_SEPARATOR . $wp->identity . DIRECTORY_SEPARATOR . $folderName;
                } else {
                    $folderName = "uploads".DIRECTORY_SEPARATOR . $wp->identity;
                }
                break;
            case "B" :
                if ($folderName) {
                    $folderName = "backup".DIRECTORY_SEPARATOR . $wp->identity . DIRECTORY_SEPARATOR . $folderName;
                } else {
                    $folderName = "backup".DIRECTORY_SEPARATOR . $wp->identity;
                }
                break;
            case "R" :
                if ($folderName) {
                    $folderName = "Var".DIRECTORY_SEPARATOR . $wp->identity .DIRECTORY_SEPARATOR. "Reports" . DIRECTORY_SEPARATOR . $folderName;
                } else {
                    $folderName = "Var".DIRECTORY_SEPARATOR . $wp->identity . DIRECTORY_SEPARATOR. "Reports";
                }
                break;
            default :
                break;
        }
        $tempFolder = $wp->documentRoot;
        if ($folderName) {            
            $tempPath_list = explode(DIRECTORY_SEPARATOR, $folderName);            
            $i = 0;
            while ($i < count($tempPath_list)) {
                $tempFolder.=$tempPath_list[$i];
                if (!file_exists($tempFolder)) {
                    mkdir($tempFolder, 0755, true);
                }
                $tempFolder.=DIRECTORY_SEPARATOR;
                $i++;
            }
        }
        return $tempFolder;
    }

    static function fileExists($file) {
        if (file_exists($file)) {
            return true;
        } else {
            return false;
        }
    }

    static function checkCache() {
        global $rootObj;
        $cc = new \CoreClass();
        $wp = $rootObj;
        $fileName = "Var".DIRECTORY_SEPARATOR . $wp->identity . DIRECTORY_SEPARATOR. "Cache".DIRECTORY_SEPARATOR;
        if (!\Core::fileExists($fileName)) {
            $ch = $cc->getObject("\Core\Cache\Refresh");
            $ch->refreshCache();
        }
        return true;
    }

    static function convertStringToMethod($string) {
        $method = lcfirst(str_replace(" ", "", ucwords(str_replace("_", " ", $string))));
        return $method;
    }

    static function convertStringToFileName($string) {
        $fileName = str_replace(" ", "", ucwords(str_replace("_", " ", $string)));
        return $fileName;
    }

    static function methodExists($object, $method) {
        //\Core::Log($method,"methods.log");
        if (method_exists($object, $method)) {
            return true;
        } else {
            return false;
        }
    }

    static function keyInArray($key, $stringNeedToCheckArray) {
        if ($key == "") {
            return false;
        }
        if (\Core::isArray($stringNeedToCheckArray)) {
            if (key_exists($key, $stringNeedToCheckArray)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    static function isArray($stringNeedToCheckArray) {
        if (is_array($stringNeedToCheckArray)) {
            return true;
        } else {
            return false;
        }
    }

    static function inArray($key, $stringNeedToCheckArray) {
        if (!\Core::isArray($stringNeedToCheckArray)) {
            return FALSE;
        }
        if (in_array($key, $stringNeedToCheckArray)) {
            return true;
        } else {
            return false;
        }
    }

    static function convertStringToArray($stringNeedExplode, $delimiter = NULL) {
        if (!$delimiter) {
            $delimiter = "|";
        }
        $output = array();
        if ($stringNeedExplode) {
            $output = explode($delimiter, $stringNeedExplode);
        }
        return $output;
    }

    static function convertArrayToString($arrayNeedTobeString, $delimiter = NULL) {
        if (!$delimiter) {
            $delimiter = "|";
        }
        $output = $arrayNeedTobeString;
        if (\Core::isArray($arrayNeedTobeString)) {
            $output = implode($delimiter, $arrayNeedTobeString);
        }
        return $output;
    }

    static function convertStringToLower($string) {
        if ($string) {
            return strtolower($string);
        }
        return $string;
    }

    static function convertStringToUpper($string) {
        if ($string) {
            return strtoupper($string);
        }
        return $string;
    }

    static function convertStringToUrlSlug($string) {
        if ($string) {
            $string = str_replace(' ', '&', $string);
            $string = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $string));
            $string = trim(preg_replace('/-+/', '-', $string), '-');
        }
        return $string;
    }

    static function redirectUrl($url, $message) {
        $string = '
            <script>';
        if ($message) {
            $string.='window.alert("' . $message . '");';
        }
        $string.='   window.location.assign("' . $url . '");            
            </script>';
        echo $string;
        exit;
    }

    static function redirectFrontendUrl($controllerPath) {
        $wp = new Core_WebsiteSettings();
        ob_clean();
        header("location: " . $wp->websiteUrl . $controllerPath);
    }

    static function getDBConfig() {

        try {
            $fp = fopen("sitesettings.xml", "r");
            $fileContent = fread($fp, filesize("sitesettings.xml"));
            fclose($fp);
            $dataBaseSettings = \Core::convertXmlToArray($fileContent);
            return $dataBaseSettings['Database'];
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    static function getSiteConfig() {
        try {
            $fp = fopen("sitesettings.xml", "r");
            $fileContent = fread($fp, filesize("sitesettings.xml"));
            fclose($fp);
            $dataBaseSettings = \Core::convertXmlToArray($fileContent);
            return $dataBaseSettings['Host'];
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage());
        }
    }

    static function convertXmlToArray($xml, $main_heading = '') {
        $deXml = simplexml_load_string($xml);
        $deJson = json_encode($deXml);
        $xml_array = json_decode($deJson, TRUE);

        if (!empty($main_heading)) {
            $returned = $xml_array[$main_heading];
            return $returned;
        } else {
            return $xml_array;
        }
    }

    static function xmlToObject($xml) {

        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $xml, $tags);
        xml_parser_free($parser);

        $elements = array();  // the currently filling [child] XmlElement array
        $stack = array();
        foreach ($tags as $tag) {
            $index = count($elements);
            if ($tag['type'] == "complete" || $tag['type'] == "open") {
                $elements[$index] = new Core_XmlData();
                $elements[$index]->name = $tag['tag'];
                $elements[$index]->attributes = $tag['attributes'];
                $elements[$index]->content = $tag['value'];
                if ($tag['type'] == "open") {  // push
                    $elements[$index]->children = array();
                    $stack[count($stack)] = &$elements;
                    $elements = &$elements[$index]->children;
                }
            }
            if ($tag['type'] == "close") {  // pop
                $elements = &$stack[count($stack) - 1];
                unset($stack[count($stack) - 1]);
            }
        }
        return $elements[0];  // the single top-level element
    }

    static function processXmlData($xmlContent, $filter = NULL) {
        $output = array();
        if ($xmlContent) {
            $xml = simplexml_load_string($xmlContent);
            if ($filter) {
                $xml = $xml->xpath($filter);
            }
            $json = json_encode($xml);
            $output = json_decode($json, TRUE);
        }
        return $output;
    }

    static function convertJsonToArray($string) {
        return json_decode($string, 1);
    }

    static function convertArrayToJson($array) {
        return json_encode($array);
    }

    static function getKeysFromArray($array) {
        $output = array();
        if (\Core::isArray($array)) {
            $output = array_keys($array);
        }
        return $output;
    }

    static function getValueFromArray($array, $key, $value = NULL) {
        $output = null;
        if (\Core::isArray($array)) {
            if (isset($array[$key]) && $array[$key] != "") {
                $output = $array[$key];
            } else {
                if ($value != NULL || $value == 0) {
                    $output = $value;
                }
            }
        }
        return $output;
    }

    static function getValuesFromArray($array) {
        $output = array();
        if (\Core::isArray($array)) {
            $output = array_values($array);
        }
        return $output;
    }

    static function diffArray($firstArray, $secondArray) {
        if (!\Core::isArray($firstArray)) {
            $firstArray = array();
        }
        if (!\Core::isArray($secondArray)) {
            $secondArray = array();
        }
        return array_diff($firstArray, $secondArray);
    }

    static function mergeArrays($firstArray, $secondArray) {
        if (!\Core::isArray($firstArray)) {
            $firstArray = array();
        }
        if (!\Core::isArray($secondArray)) {
            $secondArray = array();
        }
        return array_merge(array_values($firstArray), array_values($secondArray));
    }

    static function countArray($array) {
        return count($array);
    }

    static function getCachefilePath($nodeName, $type, $refresh = null) {
        global $rootObj;
        $filename = \Core::createFolder("Var/" . $rootObj->identity . "/Cache/structure/" . $nodeName);

        switch ($type) {
            case 'R':
                $filename.="noderelations.json";
                break;
            case 'CR':
                $filename.="childnoderelations.json";
                break;
            case 'L':
                $filename.="layout.json";
                break;
            case 'T':
                $filename.="tablestructure.json";
                break;
            case 'S':
                $filename.="nodestructure.json";
                break;
            case 'N':
                $filename.="nodefiles.json";
                break;
            case 'NA':
                $filename.="nodeactions.json";
                break;
            case 'DF':
                $filename.="defaultvalues.json";
                break;
            case 'UFS':
                $filename.="uniquesetvalues.json";
                break;
            case 'FA':
                $filename.="fieldattributes.json";
                break;
            case 'FP':
                $filename.="filepath.json";
                break;
            case 'D':
                $filename.="fielddependee.json";
                break;
            default:
                break;
        }
        if ($refresh) {
            return $filename;
        }
        if (!\Core::fileExists($filename)) {
            return false;
        } else {
            return $filename;
        }
    }

    static function getCachefilePathProfile($profile, $nodeName = null) {
        global $rootObj;
        $wp = $rootObj;
        if ($nodeName) {
            $filename = $wp->documentRoot . "Var/" . $wp->identity . "/Cache/profileaccess/" . $profile . "/" . $nodeName . "/profileacess.json";
        } else {
            $filename = $wp->documentRoot . "Var/" . $wp->identity . "/Cache/profileaccess/" . $profile . "/profileacess.json";
        }

        if (!\Core::fileExists($filename)) {
            return false;
        } else {
            return $filename;
        }
    }

    static function getCachefilePathReports($node, $reportid, $type) {
        $wp = new Core_WebsiteSettings();
        $filename = $wp->documentRoot . "Var/" . $wp->identity . "/Reports/" . $node . "/";
        if ($type == 'S') {
            $filename.=$reportid . "_query.log";
        }
        if ($type == 'F') {
            $filename.=$reportid . "_selectfields.log";
        }
        if (!\Core::fileExists($filename)) {
            return false;
        } else {
            return $filename;
        }
    }

    static function createFile($fileName, $overwrite, $data=null) {        
        try {
            if ($overwrite == 1) {
                $fp = fopen($fileName, "w+") or die($fileName."<br/>");
            } else {
                if(\Core::fileExists($fileName))
                {
                    $fp = fopen($fileName, "a") or die($fileName."<br/>");
                }
                else
                {
                    $fp = fopen($fileName, "w") or die($fileName."<br/>");
                }
            }
            fwrite($fp, $data);
            fclose($fp);
        } catch (\Exception $ex) {
            \Core::Log($ex->getMessage(), "fileexception.log");
        }
    }

    static function getFileContent($fileName) {
        $content = "";
        if (\Core::fileExists($fileName)) {
            $content = file_get_contents($fileName);
        }
        return $content;
    }

    static function getEmailTemplate($templatePath) {
        $wp = new Core_WebsiteSettings();
        $filename = $wp->documentRoot . "templates/email/" . $templatePath;
        return \Core::getFileContent($filename);
    }

    static function JsontoArray($content) {
        $output = array();
        if ($content) {
            $output = json_decode($content, 1);
        }
        return $output;
    }

    static function getStripslashes($valueNeed) {
        try {
            if (\Core::isArray($valueNeed)) {
                $temp = array();
                foreach ($valueNeed as $key => $value) {
                    $temp[stripslashes($key)] = stripslashes($value);
                }
                return $temp;
            } else {
                return $value = stripslashes($valueNeed);
            }
        } catch (Exception $ex) {
            \Core::Log($ex->getMessage(), "exception.log");
        }
        return $value;
    }

    static function sumOfArarrayValues($inputArray, $keyArray) {
        $outputArray = array();
        if (\Core::countArray($inputArray) > 0) {
            $i = 0;
            foreach ($inputArray as $singleline) {
                if ($i == 0) {
                    $singlelinekeys = \Core::getKeysFromArray($singleline);
                    foreach ($singleline as $onekey => $value) {
                        $outputArray = $outputArray + array($onekey => null);
                    }
                    $i++;
                }
                if (\Core::countArray($keyArray) > 0) {
                    foreach ($keyArray as $temkey) {
                        if (\Core::keyInArray($temkey, $singleline)) {
                            $outputArray[$temkey]+=$singleline[$temkey];
                        }
                    }
                }
            }
        }
        return $outputArray;
    }

    static function getDate() {
        return date('Y-m-d');
    }

    static function getDateTime() {
        return date('Y-m-d H:i:s');
    }

    static function is_image($path) {
        $a = getimagesize($path);
        $image_type = $a[2];

        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
            return true;
        }
        return false;
    }

    static function joinXML($files, $targetPath = null) {
        $xmlstr = '<config>';  // You may wish to change this 
        foreach ($files as $file) {
            $xmlstr = \Core::combineXML($file, $xmlstr);
        }

        $xmlstr .= '</config>';
        $xml = simplexml_load_string($xmlstr);
        file_put_contents($targetPath, $xml->asXML());
    }

    static function combineXML($file, $xmlstr) {
        if (file_exists($file)) {
            $xml = simplexml_load_file($file);

            foreach ($xml as $element) {
                $xmlstr .= $element->asXML();
            }
        }
        return $xmlstr;
    }

    static function getRequestSourceUrl() {
        $wp = new Core_WebsiteSettings();
        $string = $wp->websiteUrl . "||" . date('Y-m-d H:i:s');
        $cp = new Core_CodeProcess;
        $string = $cp->convertEncryptDecrypt("encrypt", $string);
        return $string;
    }

    static function getCurrencySymbol() {
        $string = 'Rs';
        return $string;
    }

    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? \Core::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public static function validatePhone($string) {
        $numbersOnly = preg_replace("[^0-9]", "", $string);
        $numberOfDigits = strlen($numbersOnly);
        if ($numberOfDigits == 7 or $numberOfDigits == 10) {
            return $numbersOnly;
        }
    }

    public static function convertDateToTime($string, $time) {
        $date = date('Y-m-d ' . $time, strtotime($string));
        return $date;
    }

    public static function getStringLength($string) {
        $length = strlen($string);
        return $length;
    }

    public static function copyFile($source, $destination) {
        $status = false;
        if (self::fileExists($source)) {
            $explode = explode("/", $destination);
            $fileName = $explode[count($explode) - 1];
            unset($explode[count($explode) - 1]);
            $directory = implode("/", $explode);
            $directoryPath = self::createFolder($directory);
            $destination = $directoryPath . $fileName;
            copy($source, $destination);
        }
        return $status;
    }

    static function getTempAdminThemePath() {
        global $rootObj;
        $wp = $rootObj;
        $folderName = $wp->documentRoot . "Var".DIRECTORY_SEPARATOR . $wp->identity .DIRECTORY_SEPARATOR. "design".DIRECTORY_SEPARATOR."adminhtml".DIRECTORY_SEPARATOR . $wp->themeName.DIRECTORY_SEPARATOR;
        return $folderName;
    }
    
    static function getTempFrontendThemePath(){
        global $rootObj;
        $wp = $rootObj;
        $folderName = $wp->documentRoot . "Var".DIRECTORY_SEPARATOR. $wp->identity .DIRECTORY_SEPARATOR. "design".DIRECTORY_SEPARATOR."frontend".DIRECTORY_SEPARATOR . $wp->themeName.DIRECTORY_SEPARATOR;
        return $folderName;
    }
    static function getTempAdminThemeUrl() {
        global $rootObj;
        $wp = $rootObj;
        $folderName = $wp->websiteUrl . "Var/" . $wp->identity . "/design/adminhtml/" . $wp->themeName."/";
        return $folderName;
    }
    
    static function getTempFrontendThemeUrl(){
        global $rootObj;
        $wp = $rootObj;
        $folderName = $wp->websiteUrl . "Var/" . $wp->identity . "/design/frontend/" . $wp->themeName."/";
        return $folderName;
    }
    static function deleteFile($filepath)
    {
        if(\Core::fileExists($filepath))
        {
            unlink($filepath);
        }
    }

}
