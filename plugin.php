<?php
/*
Plugin Name: AJAX Random Post
Plugin URI: http://mr.hokya.com/ajax-random-post/
Description: Show randomized post summary on your dashboard and cycle them with AJAX and JQuery animation to drag more visitor and let your visitor know more about your other posts.
Version: 2.00
Author: Julian Widya Perdana
Author URI: http://mr.hokya.com/
*/

if (!get_option("arp_count")) update_option("arp_count",5);
if (!get_option("arp_title")) update_option("arp_title","AJAX Random Post");
if (!get_option("arp_interval")) update_option("arp_interval",5);

function arp_widget ($args) {
	global $wpdb;
	extract($args);
	$home = get_option("home");
	$title = get_option("arp_title");
	$count = get_option("arp_count");
	$interval = get_option("arp_interval");
	echo $before_widget.$before_title.$title.$after_title;
	echo '<ul id="ajax-random-post">';
	$result = $wpdb->get_results("select * from $wpdb->posts where post_status='publish'");
	$random = array();
	foreach ($result as $result) {
		array_push($random,$result->ID);
	}
	shuffle($random);
	for ($i=0;$i<$count;$i++) {
		echo "<li>";
		$post = get_post($random[$i]);
		$title = $post->post_title;
		$excerpt = substr(strip_tags($post->post_content),0,300);
		$link = get_permalink($random[$i]);
		echo "<h4><a href='$link'>$title</a></h4>$excerpt";
		echo "</li>";
	}
	echo '</ul>';
	echo $after_widget;
	echo "<script src='$home/wp-content/plugins/ajax-random-post/jquery.js'></script>\n";
	echo "<script src='$home/wp-content/plugins/ajax-random-post/js.php?count=$count&interval=$interval'></script>\n";
	echo "\n\n<!-- AJAX Random Post is created by Julian Widya Perdana: mr.hokya.com -->\n\n";
	echo "<noscript><em>Please enable JavaScript for better <a href='http://mr.hokya.com/ajax-random-post/' target='_blank'>AJAX Random Post</a> animation</em></noscript>";
}

function arp_control () {
	if ($_POST["arp_submit"]) {
		update_option("arp_title",$_POST["title"]);
		update_option("arp_count",$_POST["count"]);
		update_option("arp_interval",$_POST["interval"]);
	}
	$title = get_option("arp_title");
	$count = get_option("arp_count");
	$interval = get_option("arp_interval");
	
	echo "<input type='hidden' name='arp_submit' value=1/>";
	echo "<p>Title:<input name='title' value='$title'/></p>";
	echo "<p>Max Items :<input name='count' value='$count' size=2/></p>";
	echo "<p>Interval per transition :<input name='interval' value='$interval' size=2/> second(s)</p>";
	echo "<p><small><a href='http://mr.hokya.com/ajax-random-post/' target='_blank'>Help ?</a></small></p>";
}

function arp_register () {
	register_sidebar_widget("AJAX Random Post","arp_widget");
	register_widget_control("AJAX Random Post","arp_control");
}

add_action('plugins_loaded','arp_register');
// by Julian Widya Perdana FTE UGM Yogyakarta 2009
?>