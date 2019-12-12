<?php


define( 'WP_ENV',        'local' );
define( 'WWW_URL',       site_url() );
define( 'TMPL_URI',      get_template_directory_uri() );
define( 'IMG_DIR',       TMPL_DIR . '/assets/dist/img/' );
define( 'IMG_SRC',       TMPL_URI . '/assets/dist/img/' );
define( 'SITE_NAME',     get_option( 'blogname' ) );
define( 'SITE_TAGLINE',  get_option( 'blogdescription' ) );
define( 'AUTHOR',        SITE_NAME . ' - '. WWW_URL );
define( 'SS_URI',        get_stylesheet_directory_uri() );
define( 'SS_DIR',        get_stylesheet_directory() );
define( 'DEFAULT_PHOTO', '//placehold.it/300x200/222/fff/&text=Photo+Not+Available' );
define( 'ALLOW_COMMENTS', false );
//define( 'TYPEKIT',      '123456' );
//define( 'FB_APP_ID',    '' );
//define( 'FB_PAGE',      '' );
//define( 'TWITTER_USERNAME',       '' );
//define( 'GOOGLE_PLUS_AUTHOR',     '' );
//define( 'GOOGLE_PLUS_PUBLISHER',  '' );
