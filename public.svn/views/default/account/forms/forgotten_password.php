<?php
/**
 * Elgg forgotten password.
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

$form_body = "<p>" . elgg_echo('user:password:text') . "</p>";
$form_body .= "<p><label>". elgg_echo('username') . " "
	. elgg_view('input/text', array('internalname' => 'username')) . "</label></p>";
$form_body .= elgg_view('input/captcha');
$form_body .= "<p>" . elgg_view('input/submit', array('value' => elgg_echo('request'))) . "</p>";

echo elgg_view('input/form', array(
	'action' => "{$vars['url']}action/user/requestnewpassword",
	'body' => $form_body,
	'class' => "margin_top"
));
?>

<script type="text/javascript">
	$(document).ready(function() { $('input[name=username]').focus(); });
</script>