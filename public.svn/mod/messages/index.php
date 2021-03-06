<?php
/**
 * Elgg messages inbox page
 *
 * @package ElggMessages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd <info@elgg.com>
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
*/


require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
gatekeeper();
global $CONFIG;

$offset = get_input('offset', 0);
$limit = 10;

// Get the logged in user, you can't see other peoples messages so use session id
$page_owner = get_loggedin_user();
set_page_owner($page_owner->getGUID());

// Get the user's inbox, this will be all messages where the 'toId' field matches their guid
// @todo - fix hack where limit + 1 messages are requested 
$messages = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'messages',
	'metadata_name' => 'toId',
	'metadata_value' => $page_owner->getGUID(),
	'owner_guid' => $page_owner->guid,
	'limit' => $limit + 1,
	'offset' => $offset
));

// Set the page title
$area2 = "<div id='content_header'><div class='content_header_title'>";
$area2 .= elgg_view_title(elgg_echo("messages:inbox"))."</div>";
$area2 .= "<div class='content_header_options'><a class='action_button' href='{$CONFIG->wwwroot}mod/messages/send.php'>" . elgg_echo('messages:compose') . "</a></div></div>";

// Display them. The last variable 'page_view' is to allow the view page to know where this data is coming from,
// in this case it is the inbox, this is necessary to ensure the correct display
$area2 .= elgg_view("messages/forms/view",array('entity' => $messages, 'page_view' => "inbox", 'limit' => $limit, 'offset' => $offset));

// Sidebar menu options
//$area3 = elgg_view("messages/menu_options", array('context' => 'inbox'));

// format
$body = elgg_view_layout("one_column_with_sidebar", $area2);


// Draw page
page_draw(sprintf(elgg_echo('messages:user'),$page_owner->name),$body);
