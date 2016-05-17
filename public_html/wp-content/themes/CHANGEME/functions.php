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
		
        wp_enqueue_script( 'theme-scripts', get_stylesheet_directory_uri() . '/js/interaction.js', array( 'jquery' ), $version_number, true );
        // ... add more scripts as you use them

	} 
	else {

    	wp_enqueue_script( 'all-js', get_stylesheet_directory_uri() . '/js/app.js', array( 'jquery' ), $version_number, true );

    }

    // Only load (beefy) visualization scripts

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

    // Replaces the excerpt "more" text
    // function new_excerpt_more($more) {
    //     global $post;
    //     return '<a class="more-tag" href="'. get_permalink($post->ID) . '">Read more</a>';
    // }
    // add_filter('excerpt_more', 'new_excerpt_more');

}

add_action( 'after_setup_theme', 'theme_setup' );

// Custom WP Walker
@include 'utilities/walker.php';