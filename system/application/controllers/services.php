<?php



/*
 * The web services for the javascript client
 */
class Services extends Controller
{
	// -------------------------------------------------------------------------
	// Contructor
	// -------------------------------------------------------------------------

	/**
	 * The contructor for the web services
	 *
	 * This loads all the models needed for all the services
	 */
	function Services()
	{
		parent::Controller();
		$this->load->model('purchase_model');
		$this->load->model('allotted_model');
		$this->load->model('billtype_model');
		$this->load->model('currentview_model');
		$this->load->model('bankstatement_model');
		$this->load->model('user_model');

		$this->load->helper(array('form', 'url'));
	}

	// -------------------------------------------------------------------------
	// Public Members
	// -------------------------------------------------------------------------

	public function getUserFriendsRideStatus()
	{
		if($this->facebook_connect->isConnected())
		{
			$array = $this->facebook_connect->client->friends_getAppUsers();
			
			foreach($array as $item)
			{
				echo $item;
			}
		}
		else
		{
			echo "error not logged in";
		}
	}
	
	public function deletePurchase()
	{
		if($this->facebook_connect->isConnected())
		{
			$purchaseKey = $this->input->post('purchaseKey');
			$user = $this->user_model->getUser();
			
			$this->purchase_model->deletePurchase($purchaseKey, $user);
			echo "Success";
		}
		else
		{
			echo "Failure";
		}
	}

	public function modifyPurchase()
	{
		if($this->facebook_connect->isConnected())
		{
			$purchaseKey = $this->input->post('purchaseKey');
			$store = $this->input->post('store');
			$cost = (double)$this->input->post('cost');
			$month = (int)$this->input->post('month');
			$dayOfMonth = (int)$this->input->post('dayOfMonth');
			$year = (int)$this->input->post('year');
			$note = $this->input->post('note');
			$billTypeKey = (int)$this->input->post('billTypeKey');

			$user = $this->user_model->getUser();
			
			$this->purchase_model->modifyPurchase($purchaseKey,
			$store, $cost, $billTypeKey, $note,
			$month, $dayOfMonth, $year, $user);

			echo "Success";
		}
		else
		{
			echo "Failure";
		}
	}

