<?php

return array(
		'cache' => false,
		'cache_type' => 'serialize', // it can be serialize, file or memcache
		'cache_path' => __DIR__ . '/../cache',

		// A memcache server can also be used
		'memcache_server' => 'localhost',
		'memcache_port' => '11211',
	);