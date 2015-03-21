<?php

use Vortex\Database\DB;
use Vortex\Database\Auth;

class Users extends DB {

	public $table = 'users';
	private $dataTable = 'users_data';
	private $fields;
	private $password;
	private $id;

	public function create( $fields, $username = false ) {
		$this->password = Auth::pass( $fields['password'] );
		$this->fields   = $this->san( $fields );


		$sql = "INSERT INTO {$this->table}(`email`, `password`, `is_active`, `created_at`, `updated_at`) VALUES ( '{$this->fields['email']}', '{$this->password}', TRUE, NOW(), NOW())";

		if($username === true) {
			$sql = "INSERT INTO {$this->table}(`username`, `email`, `password`, `is_active`, `created_at`, `updated_at`) VALUES ('{$this->fields['username']}', '{$this->fields['email']}', '{$this->password}', TRUE, NOW(), NOW())";
		}

		if ( $this->link->query( $sql ) ) {
			$userId = $this->link->insert_id;

			$sql = "INSERT INTO {$this->dataTable}(`user_id`) VALUES('$userId')";
			if($this->link->query($sql)) {
				return true;
			}
		}

		return false;
	}

	public function read( $id ) {
		$this->id = $this->san( $id );
		if ( is_numeric( $id ) ) {
			$sql = "DELETE FROM {$this->table} WHERE `id`='$id' LIMIT 1";
			if ( $this->link->query( $sql ) ) {
				return true;
			}
		}

		return false;
	}

	public function update( $id, $fields ) {
		if ( is_numeric( $id ) ) {
			$this->id                 = $this->san( $id );
			$this->fields             = $this->san( $fields );
			$this->fields['password'] = Auth::pass( $fields['password'] );

			$sql = "UPDATE {$this->table} SET `username`='{$this->fields['username']}', `email`='{$this->fields['email']}', `password`='{$this->fields['password']}', `is_active`='{$this->fields['is_active']}', `updated_at`=NOW() WHERE `id`='{$this->id}' LIMIT 1";

			if ( $this->link->query( $sql ) ) {
				return true;
			}
		}

		return false;
	}

	public function delete( $id ) {
		if ( is_numeric( $id ) ) {
			$this->id = $this->san( $id );

			$sql = "DELETE FROM {$this->table} WHERE `id`='{$this->id}' LIMIT 1";
			if ( $this->link->query( $sql ) ) {
				return true;
			}
		}

		return false;
	}

}
