<?php get_header(); ?>

<main role="main" class="site-content">

  <section class="content">

    <h1 class="page-title">Search Results: <span><?php echo esc_attr( get_search_query() ); ?></span></h1>

    <h2>Search Again?</h2>

    <?php include TMPL_DIR . '/partials/search-form.php'; ?>

    <?php include TMPL_DIR . '/partials/posts-loop.php'; ?>

  </section>

  <?php get_sidebar(); ?>

</main>

<?php get_footer(); ?>
