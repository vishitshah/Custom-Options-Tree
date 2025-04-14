<?php
/*
Plugin Name: Custom Options Tree
Plugin URI: https://wordpress.org/plugins/custom-options-tree/
Description: Easily changes of header logo , google analytical code , footer code , footer logo, footer copyright text, footer design and develop text and social media(facebook, twitter, linkedin, instagram)
Version: 1.3
Author: Vishit Shah
Author URI: https://www.linkedin.com/in/vishit-shah-5b393383/
License: GPLv2
Text Domain : cot
*/

/* Plugin Licence

Copyright 2014 VISHIT SHAH (email : vishit99@gmail.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

// Make sure we don't expose any info if called directly
if ( basename( $_SERVER['PHP_SELF'] ) == basename( __FILE__ ) ) {
	die( 'Sorry, but you cannot access this page directly.' );
}

add_action('admin_menu', 'add_custom_option_tree');
function add_custom_option_tree() {
	add_theme_page('Custom Option Tree', 'Custom Option Tree', 'manage_options', 'edit-custom-option-tree', 'cot_display');
}
 
/**
 * Retrieves plugin options if they exist or returns default values if not
 *
 * @since Custom Options Tree 1.0
 *
 * @return array of Custom Options Trees.
 */

function cot_getoptions() {
	$default_options = array(
		'header_image_path'         => '',
		'header_favicon_icon_path'  => '',
		'header_global_code'        => '',
		'header_code'               => '',
		'footer_image_path'         => '',
		'copy_right'                => '',
		'design_development'        => '',
		'footer_code'               => '',
		'facebook'                  => '',
		'twitter'                   => '',
		'linkedin'                  => '',
		'instagram'                 => '',
		'custom_option1'            => '',
		'custom_option2'            => '',
	);

	$stored_options = get_option( 'cot_options', array() );

	// Merge defaults with stored options
	return wp_parse_args( $stored_options, $default_options );
}

function cot_display() {
	?>
	<div class="wrap">
		<h1 class="main-title"><?php esc_html_e( 'Custom Theme Option Settings', 'cot' ); ?></h1>
		<p class="description"><?php esc_html_e( 'Add theme options to your theme hassle-free', 'cot' ); ?></p>

		<?php settings_errors(); ?>

		<div class="custom_option">
			<form method="post" action="options.php" class="customtheme">
				<?php
				settings_fields( 'cot_options' );

				// Display all sections
				do_settings_sections( 'cot_headersection' );
				do_settings_sections( 'cot_footersection' );
				do_settings_sections( 'cot_socialmedia' );
				do_settings_sections( 'cot_globalsection' );
				?>

				<?php submit_button( __( 'Save Settings', 'cot' ) ); ?>
			</form>
		</div>
	</div>
	<?php
}

