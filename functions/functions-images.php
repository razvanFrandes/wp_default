<?php

/**
 * Add Post Thumbnails
 */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 50, 50, true );
add_image_size( 'facebook', 600, 315, true );

/*
 *  ADD SUPPORT FOR VARIOUS THUMBNAIL SIZES
 *  http://codex.wordpress.org/Function_Reference/add_image_size
 */
if ( function_exists( 'add_image_size' ) ) {
  // add_image_size( 'post-thumb', 250, 140, true ); //(cropped)
}
