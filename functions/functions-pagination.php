<?php
/*
 * PAGINATION
 *
  <ol class="pagination">
    <li class=pagination-first>First</li>
    <li class=pagination-prev>Previous</li>
    <li><a href=/page/1>1</a></li>
    <li><a href=/page/2>2</a></li>
    <li class=current><a href=/page/3>3</a></li>
    <li><a href=/page/4>4</a></li>
    <li><a href=/page/5>5</a></li>
    <li class=pagination-next><a href=/page/next>Next</a></li>
    <li class=pagination-last><a href=/page/last>Last</a></li>
   </ol>
 */
function pagination( $query = '', $paged = '', $pages = '', $range = 2 ) {
  $showitems = ( $range * 2 ) + 1;
  if ( $query == '' ) {
    global $wp_query;
    $query = $wp_query;
  }

  if ( $paged == '' ) {
    $paged = ( get_query_var( 'paged' ) )
           ? get_query_var( 'paged' )
           : 1;
  }

  if ( $pages == '' ) {
    $pages = $query->max_num_pages;

    if ( ! $pages ) {
      $pages = 1;
    }
  }

  if ( $pages != 1 ) {
    echo '<ol class="pagination">';

    if ( $paged > 1 ) {
      echo '<li class="pagination-prev"><a href="' . get_pagenum_link( $paged - 1 ) . '">Prev</a></li>';
    }

    if ( $paged > 2 && $paged > ( $range + 1 ) && $showitems < $pages ) {
      echo '<li><a href="' . get_pagenum_link(1) . '">1</a></li><li class="pagination-more"><span>&#8230;</span></li>';
    }

    for ( $i = 1; $i <= $pages; $i++ ) {
      if ( 1 != $pages && ( !( $i >= ( $paged + $range + 1 ) || $i <= ( $paged - $range - 1 ) ) || $pages <= $showitems ) ) {
        echo ( $paged == $i )
             ? '<li class="pagination-curr"><span>' . $i . '</span></li>'
             : '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
             // This line displays the page number links
      }
    }

    if ( $paged < ( $pages - 1 ) && ( $paged + $range - 1 ) < $pages && $showitems < $pages ) {
      echo '<li class="pagination-more"><span>&#8230;</span></li><li><a href="' . get_pagenum_link( $pages ) . '">' . $pages . '</a></li>';
    }

    if ( $paged < $pages ) {
      echo '<li class="pagination-next"><a href="' . get_pagenum_link( $paged + 1 ) . '">Next</a></li>';
    }

    echo '</ol>';
  }
}
