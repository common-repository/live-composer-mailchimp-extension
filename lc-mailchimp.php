<?php
/**
 *	Plugin Name: Live Composer MailChimp Extension
 *	Plugin URI: http://trangcongthanh.com/live-composer-mailchimp-extension/
 *	Description: Adds a new module for subscriber intergration with MailChimp.
 *	Author: Trang Công Thành
 *	Version: 1.0
 *	Author URI: http://trangcongthanh.com
 *  License: GPL2
 *  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *  Domain Path: /lang
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

include_once('lc-mailchimp-admin.php');
include_once('lc-mailchimp-module.php');
include_once('lc-mailchimp-ajax.php');