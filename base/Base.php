<?php
	namespace ViagemCultural ;
	use BasePlugin, SplFileObject ;

	class Plugin extends BasePlugin {

		static $db_version = '0.6' ;
		static $custom_posts = array('Travel', 'Video', 'Help');
		static $custom_taxonomies = array('Region');
		static $custom_post_formats = array();
		static $custom_users = array();
		static $presenters = array();
		static $has_translations = false ;

		static $absent_roles = array();
		static $restricted_menus = array('Posts');
		static $restrict_for_everyone = true;

		static $migrations = array(
			'0.1' => 'ayvp_settings',
			'0.2' => 'post_type_field_size',
			'0.3' => 'drupal_database',
			'0.4' => 'drupal_content',
			'0.5' => 'drupal_post_types',
			'0.6' => 'region_defaults'

		);

		static $query_vars = array(

		);
		static $rewrite_rules = array(

		);

		static function build(){
			parent::build();
			add_filter( 'got_rewrite', '__return_true', 999 );

		}

		static function migrate_region_defaults(){
			$taxes = array(
				'Nacional' => array('Centro-Oeste', 'Nordeste', 'Norte', 'Sul', 'Sudeste'),
				'Internacional' => array('África', 'América', 'Ásia', 'Europa', 'Oceania')
			);
			foreach ($taxes as $parent_name => $names) {
				$parent = wp_insert_term($parent_name, 'region');
				foreach ($names as $name) {
					wp_insert_term($name, 'region', array('parent' => $parent['term_id']));
				}
			}
		}

		static function migrate_ayvp_settings(){
			global $wpdb;
			$wpdb->delete($wpdb->options, array('option_name' => 'tern_wp_youtube'));
			$wpdb->insert($wpdb->options, array(
				'option_name' => 'tern_wp_youtube',
				'option_value' => 'a:15:{s:7:"publish";s:1:"0";s:12:"display_meta";s:1:"0";s:5:"words";s:2:"20";s:4:"dims";a:2:{i:0;s:3:"506";i:1;s:3:"304";}s:7:"related";s:1:"0";s:6:"inlist";s:1:"0";s:4:"cron";s:1:"6";s:4:"user";s:0:"";s:8:"channels";a:2:{i:1;a:6:{s:2:"id";i:1;s:4:"name";s:21:"Canal Viagem Cultural";s:7:"channel";s:18:"progviagemcultural";s:4:"type";s:7:"channel";s:10:"categories";a:1:{i:0;s:1:"1";}s:6:"author";s:1:"1";}i:0;a:1:{s:7:"channel";s:18:"progviagemcultural";}}s:3:"rss";i:0;s:5:"limit";i:4;s:5:"pages";i:0;s:11:"last_import";i:1406047847;s:12:"is_importing";b:0;s:7:"version";i:206;}',
				'autoload' => 'yes'
			));
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