<?php

function wabtn_style() {
	$plugins_url = plugins_url();
	wp_enqueue_style( 'wabtn-style', $plugins_url.'/whatsapp/style.css' );
}

add_action( 'wp_enqueue_scripts', 'wabtn_style' );

//AUTO BUTTON INSERTION
function wa_btn($content) {
	$options = get_option('wa_btn');
	if (!isset($options['top'])) {$options['top'] = "off";}
	if (!isset($options['btm'])) {$options['btm'] = "off";}
	if (!isset($options['posts'])) {$options['posts'] = "off";}
	if (!isset($options['pages'])) {$options['pages'] = "off";}
	if (!isset($options['homepage'])) {$options['homepage'] = "off";}
	if (!isset($options['tracking'])) {$tracking = "";} else {$tracking='?utm_source=WhatsApp%26utm_medium=IM%26amp;utm_campaign=share%20button';}
	$btn='';
	if (
	   (is_single() && $options['posts'] == 'on') ||
       (is_page() && $options['pages'] == 'on') ||
       ((is_home() || is_front_page()) && $options['homepage'] == 'on')) {
		$btn = '<!-- WhatsApp Share Button for WordPress: http://peadig.com/wordpress-plugins/whatsapp-share-button/ --><div class="wabtn_container"><a href="whatsapp://send?text='.get_the_title().' - '.get_permalink().$tracking.'" class="wabtn">Share this on WhatsApp</a></div>';
      	if ($options['top'] == 'on' && $options['btm'] == 'on') {$output = $btn.$content.$btn;}
      	elseif ($options['top'] == 'on' && $options['btm'] != 'on') {$btn .= $content; $output = $btn;}
      	elseif ($options['top'] != 'on' && $options['btm'] == 'on') {$output = $content.$btn;}
      	else {$output = $content;}
	} else {$output = $content;}
	return $output;
}
add_filter ('the_content', 'wa_btn', 100);


function wa_btn_shortcode($waatts) {
    extract(shortcode_atts(array(
    	"waatts" => get_option('wa_btn'),
		"title" => get_the_title(),
		"url" => get_permalink(),
    ), $waatts));
    if (!empty($waatts)) {
        foreach ($waatts as $key => $option)
            $waatts[$key] = $option;
	}
	if (!isset($waatts['tracking'])) {$tracking = "";} else {$tracking='?utm_source=WhatsApp%26utm_medium=IM%26amp;utm_campaign=share%20button';}
	$btn = '<!-- WhatsApp Share Button for WordPress: http://peadig.com/wordpress-plugins/whatsapp-share-button/ --><div class="wabtn_container"><a href="whatsapp://send?text='.$title.' - '.$url.$tracking.'" class="wabtn">Share this on WhatsApp</a></div>';
	return $btn;
}
add_filter('widget_text', 'do_shortcode');
add_shortcode('whatsapp', 'wa_btn_shortcode');


?>