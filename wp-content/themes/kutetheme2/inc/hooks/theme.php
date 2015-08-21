<?php
function kt_init_session_start(){
    if(!session_id()) {
        session_start();
    }
}
add_action('init', 'kt_init_session_start', 1);
