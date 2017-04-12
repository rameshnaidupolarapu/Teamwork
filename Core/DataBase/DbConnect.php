<?php
namespace Core\DataBase;
    class DbConnect 
    { 
        public   $default;          // The MySQL database connection 
        public      $output=array();
        /* Class constructor */ 
        function __construct()
        {       
            $dbConfig=\Core::getDBConfig();
            $this->default = mysqli_connect($dbConfig['default']['Host'], $dbConfig['default']['User'],$dbConfig['default']['PWD'],$dbConfig['default']['Name']) or die("Please Check DB");
            mysqli_select_db($this->default,$dbConfig['default']['Name']);
        }

        function begin()
        { 
       
            $null = mysqli_query("START TRANSACTION", $this->default); 
            return mysqli_query("BEGIN", $this->default); 
        } 

        function commit()
        { 
           return mysqli_query("COMMIT", $this->default); 
        } 

        function rollback()
        { 

           return mysqli_query("ROLLBACK", $this->default); 
        } 

        function executeQuery($query)
        { 
            
            try
            {                
                $this->output['result'] = mysqli_query($this->default,$query) or (mysqli_error($this->default).\Core::Log($query));
                $arrayResults=(array)$this->output['result'];
                $affetedrows="";
                $affetedfields="";
                if(isset($arrayResults['num_rows']))
                {   
                    $affetedrows=$arrayResults['num_rows'];
                }
                if(isset($arrayResults['field_count']))
                {
                    $affetedfields=$arrayResults['field_count'];
                }
                $this->output['affetedrows'] =$affetedrows;                
                $this->output['affetedfields']=$affetedfields;
                return $this->output;         
            }
            catch(Exception $ex)
            {               
                \Core::Log($ex->getMessage().$query);
            }
        }
        function getLastInsertID()
        {
            return mysqli_insert_id($this->default);
        }
    }
?>