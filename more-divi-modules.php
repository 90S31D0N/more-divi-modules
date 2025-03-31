<?php
/*
Plugin Name: More Divi Modules
Plugin URI:  
Description: 
Version:     1.0.1
Author:      Noël Schaller
Author URI:  
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: mdm-more-divi-modules
Domain Path: /languages

More Divi Modules is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

More Divi Modules is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with More Divi Modules. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'mdm_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function mdm_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/MoreDiviModules.php';
}
add_action( 'divi_extensions_init', 'mdm_initialize_extension' );
endif;

// Add the settings page to the WordPress admin menu
require_once plugin_dir_path( __FILE__ ) .'includes/settings.php';