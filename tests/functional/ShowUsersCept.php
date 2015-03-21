<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('show list of users');

$I->signInAdmin();

$I->amOnPage('/manage/users');
$I->see('Users');
