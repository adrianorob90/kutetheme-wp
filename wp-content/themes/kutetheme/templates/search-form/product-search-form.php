<?php 
$args = array(
  'show_option_none' => __( 'All Categries', 'kutetheme' ),
  'taxonomy'    => 'product_cat',
  'class'      => 'select-category',
  'hide_empty'  => 1,
  'orderby'     => 'name',
  'order'       => "desc",
  'tab_index'   => true,
  'hierarchical' => true
);
?>
<form class="form-inline woo-search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
  <div class="form-group form-category">
    <?php wp_dropdown_categories( $args ); ?>
  </div>
  <div class="form-group input-serach">
    <input type="hidden" name="post_type" value="product" />
    <input type="text" name="s"  placeholder="<?php _e('Keyword here...', 'kutetheme') ?>" />
  </div>
  <button type="submit" class="pull-right btn-search"></button>
</form>