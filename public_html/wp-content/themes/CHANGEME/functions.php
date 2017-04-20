<?php

// Debugging 
$debugging = false;
if ( SERVER_ENVIRONMENT === 'dev' ) $debugging = true;


//
// Stylesheets and Javascript
//

function theme_scripts_styles() {

    $version_number = '0.1';
	global $debugging;

    // Theme registration stylesheet, combined theme stylesheet and any other necessary styles
    wp_enqueue_style( 'registration-stylesheet', get_stylesheet_directory_uri() . '/style.css', $version_number );

    // Use JS files with looser linting for local dev
	if( $debugging )  {
		
        wp_enqueue_script( 'dev-js', get_stylesheet_directory_uri() . '/dist/app.js', array( 'jquery' ), $version_number, true );
        wp_enqueue_style( 'dev-styles', get_stylesheet_directory_uri() . '/dist/styles.css', $version_number );

	} 
	else {

    	wp_enqueue_script( 'prod-js', get_stylesheet_directory_uri() . '/build/app.js', array( 'jquery' ), $version_number, true );
        wp_enqueue_style( 'prod-styles', get_stylesheet_directory_uri() . '/build/styles.css', $version_number );

    }

}

add_action( 'wp_enqueue_scripts', 'theme_scripts_styles' );

function theme_setup() {

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // This theme uses wp_nav_menu() some locations
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu' ),
        )
    );

    //  Enable featured images for posts
    add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'theme_setup' );

// Custom WP Walker
@include 'utilities/walker.php';