add_action( 'admin_init', 'cot_register_settings' );
function cot_register_settings() {

	// Register the setting
	register_setting( 'cot_options', 'cot_options', 'cot_validate_options' );

	/**
	 * Header Section
	 */
	add_settings_section( 'cot_header_section', __( 'Header Section', 'cot' ), 'cot_headertext', 'cot_headersection' );

	add_settings_field( 'cot_headerlogo', __( 'Header Logo', 'cot' ), 'cot_headerlogo', 'cot_headersection', 'cot_header_section' );

	add_settings_field( 'cot_faviconicon', __( 'Favicon Icon', 'cot' ), 'cot_faviconicon', 'cot_headersection','cot_header_section' );

	/**
	 * Footer Section
	 */
	add_settings_section( 'cot_footer_section', __( 'Footer Section', 'cot' ), 'cot_footertext', 'cot_footersection' );

	add_settings_field( 'cot_footerlogo', __( 'Footer Logo', 'cot' ), 'cot_footerlogo', 'cot_footersection', 'cot_footer_section' );

	add_settings_field( 'cot_copyrighttext', __( 'Footer Copyright Text', 'cot' ), 'cot_copyrighttext', 'cot_footersection', 'cot_footer_section' );

	add_settings_field( 'cot_designdevelopmenttext', __( 'Design & Development Text', 'cot' ), 'cot_designdevelopmenttext', 'cot_footersection', 'cot_footer_section' );

	/**
	 * Social Media Section
	 */
	add_settings_section( 'cot_social_section', __( 'Social Media', 'cot' ), 'cot_socialmediatext', 'cot_socialmedia' );

	add_settings_field( 'cot_facebooklink', __( 'Facebook', 'cot' ), 'cot_facebooklink', 'cot_socialmedia', 'cot_social_section' );

	add_settings_field( 'cot_twitterlink', __( 'Twitter', 'cot' ), 'cot_twitterlink', 'cot_socialmedia', 'cot_social_section' );

	add_settings_field( 'cot_linkedinlink', __( 'LinkedIn', 'cot' ), 'cot_linkedinlink', 'cot_socialmedia', 'cot_social_section' );

	add_settings_field( 'cot_instagramlink', __( 'Instagram', 'cot' ), 'cot_instagramlink', 'cot_socialmedia', 'cot_social_section' );

	add_settings_field( 'cot_customoption1link', __( 'Custom 1', 'cot' ), 'cot_customoption1link', 'cot_socialmedia', 'cot_social_section' );

	add_settings_field( 'cot_customoption2link', __( 'Custom 2', 'cot' ), 'cot_customoption2link', 'cot_socialmedia', 'cot_social_section' );

	/**
	 * Global Section
	 */
	add_settings_section( 'cot_global_section', __( 'Global Section', 'cot' ), 'cot_globaltext', 'cot_globalsection' );

	add_settings_field( 'cot_globalheadercode', __( 'Google Analytics Code', 'cot' ), 'cot_globalheadercode', 'cot_globalsection', 'cot_global_section' );

	add_settings_field( 'cot_otherheadercode', wp_kses( __( 'Other Code<br>add to header.php', 'cot' ), [ 'br' => [] ] ), 'cot_otherheadercode', 'cot_globalsection', 'cot_global_section');

	add_settings_field( 'cot_otherfootercode', wp_kses( __( 'Other Code<br>add to footer.php', 'cot' ), [ 'br' => [] ] ), 'cot_otherfootercode', 'cot_globalsection', 'cot_global_section' );
}

function cot_headertext() {
	echo '<p>' . esc_html__( 'Customize your theme header settings.', 'cot' ) . '</p>';
}

function cot_footertext() {
	echo '<p>' . esc_html__( 'Customize your theme footer settings.', 'cot' ) . '</p>';
}

function cot_socialmediatext() {
	echo '<p>' . esc_html__( 'Add your social media profile links.', 'cot' ) . '</p>';
}

function cot_globaltext() {
	echo '<p>' . esc_html__( 'Add global scripts or tracking codes here.', 'cot' ) . '</p>';
}

// Header Logo
function cot_headerlogo() {
	$options = cot_getoptions();
	$cot_headerlogo = isset( $options['header_image_path'] ) ? $options['header_image_path'] : '';
	?>

	<p>
		<label for="cot_header_logo_image" class="screen-reader-text"><?php esc_html_e( 'Header Logo URL', 'cot' ); ?></label>
		<input id="cot_header_logo_image" class="regular-text code" type="text" name="cot_options[header_image_path]" value="<?php echo esc_attr( $cot_headerlogo ); ?>" />
		<input id="upload_header_image_button" type="button" class="button button-secondary" value="<?php esc_attr_e( 'Media Library', 'cot' ); ?>" />
		<p class="description">
			<?php esc_html_e( 'Enter an image URL or use an image from the media library.', 'cot' ); ?>
		</p>
		<?php if ( ! empty( $cot_headerlogo ) ) : ?>
			<p>
				<img id="cot_customtheme_admin_preview" src="<?php echo esc_url( $cot_headerlogo ); ?>" alt="<?php esc_attr_e( 'Header Logo Preview', 'cot' ); ?>" style="max-width: 200px; height: auto;"/>
			</p>
		<?php endif; ?>

		<p class="notice-shortcode">
			<span><?php esc_html_e( 'Use this shortcode for header logo:', 'cot' ); ?></span>
			<code>&lt;?php cot_showheaderlogo(); ?&gt;</code>			
		</p>
	</p>
	<?php
}

