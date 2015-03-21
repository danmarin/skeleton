<?php

class DashboardController extends MainController {

	public function dashboard() {
		$this->authTemplate( 'index.php', 'users' );
	}

	public function logout() {
		$this->auth->logout( 'users', $this->url['user_login_url'] );
	}

}
