<?php
  namespace ViagemCultural ;
  use CustomPost, DateTime, DateInterval ;

  class Plan extends CustomPost {

    static $name = "plan" ;
    static $creation_fields = array(
      'label' => 'plan','description' => 'Teaser de uma viagem futura.',
      'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true,
      'hierarchical' => false,'rewrite' => array('slug' => 'proxima-parada'),'query_var' => true,
      'supports' => array('custom-fields', 'title', 'thumbnail', 'editor'),
      'has_archive' => true, 'taxonomies' => array(), 'menu_position' => 5
    ) ;
    static $labels = array (
      'name' => 'Plano',
      'singular_name' => 'Planos',
      'menu_name' => 'Próxima Parada',
      'add_new' => 'Adicionar novo',
      'add_new_item' => 'Adicionar novo plano',
      'edit' => 'Atualizar',
      'edit_item' => 'Atualizar plano',
      'new_item' => 'Registrar plano',
      'view' => 'Ver',
      'view_item' => 'Ver plano'
    );

    static $icon = '\f145' ;

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