// Favicon Icon
function cot_faviconicon() {
	$options = cot_getoptions();
	$cot_faviconicon = isset( $options['header_favicon_icon_path'] ) ? $options['header_favicon_icon_path'] : '';
	?>

	<p>
		<label for="cot_favicon_icon_image" class="screen-reader-text"><?php esc_html_e( 'Favicon Icon URL', 'cot' ); ?></label>
		
		<input id="cot_favicon_icon_image" class="regular-text code" type="text" name="cot_options[header_favicon_icon_path]" value="<?php echo esc_attr( $cot_faviconicon ); ?>" />

		<input id="upload_favicon_icon_button" type="button" class="button button-secondary" value="<?php esc_attr_e( 'Media Library', 'cot' ); ?>" />

		<p class="description"><?php esc_html_e( 'Enter an image URL or use an image from the media library.', 'cot' ); ?></p>

		<?php if ( ! empty( $cot_faviconicon ) ) : ?>
			<p><img id="cot_favicon_admin_preview" src="<?php echo esc_url( $cot_faviconicon ); ?>" alt="<?php esc_attr_e( 'Favicon Icon Preview', 'cot' ); ?>" style="max-width: 64px; height: auto;" /></p>
		<?php endif; ?>

		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for favicon icon:', 'cot' ); ?>
			<code>&lt;?php cot_showfaviconicon(); ?&gt;</code>
		</p>
	</p>

	<?php
}

//Header Google Analytical Function
function cot_globalheadercode() {
	$options = cot_getoptions();
	$cot_headerglobalcode = isset( $options['header_global_code'] ) ? $options['header_global_code'] : '';
	?>

	<label for="cot_header_global_code" class="screen-reader-text"><?php esc_html_e( 'Google Analytics Code', 'cot' ); ?></label>
	<textarea id="cot_header_global_code" class="large-text" name="cot_options[header_global_code]" rows="8" placeholder="<?php esc_attr_e( 'Google Analytics Code', 'cot' ); ?>"><?php echo esc_textarea( $cot_headerglobalcode ); ?></textarea>
	<p class="description"><?php esc_html_e( 'Add your Google Analytics code here.', 'cot' ); ?></p>

	<?php
}

//Header Another Code Function
function cot_otherheadercode() {
	$options = cot_getoptions();
	$cot_headerothercode = isset( $options['header_code'] ) ? $options['header_code'] : '';
	?>

	<label for="cot_other_header_code" class="screen-reader-text"><?php esc_html_e( 'Custom Header Code', 'cot' ); ?></label>
	<textarea id="cot_other_header_code" class="large-text" name="cot_options[header_code]" rows="8" placeholder="<?php esc_attr_e( 'Add custom header code here...', 'cot' ); ?>"><?php echo esc_textarea( $cot_headerothercode ); ?></textarea>
	<p class="description"><?php esc_html_e( 'Any custom code that needs to be added to header.php.', 'cot' ); ?></p>

	<?php
}

//Footer Logo Function  
function cot_footerlogo() {
	$options = cot_getoptions();
	$cot_footerlogo = isset( $options['footer_image_path'] ) ? $options['footer_image_path'] : '';
	?>
	<p>
		<label for="cot_footer_logo_image" class="screen-reader-text"><?php esc_html_e( 'Footer Logo URL', 'cot' ); ?></label>

		<input type="text" id="cot_footer_logo_image" name="cot_options[footer_image_path]" class="regular-text code" value="<?php echo esc_attr( $cot_footerlogo ); ?>" placeholder="<?php esc_attr_e( 'Enter image URL...', 'cot' ); ?>" />

		<input type="button" id="upload_footer_image_button" class="button-secondary" value="<?php esc_attr_e( 'Media Library', 'cot' ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter an image URL or use an image from the media library.', 'cot' ); ?>
		</p>

		<?php if ( ! empty( $cot_footerlogo ) ) : ?>
			<img id="cot_customtheme_footer_admin_preview" src="<?php echo esc_url( $cot_footerlogo ); ?>" alt="<?php esc_attr_e( 'Footer logo preview', 'cot' ); ?>" style="max-width: 150px; height: auto;" />
		<?php endif; ?>

		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for footer logo:', 'cot' ); ?>
			<b><?php echo esc_html( '<?php cot_showfooterlogo(); ?>' ); ?></b>
		</p>
	</p>
	<?php
}

