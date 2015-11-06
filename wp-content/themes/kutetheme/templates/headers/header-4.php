<!-- HEADER -->
<div id="header" class="header option4">
    <div class="top-header">
        <div class="container">
            <?php kt_topbar_menu();?>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div id="main-header">
        <div class="container main-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 logo">
                    <?php echo kt_get_logo(); ?>
                </div>
                <div id="main-menu" class="col-sm-10 col-md-10 col-lg-8 main-menu">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
                            </div>
                            <?php kt_setting_mega_menu(); ?><!--/.nav-collapse -->
                        </div>
                    </nav>
                </div>
                <?php 
                    if( kt_is_wc() ): 
                        do_action('kt_mini_cart');
                     endif; 
                 ?>
            </div>
        </div>
    </div>
    <!-- END MANIN HEADER -->
    <div class="nav-top-menu">
        <div class="container">
            <?php do_action( 'kt_show_vertical_menu_option_4' ); ?>
        </div>
    </div>
</div>
<!-- end header -->