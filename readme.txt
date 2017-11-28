=== Coin Auth ===
Contributors: dustyfresh
Tags: coinhive, bruteforce, brute-force, brute, attack, monero, mining, recaptcha alternative, security, bots, recaptcha, nocaptcha, google, login
Requires at least: 4.2.2
Tested up to: 4.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Deter and monetize brute force attacks on your WordPress site with proof-of-work authentication. Similar to Google's reCAPTCHA at authentication. No more picking out street signs, cars, or storefronts!


== Description ==

This plugin deters brute-force attacks on the WordPress admin dashboard by implementing a "proof-of-work" authentication workflow using the Coinhive.com captcha API. This plugin requires a Coinhive.com account to mine cryptocurrency in the browser. The server will verify the amount of work completed by the client and allow a login request to wp-login.php if verification is successful. We hope to deter brute-force attacks on WordPress sites by introducing this economic control.

== FAQs ==

Q: What is cryptocurrency?
A: Magical internet money! Cryptocurrency like bitcoin, and others, are "mined" by solving complex mathematical problems. See additional reading section of this readme to learn more.

Q: What is a brute-force attack?
A: In terms of WordPress, it's when an adversary tries to guess your password by submitting a lot of login requests.

Q: Will I get rich off of brute force attacks?!
A: More than likely not, but adversaries will waste a lot of time trying to guess your password.

Q: Does this mine Bitcoins in the browser?
A: No, the coinhive API only supports Monero

Q: Is this officially supported, or endorsed by Coinhive.com?
A: No, I am an individual developer and have designed this plugin on my own accord for research. If you need support please visit the Github repo and open an issue.

Q: How do I get money from this plugin?
A: The goal here is to deter brute-force login attacks and waste adversaries time, not to make lots of money. There is cryptocurrency that is generated from each login request and can be deposited to the monero wallet of your choice. This is all configurable in the Coinhive.com dashboard.


== Installation ==

1. Upload `coin-auth` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Register with coinhive.com -> Dashboard -> Sites & API Keys -> Copy API credentials (Site Key, and Secret Key)
4. In the admin dashboard, go to Settings -> Coin auth and enter your API credentials
5. Click save


== Screenshots ==

1. WordPress login screen, unverified
2. WordPress login screen, verified
3. Coin auth admin settings screen


== To do ==

1. Logging feature
2. Pull additional data about coinhive account to display in admin dashboard
3. Assign additional work to brute-force offenders automatically


== Additional reading ==

- 
- https://en.wikipedia.org/wiki/Proof-of-work_system
- https://coinhive.com/documentation


== 3rd party tools used in this project & privacy ==

- Coinhive API / https://coinhive.com/documentation/http-api
- Coinhive Privacy policy / https://coinhive.com/info/privacy
- cryptocompare.com and authedmine.com are also associated with the Coihive API requests.

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
