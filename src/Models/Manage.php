<?php

use Vortex\Database\DB;
use Vortex\Database\Auth;

class Manage extends DB {

    private $table = 'admins';
	private $billingTable = 'billing';
	private $data;
	private $totalUsers;
	private $totalEmails;

	/**
	 * Get administrator data
	 * @return bool|object
	 */
    public function getAdminData() {
        if(isset($_SESSION['admins_user_id']) && is_numeric($_SESSION['admins_user_id'])) {
            return $this->one($this->table, 'id=' . $this->san($_SESSION['admins_user_id']));
        }

        return false;
    }

	/**
	 * Check to see if the password is a valid admin password
	 * @param $password
	 *
	 * @return bool
	 */
	public function validateAdminPassword($password) {
		if(isset($_SESSION['admins_user_id']) && is_numeric($_SESSION['admins_user_id'])) {
			$data = $this->one($this->table, 'id='.$this->san($_SESSION['admins_user_id']));
			if(password_verify($password, $data->password)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get 10 users from the database
	 * @return bool|object
	 */
	public function getUsersData() {
		$sql = "SELECT * FROM `users` ORDER BY `created_at` DESC LIMIT 10";
		return $this->exec($sql);
	}

	public function getUsers() {
		$sql = "SELECT `users`.*, `users_data`.* FROM `users`,`users_data` WHERE `users_data`.`user_id`=`users`.`id` ORDER BY `created_at` DESC";
		if($this->data = $this->query($sql)) {
			$this->totalUsers = $this->total('id', 'users');
			return $this->data;
		}

		return false;
	}

	public function disableUser($id) {
		$id = $this->san($id);
		if(is_numeric($id)) {
			$sql = "UPDATE `users` SET `is_active`=FALSE WHERE `id`=$id";
			if($this->link->query($sql)) {
				return true;
			}
		}

		return false;
	}

	public function enableUser($id) {
		$id = $this->san($id);
		if(is_numeric($id)) {
			$sql = "UPDATE `users` SET `is_active`=TRUE WHERE `id`=$id";
			if($this->link->query($sql)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get total users
	 * @return mixed
	 */
	public function getTotal() {
		return $this->totalUsers;
	}

	/**
	 * Count total users
	 * @return bool|null
	 */
	public function countUsers() {
		return $this->total('id', 'users');
	}

	/**
	 * Get total emails
	 * @return mixed
	 */
	public function getTotalEmails() {
		return $this->totalEmails;
	}

	/**
	 * Get newsletter emails
	 * @return bool|object
	 */
	public function getNewsletterEmails() {
		$sql = "SELECT * FROM `newsletter`";
		if($this->data = $this->query($sql)) {
			$this->totalEmails = $this->total('id', 'newsletter');
			return $this->data;
		}

		return false;
	}

	/**
	 * Delete newsletter by id
	 * @param $id
	 *
	 * @return bool
	 */
	public function deleteNewsletter($id) {
		$id = $this->san($id);
		if(is_numeric($id)) {
			$sql = "DELETE FROM `newsletter` WHERE `id`=$id";
			if($this->link->query($sql)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if the username is taken by other admins
	 * @param $username
	 * @param $id
	 *
	 * @return bool
	 */
	public function checkAdminUsername($username, $id) {
		$username = $this->san($username);
		$id = $this->san($id);

		$sql = "SELECT * FROM $this->table WHERE `username`='$username' AND `id`!=$id LIMIT 1";
		if($result = $this->link->query($sql)) {
			if($result->num_rows>0) {
				return false;
			} else {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if the email was already used by another administrator
	 * @param $email
	 * @param $id
	 *
	 * @return bool
	 */
	public function checkAdminEmail($email, $id) {
		$email = $this->san($email);
		$id = $this->san($id);

		$sql = "SELECT * FROM $this->table WHERE `email`='$email' AND `id`!=$id LIMIT 1";
		if($result = $this->link->query($sql)) {
			if($result->num_rows>0) {
				return false;
			} else {
				return true;
			}
		}

		return false;
	}

	/**
	 * Update administrator data
	 * @param $array
	 * @param bool $newPassword
	 *
	 * @return bool
	 */
	public function updateAdmin($array, $newPassword = false) {

		$password = Auth::pass($array['new_password']);
		$id = $this->san($_SESSION['admins_user_id']);

		$array = $this->san($array);

		$sql = "UPDATE $this->table SET `username`='{$array['username']}', `email`='{$array['email']}', `first_name`='{$array['first_name']}', `last_name`='{$array['last_name']}', `updated_at`=NOW() WHERE `id`='$id'";

		if($newPassword == true) {
			$sql = "UPDATE $this->table SET `username`='{$array['username']}', `email`='{$array['email']}', `password`='$password' ,`first_name`='{$array['first_name']}', `last_name`='{$array['last_name']}', `updated_at`=NOW() WHERE `id`='$id'";
		}
		if($this->link->query($sql)) {
			return true;
		}

		return false;
	}

	/**
	 * Create administrator
	 * @param $array
	 *
	 * @return bool
	 */
	public function createAdmin($array) {
		$password = Auth::pass($array['password']);
		$array = $this->san($array);

		$sql = "INSERT INTO $this->table(`username`,`email`,`password`,`first_name`,`last_name`,`level`,`created_at`,`updated_at`) VALUES('{$array['username']}', '{$array['email']}', '$password', '{$array['first_name']}', '{$array['last_name']}', '{$array['level']}', NOW(), NOW())";

		if($this->link->query($sql)) {
			return true;
		}

		return false;
	}


	/**
	 * Get Billing settings
	 * @return bool|object
	 */
	public function getBillingSettings() {
		return $this->one($this->billingTable);
	}


	public function updateBillingSettings($array) {
		$array = $this->san($array);

		$sql = "REPLACE INTO $this->billingTable(`paypal_email`, `sales_email`) values('{$array['paypal_email']}', '{$array['sales_email']}')";

		if($this->link->query($sql)) {
			return true;
		}

		return false;
	}

}
