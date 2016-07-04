<?php

/***************************************************************************
 * TwizaNex Smart Community Software
 * ---------------------------------
 * Start.php: Elgg Ajax Comments
 *        
 * begin : Mon Mar 23 2011
 * copyright : (C) 2016 TwizaNex Group
 * website : http://www.TwizaNex.com/
 * This file is part of TwizaNex - Smart Community Software
 *
 * @package Twizanex
 * @link http://www.twizanex.com/
 * TwizaNex is free software. This work is licensed under a GNU Public License version 2.
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @author Tom Ondiba <twizanex@yahoo.com>
 * 
 * Author : Raez Mon | Team Webgalli
 * Team Webgalli | Elgg developers and consultants
 * Mail : info@webgalli.com
 * Web	: http://webgalli.com
 * Skype : 'team.webgalli'
 * @package Elgg Ajax Comments
 *  Plugin info : Post comments without a page refresh
 * Licence : GNU2
 * Copyright : Team Webgalli 2011-2015
 * @copyright Twizanex Group 2014
 * TwizaNex is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Public License version 2 for more details.
 * For any questions or suggestion write to write to twizanex@yahoo.com
 *
***************************************************************************/

 
elgg_register_event_handler('init', 'system', 'galliComments_init');

function galliComments_init() {
	elgg_extend_view('js/elgg', 'galliComments/js');
	elgg_register_ajax_view('galliComments/singleriver');		
	elgg_register_action('galliComments/add', elgg_get_plugins_path()."galliComments/actions/comments/add.php");	
}
