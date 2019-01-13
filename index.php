<?php
  get_header();
  $blog_page_id     = get_option( 'page_for_posts' );
  $blog_page_title  = get_the_title( $blog_page_id );
?>

<main role="main" class="site-content">

  <section class="content">

    <?php edit_post_link( 'Edit', '<p>', '</p>', $blog_page_id ); ?>
    <h1 class="page-title"><?php echo $blog_page_title; ?></h1>

    <?php include TMPL_DIR . '/partials/posts-loop.php'; ?>

  </section>

  <?php get_sidebar(); ?>

</main>

<?php get_footer(); ?>
