<?php
//Menu
$menu_id = kt_add_menu( 334, 'Custom Menu footer', 'custom_footer_menu' );

 // Menu Item
kt_add_menu_item( 1884, $menu_id, 0, 'About Us', 'custom', 1884, 'custom', '#', '', '0', '' );

kt_add_menu_item( 1885, $menu_id, 0, 'Affiliates', 'custom', 1885, 'custom', '#', '', '0', '' );

kt_add_menu_item( 1886, $menu_id, 0, 'Careers', 'custom', 1886, 'custom', '#', '', '0', '' );
