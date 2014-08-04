<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DEFINE DATA BASE STRUCTURE
| -------------------------------------------------------------------
| This file contains four arrays of user agent data.  It is used by the
| User Agent Class to help identify browser, platform, robot, and
| mobile device data.  The array keys are used to identify the device
| and the array values are used to set the actual name of the item.
|
*/

$config['prefrance'] = array(	'LOCALHOST'	=> 'localhost',
								'DB_USRE'	=> 'root',
								'DB_PASSWORD'	=> '',
								'DB_NAME'	=> 'new_product',
								'PASSWORD'	=> 'member' );

	//  tbl name  DECIDED PAGE
$config['db_table_name_structure'] = array(
					'1'	=> 'user',
					'2'	=> 'admin',
					'3'	=> 'member'
				);
$config['db_table_structure'] = array(
					'1'	=> array(
							'user_id',
							'user_name',
							'user_email',
							'user_phone',
							'user_password',
							'user_published',
							'user_createdon',
							'user_modifiedon'
								),
					'2'	=> 'admin',
					'3'	=> array(
							'member_id',
							'user_id',
							'member_father_name',
							'member_cnic',
							'member_bike_number',
							'member_card_issue',
							'member_card_expire',
							'member_featured'
								),
				);

//         DECIDED CONTROLLAR ROLE
$config['db_table_role'] = array(
							'1' => array(
								'title' => 'user',
								'join_table' => '', 			//  tbl title
								'controller' => 'user' 					//  tbl controller name
								),
							'2' => array(
								'title' => 'admin',
								'join_table' => 'user', 			//  tbl title
								'controller' => 'admin' 					//  tbl controller name
								),
							'3' => array(
								'title' => 'member',
								'join_table' => 'user', 			//  tbl title
								'controller' => 'menber' 					//  tbl controller name
								)
							);




/* End of file main_controller.php */
/* Location: ./application/config/main_controller.php */