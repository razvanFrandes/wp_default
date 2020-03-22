<?php
/**
 * Remove junk from <head>
 * Source: http://digwp.com/2010/03/wordpress-functions-php-template-custom-functions
 * https://wordpress.org/support/topic/removing-emoji-code-from-header?replies=7#post-6864480
 */
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'wp_resource_hints', 2); // remove WP 4.9+ dns-prefetch nonsense
remove_action('wp_head', 'rest_output_link_wp_head', 10);

// Remove Emoji code from header
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

/**
 * Remove Query Strings from Static Resources
 */
function dequeue_jquery_migrate(&$scripts)
{
    if (!is_admin())
    {
        $scripts->remove('jquery');
    }
}
add_filter('wp_default_scripts', 'dequeue_jquery_migrate');

/**
 * Remove wp-embeded.js from footer
 */
function my_deregister_wp_embeded()
{
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'my_deregister_wp_embeded');

/**
 * Remove Query Strings from Static Resources
 * Source: http://forwpblogger.com/tutorial/remove-query-strings-from-static-resources/
 */
function _remove_script_version($src)
{
    $parts = explode('?ver=', $src);
    $parts = explode('&ver=', $parts[0]);
    return $parts[0];
}
add_filter('script_loader_src', '_remove_script_version', 15, 1);
add_filter('style_loader_src', '_remove_script_version', 15, 1);

/**
 * Add new classes to the $classes array
 * http://codex.wordpress.org/Function_Reference/body_class#Add_Classes_By_Filters
 */
add_filter('body_class', 'my_class_names');
function my_class_names($classes)
{
    global $post;
    if (is_front_page()):
        $classes[] = 'home';
    elseif (is_page()):
        $classes[] = $post->post_name;
    elseif (is_archive()):
        $classes[] = 'archive';
    elseif (is_404()):
        $classes[] = 'error';
    elseif (is_search()):
        $classes[] = 'search';
    endif;
    return $classes;
}

/**
 * Add correct title tag support
 */

add_theme_support('title-tag');

//Disable gutenberg style in Front
function wps_deregister_styles()
{
    wp_dequeue_style('wp-block-library');
}

add_action('wp_print_styles', 'wps_deregister_styles', 100);