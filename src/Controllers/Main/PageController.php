<?php

class PageController extends MainController {

	public function index() {
		require $this->config->get('site_template') . '/index.php';
	}

	public function login() {
		$this->baseLogin('users');
	}

	public function signup() {
		$this->baseSignup('users');
	}

	public function forgotPassword() {
		$this->resetPassword('users');
	}

	public function adminLogin() {
		$this->baseLogin('admins', 'admin');
	}

	public function show404() {
		$this->title = 'Page was not found!';
		set404();
		require $this->config->get('errors_template') . '/404.php';
	}

}