<?php
/**
 *	Elgg Ajax Comments
 *	Author : Raez Mon | Team Webgalli
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package Elgg Ajax Comments
 * 	Plugin info : Post comments without a page refresh
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */
 
elgg_register_event_handler('init', 'system', 'galliComments_init');

function galliComments_init() {
	elgg_extend_view('js/elgg', 'galliComments/js');
	elgg_register_ajax_view('galliComments/singleriver');		
	elgg_register_action('galliComments/add', elgg_get_plugins_path()."galliComments/actions/comments/add.php");	
}
