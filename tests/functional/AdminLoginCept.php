<?php 
$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('login to my administrator account');

$I->signInAdmin();
