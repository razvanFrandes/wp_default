<?php

/*
 * 410 Error Code Reponse Header
 * Note: This allows you to specify 410 RewriteRules in the .htaccess to use a custom 410.php WordPress template.
 * Source: http://otroblogmas.com/retornar-410-wordpress/
 */
function az_response_410( $template ) {
  if( is_404() && '410' == $_SERVER['REDIRECT_STATUS'] ) {
    status_header( 410 );
    if( file_exists( SS_DIR . '/410.php' ) ) {
      return SS_DIR . '/410.php';
    }
  }
  return $template;
}
add_filter( 'template_include', 'az_response_410' );
