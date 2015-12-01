<?php
//Menu
$menu_id = kt_add_menu( 70, 'My account', '' );

 // Menu Item
kt_add_menu_item( 384, $menu_id, 0, 'My Order', 'custom', 384, 'custom', '#', '', '0', '' );

kt_add_menu_item( 385, $menu_id, 0, 'My Wishlist', 'custom', 385, 'custom', '#', '', '0', '' );

kt_add_menu_item( 387, $menu_id, 0, 'My Credit Slip', 'custom', 387, 'custom', '#', '', '0', '' );

kt_add_menu_item( 388, $menu_id, 0, 'My Addresses', 'custom', 388, 'custom', '#', '', '0', '' );

kt_add_menu_item( 389, $menu_id, 0, 'My Personal In', 'custom', 389, 'custom', '#', '', '0', '' );
