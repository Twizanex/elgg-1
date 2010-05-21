<?php

/**
 * Elgg categories plugin
 *
 * @package ElggCategories
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd <info@elgg.com>
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

/**
 * Initialise categories plugin
 *
 */
function categories_init() {
	global $CONFIG;

	elgg_extend_view('css', 'categories/css');

	register_action('settings/categories/save', FALSE, $CONFIG->pluginspath . 'categories/actions/save.php', TRUE);

	register_page_handler('categories', 'categories_page_handler');

	register_elgg_event_handler('update','all','categories_save');
	register_elgg_event_handler('create','all','categories_save');
}


/**
 * Page handler
 *
 */
function categories_page_handler() {
	include(dirname(__FILE__) . "/listing.php");
	return TRUE;
}

/**
 * Save site categories to and object upon save / edit
 *
 */
function categories_save($event, $object_type, $object) {
	if ($object instanceof ElggEntity) {
		$marker = get_input('universal_category_marker');

		if ($marker == 'on') {
			$categories = get_input('universal_categories_list');

			if (empty($categories)) {
				$categories = array();
			}

			$object->universal_categories = $categories;
		}
	}
	return TRUE;
}

/**
 * Add a reminder to set default categories.
 */
function categories_on_enable() {
	if (!$site->categories) {
		global $CONFIG;
		$message = sprintf(elgg_echo('categories:on_enable_reminder'), "{$CONFIG->url}pg/admin/plugin_settings/categories");
		elgg_add_admin_notice('categories_admin_notice_no_categories', $message);
	}
	return TRUE;
}

/**
 * Clean up admin notices on disable.
 */
function categories_on_disable() {
	elgg_delete_admin_notice('categories_admin_notice_no_categories');
}

register_elgg_event_handler('init','system','categories_init');