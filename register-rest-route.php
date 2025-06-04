<?php
/**
 * Register REST route for Firebase Authentication
 *
 * @package firebase-authentication
 */


require_once WP_FIREBASE_AUTHENTICATION_DIR . '/vendor/autoload.php';

use Kreait\Firebase\JWT\IdTokenVerifier;

/**
 * Registers the REST route for verifying Firebase tokens.
 *
 * @return void
 */
function firebase_auth_register_rest_route() {

	register_rest_route(
		'firebase-auth/v1',
		'/verify-token',
		array(
			'methods'             => 'POST',
			'callback'            => 'firebase_auth_verify_token',
			'permission_callback' => '__return_true',
			'args'                => array(
				'token' => array(
					'required'          => true,
					'validate_callback' => function ( $param ) {
						return is_string( $param );
					},
				),
			),
		)
	);
}

/**
 * Callback function to verify Firebase token.
 *
 * @param WP_REST_Request $request The REST request object.
 *
 * @return WP_REST_Response
 */
function firebase_auth_verify_token( WP_REST_Request $request ) {

	$token = $request->get_param( 'token' );

	try {
		// Initialize the IdTokenVerifier with Firebase project ID.
		$verifier = IdTokenVerifier::createWithProjectId( 'fir-auth-993a8' );

		// Verify the token.
		$verified_token = $verifier->verifyIdToken( $token );

		if ( ! $verified_token ) {
			return new WP_Error(
				'invalid_token',
				__( 'Invalid Firebase token.', 'firebase-authentication' ),
				array( 'status' => 401 )
			);
		}

		// Extract user information from the verified token.
		$payload = $verified_token->payload();

		$email = $payload['email'] ?? '';
		$user  = get_user_by( 'email', $email );

		// If user does not exist, create a new user.
		if ( empty( $user ) ) {
			$username = $payload['name'] ?? explode( '@', $email )[0];
			$password = wp_generate_password();

			$user_id = wp_create_user(
				$username,
				$password,
				$email
			);

			if ( is_wp_error( $user_id ) ) {
				return new WP_Error(
					'user_creation_failed',
					__( 'User could not be created.', 'firebase-authentication' ),
					array( 'status' => 500 )
				);
			}

			// Set the user role to 'subscriber' or any other role you prefer.
			$user = get_user_by( 'id', $user_id );
			$user->set_role( 'subscriber' );
		}

		if ( ! $user ) {
			return new WP_Error(
				'user_not_found',
				__( 'User not found or could not be created.', 'firebase-authentication' ),
				array( 'status' => 404 )
			);
		}

		// Set the user as logged in.
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID );

		return new WP_REST_Response(
			array(
				'message' => __( 'User authenticated successfully.', 'firebase-authentication' ),
			),
			200
		);
	} catch ( Exception $e ) {
		return new WP_Error(
			'firebase_auth_error',
			__( 'Token verification failed.', 'firebase-authentication' ),
			array( 'status' => 500 )
		);
	}
}

add_action( 'rest_api_init', 'firebase_auth_register_rest_route' );
