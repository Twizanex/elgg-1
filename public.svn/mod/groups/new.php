<?php
	/**
	 * Elgg groups plugin
	 * 
	 * @package ElggGroups
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 */

	gatekeeper();

	set_page_owner(get_loggedin_userid());

	// Render the file upload page
	$title = elgg_echo("groups:new");
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view("forms/groups/edit");
	
	$body = elgg_view_layout('one_column_with_sidebar', $area1.$area2);
	
	page_draw($title, $body);
?>