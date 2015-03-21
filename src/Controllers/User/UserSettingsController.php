<?php

class UserSettingsController extends MainController {

	public function settings() {
		$this->authTemplate('settings.php', 'users', 'user');
	}

}
