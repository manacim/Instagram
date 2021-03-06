<?php
/*
Theme Name: Instagram
Theme URI: https://github.com/manacim/Instagram
Author: Cim
Author URI: https://demyx.com/
Description: Instagram widget that displays up to 9 recent posts.
Version: 2.0.0
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: instagram
*/

$widget = elgg_extract('entity', $vars);
$username = $widget->username;
$number = $widget->num_display;
$json = file_get_contents('https://www.instagram.com/'.$username.'/media/');
$content = json_decode($json);
$items = $content->items;
$instagram_class = '';

if (empty($username)) {
	echo elgg_echo('instagram:empty');
	return;
}

echo '<ul class="instagram-list">';
foreach ($items as $key => $value) {
	if ($key == $number) break;
	switch ($number) {
	    case 1:
	        $instagram_class = 'ig-1';
	        break;
	    case 3:
	        $instagram_class = 'ig-3';
	        break;
	    case 6:
	        $instagram_class = 'ig-6';
	        break;
	    default:
	        $instagram_class = 'ig-9';
	}
	echo '<li class="'.$instagram_class.'">';
		echo elgg_view('output/url', [
		   'text' => '<img src="' . $value->images->standard_resolution->url . '">',
		   'href' => 'javascript:',
		   'class' => 'elgg-lightbox',
		   'data-colorbox-opts' => json_encode([
		   		'width' => '500px',
		   		'height' => '600px',
		   		'href' => elgg_normalize_url('ajax/view/instagram/view' . '?id=' . $key . '&username=' . $username),
		   		'className' => 'ig-colorbox'
		   	])
		]);
	echo '</li>';
}
echo '</ul>';