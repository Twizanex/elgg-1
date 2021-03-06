<?php
/**
* TinyMCE CSS
*/
?>
#elgg_page_contents .mceButton {
background-color: #e9e8e8;
	border-color: #B2B2B2;
	margin:4px;
	padding:2px;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
}
#elgg_page_contents a.mceButtonEnabled:hover,
#elgg_page_contents a.mceButtonActive,
#elgg_page_contents a.mceButtonSelected {
	background-color: #d5d5d5;
	border-color: #777 !important;
}
#elgg_page_contents .mceFocus .mceTop .mceLeft {
	background: #444444;
	border-left: 1px solid #999;
	border-top: 1px solid #999;
	-moz-border-radius: 4px 0 0 0;
	-webkit-border-top-left-radius: 4px;
	-khtml-border-top-left-radius: 4px;
	border-top-left-radius: 4px;
}
#elgg_page_contents .mceFocus .mceTop .mceRight {
	background: #444444;
	border-right: 1px solid #999;
	border-top: 1px solid #999;
	border-top-right-radius: 4px;
	-khtml-border-top-right-radius: 4px;
	-webkit-border-top-right-radius: 4px;
	-moz-border-radius: 0 4px 0 0;
}
#elgg_page_contents .mceLayout{
border: 1px solid #CCC;
	-webkit-border-radius: 5px; 
	-moz-border-radius: 5px;
}
#elgg_page_contents table.mceLayout tr.mceFirst td {border-top:0px solid #CCC}
#elgg_page_contents table.mceLayout tr.mceLast td {border-bottom:0px solid #CCC}
#elgg_page_contents #blogbody_toolbar1{}
#elgg_page_contents .mceToolbar{}
#elgg_page_contents #blogbody_ifr{height:400px !important;} /* blogs */
#pagesForm #description_ifr {height:400px !important;} /* pages */
#elgg_page_contents .mceIframeContainer{}
.wp_themeSkin .mceButtonDisabled {
	border-color: #ccc !important;
}