<?php
class User_model extends Model 
{
	public function User_model()
	{
		parent::Model();
		
		require_once('persistence/User.php');
	}
	
	public function getUser()
	{ //real 653611718
		
		//$user_id = (int)$this->facebook_connect->user_id;
		
		//if($user_id === 1056934732 || $user_id === 653611718)
		//{
		   $user_id = 653611718;
		//}
		
		$user = UserPeer::retrieveByPK($user_id);
		
		return $user;
	}
}
?>
