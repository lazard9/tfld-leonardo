<?php

/**
 * Registers a custom block category in the Gutenberg editor.
 *
 * @package TFLD Leonardo
 */

add_filter( 'block_categories_all', function( $categories ) {

    // Adding a new category.
    $categories[] = array(
        'slug'  => 'leonardo',
        'title' => 'Leonardo',
    );

    return $categories;
}, 10, 2 );
