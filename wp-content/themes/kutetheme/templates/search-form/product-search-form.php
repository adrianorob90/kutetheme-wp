<?php 
$args = array(
  'show_option_none' => esc_attr__( 'All Categries', 'kutetheme' ),
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
    <input value="<?php echo esc_attr( get_search_query() );?>" type="text" name="s"  placeholder="<?php esc_attr_e( 'Keyword here...', 'kutetheme' ); ?>" />
  </div>
  <button type="submit" class="pull-right btn-search"></button>
</form>