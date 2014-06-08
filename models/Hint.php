<?php
	namespace ViagemCultural ;
	use CustomPost, DateTime, DateInterval ;

	class Hint extends CustomPost {

		static $name = "hint" ;
		static $creation_fields = array(
			'label' => 'hint','description' => 'Dicas de viagem sobre uma cidade.',
			'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true,
			'hierarchical' => false,'rewrite' => array('slug' => 'dicas'),'query_var' => true,
			'supports' => array('custom-fields', 'title', 'thumbnail', 'editor'),
			'has_archive' => true, 'taxonomies' => array(), 'menu_position' => 5
		) ;
		static $labels = array (
			'name' => 'Dicas',
			'singular_name' => 'Dica',
			'menu_name' => 'Dicas',
			'add_new' => 'Adicionar nova',
			'add_new_item' => 'Adicionar nova dica',
			'edit' => 'Atualizar',
			'edit_item' => 'Atualizar dica',
			'new_item' => 'Registrar dica',
			'view' => 'Ver',
			'view_item' => 'Ver dica'
		);

		static $icon = '\f118' ;

		static $fields = array(

    ) ;

		static $editable_by = array(

		);

		static function build(){
			$class = get_called_class();
			parent::build();
    }
	}

 ?>