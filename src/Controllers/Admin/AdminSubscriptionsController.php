<?php

class AdminSubscriptionsController extends AdminController {

	public function subscriptions() {
		$this->isAuth('subscriptions.php');
	}

}