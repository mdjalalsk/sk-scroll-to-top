<?php
/**
* Plugin Name:       SK Scroll To Top
* Plugin URI:        https://github.com/mdjalalsk/
* Description:       This plugin to add a customizable "Scroll to Top" button.
* Version:           1.0.0
* Requires at least: 6.5
* Requires PHP:      7.2
* Author:            Jalal
* Author URI:        https://jalal.blog
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       sk-scroll-to-top
* Domain Path:       /languages
* Requires Plugins:  WooCommerce
*/

/**
 * SK Scroll to Top is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * SK Scroll to Top is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SK Scroll to Top. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require plugin_dir_path( __FILE__ ) . 'inc/class-skst-admin.php';

function sk_scroll_to_top_init() {
    return SKST_Admin::get_instance(__FILE__,'1.0.0');
}
sk_scroll_to_top_init();
