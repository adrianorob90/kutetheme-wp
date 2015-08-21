<div <?php post_class('post-item'); ?>>
<article class="entry">
    <div class="row">
        <?php if(has_post_thumbnail()):?>
        <div class="col-sm-5">
            <div class="entry-thumb image-hover2">
                <a href="<?php the_permalink();?>">
                    <?php the_post_thumbnail('post-thumb');?>
                </a>
            </div>
        </div>
        <div class="col-sm-7">
        <?php else:?>
        <div class="col-sm-12">
        <?php endif;?>
            <div class="entry-ci">
                <h3 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                <?php get_template_part( 'templates/post','meta' );?>
                <div class="entry-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                <div class="entry-more">
                    <a href="<?php the_permalink();?>"><?php _e('Read more', THEME_LANG );?></a>
                </div>
            </div>
        </div>
    </div>
</article>
</div>