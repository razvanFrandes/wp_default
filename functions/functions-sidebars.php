<?php

if ( function_exists( 'register_sidebar' )  ) {
  register_sidebar( array(
    'name'            => 'Pages',
    'id'              => 'pages-sidebar',
    'before_widget'   => '<li id="%1$s" class="widget %2$s">',
    'after_widget'    => '</li>',
    'before_title'    => '<h2>',
    'after_title'     => '</h2>',
  ) );
}
