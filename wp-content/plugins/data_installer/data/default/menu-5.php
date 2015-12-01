<?php
//Menu
$menu_id = kt_add_menu( 333, 'Custom Header Menu', 'custom_header_menu' );

 // Menu Item
kt_add_menu_item( 1879, $menu_id, 0, 'Promotion', 'custom', 1879, 'custom', '#', '', '0', '' );

kt_add_menu_item( 1880, $menu_id, 0, 'Payment', 'custom', 1880, 'custom', '#', '', '0', '' );

kt_add_menu_item( 1881, $menu_id, 0, 'Shipping', 'custom', 1881, 'custom', '#', '', '0', '' );

kt_add_menu_item( 1882, $menu_id, 0, 'Return', 'custom', 1882, 'custom', '#', '', '0', '' );

kt_add_menu_item( 1883, $menu_id, 0, 'Call Us: +04 123456789', 'custom', 1883, 'custom', '#', '', '0', '' );
