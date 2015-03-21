<?php

class AdminBillingController extends AdminController {

	public function billingSettings() {

		$rules = array(
			'paypal_email' => 'email',
			'sales_email' => 'email',
		);

		if(post('submit')) {
			if ($this->validation->validate($_POST, $rules)) {
				if($this->manage->updateBillingSettings($_POST))
					$this->message = 'Updated!';
			}
		}

		$this->data = $this->manage->getBillingSettings();
		$this->isAuth('billing.php');
	}

}