//Footer Copyright Text Funxtion
function cot_copyrighttext() {
	$options = cot_getoptions();
	$cot_copyright = isset( $options['copy_right'] ) ? $options['copy_right'] : '';
	?>

	<p>
		<label for="cot_copyright" class="screen-reader-text"><?php esc_html_e( 'Copyright Text', 'cot' ); ?></label>

		<input type="text" id="cot_copyright" name="cot_options[copy_right]" class="text-box regular-text" value="<?php echo esc_attr( $cot_copyright ); ?>" placeholder="<?php esc_attr_e( '© 2025 WordPress', 'cot' ); ?>" />
		
		<p class="description">
			<?php esc_html_e( 'Enter your site\'s copyright text here.', 'cot' ); ?>
		</p>
		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for copyright text:', 'cot' ); ?>
			<b><?php echo esc_html( '<?php cot_copyright(); ?>' ); ?></b>
		</p>
	</p>

	

	<?php
}

//Footer Design & Development Text Funxtion
function cot_designdevelopmenttext() {
	$options = cot_getoptions();
	$cot_designdevelopment = isset( $options['design_development'] ) ? $options['design_development'] : '';
	?>

	<p>
		<label for="cot_design_development" class="screen-reader-text"><?php esc_html_e( 'Design & Development Text', 'cot' ); ?></label>

		<input type="text" id="cot_design_development" name="cot_options[design_development]" class="text-box regular-text" value="<?php echo esc_attr( $cot_designdevelopment ); ?>" placeholder="<?php esc_attr_e( 'Design & Developed By Vishit Shah', 'cot' ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter your design and development credit text here.', 'cot' ); ?>
		</p>
		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for design & development text:', 'cot' ); ?>
			<b><?php echo esc_html( '<?php cot_designdevelopment(); ?>' ); ?></b>
		</p>
	</p>

	<?php
}


//Footer Another Code Function
function cot_otherfootercode() {
	$options = cot_getoptions();
	$cot_footerglobalcode = isset( $options['footer_code'] ) ? $options['footer_code'] : '';
	?>

	<label for="cot_other_footer_code" class="screen-reader-text"><?php esc_html_e( 'Custom Footer Code', 'cot' ); ?></label>

	<textarea id="cot_other_footer_code" class="large-text" name="cot_options[footer_code]" rows="8" placeholder="<?php esc_attr_e( 'Add custom footer code here...', 'cot' ); ?>" ><?php echo esc_textarea( $cot_footerglobalcode ); ?></textarea>

	<p class="description"><?php esc_html_e( 'Any custom code that needs to be added to footer.php.', 'cot' ); ?></p>

	<?php
}

//Social Media Facebook Function
function cot_facebooklink() {
	$options         = cot_getoptions();
	$cot_facebookurl = isset( $options['facebook'] ) ? $options['facebook'] : '';
	?>

	<p>
		<label for="cot_facebook_url" class="screen-reader-text"><?php esc_html_e( 'Facebook Profile URL', 'cot' ); ?></label>

		<input type="url" id="cot_facebook_url" name="cot_options[facebook]" class="text-box regular-text" placeholder="<?php esc_attr_e( 'http://facebook.com/yourprofileurl', 'cot' ); ?>" value="<?php echo esc_attr( $cot_facebookurl ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter your Facebook profile URL here.', 'cot' ); ?>
		</p>

		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for Facebook link:', 'cot' ); ?>
			<b><?php echo esc_html( '<?php cot_facebook(); ?>' ); ?></b>
		</p>
	</p>

	<?php
}


