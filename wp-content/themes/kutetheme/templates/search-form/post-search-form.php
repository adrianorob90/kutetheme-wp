<form class="form-inline woo-search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
      <div class="form-group input-serach">
        <input type="hidden" name="post_type" value="post" />
        <input type="text" name="s"  placeholder="<?php _e('Keyword here...', 'kutetheme') ?>" />
      </div>
      <button type="submit" class="pull-right btn-search"></button>
</form>