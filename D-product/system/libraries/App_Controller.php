<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_App_Controller extends  CI_Controller  {

	private $CI;


  var $db_table_name = '';
  var $db_post_data = '';
  var $db_table_name_join = '';

	var $Previous_action	= ''; // The page we are linking to
	var $Previous_class		= ''; // A custom prefix added to the path.
	var $Previous_fucntion	= ''; // A custom suffix added to the path.

	var $Current_action		= ''; // Total number of items (database results)
	var $Current_class		= ''; // Max number of items you want shown per page
	var $Current_fucntion	= ''; // Number of "digit" links to show before/after the currently viewed page

	var $Page_title			= ''; // The current page being viewed
	var $Page_action		= ''; // Use page number for segment instead of offset

	var $first_auto_decoded_id	= '';
	var $first_auto_encoded_id	= '';

  var $first_auto_decoded_role_id  = '';
  var $first_auto_encoded_role_id  = '';

	var $Page_message = array();
  var $Show_message = 'none';
	var $Page_content = array();


  var $link_url  = '';

  var $extra_list ='';

  // config varibles
  var $prefrance = '';
  var $db_table_role = "gldskflgslkfdg";
  var $db_table_name_structure = "";
  var $db_table_structure      = "";





/**
   * Constructor
   *
   * @access  public
   * @param array initialization parameters
   */
  public function __construct($params = array())
  {
    if (count($params) > 0)
    {
      $this->initialize($params);
      $this->CI =& get_instance();
      //$this->CI->load->model('main_m');
     //$this->check_isvalidated();
     //$this->get_menu();
     //$this->load_page_settings();
     //$this->links();
    }

  }
  // --------------------------------------------------------------------

  /**
   * Initialize Preferences
   *
   * @access  public
   * @param array initialization parameters
   * @return  void
   */
  function initialize($params = array())
  {
    if (count($params) > 0)
    {
      foreach ($params as $key => $val)
      {
        if (isset($this->$key))
        {
          $this->$key = $val;
        }
      }
    }
  }



 //================== Index Fucntion =====================
 private function check_isvalidated()
 {
    //--------------  Check User is Login In Session --------
    $is_logged_in = $this->CI->session->userdata('logged_in');
    if(!isset($is_logged_in) || $is_logged_in != true)
    {
          redirect('login');
      echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';
      die();
    }
  //--------------  Check User is Login In Session --------
 }
//================== Page setting Fucntion =====================
 function get_menu()
 {
   $this->db_table_role = $this->db_table_role;
 }
  //================== Index Fucntion =====================
 //================== Page setting Fucntion =====================
 function view_by_role_id()
 {
   return $this->CI->main_m->viewRoleById($this->first_auto_decoded_id,$this->first_auto_decoded_role_id,$this->db_table_name);
 }
  //================== Index Fucntion =====================
  //================== Page setting Fucntion =====================
 function add_by_role_id()
 {
   return $this->CI->main_m->addByRoleId($this->db_table_name,$this->db_post_data);
 }
  //================== Index Fucntion =====================
   //================== Page setting Fucntion =====================
 function edit_by_role_id()
 {
   return $this->CI->main_m->editByRoleId($this->db_table_name,$this->db_post_data,$this->first_auto_decoded_id);
 }
  //================== Index Fucntion =====================
  //================== Page setting Fucntion =====================
 function view_by_id_join()
 {
  return $this->CI->main_m->viewUserByIdJonin($this->first_auto_decoded_id,$this->db_table_name_join,$this->db_table_name);
 }
  //================== Index Fucntion =====================
   //================== Page setting Fucntion =====================
 function delete_by_id_join()
 {
  echo "ok";
  //$this->CI->main_m->deleteById($this->first_auto_decoded_id,$this->db_table_name);

 // return $this->CI->main_m->deleteById($this->first_auto_decoded_id,$this->db_table_name_join);
 }
  //================== Index Fucntion =====================
    //================== Page setting Fucntion =====================
 function delete_by_id()
 {
  return $this->CI->main_m->deleteById($this->first_auto_decoded_id,$this->db_table_name);

 }
  //================== Index Fucntion =====================

 //================== Page setting Fucntion =====================
 function all_list()
 {
    return $this->CI->main_m->getAllListing($this->db_table_name,$this->first_auto_decoded_role_id);
 }
 //================== Index Fucntion =====================
 private function load_page_settings()
 {

    //--------------  Previous Url / Class / & Method Get From Url --------
        $pre_url =  $this->CI->session->userdata('session_page');
        $this->Previous_action = $pre_url['url_full'];
        $this->Previous_class = $pre_url['class'];
        $this->Previous_fucntion = $pre_url['fucntion'];

    //--------------  Previous Url / Class / & Method Get From Url --------

  //--------------  Current Url / Class / & Method Get From Url --------
   // set page content

    // set page messages
     $this->Page_message['none']    =  '';
     $this->Page_message['delete']   =   '<div class="mws-form-message error">'.$this->Page_title.' record successfully deleted</div>';
     $this->Page_message['add']   =   '<div class="mws-form-message success">'.$this->Page_title.' record successfully added</div>';
     $this->Page_message['edit']    = '<div class="mws-form-message success">'.$this->Page_title.' record successfully edit</div>';

  //--------------  Check User is Login In Session --------
 }
//================== Page setting Fucntion =====================
function links()
{
  //--------------  Current Url / Class / & Method Get From Url --------
     $this->Current_action    =  $this->CI->uri->uri_string();
     $this->Current_class   = $this->CI->router->fetch_class();
     $this->Current_fucntion  = $this->CI->router->fetch_method();
   // Page Action And Page title
   $page_action_arr = explode('_',$this->CI->router->fetch_method());
   $this->Page_title = $page_action_arr['0'];
   if (isset($page_action_arr['1'])) {
     $this->Page_action = $page_action_arr['1'];
   }


   // Get last id form url for decode
   $explode_array_for_param = explode('/',$this->CI->uri->uri_string());
   $param_count = count($explode_array_for_param);
   if ($param_count > 2)
   {
       foreach ($explode_array_for_param as $key => $value)
        {

            if ($key == 2) {
              //echo $value;
              $this->first_auto_decoded_role_id  = $this->decode_base64($value);
              $this->first_auto_encoded_role_id  = $value;

            }elseif ($key ==3) {
              //echo $value;
              $this->first_auto_encoded_id = $value;
              $this->first_auto_decoded_id = $this->decode_base64($value);
            }
        }
    }

    foreach ($this->db_table_role as $key => $value)
    {
      if ($key == $this->first_auto_decoded_role_id) {
         $explode_function_name = explode("_",$this->Current_fucntion);
    $this->link_url['encode_list'] = base_url()."index.php/".$value['controller']."/".$this->Current_fucntion."/".$this->first_auto_encoded_role_id."/".$this->first_auto_encoded_id;
    $this->link_url['encode_edit'] = base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_edit/".$this->first_auto_encoded_role_id."/".$this->first_auto_encoded_id;
    $this->link_url['encode_add']= base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_add/".$this->first_auto_encoded_role_id."/".$this->first_auto_encoded_id;
    $this->link_url['encode_view'] = base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_view/".$this->first_auto_encoded_role_id."/".$this->first_auto_encoded_id;
    $this->link_url['decode_list'] = base_url()."index.php/".$value['controller']."/".$this->Current_fucntion."/".$this->first_auto_decoded_role_id."/".$this->first_auto_decoded_id;
    $this->link_url['decode_edit'] = base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_edit/".$this->first_auto_decoded_role_id."/".$this->first_auto_decoded_id;
    $this->link_url['decode_add']= base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_add/".$this->first_auto_decoded_role_id."/".$this->first_auto_decoded_id;
    $this->link_url['decode_view'] = base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_view/".$this->first_auto_decoded_role_id."/".$this->first_auto_decoded_id;
    $this->link_url['decode_delete'] = base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_delete/".$this->first_auto_decoded_role_id."/".$this->first_auto_decoded_id;
    $this->link_url['custom'] = base_url()."index.php/".$value['controller']."/".$explode_function_name['0']."_";


      //---------------- check "_" in sting ---------------
                        $string = $value['title'];
                        $replace_value = "_";
                        $final_string = str_replace($replace_value, " ", $string);
                    //---------------- check "_" in sting ---------------

    $this->Page_content['title']  =  $final_string." ".str_replace("_"," ",$explode_function_name['1']);
    $this->db_table_name =$value['controller'];
    $this->db_table_name_join =$value['title'];
    $this->Page_content['title_role'] = str_replace("_"," ",$value['title']);
       }

    }

}
	//--------------------------------------------------------------
//--------------PAGE SETTING AND DATA SEND FUNCTOIN-------------
//--------------------------------------------------------------
 function control_page($row="",$check=""){



      if ($row == "view") {
        $row = $this->view_by_role_id();
      }elseif ($row == "list") {
       $row = $this->all_list();
      }elseif ($row == "view_join") {
         $row = $this->view_by_id_join();
      }
      elseif ($row == "add") {
         $row_id = $this->add_by_role_id();
         $this->first_auto_decoded_id = $row_id;
         $row = $this->view_by_role_id();
      }
      elseif ($row == "edit") {
         $row_id = $this->edit_by_role_id();
         $row = $this->view_by_role_id();
      }
      elseif ($row == "edit_join") {
         $row_id = $this->edit_by_role_id();
         $row = $this->view_by_id_join();
      }elseif($row == "delete_join")
      {
     return $row = $this->delete_by_id_join();
      }elseif($row == "delete")
      {
     return $row = $this->delete_by_id();
      }



   $data['main_content'] = $this->Current_fucntion;
   $data['list'] = array(
            'Page_content'			=> $this->Page_content,
            'Page_message' 			=> $this->Page_message,
            'Show_message'      => $this->Show_message,
            'current_decoded_id' 	=> $this->first_auto_decoded_id,
			      'current_encoded_id' 	=> $this->first_auto_encoded_id,
            'Previous_action' 		=> $this->Previous_action,
			      'Previous_class' 		=> $this->Previous_class,
			      'Previous_fucntion' 	=> $this->Previous_fucntion,
			      'Current_action' 		=> $this->Current_action,
			      'Current_class' 		=> $this->Current_class,
			      'Current_fucntion' 		=> $this->Current_fucntion,
            'first_auto_encoded_role_id'=> $this->first_auto_encoded_role_id,
            'first_auto_decoded_role_id'=> $this->first_auto_decoded_role_id,
            'link_url'                  => $this->link_url,
            'user_role'=> $this->db_table_role,
            'extra_list'=> $this->extra_list,
            'row'=> $row
            );


   if ($check == "check") {
  echo "<pre>";
  print_r($data);
  echo "<pre>";

   }elseif ($check == "check_exit") {
  echo "<pre>";
  print_r($data);
  echo "<pre>";
  exit();
   }


//$CI =& get_instance();
$this->CI->load->view('includes/template', $data);
             //  return $data;


    }
//--------------------------------------------------------------
//--------------PAGE SETTING AND DATA SEND FUNCTOIN-------------
//--------------------------------------------------------------
//**************************************************************

//--------------------------------------------------------------
//-----------------Check User is Login In Session---------------
//--------------------------------------------------------------
//**************************************************************
//--------------------------------------------------------------
//--------------------Base Url Encode Fucntion -----------------
//--------------------------------------------------------------
   function decode_base64($id="")
    {
     $base_64 = $id . str_repeat('=', strlen($id) % 4);
     $id_decode = base64_decode($base_64);
     return $id_decode;
    }
//--------------------------------------------------------------
//--------------------Base Url Encode Fucntion -----------------
//--------------------------------------------------------------
//**************************************************************
//--------------------------------------------------------------
//--------------------Base Url Decode Fucntion -----------------
//--------------------------------------------------------------
    function encode_base64($id="")
    {
     //---------------- url encode base64 ---------------
                        $base_64_role = base64_encode($id);
                        $id_encode = rtrim($base_64_role, '=');
      //---------------- url encode base64 ---------------
     return $id_encode;
    }
//--------------------------------------------------------------
//--------------------Base Url Decode Fucntion -----------------
//--------------------------------------------------------------
//--------------------------------------------------------------
//-------------------- From Validation Fucntion ----------------
//--------------------------------------------------------------
    function form_validation($form="")
  {
    $this->load->library('form_validation');

    // field name, error message, validation rules
    $this->form_validation->set_rules('category_title', 'Category Name', 'trim|required');
   // $this->form_validation->set_rules('gallery_detail', 'Gallery Detail', 'trim|required');
   // $this->form_validation->set_rules('cover_image', 'cover_image', 'required');
   // $this->form_validation->set_rules('thumbnail_image', 'thumbnail_image', 'required');

    if($this->form_validation->run() == FALSE)
      {
        if ($form == "edit"){

         return;
        //$data = $this->page_setting($query_result="",$gallery_id,$message="");
                      }
      else{
        $data = $this->page_setting($query_result="",$page="add_category",$message="");

           }
        $this->load->view('includes/template',$data);

      }
    else
    {
       if ($form == "edit"){

      $data['cat_title'] = $_POST['category_title'];
      //$data['is_visible'] = $_POST['publish_category'];

      $data['cat_modified_date'] = date('Y-m-d H:i:s');
      return $data;
                      }
      else{
         $data = $_POST;
         $hh= end($_POST['cat_id']);
         echo $hh;
         exit();



      //$publish_gallery = (isset($_POST['publish_gallery'])) ? $data['gallery_is_visible'] = $_POST['publish_gallery'] : "" ;
      return $data;

           }


      }

    }



//--------------------------------------------------------------
//-------------------- From Validation Fucntion ----------------
//--------------------------------------------------------------
//**************************************************************

    function HelperGetDirectoryList($dir = MIGRATION_FOLDER_PATH)
    {
        $listDir = array();
        if($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if(is_file($dir."/".$sub)) {
                        $listDir[] = $sub;
                    }elseif(is_dir($dir."/".$sub)){
                        $listDir[$sub] = $this->ReadFolderDirectory($dir."/".$sub);
                    }
                }
            }
            closedir($handler);
        }
        return $listDir;
    }

    public function HelperCreateDb($value='')
    {

        $con=mysqli_connect(LOCALHOST,DB_USER,DB_PASSWORD);
        // Check connection
        if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

          // Make my_db the current database
        $db_selected = mysql_select_db(DB_NAME, $con);

        if (!$db_selected) {
          // If we couldn't, then it either doesn't exist, or we can't see it.
          $sql = 'CREATE DATABASE '.DB_NAME;

          // Create database
         // $sql="CREATE DATABASE my_db";
          if (mysqli_query($con,$sql)) {
            return ture;
          } else {
            echo "Error creating database: " . mysqli_error($con);
          }
        }else{
          // re create config

        }

    }


    public function HelperCreateAutoConfig($filename=AUTO_CONFIG_PATH,$prefrance="")
    {

    if (file_exists($filename )) {

        $Content = "<?php\r\n";
      foreach ($prefrance as $key => $value) {
       $Content .= "define('".$key."','".$value."');\r\n";
      }
      $Content .="?>\r\n";
      $fh = fopen($filename, 'w') or die("can't open file");
      fwrite($fh, $Content);
      fclose($fh);
      return 1;
      }
      else{
      $Content = "<?php\r\n";
      foreach ($prefrance as $key => $value) {
       $Content .= "define('".$key."','".$value."');\r\n";
       }
      $Content .="?>\r\n";
      $handle = fopen($filename, 'x+');
      fwrite($handle, $Content);
      fclose($handle);
      return 1;
      }
      return 0;
    }

    function strToHex($string)
    {
        $hex='';
        for ($i=0; $i < strlen($string); $i++)
        {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }
    function hexToStr($hex)
    {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2)
        {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
    public function redirect($value='')
    {
      die("<script>location.href = '$value'</script>");
    }

    public function createFolderIsNotExist($value='')
    {

      if (!file_exists($value)) {

        if (!mkdir($value, 0777, true)) {
            die('Failed to create folders...');
             }
           return $value;
        }else{
          return $value;
        }
      }
}

class Profile {
    const LABEL_FIRST_NAME = "First Name";
    const LABEL_LAST_NAME = "Last Name";
    const LABEL_COMPANY_NAME = "Company";
}

// $refl = new ReflectionClass('Profile');
// print_r($refl->getConstants());



/* End of file Page_setting.php */