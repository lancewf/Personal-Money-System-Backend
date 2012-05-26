<?php


/*
 *
 */
class CurrentViewItem
{
	// -------------------------------------------------------------------------
	// Private Data
	// -------------------------------------------------------------------------
	
	private $billTypeKey;
	
	private $allotted;
	
	private $spent;
	
	private $amountLeft;
	
	private $average;
	
	private $amountLeftOfAverage;
	
	// -------------------------------------------------------------------------
	// Contructor
	// -------------------------------------------------------------------------

	function __construct()
	{

	}

	// -------------------------------------------------------------------------
	// Public Members
	// -------------------------------------------------------------------------

    public function toJson()
    {
        $array_store = array ();
    
        $array_store["billType"] = $this->getBillTypeKey();
        $array_store["allotted"] = $this->getAllotted();
        $array_store["spent"] = $this->getSpent();

        $array_store["amountLeft"] = $this->getAmountLeft();
        $array_store["average"] = $this->getAverage();
        $array_store["amountLeftOfAverage"] = $this->getAmountLeftOfAverage();
    
        return json_encode($array_store);
    }
	
	public function getBillTypeKey()
	{
		return $this->billTypeKey;
	}
	
	public function setBillTypeKey($billTypeKey)
	{
		$this->billTypeKey = $billTypeKey;
	}
	 
	public function getAllotted()
	{
		return $this->allotted;
	}
	
	public function setAllotted($allotted)
	{
		$this->allotted = $allotted;
	}
	 
	public function getSpent()
	{
		return $this->spent;
	}

	public function setSpent($spent)
	{
		$this->spent = $spent;
	}
	
	public function getAmountLeft()
	{
		return $this->amountLeft;
	}

	public function setAmountLeft($amountLeft)
	{
		$this->amountLeft = $amountLeft;
	}
	
	public function getAverage()
	{
		return $this->average;
	}

	public function setAverage($average)
	{
		$this->average = (double)$average;
	}
	
	public function setAmountLeftOfAverage($amountLeftOfAverage)
	{
		$this->amountLeftOfAverage = $amountLeftOfAverage;
	}
	
	public function getAmountLeftOfAverage()
	{
		return $this->amountLeftOfAverage;
	}
}

?>