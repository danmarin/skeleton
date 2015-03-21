<?php

switch (get('do')) {

	/**
	 * Main Website
	 */
	case '':
		(new PageController())->index();
		break;

	case 'signup':
		(new PageController())->signup();
		break;

	case 'login':
		(new PageController())->login();
		break;

	case 'forgot-password':
		(new PageController())->forgotPassword();
		break;
	/**
	 * END Main Website
	 */

	/**
	 * User Dashboard
	 */
	case 'dashboard':
		switch (get('action')) {
			case '':
				(new DashboardController())->dashboard();
				break;

			case 'settings':
				(new UserSettingsController())->settings();
				break;

			case 'logout':
				(new DashboardController())->logout();
				break;
			default:
				(new PageController())->show404();
				break;
		}
		break;
	/**
	 * END User Dashboard
	 */

	/**
	 * Administrator Dashboard
	 */
	case 'manage':
		switch (get('action')) {
			case 'login':
				(new PageController())->adminLogin();
				break;

			case 'dashboard':
				(new AdminDashboardController())->dashboard();
				break;

			case 'settings':
				(new AdminSettingsController())->settings();
				break;

			case 'billing':
				(new AdminBillingController())->billingSettings();
				break;

			case 'subscriptions':
				(new AdminSubscriptionsController())->subscriptions();
				break;

			case 'tickets':
				(new AdminTicketsController())->tickets();
				break;

			case 'logout';
				(new AdminController())->logout();
				break;

			/* Admin Users Manager */
			case 'users':
				switch(get('type')) {

					case '';
						(new AdminUsersController())->showUsers();
						break;

					case 'create':
						(new AdminUsersController())->createUserAccount();
						break;

					default:
						(new PageController())->show404();
						break;
				}
				break;
			/* End Admin Users Manager */

			/* Admin Newsletter Manager */
			case 'newsletter':
				switch(get('type')) {
					case '';
						(new AdminNewsletterController())->newsletterEmails();
						break;

					default:
						(new PageController())->show404();
						break;
				}
				break;

			default:
				(new PageController())->show404();
				break;
			/* End Admin Newsletter Manager */
		}

		break;
	/**
	 * END Administrator Dashboard
	 */

	/**
	 * Start API
	 */
	case 'api':
		// Results for the API
		break;
	/**
	 * END API
	 */

	case '404':
		(new PageController())->show404();
		break;

	default:
		(new PageController())->show404();
		break;

}
