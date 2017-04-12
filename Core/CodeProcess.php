<?php

namespace Core;

class CodeProcess {

    public static function stripslashes_deep($value) {
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);

        return $value;
    }

    public function convertEncryptDecrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'ENCRYPTION_KEY';
        $secret_iv = 'ENCRYPTION_KEY';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public function dirToArray($dir) {
        $result = array();
        if (\Core::fileExists($dir)) {
            $cdir = scandir($dir);
            if (\Core::countArray($cdir) > 0) {
                foreach ($cdir as $key => $value) {
                    if (!in_array($value, array(".", ".."))) {
                        if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                            $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                        } else {
                            $result[] = $value;
                        }
                    }
                }
            }
        }
        return $result;
    }

    function rmdir_recursive($dir) {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file)
                continue;
            if (is_dir("$dir/$file")) {
                $this->rmdir_recursive("$dir/$file");
            } else {
                unlink("$dir/$file");
            }
        }
        rmdir($dir);
    }

    function createZipFile($path, $targetfilepath) {
        $zip_name = "temfolder.zip";
        $zip = new ZipArchive();
        if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
            $error .= "* Sorry ZIP creation failed at this time";
        }
        if (!\Core::isArray($path)) {
            $path = array($path);
        }
        if (\Core::countArray($path) > 0) {
            foreach ($path as $singlefolder) {

                $valid_files = $this->dirToArray($singlefolder);

                foreach ($valid_files as $key => $file) {
                    if (is_array($file)) {
                        foreach ($file as $subfile) {
                            $filepath = $singlefolder . "/" . $key . "/" . $subfile;
                            if (file_exists($filepath)) {
                                $zip->addFile($filepath, $foldername . "/" . $key . "/" . $subfile);
                            }
                        }
                    } else {
                        $filepath = $singlefolder . "/" . $file;
                        if (file_exists($filepath)) {
                            $zip->addFile($filepath, $foldername . "/" . $file);
                        }
                    }
                }
            }
            $zip->close();
            rename($zip_name, $targetfilepath . ".zip");
            return true;
        }
    }

    public function searchDirectory($directoryPath) {
        $directoryList = [];
        $dirs = array();
        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(getcwd()), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $file) {
            if ($file->isDir()) {
                $item = substr($file->getPathname(), strlen(getcwd()));
                if ($this->endsWith($item, $directoryPath)) {
                    $directoryList[] = $item;
                }
            }
        }
        return $directoryList;
    }

    public function searchFiles($filePath) {
        $fileList = [];
        $dirs = array();
        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(getcwd()), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $file) {
            if ($file->isFile()) {
                $item = substr($file->getPathname(), strlen(getcwd()));
                if ($this->endsWith($item, $filePath)) {
                    $fileList[] = $item;
                }
            }
        }
        return $fileList;
    }

    public function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public function dirToDirectoryArray($dir) {
        $result = array();
        if (\Core::fileExists($dir)) {
            $cdir = scandir($dir);
            if (\Core::countArray($cdir) > 0) {
                foreach ($cdir as $key => $value) {
                    if (!in_array($value, array(".", ".."))) {
                        if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                            $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                        } else {
                            //$result[] = $value; 
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function dirToFilesArray($dir,$results=[]) {
        if(file_exists($dir))
        {
            $files = scandir($dir);  
            
            if(\Core::isArray($files) && \Core::countArray($files)>0)
            {        
                foreach ($files as $key => $value) {
                    $path = realpath($dir . DIRECTORY_SEPARATOR . $value); 
                    if (!is_dir($path)) {
                        $results[] = $path;
                    } else if ($value != "." && $value != "..") {                            
                        $results=$this->dirToFilesArray($path, $results);  
                        $results[] = $path;
                    }                        
                }
            }
        }        
        return $results;
    }

}
