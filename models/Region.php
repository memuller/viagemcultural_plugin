<?php
	namespace ViagemCultural ;  
	use CustomTaxonomy;

	class Region extends CustomTaxonomy {

		static $name = "region" ;
		static $applies_to = array('travel');
		static $settings = array( 
			'hierarchical' => true, 'has_parent' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'regiao'),
			'show_admin_column' => true,
			'update_count_callback' => '_update_post_term_count'
		);
		static $labels = array(
			'name' => 'Regiões',
			'singular_name' => 'Região',
			'search_items' => 'Buscar Regiões',
			'popular_items' => 'Regiões Mais Frequentes',
			'all_items' => 'Todas as Regiões',
			'parent_item' => 'Região Pai',
			'parent_item_colon' => 'Região Pai',
			'edit_item' => 'Editar Região',
			'update_item' => 'Salvar Região',
			'add_new_item' => 'Adicionar Nova Região',
			'new_item_name' => 'Nome da Nova Região'
		);

		static $fields = array( 
			
		) ;

		static function build(){
			$class = get_called_class();
			parent::build();
		}
	}

 ?>