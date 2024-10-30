<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function lc_mailchimp_scripts() {
	wp_enqueue_style('lc-mailchimp-style',plugin_dir_url(__FILE__).'style/style.css');
	wp_register_script( 'lc-mailchimp-js', plugin_dir_url( __FILE__ ) . 'js/lc.mailchimp.min.js', array('jquery'), '1.0.0' );
	wp_localize_script('lc-mailchimp-js', 'jakiez', array('url' => admin_url('admin-ajax.php')));
	wp_enqueue_script('jquery');
	wp_enqueue_script('lc-mailchimp-js');
}
add_action('init', 'lc_mailchimp_scripts');
function lc_mailchimp_footer() {
	echo "<script>var loadingImg = '".plugin_dir_url(__FILE__)."images/loading.gif';</script>";
}
add_action('get_footer','lc_mailchimp_footer');

if (is_admin()): // Load only if we are viewing admin page

add_action('admin_menu', 'lc_mailchimp_init');

function lc_mailchimp_init() {
    $page_title = 'Mailchimp for Live Composer by Jakiez';
    $menu_title = 'Mailchimp';
    $capability = 'edit_posts';
    $menu_slug = 'lc-mailchimp';
    $function = 'lc_mailchimp_admin_page';
    $icon_url = 'dashicons-email-alt';
    $position = 226;

    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    // add_submenu_page( 'dslc_plugin_options', 'My Custom Page', 'My Custom Page','manage_options', 'dslc_plugin_options');

    add_action( 'admin_init', 'lc_mailchimp_settings' );
}

function lc_mailchimp_settings() {
	register_setting('lc-mailchimp-settings','jakiez_settings');
}

function lc_mailchimp_admin_page() {
	global $settings; ?>
	<div class="wrap">
		<div id="welcome-panel" class="welcome-panel" style="padding:20px 10px">
			<div class="welcome-panel-content">
				<h2>Mailchimp for Live Composer!</h2>
				<p class="about-description">We’ve assembled some links to get you started:</p>
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h3>Configure</h3>
						<form method="post" action="options.php">
			    			<?php settings_fields( 'lc-mailchimp-settings' ); ?>
			    			<?php do_settings_sections('lc-mailchimp-settings' );?>
			    			<?php $settings = get_option('jakiez_settings'); ?>
			    			<p><label for="lc-mailchimp-api-key" style="margin-right:10px">API Key:</label><input type="text" id="lc-mailchimp-api-key" class="regular-text" name="jakiez_settings[mailchimp_api]" value="<?php echo $settings['mailchimp_api']; ?>" /></p>
							<input type="submit" name="submit" id="submit" class="button button-primary button-hero" value="Save Changes">
						</form>
					</div>
					<div class="welcome-panel-column">
						<h3>More Actions</h3>
						<ul>
							<li><a href="http://trangcongthanh.com/live-composer-mailchimp-extension/#mailchimp-api-key" target="_blank" class="welcome-icon dashicons-admin-network">HOW TO GET MAILCHIMP API KEYS?</a></li>
							<li><a href="http://trangcongthanh.com/live-composer-mailchimp-extension/#mailchimp-list-id" target="_blank" class="welcome-icon dashicons-list-view">HOW TO GET MAILCHIMP LIST ID?</a></li>
						</ul>
					</div>
					<div class="welcome-panel-column welcome-panel-last">
						<h3>Do you need help?</h3>
						<ul>
							<li><a href="http://trangcongthanh.com/live-composer-mailchimp-extension/" target="_blank" class="welcome-icon dashicons-admin-home">Plugin's Homepage</a></li>
							<li><a href="https://fb.com/jackytrang" target="_blank" class="welcome-icon dashicons-facebook-alt">Jakiez's Facebook</a></li>
							<li><a href="mailto:trangcongthanh91@gmail.com" target="_blank" class="welcome-icon dashicons-email-alt">Jakiez's Email</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php endif; ?>