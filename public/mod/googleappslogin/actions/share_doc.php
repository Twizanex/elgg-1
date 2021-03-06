<?php

$doc_id = get_input('doc_id');
$comment = get_input('comment', '');
$tags = get_input('tags', '');
$activity_access = get_input('access', '');
$group_channel = get_input('group_channel', '');

$to_share=array();
$to_share['doc_id']=$doc_id;
$to_share['comment']=$comment;
$to_share['access']=$activity_access;
$to_share['group_channel']=$group_channel;
$to_share['tags']=$tags;
$_SESSION['google_docs_to_share_data']=serialize($to_share); // remember data

if ( is_null($doc_id) ) {
    echo elgg_echo("googleappslogin:doc:share:no_doc_id");
    exit;
}

if( empty($comment)) {
    echo elgg_echo("googleappslogin:doc:share:no_comment");
    exit;
}

$google_docs = unserialize($_SESSION['oauth_google_docs']);

$user = $_SESSION['user'];
$doc = $google_docs[$doc_id];
$doc_access = $doc['collaborators'];

if ($activity_access == 'group') {
	$members = get_group_or_channel_members($group_channel);
} else {
	$members = null;
}

if (! check_document_permission($doc_access, $activity_access, $members) ) {

	$area2 .= '
	<script>
	function save_answer(el) {
		el.form.answer.value = el.value;
	}
	</script>';
	$area2 .= '<div class="contentWrapper singleview">';
	$area2 .= '<form action="'. $GLOBALS['change_doc_permissions_url'] .'" onsubmit="return ajax_submit(this);"  method="post">';
	$area2 .= '<h3>'.elgg_echo('googleappslogin:doc:share:wrong_permissions').'</h3>';
	$area2 .= '<input type="hidden" value="" name="answer">&nbsp;';
	$area2 .= '<input type="submit" value="Grant view permisson" onclick="save_answer(this)">&nbsp;';
	$area2 .= '<input type="submit" value="Ignore and continue" onclick="save_answer(this)">&nbsp;';
	$area2 .= '<input type="submit" value="Cancel" onclick="save_answer(this)">&nbsp;';
	$area2 .= '</div><div class="clearfloat"></div>';
	echo $area2;
	exit;
 } else {

     if ($activity_access == 'group') {
         $doc_access = get_group_or_channel_members($group_channel); // rewrite access to group members
    }

     share_document($doc, $user, $comment, $tags, $activity_access, $doc_access); // Share and public document activity
     echo elgg_echo("googleappslogin:doc:share:ok");
     exit;
 }




?>
