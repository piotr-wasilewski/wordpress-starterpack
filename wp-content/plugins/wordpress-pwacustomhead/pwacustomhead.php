<?php
/*
Plugin Name: Wordpress pwacustomhead
*/


function pwa_custom_head() {

    $user = wp_get_current_user();
//    var_dump($user->data->ID);exit;
    if($user->data->ID !== "2") {

        echo '<style>
                #toplevel_page_elementor,
                #menu-posts-elementor_library, 
                .edit_with_elementor,
                #elementor-switch-mode-button,
                #elementor-editor
                {display: none !important;}
              </style>';

	    echo '<script type="text/javascript">
            console.log("test")
            window.onload = load;

            function load()
            {
                document.querySelector(\'#toplevel_page_elementor\').remove();
                document.querySelector(\'#menu-posts-elementor_library\').remove();
                document.querySelector(\'.edit_with_elementor\').remove();
                document.querySelector(\'#elementor-switch-mode-button\').remove();
                document.querySelector(\'#elementor-editor\').remove();
            }

        </script>';
    }
}
add_action( 'admin_head', 'pwa_custom_head' );
