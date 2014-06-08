<?php
	namespace ViagemCultural ;
	use BasePlugin ;

	class Plugin extends BasePlugin {

		static $db_version = '0' ;
		static $custom_posts = array('Travel', 'Hint', 'Video', 'Plan', 'Help');
		static $custom_post_formats = array();
		static $custom_users = array();
		static $presenters = array();
		static $has_translations = false ;

		static $absent_roles = array();
		static $restricted_menus = array('Posts');
		static $restrict_for_everyone = true;

		static $migrations = array(

		);

		static $query_vars = array(

		);
		static $rewrite_rules = array(

		);

		static function build(){
			parent::build();
			add_filter( 'got_rewrite', '__return_true', 999 );

		}
	}

 ?>