<?php
/**
* Kaltura video client
* @package ElggKalturaVideo
* @license http://www.gnu.org/licenses/gpl.html GNU Public License version 3
* @author Ivan Vergés <ivan@microstudi.net>
* @copyright Ivan Vergés 2010
* @link http://microstudi.net/elgg/
**/


	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// Get the specified blog post
	$post = (int) get_input('videopost');

	// If we can get out the blog post ...
	if ($videopost = get_entity($post)) {

	// Set the page owner
		set_page_owner($videopost->getOwner());
		$page_owner = get_entity($videopost->getOwner());

	// Display it
		$area2 = elgg_view("kaltura/view");
	// Set the title appropriately
		$title = sprintf(elgg_echo("kalturavideo:posttitle"),$page_owner->name,$videopost->title);
		$area1 = elgg_view_title($videopost->title);

	// Display through the correct canvas area
		$body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2 , $area3 );

	// If we're not allowed to see the blog post
	} else {

	// Display the 'post not found' page instead
			$body = elgg_view("kaltura/notfound");
			$title = elgg_echo("kalturavideo:notfound");

	}

	// Display page
	page_draw($title,$body);

?>