//Social Media Twitter Function
/**
 * Render Twitter URL input field for Theme Options.
 */
function cot_twitterlink() {
	$options        = cot_getoptions();
	$cot_twitterurl = isset( $options['twitter'] ) ? $options['twitter'] : '';
	?>

	<p>
		<label for="cot_twitter" class="screen-reader-text">
			<?php esc_html_e( 'Twitter URL', 'cot' ); ?>
		</label>

		<input type="url" class="text-box regular-text" id="cot_twitter" name="cot_options[twitter]" placeholder="https://twitter.com/yourprofileurl" value="<?php echo esc_attr( $cot_twitterurl ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter your Twitter profile URL.', 'cot' ); ?>
		</p>
		
		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for Twitter link:', 'cot' ); ?>
			<b><?php echo esc_html( "<?php cot_twitter(); ?>" ); ?></b>
		</p>
	</p>

	<?php
}


//Social Media Linkedin Function
/**
 * Render LinkedIn URL input field for Theme Options.
 */
function cot_linkedinlink() {
	$options           = cot_getoptions();
	$cot_linkedinurl   = isset( $options['linkedin'] ) ? $options['linkedin'] : '';
	?>

	<p>
		<label for="cot_linkedin" class="screen-reader-text">
			<?php esc_html_e( 'LinkedIn URL', 'cot' ); ?>
		</label>

		<input type="url" class="text-box regular-text" id="cot_linkedin" name="cot_options[linkedin]" placeholder="https://www.linkedin.com/yourprofileurl" value="<?php echo esc_attr( $cot_linkedinurl ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter your LinkedIn profile URL.', 'cot' ); ?>
		</p>

		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for LinkedIn link:', 'cot' ); ?>
			<b><?php echo esc_html( "<?php cot_linkedin(); ?>" ); ?></b>
		</p>
	</p>	

	<?php
}


//Social Media Instagram Function
/**
 * Render Instagram URL input field for Theme Options.
 */
function cot_instagramlink() {
	$options            = cot_getoptions();
	$cot_instagramurl   = isset( $options['instagram'] ) ? $options['instagram'] : '';
	?>

	<p>
		<label for="cot_instagram" class="screen-reader-text">
			<?php esc_html_e( 'Instagram URL', 'cot' ); ?>
		</label>

		<input type="url" class="text-box regular-text" id="cot_instagram" name="cot_options[instagram]" placeholder="https://www.instagram.com/yourprofileurl" value="<?php echo esc_attr( $cot_instagramurl ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter your Instagram profile URL.', 'cot' ); ?>
		</p>

		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for Instagram link:', 'cot' ); ?>
			<b><?php echo esc_html( "<?php cot_instagram(); ?>" ); ?></b>
		</p>
	</p>

	<?php
}


//Social Media Custom option Function
/**
 * Render Custom Option 1 URL input field for Theme Options.
 */
function cot_customoption1link() {
	$options               = cot_getoptions();
	$cot_customoptionurl1  = isset( $options['custom_option1'] ) ? $options['custom_option1'] : '';
	?>

	<p>
		<label for="cot_custom_option1" class="screen-reader-text">
			<?php esc_html_e( 'Custom Option 1 URL', 'cot' ); ?>
		</label>

		<input type="url" class="text-box regular-text" id="cot_custom_option1" name="cot_options[custom_option1]" placeholder="https://www.example.com" value="<?php echo esc_attr( $cot_customoptionurl1 ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter a custom URL for any social or external link.', 'cot' ); ?>
		</p>

		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for Custom Option link:', 'cot' ); ?>
			<b><?php echo esc_html( "<?php cot_customoption1(); ?>" ); ?></b>
		</p>
	</p>

	<?php
}


//Social Media Custom option Function
/**
 * Render Custom Option 2 URL input field for Theme Options.
 */
