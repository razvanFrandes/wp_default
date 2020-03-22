<?php
/**
 * A table of contents for the site PHP
 * Don't want one? Comment it out.
 */

include_once 'functions/functions-constants.php';

include_once 'functions/functions-assets.php';
if ( ! ALLOW_COMMENTS ) {
  include_once 'functions/functions-comments.php';
}
include_once 'functions/functions-errors.php';
include_once 'functions/functions-housekeeping.php';
include_once 'functions/functions-images.php';
include_once 'functions/functions-svg.php';
include_once 'functions/functions-menus.php';
include_once 'functions/functions-pages-posts.php';
include_once 'functions/functions-pagination.php';
include_once 'functions/functions-sidebars.php';
include_once 'functions/functions-yoast.php';
include_once 'functions/functions-custom-posts.php';


/**
 * YOUR FUNCTIONS
 * Any PHP you need to make you theme work goes below ... temporarily
 * At your earliest convenience, refactor these into sensibly named
 * files in the `/functions/` directory
 */