<?php

if ( function_exists( 'register_block_type' ) ) {
	function attend_render_block_cover_image( $attributes, $content ) {
		return sprintf(
			'<div class="wp-block-cover-image-wrapper">%1$s</div>',
			$content
		);
	}

	register_block_type( 'core/cover-image', array(
		'render_callback' => 'attend_render_block_cover_image',
	) );
}