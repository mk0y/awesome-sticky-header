<?php
/*
Plugin Name: Awesome Sticky Header by DevCanyon
Contributors: markzero,nikolicdragan
Description: Awesome Sticky Header is a WordPress plugin that lets you control your sticky header.
Version: 1.0.1
Plugin URI: https://awesomeheader.com/
Author: DevCanyon
Author URI: http://devcanyon.com/
Network: True
Text Domain: awesomeheader

Awesome Sticky Header Plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (!function_exists('add_action')) {
  return;
}

if (defined('WP_INSTALLING') && WP_INSTALLING) {
  return;
}


define('ASMH_VERSION', '1.0.1');
define('ASMH_PATH', trailingslashit(dirname(__FILE__)));
define('ASMH_URL', plugins_url('', __FILE__));
define('ASMH_LANG', 'awesomeheader');
define('ASMH_ASSETS_DIR', ASMH_PATH . '/assets/');
define('ASMH_ASSETS_URL', ASMH_URL . '/assets/');


if (version_compare(PHP_VERSION, "5.4", "<")) {
  require_once(ASMH_PATH . 'admin/notices.php');
  add_action('admin_notices', 'asmh_phpversion');
  return;
}

// Define main entry point
require_once 'boot.php';

if (defined('ABSPATH') && defined('WPINC')) {
  asmh_init();
}
