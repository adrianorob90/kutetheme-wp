<form class="form-inline woo-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
      <div class="form-group input-serach">
        <input type="hidden" name="post_type" value="post" />
        <input type="text" name="s"  placeholder="<?php _e('Keyword here...', THEME_LANG) ?>" />
      </div>
      <button type="submit" class="pull-right btn-search"></button>
</form>