<form class="form-inline blog-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
      <div class="form-group input-serach">
        <input type="hidden" name="post_type" value="post" />
        <input value="<?php echo esc_attr( get_search_query() );?>" type="text" name="s"  placeholder="<?php _e('Keyword here...', 'kutetheme') ?>" />
      </div>
      <button type="submit" class="pull-right btn-search"></button>
</form>