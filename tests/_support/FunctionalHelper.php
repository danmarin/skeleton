<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module {

	public $adminEmail = 'dan@spiral8.net';
	public $adminPass = '12341234';

	public $userEmail = 'dan@spiral8.net';
	public $userPass = '12341234';

	public $testUser = 'test';
	public $testEmail = 'test@test.com';
	public $testPass = '12341234';

	public $testUser2 = 'test2';
	public $testEmail2 = 'test2@test.com';
	public $testPass2 = '12341234';

	public function signInAdmin() {

		$I = $this->getModule('PhpBrowser');

		$I->amOnPage('/manage/login');
		$I->fillField('email', $this->adminEmail);
		$I->fillField('password', $this->adminPass);
		$I->click('Login');
		$I->amOnPage('/manage/dashboard');
		$I->see('Logout');
	}

	public function signInUser() {

		$I = $this->getModule('PhpBrowser');

		$I->amOnPage('/login');
		$I->fillField('email', $this->testEmail2);
		$I->fillField('password', $this->testPass2);
		$I->click('Login');
		$I->amOnPage('/dashboard');
		$I->see('Logout');
	}

	public function createUserAccount() {

		$I = $this->getModule('PhpBrowser');

		$I->amOnPage('/signup');
		$I->fillField('email', $this->testEmail2);
		$I->fillField('password', $this->testPass2);
		$I->fillField('confirm_password', $this->testPass2);
		$I->click('Sign Up');
		$I->see('Account created!');

		$DB = $this->getModule('Db');

		$DB->seeInDatabase('users', array('email' => $this->testEmail2));
	}


	public function verifyAdminPage() {

		$I = $this->getModule('PhpBrowser');

		$I->amOnPage('/manage/login');
		$I->fillField('email', $this->adminEmail);
		$I->fillField('password', $this->adminPass);
		$I->click('Login');
		$I->amOnPage('/manage/dashboard');
		$I->see('Logout');
	}

	public function createUserAccountFromAdmin() {

		$I = $this->getModule('PhpBrowser');
		$DB = $this->getModule('Db');

		$I->fillField('username', $this->testUser);
		$I->fillField('email', $this->testEmail);
		$I->fillField('password', $this->userPass);
		$I->click('Create account');
		$I->see('Account created!');
		$DB->seeInDatabase('users', array('username'=> $this->testUser, 'email' => $this->testEmail));
	}
}
