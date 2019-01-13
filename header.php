<!doctype html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="initial-scale=1.0">
  <?php wp_head(); ?>

</head>

<body <?php body_class(); ?> >
  <header role="banner" class="site-header">

    <a href="<?php echo WWW_URL; ?>" class="site-logo"><?php echo SITE_NAME; ?></a>
    <nav role="navigation" class="nav main-nav">
      <?php wp_nav_menu( array( 'menu' => 'Main-Nav', 'theme_location' => 'primary', 'container' => false ) ); ?>
    </nav>

  </header>
