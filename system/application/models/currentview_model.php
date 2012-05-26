<?php
class Currentview_model extends Model
{
	// -------------------------------------------------------------------------
	// Contructor
	// -------------------------------------------------------------------------

	public function Currentview_model()
	{
		parent::Model();

		require_once('persistence/Purchase.php');

		require_once('billtype_model.php');
		require_once('purchase_model.php');
		require_once('persistence/Billtype.php');
		require_once('CurrentViewItem.php');
	}

	// -------------------------------------------------------------------------
	// Public Members
	// -------------------------------------------------------------------------

	public function getCurrentViewItems($user)
	{
		$currentViewItems = array();

		$billtype_model = new Billtype_model();

		$billTypes = $billtype_model->getBillTypes($user);

		foreach($billTypes as $billType)
		{
			$allotted = $billType->getCurrentAllotted();
				
			if(!is_null($allotted) && $allotted->getAmount() > 0.0)
			{
				$spent = $this->calculateTotalPurcahseAmountCurrentMonth($user, $billType);

				$averageAmount = $this->calculateAverageSpentAmount($billType, $allotted);

				$amountLeft = $allotted->getAmount() - $spent;

				$amountLeftOfAverage = $this->getAmountLeftForAverage($billType);

				$currentViewItem = new CurrentViewItem();

				$currentViewItem->setBillTypeKey($billType->getKey());
				$currentViewItem->setSpent($spent);
				$currentViewItem->setAllotted($allotted->getAmount());
				$currentViewItem->setAverage($averageAmount);
				$currentViewItem->setAmountLeft($amountLeft);
				$currentViewItem->setAmountLeftOfAverage($amountLeftOfAverage);

				array_push($currentViewItems, $currentViewItem);
			}
		}

		return $currentViewItems;
	}

	// -------------------------------------------------------------------------
	// Private Members
	// -------------------------------------------------------------------------

	private function calculateTotalPurcahseAmountCurrentMonth($user, $billType)
	{
		$timestamp = time();
		$startMonth = (int)date("n", $timestamp);
		$startYear = (int)date("Y", $timestamp);
		$endMonth = $startMonth + 1;
		$endYear = $startYear;

		if($startMonth > 12)
		{
			$endMonth = 1;
			$endYear = $startYear+1;
		}

		$purchase_model = new Purchase_model();

		$purchases = $purchase_model->getPurchases($startMonth, 1, $startYear,
		$endMonth, 1, $endYear, $user, $billType);

		$total = 0;
		foreach($purchases as $purchase)
		{
			$total += $purchase->getCost();
		}

		return $total;
	}

	private function calculateAverageSpentAmount($billType)
	{
		$allotted = $billType->getCurrentAllotted();

		$startDate = $allotted->getStartMonth() + $allotted->getStartYear() * 12;

		$timestamp = time();
		$currentMonth = (int)date("n", $timestamp);
		$currentYear = (int)date("Y", $timestamp);
		$currentDayOfMonth = (int)date("j",$timestamp);

		$endDate = $currentMonth + $currentYear * 12;

		if($currentDayOfMonth > 14)
		{
			$endDate++;
		}

		$differentsInMonths = $endDate - $startDate;
			
		$purchases = $billType->getCurrentAllottedPurchases();

		$total = (double)0.0;
		foreach($purchases as $purchase)
		{
			$total = $total + (double)$purchase->getCost();
		}

		$average  = ((double)$total) / ((double)$differentsInMonths);

		return (double)$average;
	}

	private function getAmountLeftForAverage($billType)
	{
		$total = 0;
		foreach($billType->getAllotteds() as $allotted)
		{
			$total += $this->getAmountLeftForAverageFromAllotted($billType, $allotted);
		}

		return $total;
	}

	private function getAmountLeftForAverageFromAllotted($billType, $allotted)
	{
		$startDate = $allotted->getStartMonth() + $allotted->getStartYear() * 12;
		
		$timestamp = time();
		$currentMonth = (int)date("n", $timestamp);
		$currentYear = (int)date("Y", $timestamp);
		$currentDayOfMonth = (int)date("j",$timestamp);
		
		$endDate = 0;
		
		if($allotted->getEndMonth() > $currentMonth && 
			$allotted->getEndYear() > $currentYear)
		{
			$endDate = $currentMonth + $currentYear*12;
			
			if($currentDayOfMonth > 14)
			{
				$endDate++;
			}
		}
		else
		{
			$endDate = $allotted->getEndMonth() + $allotted->getEndYear() * 12;
		}
		
		$differentsInMonths = $endDate - $startDate;
		
		$total = 0;
		foreach($billType->getAllottedPurchases($allotted) as $purchase)
		{
			$total += $purchase->getCost();
		}
		
		$correctTotal = $allotted->getAmount() * $differentsInMonths;

		return $correctTotal - $total;
	}
}
?>