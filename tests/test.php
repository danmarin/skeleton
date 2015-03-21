<?php

require __DIR__ . '/../bootstrap/start.php';

use Vortex\Config\Config;
use Vortex\Database\DB;
use Faker\Factory as Faker;

Config::setDirScan(__DIR__ . '/../app/config/');

$db = new DB(new Config());
$faker = Faker::create();


for($i = 0; $i < 100; $i++) {
	$name = $faker->name;
	$email = $faker->email;
	$sql = "INSERT INTO `newsletter`(`name`, `email`, `date`) VALUES('$name', '$email', NOW())";
	if($db->link->query($sql)) {
		echo 'Adding:'.PHP_EOL;
		echo 'Name: '.$name.PHP_EOL;
		echo 'Email: '.$email.PHP_EOL;
		echo '------------------------'.PHP_EOL;
	}
}



