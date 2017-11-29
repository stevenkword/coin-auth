<?php
/**
 * Plugin Name: coin-auth
 * Plugin URI: https://github.com/dustyfresh/coin-auth
 * Description: coinhive crypto-miner captcha WordPress plugin. Forked from version 1.6 of https://github.com/ashmatadeen/no-captcha
 *
 * @package coin-auth
 * Author: dustyfresh
 * Author URI: https://twitter.com/dustyfresh
 * Version: 1.0
 */

add_action( 'admin_menu', 'coin_auth_menu' );
add_action( 'admin_init', 'coin_auth_display_options' );
add_action( 'login_enqueue_scripts', 'coin_auth_login_form_script' );
add_action( 'login_form', 'coin_auth_render_login_captcha' );
add_filter( 'wp_authenticate_user', 'coin_auth_verify_login_captcha', 10, 2 );

// Specific support for WooCommerce login form!
// Using WooCommerce specific hooks because WooCommerce's login form does not use the expected wp_login_form().
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	add_action( 'woocommerce_login_form', 'coin_auth_render_login_captcha' );
	add_action( 'wp_enqueue_scripts', 'coin_auth_login_form_script' );
}

function coin_auth_menu() {
	add_options_page( 'Coin auth', 'Coin auth', 'manage_options', 'coinhive-options', 'coin_auth_options_page' );
}

