<?php
/*
Plugin Name: List Multisite Sites
Plugin URI: https://github.com/mirhec/list-multisite-sites
Description: ...
Version: 1.0
Author: Mirko Hecky
Author URI: none
License: GPL2
*/

add_action('init', 'list_multisite_sites_register_shortcodes');

function list_multisite_sites_register_shortcodes() {
    // register shortcode [list_multisite_sites]
    add_shortcode('list_multisite_sites', 'do_list_multisite_sites');
    add_shortcode('list_multisite_sites_sum_cfdb', 'do_list_multisite_sites_sum_cfdb');
}

function do_list_multisite_sites_sum_cfdb($args, $content) {
    global $wpdb;

    if(!is_multisite()) return;

    $spacer = '<br>';
    if(isset($args['spacer']))
        $spacer = $args['spacer'];

    $formname = '';
    if(isset($args['form_name']))
        $formname = $args['form_name'];
    else
        return do_list_multisite_sites($args, $content);

    $fieldname = '';
    if(isset($args['field_name']))
        $fieldname = $args['field_name'];
    else
        return do_list_multisite_sites($args, $content);

    $retval = '';
    if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
        $sites = get_sites();
        foreach($sites as $site) {
            $site_id = get_object_vars($site)["blog_id"];
            $url = get_blog_details($site_id)->siteurl;
            $site_name = get_blog_details($site_id)->blogname;
            $db_prefix = $wpdb->get_blog_prefix($site_id);
            $sum = $wpdb->get_var( $wpdb->prepare(
                "SELECT SUM(CONVERT(field_value, SIGNED INTEGER)) FROM ". $db_prefix . "cf7dbplugin_submits
                WHERE `form_name` LIKE %s
                AND `field_name` LIKE %s",
                $formname, $fieldname
            ), 0, 0 );
            if($sum == '') $sum = 0;

            $sum = number_format($sum, 2, ',', '.');
            $retval = $retval . '<a href="' . $url . '">' . $site_name . ' (' . $sum . ' €)</a>' . $spacer;
        }
    } else {
        $retval = 'get_sites does not exist';
    }
    return $retval;
}

function do_list_multisite_sites($args, $content) {
    $spacer = '<br>';
    if(isset($args['spacer']))
        $spacer = $args['spacer'];

    $retval = '';
    if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
        $sites = get_sites();
        foreach($sites as $site) {
            $site_id = get_object_vars($site)["blog_id"];
            $url = get_blog_details($site_id)->siteurl;
            $site_name = get_blog_details($site_id)->blogname;
            $retval = $retval . '<a href="' . $url . '">' . $site_name . '</a>' . $spacer;
        }
    } else {
        $retval = 'get_sites does not exist';
    }
    return $retval;
}

?>
