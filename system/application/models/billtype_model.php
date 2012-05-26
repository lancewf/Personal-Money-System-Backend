<?php
class Billtype_model extends Model
{
	public function Billtype_model()
	{
		parent::Model();

		require_once('persistence/Billtype.php');
	}
	 
	public function getBillType($billTypeKey)
	{
		$billType = BilltypePeer::retrieveByPK($billTypeKey);
		
		return $billType;
	}

	public function getBillTypes($user)
	{
		$c = new Criteria();
		$c->add(BilltypePeer::USER_ID, $user->getId(), Criteria::EQUAL);
		
		$billTypes = BilltypePeer::doSelect($c);

		return $billTypes;
	}
}
?>