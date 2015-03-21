<?php
// Setting up the domain name
$domain = 'http://skeleton.dev';

return array(
	'urls' => array(
		// Urls
		'main_url' => $domain,
		'assets_url' => $domain.'/assets',
		'media_url' => $domain.'/media',
		'uploads_url' => $domain.'/media/uploads',
		'images_url' => $domain.'/media/images',
		'videos_url' => $domain.'/media/videos',

		// Login and signup for users
		'user_login_url' => $domain.'/login',
		'user_signup_url' => $domain.'/signup',
		'user_logout_url' => $domain.'/dashboard/logout',

		// Login and logout for administrators
		'admin_login_url' => $domain.'/manage/login',
		'admin_logout_url' => $domain.'/manage/logout',

		// Urls for administration
		'user_url' => $domain.'/dashboard',
		'admin_url' => $domain.'/manage/dashboard',
		'manage_url' => $domain.'/manage',
	)
);
