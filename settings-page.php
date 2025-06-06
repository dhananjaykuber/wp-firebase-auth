<?php
/**
 * Firebase Settings Page
 *
 * @package firebase-authentication
 */

/**
 * Render the Firebase Authentication settings page.
 *
 * @return void
 */
function firebase_auth_add_settings_page() {

	add_options_page(
		esc_html__( 'Firebase Authentication Settings', 'firebase-authentication' ),
		esc_html__( 'Firebase Authentication', 'firebase-authentication' ),
		'manage_options',
		'firebase-authentication',
		'firebase_auth_render_settings_page'
	);
}

add_action( 'admin_menu', 'firebase_auth_add_settings_page' );

/**
 * Render the settings page content.
 *
 * @return void
 */
function firebase_auth_register_settings() {

	// Register the settings for Firebase Authentication.
	register_setting(
		'firebase_authentication_options',
		'firebase_authentication_options',
		array(
			'sanitize_callback' => 'firebase_auth_sanitize_options',
			'default'           => array(
				'api_key'             => '',
				'auth_domain'         => '',
				'project_id'          => '',
				'storage_bucket'      => '',
				'messaging_sender_id' => '',
				'app_id'              => '',
			),
		)
	);

	// Add a settings section for Firebase Authentication.
	add_settings_section(
		'firebase_authentication_settings_section',
		esc_html__( 'Firebase Authentication Settings', 'firebase-authentication' ),
		'firebase_auth_render_settings_section',
		'firebase-authentication'
	);

	// Add settings fields for each Firebase Authentication configuration.
	foreach ( firebase_auth_get_fields() as $key => $label ) {

		add_settings_field(
			"firebase_{$key}",
			$label,
			function () use ( $key ) {
				if ( 'enabled' === $key ) {
					firebase_auth_render_checkbox_field( $key );
				} else {
					firebase_auth_render_text_field( $key );
				}
			},
			'firebase-authentication',
			'firebase_authentication_settings_section'
		);
	}
}

add_action( 'admin_init', 'firebase_auth_register_settings' );

/**
 * Render the settings page.
 *
 * @return void
 */
function firebase_auth_render_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Firebase Authentication Settings', 'firebase-authentication' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'firebase_authentication_options' );
			do_settings_sections( 'firebase-authentication' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}


/**
 * Render a text field for Firebase Authentication settings.
 *
 * @param string $key The key for the setting.
 * @return void
 */
function firebase_auth_render_text_field( $key ) {

	$options = get_option( 'firebase_authentication_options' );
	$value   = isset( $options[ $key ] ) ? esc_attr( $options[ $key ] ) : '';

	printf(
		'<input type="text" id="firebase_%1$s" name="firebase_authentication_options[%1$s]" value="%2$s" class="regular-text">',
		esc_attr( $key ),
		$value
	);
}

/**
 * Render a checkbox field for Firebase Authentication settings.
 *
 * @param string $key The key for the setting.
 * @return void
 */
function firebase_auth_render_checkbox_field( $key ) {

	$options = get_option( 'firebase_authentication_options' );
	$checked = isset( $options[ $key ] ) && $options[ $key ] === '1' ? 'checked' : '';

	printf(
		'<label><input type="checkbox" id="firebase_%1$s" name="firebase_authentication_options[%1$s]" value="1" %2$s> %3$s</label>',
		esc_attr( $key ),
		$checked,
		esc_html__( 'Enable this setting', 'firebase-authentication' )
	);
}


/**
 * Render the settings section description.
 *
 * @return void
 */
function firebase_auth_render_settings_section() {

	printf(
		'<p>%s</p>',
		esc_html__( 'You can find your Firebase configuration in the Firebase Console under Project Settings.', 'firebase-authentication' )
	);
}

/**
 * Get the fields for Firebase Authentication settings.
 *
 * @return array Fields for Firebase Authentication settings.
 */
function firebase_auth_get_fields() {

	return array(
		'enabled'             => __( 'Enable Firebase Authentication', 'firebase-authentication' ),
		'api_key'             => __( 'API Key', 'firebase-authentication' ),
		'auth_domain'         => __( 'Auth Domain', 'firebase-authentication' ),
		'project_id'          => __( 'Project ID', 'firebase-authentication' ),
		'storage_bucket'      => __( 'Storage Bucket', 'firebase-authentication' ),
		'messaging_sender_id' => __( 'Messaging Sender ID', 'firebase-authentication' ),
		'app_id'              => __( 'App ID', 'firebase-authentication' ),
	);
}

/**
 * Sanitize Firebase Authentication settings.
 *
 * @param array $input The input values to sanitize.
 * @return array Sanitized values.
 */
function firebase_auth_sanitize_options( $input ) {

	$sanitized = array();

	$fields = firebase_auth_get_fields();

	foreach ( $fields as $key => $label ) {
		if ( 'enabled' === $key ) {
			$sanitized[ $key ] = isset( $input[ $key ] ) ? '1' : '0';
		} else {
			$sanitized[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';
		}
	}

	return $sanitized;
}
