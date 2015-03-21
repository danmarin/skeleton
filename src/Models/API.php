<?php

use Vortex\Database\DB;

class API extends DB {

	private $key;
	private $token;

	private function validKey($key) {
		$this->key = $this->san($key);
	}

	private function validToken($token) {

	}

	public function getAppName() {

	}

	public function getKey() {

	}

	public function getToken() {

	}

	public function isValid($key, $token) {
		if($this->validKey($key) && $this->validToken($token)) {
			return true;
		}

		return false;
	}

}