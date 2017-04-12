<?php
date_default_timezone_set('Asia/Kolkata');
header('Access-Control-Allow-Origin: *');
error_reporting(0);
set_time_limit(0);
register_shutdown_function("fatal_handler");
session_save_path('sessiondata');
ini_set('session.gc_probability', 1);
global $sessionData;

session_start();

$cc = new \CoreClass();
$rootObj = $cc->getObject("\Core\WebsiteSettings");
 $wp = $rootObj;
\Core::checkMode();
\Core::checkCache();

function fatal_handler() {
    $errfile = "unknown file";
    $errstr = "shutdown";
    $errno = E_ERROR;
    $errline = 0;

    $error = error_get_last();

    if ($error !== NULL) {
        $errno = $error["type"];
        //if(!in_array($errno, array("2","8")))
        {
            $errfile = $error["file"];
            $errline = $error["line"];
            $errstr = $error["message"];
            try {
                try {
                    
               echo $errorContent = (format_error($errno, $errstr, $errfile, $errline));
               /* $e = new \Exception();
                $trace = explode("\n", $e->getTraceAsString());
                // reverse array to make steps line up chronologically
                $trace = array_reverse($trace);
                array_shift($trace); // remove {main}
                array_pop($trace); // remove call to this method
                $length = count($trace);
                $result = array();
               
                for ($i = 0; $i < $length; $i++){
                        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
                }
                echo "\t" . implode("\n\t", $result);
                     $filename=$_SERVER['DOCUMENT_ROOT']."new_core/Var/Errors/".strtotime(date('Y-m-d H:i:s')).".html";

                      $fp=fopen($filename,"w+") or die($filename);
                      fwrite($fp, $errorContent);
                      fclose($fp); */
                } catch (Exception $ex) {
                    
                }
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
    }
}

function format_error($errno, $errstr, $errfile, $errline) {
    $trace = print_r(debug_backtrace(false), true);
    $content = "
        <table>
        <thead><th>Item</th><th>Description</th></thead>
        <tbody>
        <tr>
          <th>Error</th>
          <td><pre>$errstr</pre></td>
        </tr>
        <tr>
          <th>Errno</th>
          <td><pre>$errno</pre></td>
        </tr>
        <tr>
          <th>File</th>
          <td>$errfile</td>
        </tr>
        <tr>
          <th>Line</th>
          <td>$errline</td>
        </tr>
        <tr>
          <th>Trace</th>
          <td><pre>$trace</pre></td>
        </tr>
        </tbody>
        </table>";

    return $content;
}

function __autoload($class_name) {

    $filename = str_replace("_", "/", $class_name);

    $filename = str_replace("\\", "/", $filename);
    $filename.=".php";
    try {
        if (file_exists($filename)) {
            require_once($filename);
            return 1;
        } else {
            $filename = str_replace('\"', "/", $class_name);
            $filename = "./lib/*/" . $filename . ".php";
            $files = glob($filename);
            if (Core::countArray($files) > 0) {
                foreach ($files as $filename) {  
                    require_once($filename);
                    return 1;
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
