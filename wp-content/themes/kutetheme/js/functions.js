(function($){
    "use strict"; // Start of use strict
    var rtl = jQuery( 'body' ).hasClass( 'rtl' );
    
    var labels = ['Years', 'Months', 'Weeks', 'Days', 'Hrs', 'Mins', 'Secs'];
    var layout = '<span class="box-count day"><span class="number">{dnn}</span> <span class="text">Days</span></span><span class="dot">:</span><span class="box-count hrs"><span class="number">{hnn}</span> <span class="text">Hrs</span></span><span class="dot">:</span><span class="box-count min"><span class="number">{mnn}</span> <span class="text">Mins</span></span><span class="dot">:</span><span class="box-count secs"><span class="number">{snn}</span> <span class="text">Secs</span></span>';
     
    var first_lazy = jQuery( '.container-tab .active .kt-template-loop .owl-lazy' );
    /**==============================
    ***  Change Color tab Category
    ===============================**/
    var $style = jQuery('head style').first();
    
    function settingCarousel($this){
        var config = $this.data();
        config.navText = ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'];
        config.smartSpeed="300";
        config.lazyLoad = true;
        if( $this.hasClass('owl-style2') ){
            config.animateOut="fadeOut";
            config.animateIn="fadeIn";    
        }
        config.rtl = rtl;
        config.onInitialized = function( event ){
            var $item_active = $this.find( '.owl-item.active' );
            $item_active.each( function ( $i ) {
                var $item = jQuery(this);
                var $style = $item.attr("style");
                $style    = ( $style == undefined ) ? '' : $style;
                var delay = $i * 300;
                $item.attr("style", $style +
                          ";-webkit-animation-delay:" + delay + "ms;"
                        + "-moz-animation-delay:" + delay + "ms;"
                        + "-o-animation-delay:" + delay + "ms;"
                        + "animation-delay:" + delay + "ms;"
                ).addClass('slideInTop animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $item.removeClass('slideInTop animated');
                    if ( $style )
                        $item.attr("style", $style);
                }); 
            });
        }
        $this.owlCarousel(config);
    }
    function hasOnlyCountdown(){
        jQuery( '.only_countdown' ).each(function(){
            var max_time = $(this).find('.max-time-sale');
            if( max_time.length > 0 ){
                var y = max_time.data('y');
                var m = max_time.data('m');
                var d = max_time.data('d');
                var austDay = new Date( y, m - 1, d, 0, 0, 0 );
                $(this).find('.countdown-only').countdown({
                    until: austDay,
                    labels: labels, 
                    layout: layout
                });
            }
        });
    }
    function kt_lazy( $lazy ){
        $lazy.each( function($index, $element){
            $element = jQuery( $element);
            var $item = $element.closest( 'li' );
            var $style = $item.attr("style");
            $style    = ( $style == undefined ) ? '' : $style;
            var delay = $index * 300;
            $item.attr("style", $style +
                      ";-webkit-animation-delay:" + delay + "ms;"
                    + "-moz-animation-delay:" + delay + "ms;"
                    + "-o-animation-delay:" + delay + "ms;"
                    + "animation-delay:" + delay + "ms;"
            ).addClass('slideInTop animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $item.removeClass('slideInTop animated');
                $item.attr("style", $style);
            }); 
            
            if( $element.is( 'img' ) ){
                var $url = $element.data('src');
                $element.attr( 'src', $url );
            }else{
                var $url = $element.data('src');
                $element.addClass( 'kt-lazy-background' );
                $element.css( 'background', 'url("'+ $url+'")' );
            }
        } );
    }
    
    /* ---------------------------------------------
     Woocommercer Quantily
     --------------------------------------------- */
     function woo_quantily(){
        $('body').on('click','.quantity .quantity-plus',function(){
            var obj_qty = $(this).closest('.quantity').find('input.qty'),
                val_qty = parseInt(obj_qty.val()),
                min_qty = parseInt(obj_qty.attr('min')),
                max_qty = parseInt(obj_qty.attr('max')),
                step_qty = parseInt(obj_qty.attr('step'));
            val_qty = val_qty + step_qty;
            if(max_qty && val_qty > max_qty){ val_qty = max_qty; }
            obj_qty.val(val_qty);
        });
        $('body').on('click','.quantity .quantity-minus',function(){
            var obj_qty = $(this).closest('.quantity').find('input.qty'), 
                val_qty = parseInt(obj_qty.val()),
                min_qty = parseInt(obj_qty.attr('min')),
                max_qty = parseInt(obj_qty.attr('max')),
                step_qty = parseInt(obj_qty.attr('step'));
            val_qty = val_qty - step_qty;
            if(min_qty && val_qty < min_qty){ val_qty = min_qty; }
            if(!min_qty && val_qty < 0){ val_qty = 0; }
            obj_qty.val(val_qty);
        });
      }
    
    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */
    $(window).load(function() {
        // auto width megamenu
        auto_width_megamenu();
        resizeTopmenu();
    });
    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        woo_quantily();
        show_other_item_vertical_menu();
        /* Only Count down */
        hasOnlyCountdown();
        /* Resize top menu*/
        resizeTopmenu();
        /* Zoom image */
        if($('#product-zoom').length >0){
            $('#product-zoom').elevateZoom({
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 500,
                zoomWindowFadeOut: 750,
                gallery:'gallery_01'
            }); 
        }
        /* Popup sizechart */
        if($('#size_chart').length >0){
            $('#size_chart').fancybox();
        }
        /** OWL CAROUSEL**/
        $( ".owl-carousel").each(function(index, el) {
            var $this = $(this);
            if( $this.hasClass( 'tab-owl' ) ){
                var $tab_panel = $this.closest( '.tab-panel' );
                if( $tab_panel.hasClass( 'active' ) ){
                    settingCarousel($this);
                }
            }else{
                settingCarousel($this);
            }
        });
        
        $(".owl-carousel-vertical").each(function(index, el) {
          var config = $(this).data();
          config.navText = ['<span class="icon-up"></spam>','<span class="icon-down"></span>'];
          
          config.smartSpeed="900";
          
          config.animateOut="";
          
          config.animateIn="fadeInUp";
          
          config.rtl = rtl;
          
          $(this).owlCarousel(config);
        });
        
        /** COUNT DOWN **/
        $('.count-down-time[data-countdown]').each(function() { 
           var $this = $(this), finalDate = $(this).data('countdown');
           if( ! $this.hasClass( 'countdown-lastest' ) ){
               $this.countdown(finalDate, function(event) {
                 var fomat ='<span>%H</span><b></b><span>%M</span><b></b><span>%S</span>';
                 $this.html(event.strftime(fomat));
               });
            }else{
                $this.countdown(finalDate, function(event) {
                 var fomat = '<span class="box-count"><span class="number">%D</span> <span class="text">Days</span></span><span class="dot">:</span><span class="box-count"><span class="number">%H</span> <span class="text">Hrs</span></span><span class="dot">:</span><span class="box-count"><span class="number">%M</span> <span class="text">Mins</span></span><span class="dot">:</span><span class="box-count"><span class="number">%S</span> <span class="text">Secs</span></span>';
                 $this.html(event.strftime(fomat));
               });
                            
            }
        });
        
        $('.stick-countdown').each(function() {
          
           var parent = $(this).closest('.container-data-time');
           var time_max = parent.find('.max-time');

           var y = time_max.data('y');
           var m = time_max.data('m');
           var d = time_max.data('d');

           var labels = ['Years', 'Months', 'Weeks', 'Days', 'Hrs', 'Mins', 'Secs'];
           var layout = '<span class="box-count day"><span class="number">{dnn}</span> <span class="text">Days</span></span><span class="dot">:</span><span class="box-count hrs"><span class="number">{hnn}</span> <span class="text">Hrs</span></span><span class="dot">:</span><span class="box-count min"><span class="number">{mnn}</span> <span class="text">Mins</span></span><span class="dot">:</span><span class="box-count secs"><span class="number">{snn}</span> <span class="text">Secs</span></span>';
           var austDay = new Date( y , m - 1 , d ,'00','00','00');
            $(this).countdown({
                until: austDay,
                labels: labels, 
                layout: layout
            });
        });
        
        /* Close top banner*/
        $(document).on('click','.btn-close',function(){
            $(this).closest('.top-banner').animate({ height: 0, opacity: 0 },1000);
            return false;
        })
        /** SELECT CATEGORY **/
        //$('.select-category').select2();
        if( rtl ){
            $( ".select-category" ).selectmenu({
                position: { my : "left-53 top"}
            });
        }else{
             $( ".select-category" ).selectmenu();
        }
        
        /* Toggle nav menu*/
        $(document).on('click','.toggle-menu',function(){
            $(this).closest('.nav-menu').find('.navbar-collapse').toggle();
            return false;
        });
        
        /* elevator click*/ 
        $(document).on('click','a.btn-elevator',function(e){
            var top_menu_height = 50;
            if($('body').hasClass('logged-in')){
                var wpadminbar_height = $('#wpadminbar').height();
                top_menu_height = top_menu_height + wpadminbar_height;
            }
            e.preventDefault();
            var target='';
            if($(this).hasClass('up')){
              target = $(this).closest('.box-tab-category').prev('.box-tab-category');
            }else{
              target = $(this).closest('.box-tab-category').next('.box-tab-category');
              
            }
            var $target = $(target);
            if(typeof($target.offset()) != 'undefined'){
                $('html, body').stop().animate({
                    'scrollTop': $target.offset().top-top_menu_height
                }, 500);
                return false;
            }
        })
        /* scroll top */ 
        $(document).on('click','.scroll_top',function(){
            $('body,html').animate({scrollTop:0},400);
            return false;
        })
        /** #brand-showcase */
        $(document).on('click','.brand-showcase-logo li',function(){
            var id = $(this).data('tab');
            $(this).closest('.brand-showcase-logo').find('li').each(function(){
                $(this).removeClass('active');
            });
            $(this).closest('li').addClass('active');
            $('.brand-showcase-content').find('.brand-showcase-content-tab').each(function(){
                $(this).removeClass('active');
            });
            var tab_active = $('#'+id);
            tab_active.addClass('active');
            //tab_active.find('img.lazy').trigger('load_lazy');
            return false;
        })
        /** ALL CAT **/
        $(document).on('click','.open-cate',function(){
            $(this).closest('.vertical-menu-content').find('li.cat-link-orther').each(function(){
                $(this).slideDown();
            });
            $(this).addClass('colse-cate').removeClass('open-cate').html('Close');
        })
        /* Close category */
        $(document).on('click','.colse-cate',function(){
            $(this).closest('.vertical-menu-content').find('li.cat-link-orther').each(function(){
                $(this).slideUp();
            });
            $(this).addClass('open-cate').removeClass('colse-cate').html('All Categories');
            return false;
        })
        // bar ontop click
        $(document).on('click','.vertical-megamenus-ontop-bar',function(){
            $('#vertical-megamenus-ontop').find('.box-vertical-megamenus').slideToggle();
            $('#vertical-megamenus-ontop').toggleClass('active');
            return false;
        })
        // View grid list product 
        $(document).on('click','.display-product-option .view-as-grid',function(){
            $(this).closest('.display-product-option').find('li').removeClass('selected');
            $(this).addClass('selected');
            $(this).closest('.view-product-list').find('.product-list').removeClass('list').addClass('grid');
            var data = {
                action: 'fronted_set_products_view_style',
                security : screenReaderText.security,
                style: 'grid'
            };
            $.post(screenReaderText.ajaxurl, data, function(response){
               // console.log(response);
            })
            return false;
        })
        // View list list product 
        $(document).on('click','.display-product-option .view-as-list',function(){
            $(this).closest('.display-product-option').find('li').removeClass('selected');
            $(this).addClass('selected');
            $(this).closest('.view-product-list').find('.product-list').removeClass('grid').addClass('list');
            var data = {
                action: 'fronted_set_products_view_style',
                security : screenReaderText.security,
                style: 'list'
            };
            $.post(screenReaderText.ajaxurl, data, function(response){
                //console.log(response);
            })
            return false;
        })

        /// tre menu category
        $(document).on('click','.tree-menu li span',function(){
            $(this).closest('li').children('ul').slideToggle();
            if($(this).closest('li').haschildren('ul')){
                $(this).toggleClass('open');
            }
            return false;
        })
        /* Open menu on mobile */
        $(document).on('click','.btn-open-mobile',function(){
            var width = $(window).width();
            if(width >1024){
                if($('body').hasClass('home')){
                    if($('#nav-top-menu').hasClass('nav-ontop') || $('#header').hasClass('option6') || $('#header').hasClass('option5') ){
                        
                    }else{
                        return false;
                    }
                }
            }
            $(this).closest('.box-vertical-megamenus').find('.vertical-menu-content').slideToggle();
            $(this).closest('.title').toggleClass('active');
            return false;
        })
        /* Product qty */
        $(document).on('click','.btn-plus-down',function(){
            var value = parseInt($('#option-product-qty').val());
            value = value -1;
            if(value <=0) return false;
            $('#option-product-qty').val(value);
            return false;
        })
        $(document).on('click','.btn-plus-up',function(){
            var value = parseInt($('#option-product-qty').val());
            value = value +1;
            if(value <=0) return false;
            $('#option-product-qty').val(value);
            return false;
        })
        //Close vertical 
        $(document).on('click','*',function(e){
            var container = $("#box-vertical-megamenus");
            if (!container.is(e.target) && container.has(e.target).length === 0){
                if($('body').hasClass('home')){
                    if($('#nav-top-menu').hasClass('nav-ontop')){
                    }else{
                        return;
                    }
                }
                container.find('.vertical-menu-content').hide();
                container.find('.title').removeClass('active');
            }
        })
        
        // OWL Product thumb
        $('.product .thumbnails').owlCarousel(
            {
                dots:false,
                nav:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                margin:20,
                responsive : {
                  // breakpoint from 0 up
                  0 : {
                      items : 1,
                  },
                  320 : {
                      items : 2,
                  },
                  // breakpoint from 480 up
                  480 : {
                      items : 2,
                  },
                  // breakpoint from 768 up
                  768 : {
                      items : 2,
                  },
                  1000 : {
                      items : 3,
                  }
              },
              rtl: rtl
            }
        );

        // OWl related product
        $('.related.products .product-list,.upsells.products .product-list').owlCarousel(
            {
                dots:false,
                nav:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                responsive : {
                  // breakpoint from 0 up
                  0 : {
                      items : 1,
                  },
                  // breakpoint from 480 up
                  480 : {
                      items : 2,
                  },
                  // breakpoint from 768 up
                  768 : {
                      items : 2,
                  },
                  1000 : {
                      items : 3,
                  },
                  1025 : {
                      items : 3,
                  }
              },
              rtl: rtl
            }
        );

      // Category product
      $(document).on('click','.widget_product_categories a',function(){
        var paerent = $(this).closest('li');
        var t = $(this);
        //paerent.find('a').removeClass('open');
        //paerent.find('ul').removeClass('open');
        paerent.find('ul').addClass('open');
        if(paerent.children('ul').length > 0){
            //$(this).toggleClass('open');
            $(this).closest('li').children('ul').slideToggle();
            return false;
        }
      })
      // count downt
      if($('.countdown-lastest, .count-down-time').length >0){
          var labels = ['Years', 'Months', 'Weeks', 'Days', 'Hrs', 'Mins', 'Secs'];
          var layout = '<span class="box-count day"><span class="number">{dnn}</span> <span class="text">Days</span></span><span class="dot">:</span><span class="box-count hrs"><span class="number">{hnn}</span> <span class="text">Hrs</span></span><span class="dot">:</span><span class="box-count min"><span class="number">{mnn}</span> <span class="text">Mins</span></span><span class="dot">:</span><span class="box-count secs"><span class="number">{snn}</span> <span class="text">Secs</span></span>';
          $('.countdown-lastest, .count-down-time').each(function() {
              var austDay = new Date($(this).data('y'),$(this).data('m') - 1,$(this).data('d'),$(this).data('h'),$(this).data('i'),$(this).data('s'));
              $(this).countdown({
                  until: austDay,
                  labels: labels, 
                  layout: layout
              });
          });
      }
        
    /**************CHANGE COLOR *******************/
    /**************TAB CATEGORY ******************/
        
    jQuery('div[data-target="change-color"]').each(function(){
        var $this  = jQuery(this);
        var $color = $this.data("color");
        var $rgb   = $this.data('rgb');
        var $id = $this.attr("id");
        if( $this.hasClass('option1') ){
            $style.append('#'+$id+'.option1 .nav-menu-red li a:hover,#'+$id+' .nav-menu-red li.active a,#'+$id+' .nav-menu-red li.selected a,#'+$id+' .nav-menu-red,#'+$id+'.option2 .product-list li .add-to-cart:hover,#'+$id+'.option1 .product-list li .add-to-cart:hover, #'+$id+'.option1 .product-list li .quick-view a:hover,#'+$id+'.option1 .owl-controls .owl-prev:hover,#'+$id+'.option1 .owl-controls .owl-next:hover {background: '+$color+';}');
            $style.append( '#'+$id+'.option1 .product-list li .add-to-cart{background-color:rgba( '+$rgb+', 0.5 )}' );
            $style.append( '#'+$id+'{color: '+$color+'}')
        }else if( $this.hasClass('option2') ){
            if( $this.hasClass( 'tab-2' ) ){
                $style.append( '#'+$id+'.option2 .show-brand .navbar-brand,#'+$id+'.option2 .category-featured .nav-menu .nav>li>a:before,#'+$id+'.option2 .product-list li .add-to-cart:hover, #'+$id+'.option2 .product-list li .quick-view a:hover, #'+$id+'.option2 .product-list li .quick-view a:hover {background-color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .category-featured .nav-menu .nav>li.active a,#'+$id+'.option2 .category-featured .nav-menu .nav>li:hover a,#'+$id+'.option2 .category-featured .sub-category-list a:hover, #'+$id+'.option2 .nav-menu .nav>li:hover a:after, #'+$id+'.option2 .nav-menu .nav>li.active a:after {color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .category-featured .nav-menu .navbar-collapse{border-bottom-color:'+$color+'}' );
                $style.append( '#'+$id+'.option2 .product-list li .add-to-cart{background-color:rgba( '+$rgb+', 0.7 )}' );
            }else if( $this.hasClass( 'tab-3' ) ){
                $style.append( '#'+$id+'.option2 .category-featured .navbar-brand, #'+$id+'.option2 .category-featured .nav-menu .nav>li>a:before, #'+$id+'.option2 .category-featured .product-list li .add-to-cart:hover, #'+$id+'.option2 .category-featured .product-list li .quick-view a.search:hover, #'+$id+'.option2 .category-featured .product-list li .quick-view a.compare:hover, #'+$id+'.option2 .category-featured .product-list li .quick-view a.heart:hover, #'+$id+'.option2 .product-list li .quick-view a:hover{background-color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .category-featured .nav-menu .nav>li:hover a, #'+$id+'.option2 .category-featured .nav-menu .nav>li.active a, #'+$id+'.option2 .category-featured .nav-menu .nav>li:hover a:after, #'+$id+'.option2 .category-featured .nav-menu .nav>li.active a:after, #'+$id+'.option2 .category-featured .sub-category-list a:hover {color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .category-featured .nav-menu .navbar-collapse{border-bottom-color:'+$color+'}' );
                $style.append( '#'+$id+'.option2 .category-featured .product-list li .add-to-cart{background-color:rgba( '+$rgb+', 0.7 )}' );
            }else if( $this.hasClass( 'tab-4' ) ){
                $style.append( '#'+$id+'.option2 .category-featured .navbar-brand, #'+$id+'.option2 .category-featured .nav-menu .nav>li>a:before,#'+$id+'.option2 .category-featured .product-list li .add-to-cart:hover, #'+$id+'.option2 .category-featured .product-list li .quick-view a.search:hover, #'+$id+'.option2 .category-featured .product-list li .quick-view a.compare:hover, #'+$id+'.option2 .category-featured .product-list li .quick-view a.heart:hover, #'+$id+'.option2 .product-list li .quick-view a:hover{background-color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .category-featured .nav-menu .nav>li:hover a, #'+$id+'.option2 .category-featured .nav-menu .nav>li.active a, #'+$id+'.option2 .category-featured .nav-menu .nav>li:hover a:after, #'+$id+'.option2 .category-featured .nav-menu .nav>li.active a:after, #'+$id+'.option2 .category-featured .sub-category-list a:hover{color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .category-featured .nav-menu .navbar-collapse{border-bottom-color:'+$color+'}' );
                $style.append( '#'+$id+'.option2 .category-featured .add-to-cart{background-color:rgba( '+$rgb+', 0.7 )}' );
            }else if( $this.hasClass( 'tab-5' ) ){
                $style.append( '#'+$id+'.option2 .category-featured.jewelry .navbar-brand, #'+$id+'.option2 .category-featured.jewelry .nav-menu .nav>li>a:before,#'+$id+'.option2 .category-featured.jewelry .product-list li .add-to-cart:hover, #'+$id+'.option2 .category-featured.jewelry .product-list li .quick-view a.search:hover, #'+$id+'.option2 .category-featured.jewelry .product-list li .quick-view a.compare:hover, #'+$id+'.option2 .category-featured.jewelry .product-list li .quick-view a.heart:hover, #'+$id+'.option2 .category-featured.jewelry .product-list li .quick-view a:hover{background-color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .category-featured.jewelry .nav-menu .nav>li:hover a, #'+$id+'.option2 .category-featured.jewelry .nav-menu .nav>li.active a,#'+$id+'.option2 .category-featured.jewelry .nav-menu .nav>li:hover a:after, #'+$id+'.option2 .category-featured.jewelry .nav-menu .nav>li.active a:after{color: '+$color+';}' );
                $style.append( '#'+$id+'.option2 .nav-menu .navbar-collapse{border-bottom-color:'+$color+'}' );
                $style.append( '#'+$id+'.option2 .category-featured.jewelry .add-to-cart{background-color:rgba( '+$rgb+', 0.7 )}' );
            }
        }else if( $this.hasClass('box-products') ){
            $style.append( '#'+$id+'.box-products .box-tabs li>a:before, #'+$id+'.box-products .product-list li .add-to-cart:hover, #'+$id+'.box-products .product-list li .quick-view a:hover, #'+$id+'.box-products .owl-controls .owl-prev:hover, #'+$id+'.box-products .owl-controls .owl-next:hover{background-color: '+$color+';}' );
            $style.append( '#'+$id+'.box-products .box-tabs li>a:after{color: '+$color+';}' );
            $style.append( '#'+$id+'.box-products .box-product-head .box-title{border-bottom-color:'+$color+'}' );
            $style.append( '#'+$id+'.box-products .product-list li .add-to-cart{background-color:rgba( '+$rgb+', 0.7 )}' );
        }
    });
    /**==============================
    ***  Effect tab category
    ===============================**/
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var $this = jQuery(this);
            var $container = $this.closest('.container-tab');
            var $href = $this.attr('href');
            var $tab_active = $container.find($href);
            var $item_active = $tab_active.find( '.owl-item.active' );
            var $carousel_active = $tab_active.find('.owl-carousel');
            
            if( $carousel_active.length > 0 ){
                if( ! $carousel_active.hasClass( 'owl-loaded' ) ){
                  settingCarousel( $carousel_active );
                }else{
                    $item_active.each( function ( $i ) {
                        var $item = jQuery(this);
                        var $style = $item.attr("style");
                        $style    = ( $style == undefined ) ? '' : $style;
                        var delay = $i * 300;
                        $item.attr("style", $style +
                                  ";-webkit-animation-delay:" + delay + "ms;"
                                + "-moz-animation-delay:" + delay + "ms;"
                                + "-o-animation-delay:" + delay + "ms;"
                                + "animation-delay:" + delay + "ms;"
                        ).addClass('slideInTop animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                            $item.removeClass('slideInTop animated');
                            if ( $style )
                                $item.attr("style", $style);
                        }); 
                    });
                }
            }
            
            var $lazy = $tab_active.find( '.kt-template-loop .owl-lazy' );
            
            kt_lazy( $lazy );
        });
        
        
        kt_lazy( first_lazy ); 
          
    });
    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    $(window).resize(function(){
        // auto width megamenu
        auto_width_megamenu();
        // Remove menu ontop
        remove_menu_ontop();
        // resize top menu
        resizeTopmenu();
    });
    /* ---------------------------------------------
     Scripts scroll
     --------------------------------------------- */
    $(window).scroll(function(){
        /* Show hide scrolltop button */
        if( $(window).scrollTop() == 0 ) {
            $('.scroll_top').stop(false,true).fadeOut(600);
        }else{
            $('.scroll_top').stop(false,true).fadeIn(600);
        }
        /* Main menu on top */
        var h = $(window).scrollTop();
        var max_h = $('#header').height() + $('#top-banner').height();
        var width = $(window).width();
        if(width > 767){
            if( h > (max_h + vertical_menu_height)-50){
                // fix top menu
                $('#nav-top-menu').addClass('nav-ontop');
                //$('#nav-top-menu').find('.vertical-menu-content').hide();
                //$('#nav-top-menu').find('.title').removeClass('active');
                // add cart box on top menu
                $('#cart-block .cart-block').appendTo('#shopping-cart-box-ontop .shopping-cart-box-ontop-content');
                $('#shopping-cart-box-ontop').fadeIn();
                $('#user-info-top').appendTo('#user-info-opntop');
                $('#header .header-search-box form').appendTo('#form-search-opntop');
            }else{
                $('#nav-top-menu').removeClass('nav-ontop');
                if($('body').hasClass('home')){
                    $('#nav-top-menu').find('.vertical-menu-content').removeAttr('style');
                    if(width > 1024)
                        $('#nav-top-menu').find('.vertical-menu-content').show();
                    else{
                        $('#nav-top-menu').find('.vertical-menu-content').hide();
                    }
                     $('#nav-top-menu').find('.vertical-menu-content').removeAttr('style');
                }
                ///
                $('#shopping-cart-box-ontop .cart-block').appendTo('#cart-block');
                $('#shopping-cart-box-ontop').fadeOut();
                $('#user-info-opntop #user-info-top').appendTo('.top-header .container');
                $('#form-search-opntop form').appendTo('#header .header-search-box');
            }
        }
    });
    var vertical_menu_height = $('#box-vertical-megamenus .box-vertical-megamenus').innerHeight();
    /**==============================
    ***  Auto width megamenu
    ===============================**/
    function auto_width_megamenu(){
        var full_width = parseInt($('.container').innerWidth());
        //full_width = $( document ).width();
        var menu_width = parseInt($('.vertical-menu-content').actual('width'));
        $('.vertical-menu-content').find('.megamenu').each(function(){
            $(this).width((full_width - menu_width)-32);
        });
        
        if($(window).width()+scrollCompensate() < 1025){
            $("#box-vertical-megamenus li.dropdown:not(.active) >a").attr('data-toggle','dropdown');
        }else{
            $("#box-vertical-megamenus li.dropdown >a").removeAttr('data-toggle');
        }
    }
    /**==============================
    ***  Remove menu on top
    ===============================**/
    function remove_menu_ontop(){
        var width = parseInt($(window).width());
        if(width < 768){
            $('#nav-top-menu').removeClass('nav-ontop');
            if($('body').hasClass('home')){
                if(width > 1024)
                    $('#nav-top-menu').find('.vertical-menu-content').show();
                else{
                    $('#nav-top-menu').find('.vertical-menu-content').hide();
                }
            }
            ///
            $('#shopping-cart-box-ontop .cart-block').appendTo('#cart-block');
            $('#shopping-cart-box-ontop').fadeOut();
            $('#user-info-opntop #user-info-top').appendTo('.top-header .container');
            $('#form-search-opntop form').appendTo('#header .header-search-box');
        }
    }
    /* Top menu*/
    function scrollCompensate(){
        var inner = document.createElement('p');
        inner.style.width = "100%";
        inner.style.height = "200px";
        var outer = document.createElement('div');
        outer.style.position = "absolute";
        outer.style.top = "0px";
        outer.style.left = "0px";
        outer.style.visibility = "hidden";
        outer.style.width = "200px";
        outer.style.height = "150px";
        outer.style.overflow = "hidden";
        outer.appendChild(inner);
        document.body.appendChild(outer);
        var w1 = parseInt(inner.offsetWidth);
        outer.style.overflow = 'scroll';
        var w2 = parseInt(inner.offsetWidth);
        if (w1 == w2) w2 = outer.clientWidth;
        document.body.removeChild(outer);
        return (w1 - w2);
    }

    function resizeTopmenu(){
        if($(window).width() + scrollCompensate() >= 768){
            var main_menu_w = $('#main-menu .navbar').innerWidth();
            $("#main-menu .megamenu").each(function(){
                var menu_width = $(this).innerWidth();
                var offset_left = $(this).position().left;

                if(menu_width > main_menu_w){
                    $(this).css('width',main_menu_w+'px');
                    $(this).css('left','0');
                }else{
                    if((menu_width + offset_left) > main_menu_w){
                        var t = main_menu_w-menu_width;
                        var left = parseInt((t/2));
                        $(this).css('left',left);
                    }
                }
            });
        }

        if($(window).width()+scrollCompensate() < 1025){
            $("#main-menu li.dropdown:not(.active) >a").attr('data-toggle','dropdown');
        }else{
            $("#main-menu li.dropdown >a").removeAttr('data-toggle');
        }
    }


    function show_other_item_vertical_menu(){
      if($('.box-vertical-megamenus').length >0){
          var all_item = 0;
          var limit_item = 10;
          if($('.box-vertical-megamenus').hasClass('style2')){
            if($(window).width() <=1024){
              limit_item = 8;
            }
            
          }
          $('.box-vertical-megamenus').find('.vertical-menu-list>li').each(function(i){
              all_item = all_item + 1;
              if(i > limit_item){
                $(this).addClass('cat-link-orther');
              }
          })
      }
    }
    
    /*$("img.lazy").lazyload({
        effect: "fadeIn",
        skip_invisible: false,
        failure_limit : 200,
        event: 'scroll load_lazy'
    });*/
})(jQuery); // End of use strict