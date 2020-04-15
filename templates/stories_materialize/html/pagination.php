<?php
/**
 * @version		$Id: pagination.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 * 	Input variable $list is an array with offsets:
 * 		$list[limit]		: int
 * 		$list[limitstart]	: int
 * 		$list[total]		: int
 * 		$list[limitfield]	: string
 * 		$list[pagescounter]	: string
 * 		$list[pageslinks]	: string
 *
 * pagination_list_render
 * 	Input variable $list is an array with offsets:
 * 		$list[all]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[start]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[previous]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[next]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[end]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[pages]
 * 			[{PAGE}][data]		: string
 * 			[{PAGE}][active]	: boolean
 *
 * pagination_item_active
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * pagination_item_inactive
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

function pagination_list_footer($list)
{
	$html = "<div class=\"list-footer\">\n";

	//$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	$html .= $list['pageslinks'];
	//$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";

	// $html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";

	return $html;
}

function pagination_list_render($list)
{
	// Initialize variables
	$html = "<ul class='pagination post-pagination text-center center'>";
	$html .= $list['start']['data'];
	$html .= $list['previous']['data'];

	foreach($list['pages'] as $page) { 
		$html .= $page['data']; 
	}
	$html .= $list['next']['data'];
	$html .= $list['end']['data'];
	// $html .= '&#171;';
	$html .= "</ul>";
	return $html;
}
function pagination_item_active(&$item) {
	$title = $item->text;
	switch($item->text){
		case "Start":
			$item->text = '<i class="material-icons">first_page</i>';
			break;
		case "Prev":
			$item->text = '<i class="material-icons">chevron_left</i>';
			break;
		case "Next":
			$item->text = '<i class="material-icons">chevron_right</i>';
			break;
		case "End":
			$item->text = '<i class="material-icons">last_page</i>';
			break;
	}

	return "<li><a class='waves-effect waves-light' href=\"".$item->link."\" title=\"".$title."\">".$item->text."</a></li>";
}
function pagination_item_inactive(&$item) {
	if (isset($item->active) && $item->active)
	{
		$aria = JText::sprintf('JLIB_HTML_PAGE_CURRENT', $item->text);

		return "<li><span class='current waves-effect waves-light'>$item->text</span></li>";
	}
	// var_dump($item);
	// die;

	switch($item->text){
		case "Start":
			$item->text = '<i class="material-icons">first_page</i>';
			break;
		case "Prev":
			$item->text = '<i class="material-icons">chevron_left</i>';
			break;
		case "Next":
			$item->text = '<i class="material-icons">chevron_right</i>';
			break;
		case "End":
			$item->text = '<i class="material-icons">last_page</i>';
			break;
	}
	
	return "<li><span class='waves-effect waves-light'>$item->text</span></li>";
}
?>
