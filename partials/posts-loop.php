<?php
/**
 * Loop through the global `WP_Query`
 */
if ( have_posts() ) {

  echo '<ul class="hfeed">';

  while ( have_posts() ) {
    the_post();
    include TMPL_DIR . '/partials/post-preview.php';
  }

  echo '</ul>';

  if ( function_exists( 'pagination' ) ) pagination();

}