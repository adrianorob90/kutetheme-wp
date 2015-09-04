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
    $page_class="";
    if(isset($option_page['kt_page_extra_class'])){
    	$page_class= $option_page['kt_page_extra_class'][0];
    }
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($page_class); ?>>
    <?php if( isset( $option_page[ 'kt_show_page_title' ] ) ): ?>
    	<header class="entry-header">
    	<h1 class="page-heading">
            <span class="page-heading-title2"><?php the_title();?></span>
        </h1>
        </header>
    <?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'kutetheme' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'kutetheme' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
