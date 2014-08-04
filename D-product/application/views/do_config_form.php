<?php
// echo "<pre>";
// print_r($_SERVER);
// exit();
foreach (explode("/", $_SERVER['REQUEST_URI']) as $key => $value) {
			if ($value == SETTINGS) {
				$readonly = 'readonly';
				}else{
					$readonly ="";
				}

			}

if (defined('LOCALHOST')) {
	$LOCALHOST = LOCALHOST;
}else{
	define('LOCALHOST', 'localhost');
	$LOCALHOST = LOCALHOST;
}
if (defined('DB_PASSWORD')) {
	$DB_PASSWORD = DB_PASSWORD;
}else{
	define('DB_PASSWORD', '');
	$DB_PASSWORD = DB_PASSWORD;
}
if (defined('DB_NAME')) {
	$DB_NAME = DB_NAME;
}else{
	define('DB_NAME', 'product');
	$DB_NAME = DB_NAME;
}
if (defined('DB_USER')) {
	$DB_USER = DB_USER;
}else{
	define('DB_USER', 'root');
	$DB_USER = DB_USER;
}
?>
<form method="POST" action="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">
  LOCALHOST: <input type="text" name="LOCALHOST" value="<?php echo $LOCALHOST; ?>" <?php echo $readonly ?> /><br />
  DB_PASSWORD: <input type="text" name="DB_PASSWORD" value="<?php echo $DB_PASSWORD; ?>" <?php echo $readonly ?> /><br />
  DB_NAME: <input type="text" name="DB_NAME"  value="<?php echo $DB_NAME; ?>" <?php echo $readonly ?> /><br />
  DB_USER: <input type="text" name="DB_USER" value="<?php echo $DB_USER; ?>" <?php echo $readonly ?>  /><br />
  DB_USER: <input type="text" name="MY_SETTINGS_GALLERY" value="NULL"  /><br />
  <div align="center">
    <p><input type="submit" value="Create" /></p>
  </div>
</form>