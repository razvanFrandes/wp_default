  <footer class="site-footer">

    <nav class="nav footer-nav">
      <?php wp_nav_menu( array( 'menu' => 'Main-Nav', 'theme_location' => 'footer', 'container' => false ) ); ?>
    </nav>
    <p class="legal"><?php echo SITE_NAME; ?> &copy; <?php echo date( 'Y' ); ?> All Rights Reserved</p>

  </footer>

  <?php wp_footer(); ?>

</body>

</html>
