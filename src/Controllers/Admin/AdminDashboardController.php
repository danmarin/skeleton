<?php

class AdminDashboardController extends AdminController {

	public $manage;
	public $usersData;
	public $totalUsers;

	public function dashboard() {

		if(get('is') == 'disable' && get('id')) {
			if($this->manage->disableUser(get('id'))) {
				$this->message = 'User disabled!';
			}
		}

		if(get('is') == 'enable' && get('id')) {
			if($this->manage->enableUser(get('id'))) {
				$this->message = 'User enabled!';
			}
		}

		$this->usersData  = $this->manage->getUsersData();
		$this->totalUsers = $this->manage->countUsers();
		$this->isAuth('index.php');
	}

}