function cot_customoption2link() {
	$options               = cot_getoptions();
	$cot_customoptionurl2  = isset( $options['custom_option2'] ) ? $options['custom_option2'] : '';
	?>

	<p>
		<label for="cot_custom_option2" class="screen-reader-text">
			<?php esc_html_e( 'Custom Option 2 URL', 'cot' ); ?>
		</label>

		<input type="url" class="text-box regular-text" id="cot_custom_option2" name="cot_options[custom_option2]" placeholder="https://www.example.com" value="<?php echo esc_attr( $cot_customoptionurl2 ); ?>" />

		<p class="description">
			<?php esc_html_e( 'Enter a second custom URL for any use case.', 'cot' ); ?>
		</p>

		<p class="notice-shortcode">
			<?php esc_html_e( 'Use this shortcode for Custom Option link:', 'cot' ); ?>
			<b><?php echo esc_html( "<?php cot_customoption2(); ?>" ); ?></b>
		</p>
	</p>

	<?php
}


/**
 * Sanitize and validate Custom Option Tree input values.
 *
 * @param array $input Raw input values from the options form.
 * @return array Sanitized input values.
 */
function cot_section( $input ) {
	$allowed_keys = [
		'header_image_path', 'header_favicon_icon_path', 'header_global_code', 'header_code', 'footer_image_path', 'copy_right', 'design_development', 'footer_code','url','facebook', 'twitter', 'linkedin', 'instagram', 'custom_option1', 'custom_option2',
	];

	foreach ( $allowed_keys as $key ) {
		if ( isset( $input[ $key ] ) ) {
			$input[ $key ] = esc_url_raw( $input[ $key ] );
		}
	}

	return $input;
}


/**
 *
 * @since Custom Options Tree 1.0
 */
 
 
/**
 * Display the site header logo or site title if logo not set.
 */
function cot_showheaderlogo() {
	$options         = cot_getoptions();
	$header_image    = isset( $options['header_image_path'] ) ? esc_url( $options['header_image_path'] ) : '';

	if ( empty( $header_image ) ) {
		?>
		<h2 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h2>
		<?php
	} else {
		?>
		<div class="site-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo $header_image; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			</a>
		</div>
		<?php
	}
}


/**
 * Display the site favicon icon or site title if favicon is not set.
 */
function cot_showfaviconicon() {
	$options       = cot_getoptions();
	$favicon_image = isset( $options['header_favicon_icon_path'] ) ? esc_url( $options['header_favicon_icon_path'] ) : '';

	if ( empty( $favicon_image ) ) {
		?>
		<h2 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h2>
		<?php
	} else {
		?>
		<link rel="icon" href="<?php echo $favicon_image; ?>" type="image/x-icon" />
		<?php
	}
}

/**
 * Display the footer logo if available.
 */
function cot_showfooterlogo() {
	$options        = cot_getoptions();
	$footer_image   = isset( $options['footer_image_path'] ) ? esc_url( $options['footer_image_path'] ) : '';

	if ( ! empty( $footer_image ) ) {
		printf(
			'<img src="%s" alt="%s" class="footer-logo" />',
			$footer_image,
			esc_attr( get_bloginfo( 'name' ) )
		);
	}
}

/**
 * Display the copyright text if available.
 */
function cot_copyright() {
	$options   = cot_getoptions();
	$copy_text = isset( $options['copy_right'] ) ? trim( $options['copy_right'] ) : '';

	if ( ! empty( $copy_text ) ) {
		echo esc_html( $copy_text );
	}
}

/**
 * Display the Design & Development credit text if available.
 */
function cot_designdevelopment() {
	$options      = cot_getoptions();
	$dd_text      = isset( $options['design_developement'] ) ? trim( $options['design_developement'] ) : '';

	if ( ! empty( $dd_text ) ) {
		echo esc_html( $dd_text );
	}
}

/**
 * Display the Facebook URL if available.
 */
