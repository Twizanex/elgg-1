<?php
/**
 * Elgg upload new profile icon
 * 
 * @package ElggProfile
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd <info@elgg.com>
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

// Load the Elgg framework
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Make sure we're logged in
if (!isloggedin()) {
	forward();
}

// Get owner of profile - set in page handler
$user = page_owner_entity();
if (!$user) {
	register_error(elgg_echo("profile:notfound"));
	forward();
}

// check if logged in user can edit this profile icon
if (!$user->canEdit()) {
	register_error(elgg_echo("profile:icon:noaccess"));
	forward();
}

// set title
$area1 = elgg_view_title(elgg_echo('profile:createicon:header'));
$area1 .= elgg_view("profile/edit_icon", array('user' => $user));

set_context('profile_edit');

// Get the form and correct canvas area
$body = elgg_view_layout("one_column_with_sidebar", $area1);
	
// Draw the page
page_draw(elgg_echo("profile:editicon"), $body);
