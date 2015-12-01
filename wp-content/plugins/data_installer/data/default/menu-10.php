<?php
//Menu
$menu_id = kt_add_menu( 26, 'Main menu', 'primary' );

 // Menu Item
kt_add_menu_item( 2164, $menu_id, 0, 'Home', 'page', 347, 'post_type', 'http://localhost/kutetheme-wp/home/', '', '0', '' );

kt_add_menu_item( 92, $menu_id, 0, 'Blog', 'page', 2, 'post_type', 'http://localhost/kutetheme-wp/sample-page/', '', '0', '' );

kt_add_menu_item( 95, $menu_id, 92, 'Tablets', 'custom', 95, 'custom', '#', '', '0', '' );

kt_add_menu_item( 96, $menu_id, 95, 'Laptop', 'custom', 96, 'custom', '#', '', '0', '' );

kt_add_menu_item( 97, $menu_id, 95, 'Memory Cards', 'custom', 97, 'custom', '#', '', '0', '' );

kt_add_menu_item( 98, $menu_id, 92, 'Accessories', 'custom', 98, 'custom', '#', '', '0', '' );

kt_add_menu_item( 2149, $menu_id, 0, 'Fashion', 'custom', 2149, 'custom', '#', 'enabled', '23', '' );

kt_add_menu_item( 2150, $menu_id, 0, 'Foods', 'custom', 2150, 'custom', '#', 'enabled', '40', '833' );

kt_add_menu_item( 2151, $menu_id, 0, 'Contact', 'custom', 2151, 'custom', '#', '', '0', '' );

kt_add_menu_item( 2152, $menu_id, 0, 'Sport', 'custom', 2152, 'custom', '#', '', '0', '' );

kt_add_menu_item( 94, $menu_id, 59, 'Mobile', 'custom', 94, 'custom', '#', 'enabled', '23', '' );

kt_add_menu_item( 2205, $menu_id, 0, 'Clothing', 'product_cat', 337, 'taxonomy', 'http://localhost/kutetheme-wp/product-category/clothing/', '', '0', '' );
