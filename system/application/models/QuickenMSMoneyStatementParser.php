<?php

require_once('persistence/Purchase.php');

/*
 *
 */
class QuickenMSMoneyStatementParser
{
	private $bankTransactions;
	
	// -------------------------------------------------------------------------
	// Contructor
	// -------------------------------------------------------------------------

	function __construct()
	{
		$this->bankTransactions = array();
	}

	// -------------------------------------------------------------------------
	// Public Members
	// -------------------------------------------------------------------------

	function parse($filePath)
	{
		$fileReader = fopen($filePath, 'r');
		
		$this->parseBankTranList($fileReader);
		
		return $this->bankTransactions;
	}

	// -------------------------------------------------------------------------
	// Public Members
	// -------------------------------------------------------------------------

	function parseBankTranList($fileReader)
	{
	    while (!feof($fileReader)) 
	    {
        	$text = fgets($fileReader);

			if (strpos($text,"<STMTTRN>") !== false)
			{
				$this->parseStmtTrn($fileReader);
			}
		}
	}

	// -------------------------------------------------------------------------
	// Private Members
	// -------------------------------------------------------------------------
	
	function parseStmtTrn($fileReader)
	{
		$datePosted = NULL;
		$type = NULL;
		$amount = NULL;
		$storeName = NULL;

		$text = fgets($fileReader);
		while (strpos($text, "</STMTTRN>") === false)
		{
			if (strpos($text, "<TRNTYPE>") !== false)
			{
				$type = trim(str_replace("<TRNTYPE>", "", $text));
			}
			else if (strpos($text, "<DTPOSTED>") !== false)
			{
				$stringDate = trim(str_replace("<DTPOSTED>", "", $text));
				$datePosted = $this->paresDate($stringDate);
			}
			else if (strpos($text, "<TRNAMT>") !== false)
			{
				$stringDec = trim(str_replace("<TRNAMT>", "", $text));
				$amount = (float)$stringDec;
			}
			else if (strpos($text, "<NAME>") !== false)
			{
				$storeName = trim(str_replace("<NAME>", "", $text));
			}
			
			$text = fgets($fileReader);
		}

		if (($datePosted == NULL) ||
		($amount == NULL) ||
		($storeName == NULL) ||
		($type == NULL))
		{
			throw new Exception('not parsed correct missing date = ' . $datePosted 
			. ' amount= ' . $amount . ' storeName= ' . $storeName . 
			' $type = ' . $type);
		}

		if (strpos($type, "CREDIT") !== false)
		{
			$amount = $amount * -1;
		}
		else if (strpos($type, "DEBIT") !== false)
		{
			$amount = $amount * -1;
		}
		else if (strpos($type, "CHECK") !== false)
		{
			$amount = $amount * -1;
		}
		else if (strpos($type, "PAYMENT") !== false)
		{
			$amount = $amount * -1;
		}
		else if (strpos($type, "DIRECTDEBIT") !== false)
		{
			$amount = $amount * -1;
		}
		else if (strpos($type, "DEP") !== false)
		{
			$amount = $amount * -1;
		}
		else if (strpos($type, "ATM") !== false)
		{
			$amount = $amount * -1;
		}
		else if (strpos($type, "POS") !== false)
		{
			$amount = $amount * -1;
		}
		else
		{
			$amount = $amount * -1;
		}
		
		$bankTransaction = new Purchase();
		
		$bankTransaction->setStore($storeName);
		$bankTransaction->setCost($amount);
		$bankTransaction->setDate($datePosted);
		
		array_push($this->bankTransactions, $bankTransaction);
	}

	function paresDate($stringDate)
	{
		$year = substr($stringDate, 0, 4);
		$month = substr($stringDate, 4, 2);
		$day = substr($stringDate, 6, 2);

		return mktime(0, 0, 0, $month, $day, $year);
	}
}

?>
