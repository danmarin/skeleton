<?php

class AdminTicketsController extends AdminController {
	public function tickets() {
		$this->isAuth('tickets.php');
	}
}
