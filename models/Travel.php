<?php
  namespace ViagemCultural ;
  use CustomPost, DateTime, DateInterval ;

  class Travel extends CustomPost {

    static $name = "travel" ;
    static $has_many = 'videos';
    static $creation_fields = array(
      'label' => 'travel','description' => 'Registro de uma viagem realizada.',
      'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true,
      'hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,
      'supports' => array('custom-fields', 'title', 'thumbnail', 'editor'),
      'has_archive' => true, 'taxonomies' => array(), 'menu_position' => 5
    ) ;
    static $labels = array (
      'name' => 'Viagems',
      'singular_name' => 'Viagem',
      'menu_name' => 'Viagems',
      'add_new' => 'Adicionar nova',
      'add_new_item' => 'Adicionar nova viagem',
      'edit' => 'Atualizar',
      'edit_item' => 'Atualizar viagem',
      'new_item' => 'Registrar viagem',
      'view' => 'Ver',
      'view_item' => 'Ver dica'
    );

    static $icon = '\f319' ;

    static $fields = array();

    static $editable_by = array();

    static function build(){
      $class = get_called_class();
      parent::build();
    }
  }

 ?>