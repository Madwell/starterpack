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