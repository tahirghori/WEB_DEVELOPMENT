<?php
class MY_Controller extends MX_Controller {

	public $data = array();
		function __construct() {
			parent::__construct();
			$this->data['errors'] = array();
			$this->data['site_name'] = config_item('site_name');

			if (ENVIRONMENT == "development" && AUTO_MIGRATION == 'ON') {
				$this->allowToCreatOnlyDevelopment();
			}
		}

		public function allowToCreatOnlyDevelopment($value='')
		{
			$this->load->library('migration');
			$this->migration->_migration_version = count($this->app_controller->HelperGetDirectoryList());
			$list_uri =	explode("/", $_SERVER['REQUEST_URI']);
			foreach ($list_uri as $key => $value) {
				if ($value == UPDATE_DB) {
					$this->updateDb();
				}elseif ($value == CREAE_DB) {
					$this->createDb();
				}elseif ($value == SETTINGS) {
					$this->configSettings();
				}elseif($value == EXPORT){
					$this->databaseExport();
				}
			}
		}


	public function updateDb($value='')
		{
			if (! $this->migration->current()) {
						show_error($this->migration->error_string());
					}
					else {
						echo 'Migration worked!';
					}
		}

	public function createDb ()
	{
			$this->updateDb();
	}
	public function configSettings($value='')
	{
		if ($_POST) {
			$app_settings = array('APP_SETTINGS' => base64_encode(serialize ($_POST)));
			$this->app_controller->HelperCreateAutoConfig(AUTO_CONFIG_PATH,$app_settings);
		}else{
			$this->load->view('do_config_form');
		}

	}
	public function databaseExport()
	{

		if (file_exists(DATABASE_BACKUP_PATH)) {
		$dir_count =	count($this->app_controller->HelperGetDirectoryList(DATABASE_BACKUP_PATH));
		}else{
		$Create_folder_path = $this->app_controller->createFolderIsNotExist(DATABASE_BACKUP_PATH);
		 $dir_count =	count($this->app_controller->HelperGetDirectoryList($Create_folder_path));

		}


				//ENTER THE RELEVANT INFO BELOW

			$mysqlDatabaseName =DB_NAME;
			$mysqlUserName =DB_USER;
			$mysqlPassword =DB_PASSWORD;

			$mysqlExportPath =$dir_count.'_db_version.sql';


//DO NOT EDIT BELOW THIS LINE
$mysqlHostName =LOCALHOST;
//DO NOT EDIT BELOW THIS LINE
//Export the database and output the status to the page
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ~/' .$mysqlExportPath;
exec($command,$output=array(),$worked);
switch($worked){
case 0:
echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' .$mysqlExportPath .'</b>';
break;
case 1:
echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
break;
case 2:
echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
break;
}




	}



	function backup_Database($hostName,$userName,$password,$DbName,$tables = '*')
{

  // CONNECT TO THE DATABASE
  $con = mysql_connect($hostName,$userName,$password) or die(mysql_error());
  mysql_select_db($DbName,$con) or die(mysql_error());


  // GET ALL TABLES
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
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


  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table) or die(mysql_error());
    $num_fields = mysql_num_fields($result) or die(mysql_error());

    $data.= 'DROP TABLE IF EXISTS '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $data.= "\n\n".$row2[1].";\n\n";

    for ($i = 0; $i<$num_fields; $i++)
    {
      while($row = mysql_fetch_row($result))
      {
        $data.= 'INSERT INTO '.$table.' VALUES(';
        for($x=0; $x<$num_fields; $x++)
        {
          $row[$x] = addslashes($row[$x]);
          $row[$x] = clean($row[$x]); // CLEAN QUERIES
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

  //SAVE THE BACKUP AS SQL FILE
  $handle = fopen($DbName.'-Database-Backup-'.date('Y-m-d @ h-i-s').'.sql','w+');
  fwrite($handle,$data);
  fclose($handle);

   if($data)
        return true;
   else
        return false;
 }  // end of the function


//  CLEAN THE QUERIES
function clean($str) {
    if(@isset($str)){
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }
    else{
        return 'NULL';
    }
}







}
