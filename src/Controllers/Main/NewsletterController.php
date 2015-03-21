<?php

class NewsletterController extends MainController {

	public function newsletter() {

		if (isset($_POST['submit'])) {

			$rules = array(
				'email' => 'email|exists[newsletter]',
				'name'  => 'min_length[3]'
			);

			if ($this->validation->validate($_POST, $rules)) {
				if (validToken('token')) {
					if ($this->newsletter->storeEmail($_POST['name'], $_POST['email'])) {
						$this->message = 'Email added, we will notify you as soon as our website launches.';
					} else {
						$this->message = 'An error occurred, can not add email';
					}
				} else {
					$this->message = 'Email can not be added! ';
				}
			}
		}

		$this->title = "CometGrid High Speed Hosting Using Nginx and HHVM";
		require $this->config->get('site_template') . '/newsletter.php';
	}
}