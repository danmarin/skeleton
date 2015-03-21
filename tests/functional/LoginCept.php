<?php 
$I = new FunctionalTester($scenario);
$I->am('guest');
$I->wantTo('login to my account');
$I->createUserAccount();
$I->signInUser();