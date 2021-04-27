<?php
/**
 * Plugin Name:       Elementor custom dynamic content tags
 * Description:       This plugin will let you chose from all post_meta fields and taxonomies in the current system and will return the actual value to Elementor.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            garyee
 * Author URI:        https://github.com/garyee
 * License:           Public domain
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'elementor/dynamic_tags/register_tags', function( $dynamic_tags ) {

	// In our Dynamic Tag we use a group named request-variables so we need 
	// To register that group as well before the tag
	\Elementor\Plugin::$instance->dynamic_tags->register_group( 'custom', [
		'title' => 'Custom' 
	] );


	// Include the Dynamic tag class file
	include_once( 'my_tag.php' );
	include_once( 'my_tax.php' );

	// Finally register the tag
	$dynamic_tags->register_tag( 'Elementor_post_meta' );
	$dynamic_tags->register_tag( 'Elementor_custom_tax' );
} );

 ?>