<?php

//Menu
$menu_id = kt_add_menu( 345, 'Topbar menu left', 'topbar_menuleft' );

 // Menu Item
kt_add_menu_item( 2148, $menu_id, 0, '<i class="fa fa-phone"></i> +00 123 456 789', 'custom', 2148, 'custom', '#', '', '0', '' );

kt_add_menu_item( 2147, $menu_id, 0, '<i class="fa fa-envelope"></i> Contact us today !', 'custom', 2147, 'custom', '#', '', '0', '' );

//Menu
$menu_id = kt_add_menu( 344, 'Topbar menu right', 'topbar_menuright' );

 // Menu Item
kt_add_menu_item( 2136, $menu_id, 0, 'Services', 'custom', 2136, 'custom', '#', '', '0', '681' );

kt_add_menu_item( 2137, $menu_id, 0, 'Support', 'custom', 2137, 'custom', '#', '', '0', '' );

//Menu
$menu_id = kt_add_menu( 18, 'Trending', '' );

 // Menu Item
kt_add_menu_item( 34, $menu_id, 0, 'Men\'s Clothing', 'custom', 34, 'custom', '#', '', '0', '' );

kt_add_menu_item( 35, $menu_id, 0, 'Kid\'s Clothing', 'custom', 35, 'custom', '#', '', '0', '' );

kt_add_menu_item( 36, $menu_id, 0, 'Women\'s Clothing', 'custom', 36, 'custom', '#', '', '0', '' );

kt_add_menu_item( 37, $menu_id, 0, 'Accessories', 'custom', 37, 'custom', '#', '', '0', '' );
