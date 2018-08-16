<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Attend
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function attend_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'attend_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function attend_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'attend_pingback_header' );

/*
 * Add an extra li to our nav for our priority+ navigation to use
 */
function attend_add_ellipses_to_nav( $items, $args ) {
	if ( 'menu-1' === $args->theme_location ) :
		$items .= '<li id="more-menu" class="menu-item menu-item-has-children">';
		$items .= '<button class="dropdown-toggle" aria-expanded="false">';
		$items .= '<span class="screen-reader-text">'. esc_html( 'More', 'attend' ) . '</span>';
		$items .= attend_get_svg( array( 'icon' => 'ellipsis' ) );
		$items .= '</button>';
		$items .= '<ul class="sub-menu"></ul></li>';
	endif;
	return $items;
}
add_filter( 'wp_nav_menu_items', 'attend_add_ellipses_to_nav', 10, 2 );

function attend_add_ellipses_to_page_menu( $items, $args ) {

	$items .= '<li id="more-menu" class="menu-item menu-item-has-children">';
	$items .= '<button class="dropdown-toggle" aria-expanded="false">';
	$items .= '<span class="screen-reader-text">'. esc_html( 'More', 'attend' ) . '</span>';
	$items .= attend_get_svg( array( 'icon' => 'ellipsis' ) );
	$items .= '</button>';
	$items .= '<ul class="sub-menu"></ul></li>';

    return $items;
}
add_filter( 'wp_list_pages', 'attend_add_ellipses_to_page_menu', 10, 2 );

function attend_format_comment( $comment, $args, $depth ) {

	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						if ( 0 != $args['avatar_size'] ) {
							?>
							<div class="comment-author-avatar">
								<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
							</div> <?php
						}

						/* translators: %s: comment author link */
						printf(
							__( '%s' ),
							sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
						);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
								/* translators: 1: comment date, 2: comment time */
								printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			comment_reply_link(
				array_merge(
					$args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					)
				)
			);
			?>
		</article><!-- .comment-body -->
	<?php
}