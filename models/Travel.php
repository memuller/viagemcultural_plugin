<?php
  namespace ViagemCultural ;
  use CustomPost, DateTime, DateInterval ;

  class Travel extends CustomPost {

    static $name = "travel" ;
    static $has = array('video');
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

    static $fields = array(
      'next' => array('label' => 'Próximo?', 'description' => 'o próximo programa aparece em destaque na home.', 'type' => 'boolean', 'default' => true),
      'teaser' => array('label' => 'Teaser', 'description' => 'texto de chamada para o programa, antes de sua veiculação; exibido no espaço para Próximo Programa.', 'type' => 'richtext'),
      'description' => array('label' => 'Descrição Curta', 'description' => 'breve comentário sobre a natureza do programa; exibido junto com o vídeo.', 'type' => 'text')
    );

    static $tabs = array(
      'Conteúdo' => array(),
      'Teasers' => array('teaser', 'description')
    );

    static $editable_by = array(
      'Informações' => array('fields' => array('next'), 'placement' => 'side')
    );

    static function build(){
      $class = get_called_class();
      parent::build();
    }
  }

 ?>