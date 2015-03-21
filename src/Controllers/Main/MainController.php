<?php

use Vortex\Database\Auth;
use Vortex\Config\Config;
use Vortex\Database\Validation;

class MainController {

	protected $config;
	protected $url;
	protected $auth;
	protected $users;
	protected $validation;
	protected $message;

	protected $newsletter;

	public $title;

	public function __construct() {
		$this->config     = new Config();
		$this->validation = new Validation();
		$this->newsletter = new Newsletter($this->config);
		$this->auth       = new Auth($this->config);
		$this->users      = new Users($this->config);

		$this->url = $this->config->getUrls();

	}

	protected function authTemplate($file, $table, $default = 'user') {

		$this->disabled(); // Check to see if the user is disabled or not

		if ($this->auth->isLoggedIn($table)) {
			require $this->config->get($default . '_template') . '/' . $file;
		} else {
			redirect($this->url[$default . '_login_url']);
		}
	}

	private function disabled() {
		if (isset($_SESSION['users_is_active']) && $_SESSION['users_is_active'] == 0) {
			$this->auth->deleteSessions('users');
			require $this->config->get('errors_template') . '/disabled.php';
			exit;
		}
	}

	protected function baseLogin($table, $default = 'user') {
		if (isset($_POST['submit'])) {
			$rules = array(
				'email'    => 'email',
				'password' => 'min_length[6]'
			);

			if ($this->validation->validate($_POST, $rules)) {
				// we can login here :)
				if (validToken('token')) {
					if ($this->auth->login($table, $_POST['email'], $_POST['password'])) {
						redirect($this->url[$default . '_url']);
					} else {
						$this->message = 'Invalid Login!';
					}
				}
			}
		}

		if ( ! $this->auth->isLoggedIn($table)) {
			$this->title = 'Login to your account.';
			require $this->config->get($default . '_login') . '/login.php';
		} else {
			redirect($this->url[$default . '_url']);
		}
	}

	protected function resetPassword($table = 'users', $default = 'user') {
		if(! $this->auth->isLoggedIn($table)) {
			require $this->config->get($default. '_login') . '/forgot-password.php';
		} else {
			redirect($this->url[$default.'_url']);
		}
	}

	protected function baseSignup($table, $default = 'user') {
		if (isset($_POST['submit'])) {
			$rules = array(
				'email'            => 'email|exists[' . $table . ']',
				'password'         => 'min_length[6]|confirm_password',
				'confirm_password' => 'required',
			);

			if ($this->validation->validate($_POST, $rules)) {
				if (validToken('token')) {
					if ($this->users->create($_POST)) {
						$this->message = 'Account created!';
					} else {
						$this->message = 'Account could not be created';
					}
				} else {
					$this->message = 'Invalid Token!';
				}
			}
		}

		if ( ! $this->auth->isLoggedIn($table)) {
			$this->title = 'Register an account';
			require $this->config->get('site_template') . '/signup.php';
		} else {
			redirect($this->url[$default . '_url']);
		}
	}

}