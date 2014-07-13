<?php
	namespace ViagemCultural ;
	use BasePlugin, SplFileObject ;

	class Plugin extends BasePlugin {

		static $db_version = '0.0' ;
		static $custom_posts = array('Travel', 'Video', 'Help');
		static $custom_post_formats = array();
		static $custom_users = array();
		static $presenters = array();
		static $has_translations = false ;

		static $absent_roles = array();
		static $restricted_menus = array('Posts');
		static $restrict_for_everyone = true;

		static $migrations = array(
			'0.1' => 'post_type_field_size',
			'0.2' => 'drupal_database',
			'0.3' => 'drupal_content',
			'0.4' => 'drupal_post_types'

		);

		static $query_vars = array(

		);
		static $rewrite_rules = array(

		);

		static function build(){
			parent::build();
			add_filter( 'got_rewrite', '__return_true', 999 );

		}

		static function migrate_post_type_field_size(){
			global $wpdb; 
			$wpdb->query("ALTER TABLE $wpdb->posts MODIFY post_type VARCHAR(50)");
		}
		static function migrate_drupal_database(){
			global $wpdb; 
			ini_set('memory_limit','256M');
			$query = '';
			$file = new SplFileObject(static::path('/data/drupal.sql'));
			while(! $file->eof()){
				$line = $file->current();
				if(substr($line, 0, 2) == '--' || $line == ''){ continue; }
				$query .= $line ;					
				if(substr(trim($line), -1, 1) == ';'){
					$wpdb->query($query);
					$query = '';
				}
				$file->next();
			}
			$file = null ; 

		}
		static function migrate_drupal_content(){
			global $wpdb;
			ini_set('memory_limit', '256M');
			$query = '';
			$file = new SplFileObject(static::path('/data/drupal-to-wordpress.sql'));
			while(! $file->eof()){
				$line = $file->current();
				if(substr($line, 0, 2) == '--' || substr($line, 0, 2) == '#' ||  $line == ''){ continue; }
				
				$line = str_replace('wp_', $wpdb->prefix, $line);
				$query .= $line ;					
				if(substr(trim($line), -1, 1) == ';'){
					$wpdb->query($query);
					$query = '';
				}
				$file->next();
			}
			$file = null ; 
		}
		static function migrate_drupal_post_types(){
			
		}

	}

 ?>