<?php
/**
 * Plugin Name:       Firebase Authentication
 * Description:       A plugin to integrate Firebase Authentication with WordPress.
 * Version:           0.1.0
 * Plugin URI:        https://github.com/dhananjaykuber/wp-firebase-authentication
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Dhananjay Kuber
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       firebase-authentication
 *
 * @package           firebase-authentication
 */

define( 'WP_FIREBASE_AUTHENTICATION_VERSION', '0.1.0' );
define( 'WP_FIREBASE_AUTHENTICATION_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WP_FIREBASE_AUTHENTICATION_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

require_once WP_FIREBASE_AUTHENTICATION_DIR . '/settings-page.php';
require_once WP_FIREBASE_AUTHENTICATION_DIR . '/register-rest-route.php';
require_once WP_FIREBASE_AUTHENTICATION_DIR . '/firebase-scripts.php';
