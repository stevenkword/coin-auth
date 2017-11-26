=== Coin Auth ===
Contributors: dustyfresh
Tags: coinhive, recaptcha alternative, security, bots, recaptcha, nocaptcha, google, login
Requires at least: 4.2.2
Tested up to: 4.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Prevent brute force attacks on your WordPress site by utilizing Coinhive's proof of work captcha API.


== Description ==

This plugin prevents brute force logins on your WordPress website by implementing Coinhives's captcha API to verify login attempts via a proof of work authentication system. Coinhive will verify tokens that are received by performing small amounts of crypto-mining in the browser. Once the client receives a token they will submit it with their login request to Coinhive, which then verifies the one-time-use token to verify that amount of work was performed by the client requesting to authenticate to the site. Why would you want to do this? It deters attackers from submitting large amounts of valid login requests as it would require the adversary to perform a lot of crypto-mining for the administrator of the website and adds time to an already time-consuming task of cracking WordPress credentials.


== 3rd party tools used in this project & privacy ==

- Coinhive API / https://coinhive.com/documentation/http-api
- Coinhive Privacy policy / https://coinhive.com/info/privacy
- cryptocompare.com and authedmine.com are also associated with the Coihive API requests.


== Installation ==

1. Upload `coinhive-auth` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Register with coinhive.com
4. In the admin, go to Settings > Coinhive captcha and enter your API credentials
5. Click save

== Screenshots ==

1. WordPress login screen, unverified
2. WordPress login screen, verified
3. Coinhive captcha admin settings screen

== To do ==

1. Logging feature
2. Pull additional data about coinhive account to display in admin dashboard

== Changelog ==
= 1.0 =
* Initial fork and general release

/!\ This project was forked from version 1.6 of https://github.com/ashmatadeen/no-captcha /!\
=============================================================================================
= 1.6 =
* Support for bypassing the captcha for specific IP addresses when behind a proxy. Props to [Daniel Mann](https://github.com/dnlm)

= 1.5 =
* Support for bypassing the captcha for specific IP addresses. Props to [Daniel Mann](https://github.com/dnlm)

= 1.4.1 =
* Support for WooCommerce's login form

= 1.4 =
* Bug fix for when JavaScript is disabled/not available

= 1.3 =
* Initial release
