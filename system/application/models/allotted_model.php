<?php
class Allotted_model extends Model
{
   public function Allotted_model()
   {
      parent::Model();

      require_once('persistence/AllottedPeer.php');
   }

	public function getAllottedAmounts($user)
	{
		$c = new Criteria();
		$c->add(AllottedPeer::USER_ID, $user->getId(), Criteria::EQUAL);
		
		$allottedAmounts = AllottedPeer::doSelect($c);
				
		return $allottedAmounts;
	}
}
?>