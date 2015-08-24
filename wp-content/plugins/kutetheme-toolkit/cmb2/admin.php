<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class KT_Admin {
	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'kt_options';
	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'kt_option_metabox';
	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';
	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';
	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Theme Options', 'kutetheme' );
	}
	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}
	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}
	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
		// Include CMB CSS in the head to avoid FOUT
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}
    
    /**
     * Get all meta boxes that added for page options
     * @since 1.0.0
     * @return array
     */
    function get_option_boxes(){
        $boxes = CMB2_Boxes::get_all();
        $options_boxes = array();
        foreach ( $boxes  as $k => $mb ) {
            $object = $mb->mb_object_type();
            $is_true =  false;
            if ( is_array( $object ) ){
                if ( in_array( 'options-page', $object ) ) {
                    $is_true = true;
                }
            } else {
                if ( $object == 'options-page' ) {
                    $is_true = true;
                }
            }
            if ( $is_true ) {
                $is_true = false;
                if(  isset( $mb->meta_box['show_on'] ) ){
                    if(  is_string( $mb->meta_box['show_on']['value'] ) ){
                        $is_true = $mb->meta_box['show_on']['value'] == $this->key;
                    } else if ( is_array( $mb->meta_box['show_on']['value'] ) ) {
                        $is_true = in_array( $this->key, $mb->meta_box['show_on']['value'] ) ;
                    }
                }
            }
            if ( $is_true ) {
                $options_boxes[ $k ] =  $mb;
            }
        }
        return $options_boxes;
    }
    
    /**
     * Get current option page link
     *
     * @return string
     */
    function page_link(){
        return admin_url( 'admin.php?page='.$this->key );
    }
    
	/**
     * Admin page markup. Mostly handled by CMB2
     * @since  0.1.0
     */
    public function admin_page_display() {
        $link = $this->page_link();
        $boxes = $this->get_option_boxes();
        $tab =  isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : key( $boxes );
        if ( ! isset( $boxes[ $tab ] ) ) {
            reset( $boxes );
            $tab  = key( $boxes );
        }
        ?>
        <div class="wrap cmb2-options-page <?php echo $this->key; ?> <?php echo esc_attr( $tab ) ?>">
            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
            <?php  if ( count( $boxes ) > 1 ) { ?>
            <h2 class="nav-tab-wrapper">
                <?php foreach ( $boxes as $k => $mb ) { ?>
                <a href="<?php echo add_query_arg( array( 'tab' => $k ), $link ) ?>" class="nav-tab <?php echo $tab == $k ? 'nav-tab-active' : ''; ?>"><?php echo $mb->meta_box['title']; ?></a>
                <?php } ?>
            </h2>
            <?php } ?>
            <?php cmb2_metabox_form( $tab , $this->key, array( 'cmb_styles' => false ) ); ?>
        </div>
    <?php
    }
	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {
		$cmb_options_general = new_cmb2_box( array(
			'id'      => 'kt_generals',
			'hookup'  => false,
            'title'   => 'General',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        /**
    	 * Theme color
    	 */
    	$cmb_options_general->add_field( array(
    		'name'    => __( 'Theme Color', 'kutetheme' ),
    		'id'      => 'kt_theme_color',
    		'type'    => 'colorpicker',
    		'default' => '#ff3366',
            'desc'    => __( 'Setting main color for your site', 'kutetheme' ),
    	) );
        
        /**
    	 * Font color
    	 */
    	$cmb_options_general->add_field( array(
    		'name'    => __( 'Color', 'kutetheme' ),
    		'id'      => 'kt_font_color',
    		'type'    => 'colorpicker',
    		'default' => '#666666',
            'desc'    => __( 'Setting font color for your site', 'kutetheme' ),
    	) );
        
        /**
    	 * Font color hover 
    	 */
    	$cmb_options_general->add_field( array(
    		'name'    => __( 'Color Hover', 'kutetheme' ),
    		'id'      => 'kt_font_color_hover',
    		'type'    => 'colorpicker',
    		'default' => '#ff3366',
            'desc'    => __( 'When you hover on text in your site, It will tranfer the color', 'kutetheme' ),
    	) );
        
        /**
    	 * Background
    	 */
    	$cmb_options_general->add_field( array(
    		'name'    => __( 'Background', 'kutetheme' ),
    		'id'      => 'kt_bg',
    		'type'    => 'select',
    		'default' => 'color',
            'options'          => array(
    			'color' => __( 'Color', 'kutetheme' ),
    			'image' => __( 'Image', 'kutetheme' ),
    		),
            'desc'    => __( 'Setting background for your site image or color(default)', 'kutetheme' ),
    	) );
        
        $cmb_options_general->add_field( array(
    		'name'    => __( 'Background Color', 'kutetheme' ),
    		'desc'    => __( 'Setting background color for your site', 'kutetheme' ),
    		'id'      => 'kt_bg_color',
    		'type'    => 'colorpicker',
    		'default' => '#ffffff',
    	) );
        
        
        $cmb_options_general->add_field( array(
    		'name'    => __( 'Background Image', 'kutetheme' ),
    		'desc'    => __( 'Setting background image for your site', 'kutetheme' ),
    		'id'      => 'kt_bg_image',
    		'type'    => 'file'
    	) );
        
        /**
    	 * Page Layout
    	 */
    	$cmb_options_general->add_field( array(
    		'name'    => __( 'Page Layout', 'kutetheme' ),
    		'id'      => 'kt_layout',
    		'type'    => 'select',
    		'default' => 'full',
            'options'          => array(
    			'full' => __( 'Full', 'kutetheme' ),
    			'box'  => __( 'Boxed', 'kutetheme' ),
    		),
            'desc'    => __( 'Setting background for your site image or color(default)', 'kutetheme' ),
    	) );
        
        global $wp_registered_sidebars;
        $sidebars = array();
        

        foreach ( $wp_registered_sidebars as $sidebar ){
            $sidebars[  $sidebar['id'] ] =   $sidebar['name'];
        }
        
        /**
    	 * Site bar
    	 */
    	$cmb_options_general->add_field( array(
    		'name'    => __( 'Sidebar Area', 'kutetheme' ),
    		'id'      => 'kt_sidebar_are',
    		'type'    => 'select',
    		'default' => 'full',
            'options' => array(
                'full'  => 'Full',
                'left'  => 'Left',
                'right' => 'Right'
            ),
            'desc'    => __( 'Setting Sidebar Area', 'kutetheme' ),
    	) );
        
        $cmb_options_general->add_field( array(
    		'name'    => __( 'Choose sidebar', 'kutetheme' ),
    		'id'      => 'kt_used_sidebar',
    		'type'    => 'select',
    		'default' => 'sidebar-primary',
            'options' => $sidebars,
            'desc'    => __( 'Setting sidebar in the area sidebar', 'kutetheme' ),
    	) );
        
        $cmb_options_general->add_field( array(
    		'name'    => __( 'Page Service', 'kutetheme' ),
    		'id'      => 'kt_page_service',
    		'type'    => 'page',
            'desc'    => __( 'Setting page service', 'kutetheme' ),
    	) );
        
        $cmb_options_general->add_field( array(
    		'name'    => __( 'Page Support', 'kutetheme' ),
    		'id'      => 'kt_page_support',
    		'type'    => 'page',
            'desc'    => __( 'Setting page support ', 'kutetheme' ),
    	) );
        
        $cmb_options_general->add_field( array(
    		'name'    => __( 'About Us', 'kutetheme' ),
    		'id'      => 'kt_page_about_us',
    		'type'    => 'page',
            'desc'    => __( 'Setting page about us', 'kutetheme' ),
    	) );
        
        
        $cmb_options_logo = new_cmb2_box( array(
			'id'      => 'kt_logo_favicon',
			'hookup'  => false,
            'title'   => 'Logo',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        /**
    	 * Logo
    	 */
    	$cmb_options_logo->add_field( array(
    		'name'    => __( 'Logo', 'kutetheme' ),
    		'id'      => 'kt_logo',
    		'type'    => 'file',
            'desc'    => __( 'Setting your site\'s logo', 'kutetheme' ),
    	) );
        
        /**
    	 * Logo Footer
    	 */
    	$cmb_options_logo->add_field( array(
    		'name'    => __( 'Logo Footer', 'kutetheme' ),
    		'id'      => 'kt_logo_footer',
    		'type'    => 'file',
            'desc'    => __( 'Setting your site\'s logo in footer', 'kutetheme' ),
    	) );
        
        /**
    	 * Favicon
    	 */
    	$cmb_options_logo->add_field( array(
    		'name'    => __( 'Favicon', 'kutetheme' ),
    		'id'      => 'kt_favicon',
    		'type'    => 'file',
            'desc'    => __( 'Setting your site\'s favicon', 'kutetheme' ),
    	) );
        
        
        /**
    	 * Header
    	 */
        $cmb_options_header = new_cmb2_box( array(
			'id'      => 'kt_header',
			'hookup'  => false,
            'title'   => 'Header',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
    	$cmb_options_header->add_field( array(
    		'name'    => __( 'Header', 'kutetheme' ),
    		'id'      => 'kt_used_header',
    		'type'    => 'header',
            'desc'    => __( 'Setting User Menu', 'kutetheme' ),
            'default' => 'header_1',
            'options' => array(
    			'1' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v1.jpg',
    			'2' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v2.jpg',
    			// '3' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v3.jpg',
       //          '4' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v3.jpg',
       //          '5' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v3.jpg',
       //          '6' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v1.jpg',
       //          '7' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v3.jpg',
       //          '8' => KUTETHEME_PLUGIN_URL .'/assets/imgs/v3.jpg',
    		),
    	) );
        
        /**
    	 * Footer
    	 */
        $cmb_options_footer = new_cmb2_box( array(
			'id'      => 'kt_footer',
			'hookup'  => false,
            'title'   => 'Footer',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        $cmb_options_footer->add_field( array(
    		'name' => __( 'Copyrights', 'kutetheme' ),
    		'desc' => __( 'Copyrights your site', 'kutetheme' ),
    		'id'   => 'kt_copyrights',
    		'type' => 'textarea',
    	) );
        
        /**
         * Typography
         * */
       $cmb_options_typography = new_cmb2_box( array(
			'id'      => 'kt_typography',
			'hookup'  => false,
            'title'   => 'Typography',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        /**
         * Woocommerce
         * */
       $cmb_options_woocommerce = new_cmb2_box( array(
			'id'      => 'kt_woocommerce',
			'hookup'  => false,
            'title'   => 'Woocommerce',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        
        /**
    	 * Woo Site bar
    	 */
    	$cmb_options_woocommerce->add_field( array(
    		'name'    => __( 'Shop Sidebar Area', 'kutetheme' ),
    		'id'      => 'kt_woo_shop_sidebar_are',
    		'type'    => 'select',
    		'default' => 'full',
            'options' => array(
                'full'  => 'Full',
                'left'  => 'Left',
                'right' => 'Right'
            ),
            'desc'    => __( 'Setting Sidebar Area on shop page', 'kutetheme' ),
    	) );
        
        $cmb_options_woocommerce->add_field( array(
    		'name'    => __( 'Shop page sidebar', 'kutetheme' ),
    		'id'      => 'kt_woowoo_shop_used_sidebar',
    		'type'    => 'select',
    		'default' => 'sidebar-shop',
            'options' => $sidebars,
            'desc'    => __( 'Setting sidebar in the area sidebar on shop page', 'kutetheme' ),
    	) );
        
        $cmb_options_woocommerce->add_field( array(
    		'name'    => __( 'Products perpage', 'kutetheme' ),
    		'id'      => 'kt_woo_products_perpage',
    		'type'    => 'text',
    		'default' => '10',
            'desc'    => __( 'Number of products on shop page', 'kutetheme' ),
    	) );
        
        $cmb_options_woocommerce->add_field( array(
    		'name'    => __( 'Grid column', 'kutetheme' ),
    		'id'      => 'kt_woo_grid_column',
    		'type'    => 'text',
    		'default' => '3',
            'desc'    => __( 'Number column to display width gird mod', 'kutetheme' ),
    	) );
        
        $cmb_options_woocommerce->add_field( array(
    		'name'    => __( 'Number of days newness', 'kutetheme' ),
    		'id'      => 'kt_woo_newness',
    		'type'    => 'text',
    		'default' => '7',
            'desc'    => __( 'Number of days to treat as new product', 'kutetheme' ),
    	) );
        
        $cmb_options_woocommerce->add_field( array(
    		'name'    => __( 'Single Sidebar Area', 'kutetheme' ),
    		'id'      => 'kt_woo_single_sidebar_are',
    		'type'    => 'select',
    		'default' => 'full',
            'options' => array(
                'full'  => 'Full',
                'left'  => 'Left',
                'right' => 'Right'
            ),
            'desc'    => __( 'Setting Sidebar Area on single page', 'kutetheme' ),
    	) );
        
        $cmb_options_woocommerce->add_field( array(
    		'name'    => __( 'Single page sidebar', 'kutetheme' ),
    		'id'      => 'kt_woo_single_used_sidebar',
    		'type'    => 'select',
    		'default' => 'full',
            'options' => $sidebars,
            'desc'    => __( 'Setting sidebar in the area sidebar on single page', 'kutetheme' ),
    	) );
        
        /**
         * Sidebar
         * */
       $cmb_options_socials = new_cmb2_box( array(
			'id'      => 'kt_sidebars',
			'hookup'  => false,
            'title'   => 'Sidebar',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			)
        ));
    
    	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
    	$group_field_id = $cmb_options_socials->add_field( array(
    		'id'          => 'kt_group_sidebar',
    		'type'        => 'group',
            'description' => __( 'Manager custome sidebars', 'kutetheme' ),
    		'options'     => array(
    			'group_title'   => __( 'Sidebar {#}', 'kutetheme' ), // {#} gets replaced by row number
    			'add_button'    => __( 'Add new sidebar', 'kutetheme' ),
    			'remove_button' => __( 'Remove sidebar', 'kutetheme' ),
    			'sortable'      => true, // beta
    		),
    	) );
    
    	/**
    	 * Group fields works the same, except ids only need
    	 * to be unique to the group. Prefix is not needed.
    	 *
    	 * The parent field's id needs to be passed as the first argument.
    	 */
    	$cmb_options_socials->add_group_field( $group_field_id, array(
    		'name'       => __( 'Sidebar Title', 'kutetheme' ),
    		'id'         => 'title',
    		'type'       => 'text',
    		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    	) );
    
    	$cmb_options_socials->add_group_field( $group_field_id, array(
    		'name'        => __( 'Description', 'kutetheme' ),
    		'description' => __( 'sidebar desc', 'kutetheme' ),
    		'id'          => 'description',
    		'type'        => 'textarea_small',
    	) );
        
        /**
         * Socials
         * */
       $cmb_options_socials = new_cmb2_box( array(
			'id'      => 'kt_socials',
			'hookup'  => false,
            'title'   => 'Socials',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        $cmb_options_socials->add_field( array(
    		'name' => __( 'Addthis ID', 'kutetheme' ),
    		'desc' => __( 'Setting id addthis', 'kutetheme' ),
    		'id'   => 'kt_addthis_id',
    		'type' => 'text',
    	) );
        /**
         * CSS
         * */
       $cmb_options_css = new_cmb2_box( array(
			'id'      => 'kt_css',
			'hookup'  => false,
            'title'   => 'CSS',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        $cmb_options_css->add_field( array(
    		'name' => __( 'Code CSS', 'kutetheme' ),
    		'desc' => __( 'Add css in your site', 'kutetheme' ),
    		'id'   => 'kt_add_css',
    		'type' => 'textarea',
    	) );
        /**
         * JS
         * */
       $cmb_options_js = new_cmb2_box( array(
			'id'      => 'kt_js',
			'hookup'  => false,
            'title'   => 'jQuery',
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        $cmb_options_js->add_field( array(
    		'name' => __( 'Code JS', 'kutetheme' ),
    		'desc' => __( 'Add js in your site', 'kutetheme' ),
    		'id'   => 'kt_add_js',
    		'type' => 'textarea',
    	) );
        
        /**
         * INFO
         * */
       $cmb_options_info = new_cmb2_box( array(
			'id'      => 'kt_info',
			'hookup'  => false,
            'title'   => __('Info', 'kutetheme' ),
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        $cmb_options_info->add_field( array(
    		'name' => __( 'Address', 'kutetheme' ),
    		'desc' => __( 'Setting address for your site', 'kutetheme' ),
    		'id'   => 'kt_address',
    		'type' => 'text',
    	) );
        
        $cmb_options_info->add_field( array(
    		'name' => __( 'Phone', 'kutetheme' ),
    		'desc' => __( 'Setting hotline for your site', 'kutetheme' ),
    		'id'   => 'kt_phone',
    		'type' => 'text',
    	) );
        
        $cmb_options_info->add_field( array(
    		'name' => __( 'Email', 'kutetheme' ),
    		'desc' => __( 'Setting email for your site', 'kutetheme' ),
    		'id'   => 'kt_email',
    		'type' => 'text',
    	) );
	}
	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		throw new Exception( 'Invalid property: ' . $field );
	}
}
/**
 * Helper function to get/return the KT_Admin object
 * @since  0.1.0
 * @return KT_Admin object
 */
function kt_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new KT_Admin();
		$object->hooks();
	}
	return $object;
}
/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function kt_get_option( $key = '' ) {
	return cmb2_get_option( kt_admin()->key, $key );
}
// Get it started
kt_admin();