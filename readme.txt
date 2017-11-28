=== Coin Auth ===
Contributors: dustyfresh
Tags: coinhive, bruteforce, brute-force, brute, attack, monero, mining, recaptcha alternative, security, bots, recaptcha, nocaptcha, google, login
Requires at least: 4.2.2
Tested up to: 4.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Prevent and monetize brute force attacks on your WordPress site with proof-of-work authentication.


== Description ==

This plugin deters brute-force attacks on the WordPress admin dashboard by implementing a "proof-of-work" authentication workflow using the Coinhive.com captcha API (requires a Coinhive.com account). From the site owner's perspective this is the same as requiring Google's re-captcha to be completed before being allowing a login request to the WordPress site. What makes this a nice alternative to other systems that use captcha at login is that the user just has to click verify and wait for their web-browser to complete a predetermined amount of "work" by mining a small amount of cryptocurrency, instead of picking out street-signs or cars from random images, before being allowed to submit a login request. The small amount of cryptocurrency that is generated is sent to the site's administrator, even if the username/password is incorrect. The idea is to deter brute-force attacks on WordPress sites by introducing this economic control.


== Installation ==

1. Upload `coin-auth` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Register with coinhive.com -> Dashboard -> Sites & API Keys -> Copy API credentials (Site Key, and Secret Key)
4. In the admin dashboard, go to Settings -> Coin auth and enter your API credentials
5. Click save

== Screenshots ==

1. WordPress login screen, unverified
2. WordPress login screen, verified
3. Coinhive captcha admin settings screen

== To do ==

1. Logging feature
2. Pull additional data about coinhive account to display in admin dashboard

== 3rd party tools used in this project & privacy ==

- Coinhive API / https://coinhive.com/documentation/http-api
- Coinhive Privacy policy / https://coinhive.com/info/privacy
- cryptocompare.com and authedmine.com are also associated with the Coihive API requests.

== Additional reading ==

- https://en.wikipedia.org/wiki/Proof-of-work_system
- https://coinhive.com/documentation

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
