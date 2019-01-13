<?php get_header(); ?>

<main role="main" class="site-content">

  <section class="content">

    <h1 class="page-title">Page Not Found</h1>
    <p>The Page you are looking for does not exist.</p>

    <h2>Search the Site</h2>
    <?php include TMPL_DIR . '/partials/search-form.php'; ?>

    <?php
    $query = new WP_Query( 'posts_per_page=5' );
    if ( $query->have_posts() ) {
    ?>

    <h2>Latest posts</h2>
    <ul class="hfeed">
    <?php
      while ( $query->have_posts() ) {
        $query->the_post();
        include TMPL_DIR . '/partials/post-preview.php';
      }
      wp_reset_postdata();
    ?>
    </ul>

    <?php } ?>

  </section>

  <?php get_sidebar(); ?>

</main>

<?php get_footer(); ?>
