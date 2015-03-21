<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('create user account from administrator dashboard');

$I->signInAdmin();

$I->amOnPage('/manage/users/create');
$I->see('Create User Account');

$I->createUserAccountFromAdmin();
