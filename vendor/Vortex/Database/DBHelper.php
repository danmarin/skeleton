<?php

namespace Vortex\Database;

use Vortex\Config\Config;

/**
 * Class DBHelper
 * Sanitize and validate data, this is a helper class for the DB class
 * @package Vortex\Database
 */
class DBHelper {

	private $rows;

	/**
	 * Sanitize array or string
	 *
	 * @param $data
	 *
	 * @return null
	 */
	public function sanitize($data) {
		$this->rows = '';

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$this->rows[ $key ] = $this->link->real_escape_string($value);
			}
		} else {
			$this->rows = $this->link->real_escape_string($data);
		}

		return $this->rows;
	}

	/**
	 * Alias to $this->sanitize
	 *
	 * @param $data
	 *
	 * @return null
	 */
	public function san($data) {
		return $this->sanitize($data);
	}


	/**
	 * Validate if order is asc or desc
	 *
	 * @param $order
	 *
	 * @return bool
	 */
	public function validOrderBy($order) {
		if (strtoupper($order) == 'ASC' || strtoupper($order) == 'DESC') {
			return $order;
		}

		return false;
	}

	/**
	 * Validate if start and limit is numeric and if order is asc or desc
	 *
	 * @param $start
	 * @param $limit
	 * @param $order
	 *
	 * @return bool
	 */
	public function isValidOrderBy($start, $limit, $order) {
		if (is_numeric($start) && is_numeric($limit) && strtoupper($order) == 'ASC' && strtoupper($order) == 'DESC') {
			return true;
		}

		return false;
	}

	/**
	 * Numeric validation of start and limit
	 *
	 * @param $start
	 * @param $limit
	 *
	 * @return bool
	 */
	public function isValid($start, $limit) {
		if (is_numeric($start) && is_numeric($limit)) {
			return true;
		}

		return false;
	}


	/**
	 * Show the mysql error
	 * @return mixed
	 */
	public function showError() {
		if (Config::get('stage') == 'development') {
			echo $this->link->error;
		}
	}

	/**
	 * Generate start results for pagination
	 *
	 * @param bool $page
	 *
	 * @return bool|int
	 */
	public function start($page = false) {

		if ($page == false) {
			isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
		}

		if ($page == '' || $page == 1 || $page == 0) {
			$start = 0;
		} else {
			$start = (Config::get('max_results') * $page) - Config::get('max_results');
		}

		return $start;

	}


}