<?php

use Vortex\Database\DB;

class Newsletter extends DB {

	private $table = 'newsletter';
	private $email;
	private $name;

	public function storeEmail( $name, $email ) {

		$this->name  = $this->san( $name );
		$this->email = $this->san( $email );

		$sql = "INSERT INTO {$this->table}(`name`, `email`, `date`) values('$this->name','$this->email', NOW())";

		if ( $this->link->query( $sql ) ) {
			return true;
		}

		return false;
	}

}