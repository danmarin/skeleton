<?php 
$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('update admin password');

$I->signInAdmin();

$I->amOnPage('/manage/dashboard');
$I->see('Logout');
$I->amOnPage('/manage/settings');
$I->fillField('username', 'dan');
$I->fillField('email', 'dan@spiral8.net');
$I->fillField('first_name', 'Daniel');
$I->fillField('last_name', 'Marin');
$I->fillField('password', '12341234');
$I->fillField('new_password', '12341234');
$I->click('Update');
$I->amOnPage('/manage/login');
$I->see('Manager');
$I->fillField('email', 'dan@spiral8.net');
$I->fillField('password', '12341234');
$I->click('Login');
$I->amOnPage('/manage/dashboard');
$I->see('Logout');
