<?php
	namespace ViagemCultural ;
	use CustomPost ;

	class Help extends CustomPost {
		static $name = "help" ;
		static $creation_fields = array(
			'label' => 'help','description' => 'Uma página de ajuda.',
			'public' => false,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true,
			'hierarchical' => true,
			'supports' => array('custom-fields', 'title', 'editor', 'page-attributes'),
			'has_archive' => false, 'taxonomies' => array(),
			'labels' => array (
				'name' => 'Ajuda',
				'singular_name' => 'Página de ajuda',
				'menu_name' => 'Ajuda',
				'add_new' => 'Nova página',
				'add_new_item' => 'Nova página',
				'edit' => 'Atualizar',
				'edit_item' => 'Atualizar página',
				'new_item' => 'Registrar',
				'view' => 'Ver',
				'view_item' => 'Ver'),
			 'menu_position' => 80
		) ;
		static $icon = '\f223';
		static $fields = array(
			'description' => array('label' => 'Descrição', 'type' => 'text_area')
		) ;

		static $editable_by = array(
			'form_advanced' => array('fields' => array('description'))
		);

		static $absent_actions = array('quick-edit');

		static $absent_collumns = array(
			'views', 'likes', 'date'
		);

		static $collumns = array(
			'description' => 'Descrição'
		);

		public function description(){
			return "<em>$this->description</em>" ;
		}

		static function build(){
			parent::build();
			add_action('admin_menu', function(){
				remove_submenu_page('edit.php?post_type=help', 'post-new.php?post_type=help') ;
			});
		}

	}

 ?>