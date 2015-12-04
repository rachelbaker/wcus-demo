<?php
/**
 * Theme name: WCUS Demo
 *
 * @package wcus
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wcus_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'wcus_setup' );

/**
 * Enqueue scripts and styles.
 */
function wcus_scripts() {
	wp_enqueue_style( 'wcus-style', get_stylesheet_uri() );

	wp_register_script( 'director', 'https://rawgit.com/flatiron/director/master/build/director.min.js', array() );

	$version = filemtime( get_template_directory() . '/js/main.js' );

	wp_enqueue_script( 'wcus-main', esc_url( get_template_directory_uri() . '/js/main.js' ), array( 'jquery', 'underscore', 'director' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'wcus_scripts' );

/**
 * Prevent WP_Query from returning a 404.
 */
function wcus_override_routing() {
	global $wp_query;

	$wp_query->is_404 = false;

	status_header( 200 );
}
add_action( 'template_redirect', 'wcus_override_routing' );

