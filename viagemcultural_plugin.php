<?php
	/*
	Plugin Name: Viagem Cultural
	Version: 0.0.1
	Plugin URI: http://memuller.com
	Description:
	Author: Matheus Muller
	Author URI: http://memuller.com
	*/

	/*
	Copyright (c) 2014, Matheus Muller

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/


	# Requires vendored libs and base structure.
	require_once 'lib/vendors/haml/HamlParser.class.php' ;
	#require_once 'lib/vendors/recaptcha-php/recaptchalib.php';
	if(!class_exists('BasePlugin')) require_once 'lib/BasePlugin.php' ;
	if(!class_exists('Presenter')) require_once 'lib/Presenter.php' ;
	if(!class_exists('BaseItem')) require_once 'lib/BaseItem.php' ;
	if(!class_exists('BasePost')) require_once 'lib/BasePost.php' ;
	if(!class_exists('DB_Object')) require_once 'lib/DB_Object.php' ;
	if(!class_exists('CustomPost')) require_once 'lib/CustomPost.php' ;
	if(!class_exists('CustomPostFormat')) require_once 'lib/CustomPostFormat.php' ;
	if(!class_exists('CustomTaxonomy')) require_once 'lib/CustomTaxonomy.php' ;
	if(!class_exists('CustomUser')) require_once 'lib/CustomUser.php' ;
	if(!class_exists('Translation')) require_once 'lib/Translation.php' ;
	# Requires WP table/list framework.
	if(!class_exists('WP_List_Table')) require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

	require 'base/Base.php' ;
	ViagemCultural\Plugin::build();

	require 'vendors/automatic-youtube-video-posts/tern_wp_youtube.php'
?>
