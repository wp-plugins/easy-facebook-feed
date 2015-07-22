<?php
/**
* Plugin Name: Easy Facebook Feed
* Plugin URI: http://stormware.nl/
* Description: Easy Facebook Feed shows your facebook feed on a wordpress page in a easy way
* Version: 0.6
* Author: Tim Wassenburg
* Author URI: http://stormware.nl/
* License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


// include facebook post functions
include_once "includes/posts.include.php";

// include admin options
include_once "includes/options.include.php";

include_once "widget.php";

function getAccessToken(){
    return '1492018151012834|U3qsH98pUZxv5watRRC4c-rg1rc';
}

//get facebook feed
function eff_get_page_feed(){
    $defaults = array(
      'facebook_page_id' => 'bbcnews',
      'facebook_post_limit' => '5'
    );

    $accessToken = getAccessToken();
    $options = get_option( 'eff_options', $defaults );
    $url = "https://graph.facebook.com/".$options['facebook_page_id']."/posts?access_token={$accessToken}&limit=".$options['facebook_post_limit'];
    $json = file_get_contents($url);
    $feed = json_decode($json);

    return $feed;
}

// get page information
function eff_get_page(){
    $defaults = array(
      'facebook_page_id' => 'bbcnews',
      'facebook_post_limit' => '5'
    );

    $fields = 'link,name,cover';
    $accessToken = getAccessToken();
    $options = get_option( 'eff_options', $defaults );
    $url = "https://graph.facebook.com/v2.4/".$options['facebook_page_id']."?fields={$fields}&access_token={$accessToken}";
    $json = file_get_contents($url);
    $page = json_decode($json);

    return $page;
}

// add stylesheet
function eff_stylesheet() {
    wp_register_style( 'eff_bootstrap', plugins_url('css/eff_bootstrap.min.css?8', __FILE__) );
    wp_register_style( 'eff_style', plugins_url('css/eff_style.css?8', __FILE__) );
    wp_enqueue_style( 'eff_bootstrap' );
    wp_enqueue_style( 'eff_style' );
    wp_enqueue_style( 'eff-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), '4.2.0' );
}
add_action( 'wp_enqueue_scripts', 'eff_stylesheet' );

// add settings shortcut
function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=easy-facebook-feed">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

function eff_easy_facebook_feed( $atts ){
	$feed = eff_get_page_feed();
    $page = eff_get_page();
    $return = null;

    foreach ($feed->data as $key => $data) {
        switch ($data->type) {
            case 'photo': 
                $return .= eff_make_photo($data, $page);
                break;
            case 'link': 
                $return .= eff_make_link($data, $page);
                break;
            case 'video': 
                $return .= eff_make_video($data, $page);
                break;
            case 'status': 
                $return .= eff_make_status($data, $page);
                break;
            default:
                // skip unknown types
                break;
        }
    }

	return $return;
}
add_shortcode( 'easy_facebook_feed', 'eff_easy_facebook_feed' );
