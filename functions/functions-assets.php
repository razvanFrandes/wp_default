<?php
/**
 * Load Development Styles/Scripts (for local)
 */
function az_load_dev_styles_scripts()
{
    // Theme styles
    wp_enqueue_style('main', SS_URI . '/assets/dist/css/style.css', false, null, 'all');
    // Footer Scripts
    wp_enqueue_script('main', SS_URI . '/assets/dist/js/app.js', array(
        'jquery'
    ) , null, true);
}

if (WP_DEBUG) add_action('wp_enqueue_scripts', 'az_load_dev_styles_scripts');

/**
 * Load Distribution Styles/Scripts (for staging and production)
 */
function az_load_prod_styles_scripts()
{
    // Theme styles
    wp_enqueue_style('main', SS_URI . '/assets/dist/css/style.min.css', false, null, 'all');
    // Footer Scripts
    wp_enqueue_script('main', SS_URI . '/assets/dist/js/app.min.js', array(
        'jquery'
    ) , null, true);
}
if (!WP_DEBUG) add_action('wp_enqueue_scripts', 'az_load_prod_styles_scripts');