function cot_facebook() {
	$options   = cot_getoptions();
	$fb_link   = isset( $options['facebook'] ) ? trim( $options['facebook'] ) : '';

	if ( ! empty( $fb_link ) ) {
		echo esc_url( $fb_link );
	}
}

/**
 * Display the Twitter URL if available.
 */
function cot_twitter() {
	$options   = cot_getoptions();
	$tw_link   = isset( $options['twitter'] ) ? trim( $options['twitter'] ) : '';

	if ( ! empty( $tw_link ) ) {
		echo esc_url( $tw_link );
	}
}

/**
 * Display the LinkedIn URL.
 */
function cot_linkedin() {
	$options     = cot_getoptions();
	$link        = isset( $options['linkedin'] ) ? trim( $options['linkedin'] ) : '';

	if ( ! empty( $link ) ) {
		echo esc_url( $link );
	}
}

/**
 * Display the Instagram URL.
 */
function cot_instagram() {
	$options     = cot_getoptions();
	$link        = isset( $options['instagram'] ) ? trim( $options['instagram'] ) : '';

	if ( ! empty( $link ) ) {
		echo esc_url( $link );
	}
}

/**
 * Display the Custom Option 1 URL.
 */
function cot_customoption1() {
	$options     = cot_getoptions();
	$link        = isset( $options['custom_option1'] ) ? trim( $options['custom_option1'] ) : '';

	if ( ! empty( $link ) ) {
		echo esc_url( $link );
	}
}

/**
 * Display the Custom Option 2 URL.
 */
function cot_customoption2() {
	$options     = cot_getoptions();
	$link        = isset( $options['custom_option2'] ) ? trim( $options['custom_option2'] ) : '';

	if ( ! empty( $link ) ) {
		echo esc_url( $link );
	}
}

/**
 * Output global header code in <head>.
 */
function cot_globalheader() {
	$options     = cot_getoptions();
	$global_code = isset( $options['header_global_code'] ) ? trim( $options['header_global_code'] ) : '';

	if ( ! empty( $global_code ) ) {
		echo wp_kses_post( $global_code );
	}
}
add_action( 'wp_head', 'cot_globalheader' );

/**
 * Output additional header code in <head>.
 */
function cot_headercode() {
	$options     = cot_getoptions();
	$header_code = isset( $options['header_code'] ) ? trim( $options['header_code'] ) : '';

	if ( ! empty( $header_code ) ) {
		echo wp_kses_post( $header_code );
	}
}
add_action( 'wp_head', 'cot_headercode' );

/**
 * Output footer code before </body>.
 */
function cot_footercode() {
	$options     = cot_getoptions();
	$footer_code = isset( $options['footer_code'] ) ? trim( $options['footer_code'] ) : '';

	if ( ! empty( $footer_code ) ) {
		echo wp_kses_post( $footer_code );
	}
}
add_action( 'wp_footer', 'cot_footercode' );

//Add js in plugin
add_action( 'admin_print_scripts', 'cot_customthemeoption_scripts' );
/**
 * Enqueues Custom Options Tree javascript files
 *
 * @since Custom Options Tree 1.0
 */
function cot_customthemeoption_scripts() {
	wp_enqueue_media();
	wp_enqueue_script( 'cot_customthemeoption_js', plugins_url('js/customoptiontree.js' , __FILE__ ), array( 'jquery', 'media-upload', 'thickbox' ), 1.2, true );

}

add_action( 'admin_print_styles', 'cot_customtheme_styles_admin' );
/**
 * enqueues 'Custom Options Tree' and 'WordPress thickbox' styles in admin and front end
 *
 * Conditionaly checks and inserts hover.css if required
 *
 * @since Custom Options Tree 1.0
 */
function cot_customtheme_styles_admin() {
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_style( 'stylesheet', plugins_url('css/customoptiontree.css', __FILE__), array(), 1.2 );
}

register_deactivation_hook('__FILE__', 'cot_customtheme_uninstall');
/**
 * removes Custom Options Tree options upon deactivation
 *
 * @since Custom Options Tree 1.0
 */
function cot_customtheme_uninstall() {
	delete_option('cot_options');
}