	public function processBankStatement()
	{
		if($this->facebook_connect->isConnected())
		{
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'qfx';
			$config['max_size']	= '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$data = $this->upload->data();
				echo $data["file_type"];
				echo $this->upload->display_errors('<p>', '</p>');
			}
			else
			{
				$data = $this->upload->data();

				$bankTransactions =
				$this->bankstatement_model->parseBankStatement($data['full_path']);

				$output = "[";

				foreach($bankTransactions as $bankTransaction)
				{
					$output .= $bankTransaction->toJson() . ",";
				}

				if(strlen($output) > 1)
				{
					$output = substr($output, 0, strlen($output) - 1);
				}

				$output .= "]";

				echo $output;
			}
		}
		else
		{
			echo "Failure";
		}
	}

	public function getBillTypes()
	{
		if($this->facebook_connect->isConnected())
		{
			$user = $this->user_model->getUser();
			
			$billTypes = $this->billtype_model->getBillTypes($user);

			$output = "[";

			foreach($billTypes as $billType)
			{
				$output .= $billType->toJson() . ",";
			}

			if(strlen($output) > 1)
			{
				$output = substr($output, 0, strlen($output) - 1);
			}

			$output .= "]";

			echo $output;

		}
		else
		{
			echo "Failure";
		}
	}

	public function getAllocatedAmounts()
	{
		if($this->facebook_connect->isConnected())
		{
			$user = $this->user_model->getUser();
			$allocatedAmounts = $this->allotted_model->getAllottedAmounts($user);

			$output = "[";

			foreach($allocatedAmounts as $allocatedAmount)
			{
				$output .= $allocatedAmount->toJson() . ",";
			}

			if(strlen($output) > 1)
			{
				$output = substr($output, 0, strlen($output) - 1);
			}

			$output .= "]";

			echo $output;
		}
		else
		{
			echo "Failure";
		}
	}

	public function addPurchase()
	{
		if($this->facebook_connect->isConnected())
		{
			$user = $this->user_model->getUser();
			$store = $this->input->post('store');
			$cost = (double)$this->input->post('cost');
			$month = (int)$this->input->post('month');
			$dayOfMonth = (int)$this->input->post('dayOfMonth');
			$year = (int)$this->input->post('year');
			$note = $this->input->post('note');
			$billTypeKey = (int)$this->input->post('billTypeKey');

			$this->purchase_model->addPurchase($store, $cost, $billTypeKey, $note,
			$month, $dayOfMonth, $year, $user);

			echo "Success";
		}
		else
		{
			echo "Failure";
		}
	}

	public function getStores()
	{
		if($this->facebook_connect->isConnected())
		{
			$user = $this->user_model->getUser();
			
			$output = "";

			foreach($this->purchase_model->getStores($user) as $store)
			{
				$output .= $store . ";";
			}

			echo $output;
		}
		else
		{
			echo "Failure";
		}
	}

	public function getCurrentViewItems()
	{
		if($this->facebook_connect->isConnected())
		{
			$user = $this->user_model->getUser();
			$currentViewItems = $this->currentview_model->getCurrentViewItems($user);

			$output = "[";

			foreach($currentViewItems as $currentViewItem)
			{
				$output .= $currentViewItem->toJson() . ",";
			}

			if(strlen($output) > 1)
			{
				$output = substr($output, 0, strlen($output) - 1);
			}

			$output .= "]";

			echo $output;
		}
		else
		{
			echo "Failure";
		}
	}

	public function getMatchingPuchases()
	{
		if($this->facebook_connect->isConnected())
		{
			$user = $this->user_model->getUser();
			$store = $this->input->post('store');
			$cost = (double)$this->input->post('cost');
			$month = (int)$this->input->post('month');
			$dayOfMonth = (int)$this->input->post('dayOfMonth');
			$year = (int)$this->input->post('year');
			$note = $this->input->post('note');
			$billTypeKey = (int)$this->input->post('billTypeKey');

			$purchases = $this->purchase_model->getMatchingPuchases($store, 
				$cost, $billTypeKey, $note,
				$month, $dayOfMonth, $year, $user);

			$output = "[";

			foreach($purchases as $purchase)
			{
				$output .= $purchase->toJson() . ",";
			}

			if(strlen($output) > 1)
			{
				$output = substr($output, 0, strlen($output) - 1);
			}

			$output .= "]";

			echo $output;
		}
		else
		{
			echo "Failure";
		}
	}

	public function getBillTypePurchases()
	{
		if($this->facebook_connect->isConnected())
		{
			$billTypeKey = (int)$this->input->post('billtypekey');
			$user = $this->user_model->getUser();
			
			$billType = $this->billtype_model->getBillType($billTypeKey);
			
			if($billType>getUser()->getId() == $user->getId())
			{
				$purchases = $billType->getPurchases();
	
				$output = "[";
	
				foreach($purchases as $purchase)
				{
					$output .= $purchase->toJson() . ",";
				}
	
				if(strlen($output) > 1)
				{
					$output = substr($output, 0, strlen($output) - 1);
				}
	
				$output .= "]";
	
				echo $output;
			}
			else
			{
				echo "Wrong user";
			}
		}
		else
		{
			echo "Failure";
		}
	}

	//
	// should use recent an json object.
	public function getPurchases()
	{
		if($this->facebook_connect->isConnected())
		{
			$user = $this->user_model->getUser();
			$startMonth = (int)$this->input->post('startmonth');
			$startdaymonth = (int)$this->input->post('startdaymonth');
			$startyear = (int)$this->input->post('startyear');
			$endmonth = (int)$this->input->post('endmonth');
			$enddaymonth = (int)$this->input->post('enddaymonth');
			$endyear = (int)$this->input->post('endyear');

			$purchases = $this->purchase_model->getPurchases($startMonth, $startdaymonth,
				$startyear, $endmonth, $enddaymonth, $endyear, $user);

			$output = "[";

			foreach($purchases as $purchase)
			{
				$output .= $purchase->toJson() . ",";
			}

			if(strlen($output) > 1)
			{
				$output = substr($output, 0, strlen($output) - 1);
			}

			$output .= "]";

			echo $output;
		}
		else
		{
			echo "Failure";
		}
	}
}

?>