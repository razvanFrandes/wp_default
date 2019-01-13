<?php

/**
 * Custom Menus
 */
add_theme_support( 'menus' );
/**
 * This theme uses wp_nav_menu() in two locations
 */
register_nav_menus( array(
  'primary' => 'Header Primary Menu',
  'footer'  => 'Footer Menu',
) );

/** Add Parent Class to menu items
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu#How_to_add_a_parent_class_for_menu_item
 */
add_filter( 'wp_nav_menu_objects', function( $items ) {
  $hasSub = function( $menu_item_id, $items ) {
    foreach ( $items as $item ) {
      if ( $item->menu_item_parent && $item->menu_item_parent==$menu_item_id ) {
        return true;
      }
    }
    return false;
  };
  foreach ( $items as &$item ) {
    if ( $hasSub( $item->ID, $items ) ) {
      $item->classes[] = 'parent-item'; // all elements of field "classes" of a menu item get join together and render to class attribute of <li> element in HTML
    }
  }
  return $items;
});
