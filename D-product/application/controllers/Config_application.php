<?php

/**
 *  Automatically Configuration of database and config files
 */
class Config_application extends Admin_Controller
{

	var $countMigrationVersion = '';
	var $databaseDirectoryFileCount = '';
	var $mysqlDatabaseName =DB_NAME;
	var $mysqlUserName =DB_USER;
	var $mysqlPassword =DB_PASSWORD;
	var $mysqlHostName =LOCALHOST;
	var $db_tables_name ='';
	var $db_back_dir_path =DATABASE_BACKUP_PATH;
	var $con ='';

	function __construct()
	{
		if (ENVIRONMENT == "development" && AUTO_MIGRATION == 'ON') {

		}else{
			echo "Only for development ENVIRONMENT";
			exit();
		}
		parent::__construct();
		$this->load->model('config_application_m');
		$this->load->library('migration');
		$this->init_system();

	}

	public function index($value='')
	{

	}
	private function init_system()
	{
		//	$this->migration->_migration_version =
	$this->countMigrationVersion = count($this->app_controller->HelperGetDirectoryList(MIGRATION_FOLDER_PATH));
	if (file_exists(DATABASE_BACKUP_PATH)) {
		$this->databaseDirectoryFileCount =	count($this->app_controller->HelperGetDirectoryList(DATABASE_BACKUP_PATH));
		}else{
		$Create_folder_path = $this->app_controller->createFolderIsNotExist(DATABASE_BACKUP_PATH);
		$this->databaseDirectoryFileCount =	count($this->app_controller->HelperGetDirectoryList($Create_folder_path));
		}
		$this->mysqlDatabaseName =DB_NAME;
		$this->mysqlUserName =DB_USER;
		$this->mysqlPassword =DB_PASSWORD;
		$this->mysqlHostName =LOCALHOST;
		$list = $this->config_application_m->getBbTableName();
		foreach ($list as $key => $value) {
		 $this->db_tables_name .=	$value->table_name.",";
		}
		$this->db_tables_name = substr( $this->db_tables_name, 0, -1);
	}

	public function update_db($value='')
	{
		if ($value == "") {
			$this->migration->_migration_version = $this->countMigrationVersion;
		}else{
			$this->migration->_migration_version = $value;
		}


			if (! $this->migration->current()) {
						show_error($this->migration->error_string());
					}
					else {
						echo 'Migration worked!';
					}
	}
	public function settings($value='')
	{
		if ($_POST) {
			$app_settings = array('APP_SETTINGS' => base64_encode(serialize ($_POST)));
			$this->app_controller->HelperCreateAutoConfig(AUTO_CONFIG_PATH,$app_settings);
		}else{
			$this->load->view('do_config_form');
		}
	}

	// CLEAN QUERIES
	public function clean($str) {
		if(@isset($str)){
			$str = @trim($str);
			if(get_magic_quotes_gpc()) {
				$str = stripslashes($str);
			}
			return mysqli_real_escape_string($this->con,$str);
		}
		else{
			return 'NULL';
		}
	}

	// DATABASE BACKUP CREATING FUNCTION
	public	function backup_Database($tables = '*',$format="sql")
      {
        // CONNECT TO THE DATABASE
        $this->con = mysqli_connect($this->mysqlHostName,$this->mysqlUserName,$this->mysqlPassword) or die(mysqli_error());
        mysqli_select_db($this->con,$this->mysqlDatabaseName) or die(mysqli_error());
	  // GET ALL TABLES
        if($tables == '*')
        {
          $tables = array();
          $result = mysqli_query($this->con,'SHOW TABLES');
          while($row = mysqli_fetch_row($result))
          {
            $tables[] = $row[0];
          }
        }
        else
        {
          $tables = is_array($tables) ? $tables : explode(',',$tables);
        }
	    $return = 'SET FOREIGN_KEY_CHECKS=0;' . "\r\n";
        $return.= 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";' . "\r\n";
        $return.= 'SET AUTOCOMMIT=0;' . "\r\n";
        $return.= 'START TRANSACTION;' . "\r\n";
	    $data ="";
        foreach($tables as $table)
        {
          $result = mysqli_query($this->con,'SELECT * FROM '.$table) or die(mysqli_error());
          $num_fields = mysqli_num_fields($result) or die(mysqli_error());
	      $data.= 'DROP TABLE IF EXISTS '.$table.';';
          $row2 = mysqli_fetch_row(mysqli_query($this->con,'SHOW CREATE TABLE '.$table));
          $data.= "\n\n".$row2[1].";\n\n";
	      for ($i = 0; $i<$num_fields; $i++)
          {
            while($row = mysqli_fetch_row($result))
            {
              $data.= 'INSERT INTO '.$table.' VALUES(';
              for($x=0; $x<$num_fields; $x++)
              {
                $row[$x] = addslashes($row[$x]);
                //$row[$x] = ereg_replace("\n","\\n",$row[$x]);
      		  $row[$x] = $this->clean($row[$x]);// CLEAN QUERIES
                if (isset($row[$x])) {
      		  	$data.= '"'.$row[$x].'"' ;
      		  } else {
      		  	$data.= '""';
      		  }
	            if ($x<($num_fields-1)) {
      		  	$data.= ',';
      		  }
              }  // end of the for loop 2
              $data.= ");\n";
            } // end of the while loop
          } // end of the for loop 1

          $data.="\n\n\n";
        }  // end of the foreach*/

          $return .= 'SET FOREIGN_KEY_CHECKS=1;' . "\r\n";
      	$return.= 'COMMIT;';

      	if ($format == "sql") {
      		//SAVE THE BACKUP AS SQL FILE
        $handle = fopen($this->db_back_dir_path."0".$this->databaseDirectoryFileCount."_".$this->mysqlDatabaseName.'-Database-Backup-'.date('Y-m-d @ h-i-s').'.sql','w+');
        fwrite($handle,$data);
        fclose($handle);
      	}else{
      			// gz format
      	$gzdata = gzencode($data, 9);
      	$handle = fopen($this->db_back_dir_path."0".$this->databaseDirectoryFileCount."_".$this->mysqlDatabaseName.'-Database-Backup-'.date('Y-m-d @ h-i-s').'.sql.gz','w+');
      	fwrite($handle, $gzdata);
      	fclose($handle);

      	}

         if($data)
         		return true;
         else
      		return false;
       }  // end of the function
}


?>