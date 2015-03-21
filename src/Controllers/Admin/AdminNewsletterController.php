<?php

class AdminNewsletterController extends AdminController {

	public $newsletterData;

	public function newsletterEmails() {
		$deleted = false;
		if(post('submit') && post('action') == 'delete') {
			if(isset($_POST['id']) && count($_POST['id']) > 0) {
				foreach ($_POST['id'] as $id) {
					if ($this->manage->deleteNewsletter($id)) {
						$deleted = true;
					}
				}
			} else {
				$this->message = 'You need to select emails!';
			}

			if($deleted) {
				$this->message = 'Emails deleted!';
			}
		}

		$this->newsletterData = $this->manage->getNewsletterEmails();
		$this->isAuth('newsletter.php');
	}

}