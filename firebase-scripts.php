<?php
/**
 * Firebase Authentication Scripts
 *
 * @package firebase-authentication
 */

/**
 * Enqueue Firebase Authentication scripts.
 *
 * @return void
 */
function firebase_auth_enqueue_scripts() {
	$firebase_script = require_once WP_FIREBASE_AUTHENTICATION_DIR . '/build/index.asset.php';

	wp_enqueue_script(
		'firebase-authentication-script',
		WP_FIREBASE_AUTHENTICATION_URL . '/build/index.js',
		$firebase_script['dependencies'],
		$firebase_script['version'],
		true
	);

	wp_enqueue_style(
		'firebase-authentication-style',
		WP_FIREBASE_AUTHENTICATION_URL . '/build/index.css',
		array(),
		$firebase_script['version']
	);
}

add_action( 'login_enqueue_scripts', 'firebase_auth_enqueue_scripts' );

/**
 * Output the Firebase Authentication login form bottom section.
 *
 * @return void
 */
function firebase_auth_login_form_bottom() {
	?>
	<div id="firebase-login-btns">
		<button id="firebase-signin-btn">
			<?php esc_html_e( 'Sign in with Firebase', 'firebase-authentication' ); ?>
		</button>
	</div>
	<?php
}

add_action( 'login_form', 'firebase_auth_login_form_bottom' );