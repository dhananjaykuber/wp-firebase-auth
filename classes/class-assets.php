<?php
/**
 * Firebase Assets Class
 *
 * @package firebase-authentication
 */

namespace FirebaseAuthentication\Classes;

/**
 * Class Assets
 *
 * Handles Firebase Assets Enqueuing.
 */
class Assets {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->setup_hooks();
	}

	/**
	 * Setup hooks.
	 *
	 * @return void
	 */
	public function setup_hooks() {

		add_action( 'login_enqueue_scripts', array( $this, 'firebase_auth_enqueue_scripts' ) );
		add_action( 'login_form', array( $this, 'firebase_auth_login_form_bottom' ) );
	}

	/**
	 * Enqueue Firebase Authentication scripts.
	 *
	 * @return void
	 */
	public function firebase_auth_enqueue_scripts() {

		$firebase_auth_options = get_option( 'firebase_authentication_options', array() );

		// If Firebase Authentication is not enabled, do not enqueue scripts.
		if ( 1 !== (int) $firebase_auth_options['enabled'] ) {
			return;
		}

		$firebase_script = require_once WP_FIREBASE_AUTHENTICATION_DIR . '/build/index.asset.php';

		wp_enqueue_script(
			'firebase-authentication-script',
			WP_FIREBASE_AUTHENTICATION_URL . '/build/index.js',
			$firebase_script['dependencies'],
			$firebase_script['version'],
			true
		);

		wp_localize_script(
			'firebase-authentication-script',
			'firebaseAuthSettings',
			array(
				'apiKey'            => $firebase_auth_options['api_key'] ?? '',
				'authDomain'        => $firebase_auth_options['auth_domain'] ?? '',
				'projectId'         => $firebase_auth_options['project_id'] ?? '',
				'storageBucket'     => $firebase_auth_options['storage_bucket'] ?? '',
				'messagingSenderId' => $firebase_auth_options['messaging_sender_id'] ?? '',
				'appId'             => $firebase_auth_options['app_id'] ?? '',
			)
		);

		wp_enqueue_style(
			'firebase-authentication-style',
			WP_FIREBASE_AUTHENTICATION_URL . '/build/index.css',
			array(),
			$firebase_script['version']
		);
	}

	/**
	 * Output the Firebase Authentication login form bottom section.
	 *
	 * @return void
	 */
	public function firebase_auth_login_form_bottom() {

		$firebase_auth_options = get_option( 'firebase_authentication_options', array() );

		// If Firebase Authentication is not enabled, do not render the button.
		if ( 1 !== (int) $firebase_auth_options['enabled'] ) {
			return;
		}
		?>
			<div id="firebase-login-btns">
				<button id="firebase-signin-btn">
					<?php esc_html_e( 'Sign in with Firebase', 'firebase-authentication' ); ?>
				</button>
			</div>
		<?php
	}
}
