<?php
class Dataloader extends Controller
{
	// -------------------------------------------------------------------------
	// Constructor
	// -------------------------------------------------------------------------
	
	function Dataloader()
	{
		parent::Controller();
		
		require_once('persistence/Billtype.php');
		require_once('persistence/Purchase.php');
		require_once('persistence/Allotted.php');
		require_once('persistence/User.php');
	}

	// -------------------------------------------------------------------------
	// Public Members
	// -------------------------------------------------------------------------
	
	/**
	 * The default page for the park page
	 */
	public function index()
	{
		$file = "02-13-2010.mny";
		//$file = "data.xml";
	
		$xml = simplexml_load_file($file) or die ("Unable to load XML file!"); 
	
		$user = UserPeer::retrieveByPK(653611718);

//		$user = new User();
//		
//		$user->setId(653611718);
//		
//		$user->save();
		
//		foreach($xml->BillType as $xmlBilltype)
//		{
//			$billtype = new Billtype();
//
//			$billtype->setName($xmlBilltype->Name);
//
//			$billtype->setDescription($xmlBilltype->Description);
//			
//			$billtype->setUser($user);
//			
//			$billtype->save();
//		}
//		
		foreach($xml->Purchase as $xmlPurchase)
		{
			$purchase = new Purchase();
			
			$purchase->setBilltypeKey(((int)$xmlPurchase->Type) + 1);
			
			$purchase->setStore($xmlPurchase->Store);
		
			$purchase->setCost($xmlPurchase->Cost);
			
			$purchase->setDate($xmlPurchase->Date);
			
			$purchase->setNotes($xmlPurchase->Notes);
			
			$purchase->setUser($user);
			
			$purchase->save();
		}
//		
//		foreach($xml->MonthlyAllotted as $monthlyAllotted)
//		{
//			$allotted = new Allotted();
//			
//			$allotted->setBilltypeKey(((int)$monthlyAllotted->BillType) + 1);
//			
//			$allotted->setStartDate($monthlyAllotted->StartDate);
//		
//			$allotted->setEndDate($monthlyAllotted->EndDate);
//			
//			$allotted->setAmount($monthlyAllotted->Amount);
//			
//			$allotted->setUser($user);
//			
//			$allotted->save();
//		}
		
		echo "done!!!!!!!!!!!!!";
	}
	
	// -------------------------------------------------------------------------
	// Private Members
	// -------------------------------------------------------------------------

}
?>