function coin_auth_options_page() {
	?>
		<h2>Coinhive authentication for WordPress</h2>

		<div class="wrap">

			<div id="icon-options-general" class="icon32"></div>

			<div id="poststuff">

				<div id="post-body" class="metabox-holder columns-2">

					<!-- main content -->
					<div id="post-body-content">

						<div class="meta-box-sortables ui-sortable">

							<div class="postbox">
								<div class="inside">
									<form method="post" action="options.php">
										<?php
											settings_fields( 'coin_section' );
											do_settings_sections( 'coinhive-options' );
											submit_button();
										?>
									</form>

									<form method="post" action="options.php">
										<?php
											settings_fields( 'exlude_ips_section' );
											do_settings_sections( 'coinhive-exlude_ips-options' );
											submit_button();
										?>
									</form>

								</div>

							</div>
							<!-- .postbox -->

						</div>
						<!-- .meta-box-sortables .ui-sortable -->

					</div>
					<!-- post-body-content -->

					<!-- sidebar -->
					<div id="postbox-container-1" class="postbox-container">

						<div class="meta-box-sortables">

							<div class="postbox">
								<center>

								<h3>Monero conversions</h3>

								<div class="inside">
									<?php
										$monero = json_decode(file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=XMR&tsyms=BTC,USD,EUR", false));
										$xmr_to_btc = $monero->BTC;
										$xmr_to_usd = $monero->USD;
										$xmr_to_eur = $monero->EUR;
										echo "<p><b>BTC:</b> $xmr_to_btc</p>";
										echo "<p><b>USD:</b> $xmr_to_usd</p>";
										echo "<p><b>EUR:</b> $xmr_to_eur</p>";
									?>
									<!-- <a href="https://twitter.com/intent/tweet?screen_name=dustyfresh&ref_src=twsrc%5Etfw" class="twitter-mention-button" data-show-count="false">Tweet to @dustyfresh</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> !-->
								</div>
								<!-- .inside -->
							</center>
							</div>
							<!-- .postbox -->

						</div>
						<!-- .meta-box-sortables -->

					</div>
					<!-- #postbox-container-1 .postbox-container -->

				</div>
				<!-- #post-body .metabox-holder .columns-2 -->

				<br class="clear">
			</div>
			<!-- #poststuff -->

		</div> <!-- .wrap -->
	<?php
}



function coin_auth_display_options() {

	// add coinhive section to settings menu
	add_settings_section( 'coin_section', 'Coinhive auth Settings', 'coin_auth_display_coin_api_content', 'coinhive-options' );

	// Coinhive auth key Secret-key section
	add_settings_field( 'coin_auth_site_key', 'Site key', 'coin_auth_key_input', 'coinhive-options', 'coin_section' );
	add_settings_field( 'coin_auth_secret_key', 'Secret Key', 'coin_auth_secret_key_input', 'coinhive-options', 'coin_section' );
	register_setting( 'coin_section', 'coin_auth_site_key' );
	register_setting( 'coin_section', 'coin_auth_secret_key' );

	add_settings_field('coin_auth_hashcount','Hash count for proof of work (hashes goal should be a multiple of 256). The higher the number the longer the proof of work will take to recive access token.', 'coin_auth_hashcount_input', 'coinhive-options', 'coin_section');
	register_setting('coin_section', 'coin_auth_hashcount');
	if ( get_option( 'coin_auth_hashcount' ) === false ){ update_option( 'coin_auth_hashcount', '256' ); }

	// IP whitelist settings in options
	add_settings_section( 'exlude_ips_section', 'Whitelist IP addresses', 'coin_auth_display_coin_exlude_ips_content', 'coinhive-exlude_ips-options' );
	add_settings_field( 'coin_auth_exlude_ips', 'Whitelist', 'coin_auth_exlude_ips_input', 'coinhive-exlude_ips-options', 'exlude_ips_section' );
	add_settings_field( 'coin_auth_exlude_ips_forwarded_for', 'Cloudflare', 'coin_auth_exlude_ips_forwarded_for_input', 'coinhive-exlude_ips-options', 'exlude_ips_section' );
	register_setting( 'exlude_ips_section', 'coin_auth_exlude_ips' );
	register_setting( 'exlude_ips_section', 'coin_auth_exlude_ips_forwarded_for' );

}

function coin_auth_hashcount_input() {
	echo '<input type="text" name="coin_auth_hashcount" id="coin_auth_hashcount" value="' . esc_attr(get_option( 'coin_auth_hashcount' )) . '" />';
}

function coin_auth_display_coin_exlude_ips_content() {
	echo '<p>You can whitelist specific IP addresses (separated by comma) from having to complete the proof-of-work captcha:</p>';
}

function coin_auth_exlude_ips_input() {
	echo '<input size="60" type="text" name="coin_auth_exlude_ips" id="coin_auth_exlude_ips" value="' . esc_attr(get_option( 'coin_auth_exlude_ips' )) . '" />';
}

function coin_auth_display_coin_api_content() {
	echo 'Please register with <a href="https://coinhive.com/" target="_blank">Coinhive</a> to obtain the API keys and enter them below.</p>';
}

function coin_auth_key_input() {
	echo '<input type="text" name="coin_auth_site_key" id="captcha_site_key" value="' . esc_attr(get_option( 'coin_auth_site_key' )) . '" />';
}

function coin_auth_secret_key_input() {
	echo '<input type="password" name="coin_auth_secret_key" id="captcha_secret_key" value="' . esc_attr(get_option( 'coin_auth_secret_key' )) . '" />';
}

function coin_auth_exlude_ips_forwarded_for_input() {
	echo '<input type="checkbox" id="coin_auth_exlude_ips_forwarded_for" name="coin_auth_exlude_ips_forwarded_for" value="1"' . checked( 1, esc_attr(get_option( 'coin_auth_exlude_ips_forwarded_for' )), false ) . '/>';
}

function coin_auth_login_form_script() {
	if ( ! coin_auth_is_ip_excluded() ) {
		wp_register_script( 'coin_js', plugins_url( '/js/coinhive.js', __FILE__ ) );
		wp_enqueue_script( 'coin_js' );
		//wp_register_script( 'coin_auth_login', 'https://authedmine.com/lib/captcha.min.js' );
		//wp_enqueue_script( 'coin_auth_login' );
	}
}

function coin_auth_render_login_captcha() {
	// Set your keys or work will automatically happen **without proof verification**
	if ( !coin_auth_api_keys_set() && ! coin_auth_is_ip_excluded() ) {
		die("<h4 style='color: red;'>coinhive-auth API keys are not set! You must remove the plugin before being able to login again. Reinstall the plugin and configure Coinhive API keys.</h4>");
	}
	if ( coin_auth_api_keys_set() && ! coin_auth_is_ip_excluded() ) {
		echo '
		<script>
			function hide(id){
				var x = document.getElementById(id);
				if (x.style.display === "none") {
						x.style.display = "block";
				} else {
						x.style.display = "none";
				}
			}
			function callmemaybe(token) {
				document.getElementById("loginform").innerHTML += "<input type=\"hidden\" name=\"captcha_token\" value=\""+ token + "\">";
				hide("notice");
				hide("coinhive-auth");
				document.getElementById("alert").innerHTML += "<br/><font style=\'color: green;\'>Proof of work verification complete! You may now login to this WordPress.</font>";
			}
		</script>
			<div class="coinhive-captcha"
	name="coinhive-auth"
	id="coinhive-auth"
	data-hashes="' . esc_attr(get_option( 'coin_auth_hashcount' )) . ' "
	data-key="'. esc_attr(get_option( 'coin_auth_site_key' )) .'"
	data-whitelabel="true"
	data-disable-elements="input[type=submit]"
	data-callback="callmemaybe">
				<em>Loading Captcha...<br>
				If it does not load, please disable Adblock!</em>
			</div>
			<div id="alert"><font style="color: red;" id="notice">Verify captcha before logging in.</font><br/><a href="https://coinhive.com/info/captcha-help" target="_blank"><u>What is this?</u></a><br/>Disable adblock if you do not see "Verify me" box.</div>';
	}
}

function coin_auth_verify_login_captcha( $user, $password ) {
	$post_data = [
		'secret' => esc_attr(get_option( 'coin_auth_secret_key' )), // <- Your secret key
		'token' => $_POST['captcha_token'],
		'hashes' => esc_attr(get_option( 'coin_auth_hashcount' ))
	];
	$post_context = stream_context_create([
		'http' => [
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($post_data)
		]
	]);
	$url = 'https://api.coinhive.com/token/verify';
	$response = json_decode(file_get_contents($url, false, $post_context));

	if ($response && $response->success) {
		// All good. Token verified!
		return $user;
	}
}

function coin_auth_api_keys_set() {
	if ( get_option( 'coin_auth_secret_key' ) && get_option( 'coin_auth_site_key' ) ) {
		return true;
	} else {
		return false;
	}
}

function coin_auth_get_exlude_ips() {
	$exlude_ips = esc_attr(get_option( 'coin_auth_exlude_ips' ));
	if ( $exlude_ips ) {
		return array_map( 'trim', explode( ',', $exlude_ips ) );
	} else {
		return array();
	}
}

function coin_auth_get_client_ip() {
	$ipaddress = '';
	if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} elseif ( get_option( 'coin_auth_exlude_ips_forwarded_for' ) === '1' && isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}
	return $ipaddress;
}

function coin_auth_is_ip_excluded() {
	if ( coin_auth_get_client_ip() === 'UNKNOWN' ) {
		return false;
	} else {
		return in_array( coin_auth_get_client_ip(), coin_auth_get_exlude_ips() );
	}
}
