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
    wp_enqueue_style( 'theme-styles', get_stylesheet_directory_uri() . '/css/theme.css', $version_number );

    // Use non-minified JS files for local dev, otherwise load single concatinated app.js
	if( $debugging )  {
		
        wp_enqueue_script( 'concatinated-js', get_stylesheet_directory_uri() . '/js/app.js', array( 'jquery' ), $version_number, true );
        // ... add more scripts as you use them and don't include them in Gulp

	} 
	else {

    	wp_enqueue_script( 'minified-js', get_stylesheet_directory_uri() . '/js/app.min.js', array( 'jquery' ), $version_number, true );

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