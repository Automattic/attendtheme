<?php
//  Exit if accessed directly.
defined('ABSPATH') || exit;

// Only load if Gutenberg is available.
if ( ! function_exists( 'register_block_type' ) ) {
	return;
}

/**
 * Enqueue block editor only JavaScript and CSS
 */
function attend_editor_scripts() {

    // Make paths variables so we don't write em twice ;)
    $blockPath = get_template_directory_uri() . '/inc/gutenberg/assets/js/editor.blocks.js';
    $editorStylePath = get_template_directory_uri() . '/inc/gutenberg/assets/css/blocks.editor.css';

    // Enqueue the bundled block JS file
    wp_enqueue_script(
        'attend-blocks-js',
        $blockPath,
        [ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' ]
    );

    // Enqueue optional editor only styles
    wp_enqueue_style(
        'attend-blocks-editor-css',
        $editorStylePath,
        [ 'wp-blocks' ]
    );

}

// Hook scripts function into block editor hook
add_action( 'enqueue_block_editor_assets', 'attend_editor_scripts' );

/**
 * Enqueue front end and editor JavaScript and CSS
 */
function attend_gutenberg_scripts() {
    $blockPath = get_template_directory_uri() . '/inc/gutenberg/assets/js/frontend.blocks.js';
    // Make paths variables so we don't write em twice ;)
    $stylePath = get_template_directory_uri() . '/inc/gutenberg/assets/css/blocks.style.css';

    // Enqueue the bundled block JS file
    wp_enqueue_script(
        'attend-blocks-frontend-js',
        $blockPath,
        [ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' ]
    );

    // Enqueue frontend and editor block styles
    wp_enqueue_style(
        'attend-blocks-css',
        $stylePath,
        [ 'wp-blocks' ]
    );

}

// Hook scripts function into block editor hook
add_action('enqueue_block_assets', 'attend_gutenberg_scripts');

// Add Custom Blocks
require get_template_directory() . '/inc/gutenberg/blocks/cover-image/index.php';