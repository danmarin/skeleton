<?php

use Vortex\Config\Config;
use Vortex\Database\Validation;
use Vortex\Database\Auth;

class AdminController {

	protected $config;
	protected $url;
	protected $auth;
	protected $users;

	protected $message;
	protected $validation;
	protected $data;
	protected $title;

	protected $manage;

	private $adminTable = 'admins';
	private $adminTemplate = 'admin_template';
	private $adminUrl = 'admin_url';

	private $tokenName = 'token';

	public $adminData;

	/*
	 * We need to instantiate values so we can use them
	 */
	public function __construct() {
		$this->title  = 'Administration Panel';
		$this->config = new Config();

		$this->url = $this->config->getUrls();

		$this->manage     = new Manage($this->config);
		$this->users      = new Users($this->config);
		$this->validation = new Validation($this->config);
		$this->auth       = new Auth($this->config);

		$this->adminData = $this->manage->getAdminData();
	}

	public function isAuth($template) {
		if ($this->auth->isLoggedIn($this->adminTable)) {
			require $this->config->get($this->adminTemplate) . '/' . $template;
		} else {
			redirect($this->url['admin_login_url']);
		}
	}

	public function login() {
		if (post('submit')) {
			$rules = [
				'email'    => 'email',
				'password' => 'min_length[6]'
			];

			if ($this->validation->validate($_POST, $rules)) {
				if (validToken($this->tokenName)) {
					if ($this->auth->login($this->adminTable, post('email'), post('password'))) {
						redirect($this->adminTemplate);
					}
				}
			}
		}
	}

	public function logout() {
		$this->auth->logout('admins', $this->url['admin_login_url']);
	}
}