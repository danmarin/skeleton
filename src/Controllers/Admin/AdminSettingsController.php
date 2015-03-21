<?php

class AdminSettingsController extends AdminController {

	public function settings() {
		if(post('submit')) {
			/*
			 * Main validation rules are here
			 */
			$rules = array(
				'username' => 'min_length[3]',
				'email' => 'email',
				'first_name' => 'required',
				'last_name' => 'required',
				'password' => 'required',
			);

			if($this->validation->validate($_POST, $rules)) {

				/*
				 * Some Validation rules after the main validation success
				 */
				if(!$this->manage->checkAdminEmail($_POST['email'], $_SESSION['admins_user_id'])) {
					$this->validation->errors[] = 'Another admin has this email!';
				}

				if(!$this->manage->checkAdminUsername($_POST['username'], $_SESSION['admins_user_id'])) {
					$this->validation->errors[] = 'This username already exists!';
				}

				if(!$this->manage->validateAdminPassword($_POST['password'])) {
					$this->validation->errors[] = 'Not a valid password';
				}

				if(!empty($_POST['new_password'])) {
					if(strlen($_POST['new_password']) < 6) {
						$this->validation->errors[] = 'The size of the password needs to be at least 6 chars';
					}
				}

				/*
				 * If no validation errors then we update admin
				 */
				if(count($this->validation->errors) == 0) {
					/*
					 * Check to see if a new password was inserted
					 */
					if(!empty($_POST['new_password'])) {
						$this->manage->updateAdmin($_POST, true);
					} else {
						$this->manage->updateAdmin($_POST);
					}
					$this->message = 'Updated!';
				}
			}
		}
		// Loading template if authenticated
		$this->isAuth('settings.php');
	}

}