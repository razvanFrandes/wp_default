<?php
/**
 * Add excerpt to pages
 */
function az_add_excerpts_to_pages()
{
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'az_add_excerpts_to_pages');

/**
 * Add class to excerpt
 */
function az_add_class_to_excerpt($excerpt)
{
    return str_replace('<p', '<p class="post-excerpt"', $excerpt);
}
add_filter('the_excerpt', 'az_add_class_to_excerpt');

/**
 * Add next and prev classes to previous/next post links
 */
function az_add_class_prev_link($class)
{
    return str_replace('<a', '<a class="prev-post"', $class);
}
add_filter('previous_post_link', 'az_add_class_prev_link');

function az_add_class_next_link($class)
{
    return str_replace('<a', '<a class="next-post"', $class);
}
add_filter('next_post_link', 'az_add_class_next_link');

/**
 * Get a Page's ID by slug
 * http://erikt.tumblr.com/post/278953342/get-a-wordpress-page-id-with-the-slug
 */
function get_id_by_slug($page_slug, $post_type = 'page')
{
    $page = get_page_by_path($page_slug, 'OBJECT', $post_type);
    if ($page)
    {
        return $page->ID;
    }
    else
    {
        return null;
    }
}

/**
 * Check If Page Is Child
 * http://bavotasan.com/2011/is_child-conditional-function-for-wordpress/
 */
function is_child($page_id_or_slug)
{
    // $page_id_or_slug = The ID of the page we're looking for pages underneath
    global $post;
    // load details about this page
    if (!is_numeric($page_id_or_slug))
    {
        // Used this code to change a slug to an ID, but had to change is_int to is_numeric for it to work.
        $page = get_page_by_path($page_id_or_slug);
        if (isset($page))
        {
            $page_id_or_slug = $page->ID;
            if (is_page() && ($post->post_parent == $page_id_or_slug)) return true;
            // we're at the page or at a sub page
            else return false;
            // we're elsewhere
            
        }
        else
        {
            return false;
        }
    }
}

/**
 * Check If Page Is Parent/Child/Ancestor
 * http://css-tricks.com/snippets/wordpress/if-page-is-parent-or-child/#comment-172337
 */
function is_tree($page_id_or_slug)
{
    // $page_id_or_slug = The ID of the page we're looking for pages underneath
    global $post;

    // load details about this page
    if (!is_numeric($page_id_or_slug))
    {
        // Used this code to change a slug to an ID, but had to change is_int to is_numeric for it to work: http://bavotasan.com/2011/is_child-conditional-function-for-wordpress/
        $page = get_page_by_path($page_id_or_slug);
        $page_id_or_slug = $page->ID;
    }
    if (is_page() && ($post->post_parent == $page_id_or_slug || (is_page($page_id_or_slug) || in_array($page_id_or_slug, $post->ancestors)))) return true;
    // we're at the page or at a sub page
    else return false;
    // we're elsewhere
    
}

/**
 * Remove brackets from ellipse
 */
function az_excerpt_ellipse($text)
{
    return str_replace(array(
        '[...]',
        '[&hellip;]'
    ) , '&hellip;', $text);
}
add_filter('get_the_excerpt', 'az_excerpt_ellipse');