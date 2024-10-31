<?php

/*
Plugin Name: MyAnime Widget
Plugin URI: http://www.myanime.me/widget
Description: Plugin displaying the latest anime fansubs
Author: Regios
Version: 1.1
Author URI: http://www.myanime.me
License: MIT
*/



add_action('plugins_loaded', 'myanime_loaded');
add_action('admin_menu', 'myanime_admin_actions');

function myanime_admin() {	

	include('myanime_import_admin.php');
}


function myanime_admin_actions() {
	add_options_page("MyAnime Widget", "MyAnime", 1, "myanime_import_admin.php", "myanime_admin");
}

	

function myanime_loaded()
{
        $widget_ops = array('classname' => 'myanime_widget', 'description' => "MyAnime widget for your sidebar." );
        wp_register_sidebar_widget('myanime_widget', 'MyAnime', 'myanime_widget', $widget_ops);
}



function myanime_widget() {

echo "<div id='myanimefeed'></div>";

$opts = array("select", "unique", "latestonly", "series", "subber", "username", "width", "margin", "results", "iconsize", "knownonly", "roundcorners",
"fontfamily", "highlight", "showseeders", "showleechers", "showsize", "showres", "showsubber", "showformat", "showdate", "shortformat", "fgcolor",
"bgcolor", "bordercolor", "iconbordercolor", "linkcolor", "hlcolor");

$params = '';

foreach ($opts as $opt)
{
	$optval = get_option("myanime_".$opt);
	if ($optval != '') $params .= '&'.$opt.'='.strtolower($optval);
}

if( !class_exists( 'WP_Http' ) )
    include_once( ABSPATH . WPINC. '/class-http.php' );
	
$request = new WP_Http;
$output = $request->request( "http://www.myanime.me/infowidget.php?parent=myanimefeed".$params);

echo $output["body"];

}

?>