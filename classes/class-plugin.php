<?php
/**
 * Plugin Class
 *
 * @package firebase-authentication
 */

namespace FirebaseAuthentication\Classes;

require_once WP_FIREBASE_AUTHENTICATION_DIR . '/classes/class-settings.php';
require_once WP_FIREBASE_AUTHENTICATION_DIR . '/classes/class-assets.php';
require_once WP_FIREBASE_AUTHENTICATION_DIR . '/classes/class-rest.php';

/**
 * Class Plugin
 *
 * Handles Firebase Authentication plugin functionalities.
 */
class Plugin {

	/**
	 * Constructor.
	 */
	public function __construct() {

		new Settings();
		new Assets();
		new Rest();
	}
}
