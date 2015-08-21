<div class="entry-meta-data">
    <?php
    printf( '<span class="author vcard"><i class="fa fa-user"></i> '.__('by:', THEME_LANG ).'  <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', THEME_LANG ), get_the_author() ) ),
        get_the_author()
    );
    ?>
    <span class="cat"><i class="fa fa-folder-o"></i> <?php the_category(', '); ?></span>
    <span class="comment-count"><i class="fa fa-comment-o"></i> <?php comments_number(
        __('0', THEME_LANG),
        __('1', THEME_LANG),
        __('%', THEME_LANG)
    ); ?></span>
    <span class="date"><i class="fa fa-calendar"></i> <?php the_date();?></span>
</div>
<!--
<div class="post-star">
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star-half-o"></i>
    <span>(7 votes)</span>
</div>
-->