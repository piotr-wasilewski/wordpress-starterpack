<?php
/*
Plugin Name: Wordpress Pwa Hide all
*/

function wordpresspwahideall($current_user) {

}

//plugins_loaded

//remove_action( 'edit_form_after_title', ['Elementor\Core\Admin\Admin', 'print_switch_mode_button'] );



add_action( 'admin_enqueue_scripts', 'wpse_gutenberg_editor_test' );
function wpse_gutenberg_editor_test() {
    if( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) {

    }
    else {
//        list_hooks();
    }
}

/**
 * Even fancier debug info
 * @props @Danijel http://stackoverflow.com/a/26680808/383847
 * @since 1.7.7
 */
function list_hooks()
{
    global $wp_filter;

    $hooks = $wp_filter;

    foreach ($hooks as &$item) {

        // function name as string or static class method eg. 'Foo::Bar'
        if (is_string($item['function'])) {

            try {

                $ref = strpos($item['function'], '::') ? new ReflectionClass(strstr($item['function'], '::', true)) : new ReflectionFunction($item['function']);
                $item['file'] = $ref->getFileName();
                $item['line'] = get_class($ref) == 'ReflectionFunction'
                    ? $ref->getStartLine()
                    : $ref->getMethod(substr($item['function'], strpos($item['function'], '::') + 2))->getStartLine();

            } catch (Exception $e) {
                $item['error'] = $e->getMessage();
            }

            // array( object, method ), array( string object, method ), array( string object, string 'parent::method' )
        } elseif (is_array($item['function'])) {

            try {
                $ref = new ReflectionClass($item['function'][0]);
                $item['file'] = $ref->getFileName();
                $item['line'] = strpos($item['function'][1], '::')
                    ? $ref->getParentClass()->getMethod(substr($item['function'][1], strpos($item['function'][1], '::') + 2))->getStartLine()
                    : $ref->getMethod($item['function'][1])->getStartLine();

            } catch (Exception $e) {
                $item['error'] = $e->getMessage();
            }

            // closures
        } elseif (is_callable($item['function'])) {

            try {
                $ref = new ReflectionFunction($item['function']);
                $item['function'] = get_class($item['function']);
                $item['file'] = $ref->getFileName();
                $item['line'] = $ref->getStartLine();
            } catch (Exception $e) {
                $item['error'] = $e->getMessage();
            }

        }


    }
    echo '<pre>';
    print_r($hooks);
    exit;

}