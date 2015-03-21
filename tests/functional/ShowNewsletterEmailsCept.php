<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('show newsletter emails');

$I->signInAdmin();

$I->amOnPage('/manage/newsletter');
$I->dontSee('404');
$I->see('Newsletter Subscriptions');
