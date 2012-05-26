<?php

require_once('QuickenMSMoneyStatementParser.php');

class Bankstatement_model extends Model
{
   public function Bankstatement_model()
   {
      parent::Model();
   }

	public function parseBankStatement($filePath)
	{
		$parser = new QuickenMSMoneyStatementParser();
		
		return $parser->parse($filePath);
	}
}
?>