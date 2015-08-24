<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Kute Theme
 * @since Kute Theme 1.0
 */
?>
<?php 
    $option_page = get_post_meta( get_the_ID()) ;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if( isset( $option_page[ '_kt_page_page_title' ] ) ): ?>
    	<header class="entry-header">
    		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    	</header><!-- .entry-header -->
    <?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', THEME_LANG ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', THEME_LANG ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
