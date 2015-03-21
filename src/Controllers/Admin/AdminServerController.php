<?php

class AdminServerController extends AdminController {

	public function create() {
		$this->isAuth('create-server.php');
	}

	public function update($userId, $serverId) {

	}

	public function delete($serverId) {

	}

}