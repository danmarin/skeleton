<?php

class AdminUsersController extends AdminController {

	public $usersData;

	public function createUserAccount() {
		if(post('submit')) {
			$rules = array(
				'username' => 'min_length[3]|exists['.$this->users->table.']',
				'email' => 'email|exists['.$this->users->table.']',
				'password' => 'min_length[6]'
			);

			if($this->validation->validate($_POST, $rules)) {
				if($this->users->create($_POST, true)) {
					$this->message = 'Account created!';
				} else {
					$this->validation->errors[] = 'Could not create user!';
				}
			}

		}

		$this->isAuth('create-user.php');
	}

	public function showUsers() {
		$disabled = false;
		$enabled = false;

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

		if(post('submit') && post('action')=='disable') {
			if(isset($_POST['id']) && count($_POST['id']) > 0) {
				foreach ($_POST['id'] as $id) {
					$this->manage->disableUser($id);
					$disabled = true;
				}

				if ($disabled) {
					$this->message = "Users disabled!";
				}
			} else {
				$this->message = "You need to select the users you want to disable!";
			}
		}

		if(post('submit') && post('action')=='enable') {
			if(isset($_POST['id']) && count($_POST['id']) > 0) {
				foreach($_POST['id'] as $id) {
					$this->manage->enableUser($id);
					$enabled = true;
				}
				if($enabled)
					$this->message = "Users enabled!";
			} else {
				$this->message = "You need to select the users you want to enable!";
			}
		}

		$this->usersData = $this->manage->getUsers();
		$this->isAuth('users.php');
	}
}
