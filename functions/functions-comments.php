<?php
/**
 * Disable WordPress Comments
 * http://www.dfactory.eu/wordpress-how-to/turn-off-disable-comments/
 */

/**
 * Disable support for comments and trackbacks in post types
 */
function az_disable_comments_post_types_support() {
  $post_types = get_post_types();
  foreach ( $post_types as $post_type ) {
    if ( post_type_supports( $post_type, 'comments' ) ) {
      remove_post_type_support( $post_type, 'comments' );
      remove_post_type_support( $post_type, 'trackbacks' );
    }
  }
}
add_action('admin_init', 'az_disable_comments_post_types_support');

/**
  * Close comments on the front-end
 */
function az_disable_comments_status() {
  return false;
}
add_filter( 'comments_open', 'az_disable_comments_status', 20, 2 );
add_filter( 'pings_open', 'df_disable_comments_status', 20, 2 );

/**
 * Hide existing comments
 */
function az_disable_comments_hide_existing_comments($comments) {
  $comments = array();
  return $comments;
}
add_filter( 'comments_array', 'az_disable_comments_hide_existing_comments', 10, 2 );

/**
 * Remove comments page in menu
 */
function az_disable_comments_admin_menu() {
  remove_menu_page('edit-comments.php');
}
add_action( 'admin_menu', 'az_disable_comments_admin_menu' );

/**
 * Redirect any user trying to access comments page
 */
function az_disable_comments_admin_menu_redirect() {
  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url()); exit;
  }
}
add_action( 'admin_init', 'az_disable_comments_admin_menu_redirect' );

/**
 * Remove comments metabox from dashboard
 */
function az_disable_comments_dashboard() {
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'az_disable_comments_dashboard' );

/**
 * Remove comments links from admin bar
 */
function az_disable_comments_admin_bar() {
  if ( is_admin_bar_showing() ) {
    remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
  }
}
add_action( 'init', 'az_disable_comments_admin_bar' );

/**
 * Remove Recent Comments CSS from head
 */
function az_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'  ) );
}
add_action( 'widgets_init', 'az_remove_recent_comments_style' );
