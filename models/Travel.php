<?php
    namespace ViagemCultural ;
    use CustomPost, DateTime, DateInterval ;

    class Travel extends CustomPost {

        static $name = "travel" ;
        static $has = array('video');
        static $creation_fields = array(
            'label' => 'travel','description' => 'Registro de uma viagem realizada.',
            'public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post', 'map_meta_cap' => true,
            'hierarchical' => false,'rewrite' => array('slug' => 'viagem'),'query_var' => true,
            'supports' => array('custom-fields', 'title', 'thumbnail', 'editor', 'comments'),
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
        static $taxonomies = array('region');
        static $fields = array(
            'next' => array('label' => 'Próximo?', 'description' => 'o próximo programa aparece em destaque na home.', 'type' => 'boolean', 'default' => true),
            'teaser' => array('label' => 'Teaser', 'description' => 'texto de chamada para o programa, antes de sua veiculação; exibido no espaço para Próxima Parada.', 'type' => 'editor'),
            'description' => array('label' => 'Descrição Curta', 'description' => 'breve comentário sobre a natureza do programa; exibido junto com o vídeo.', 'type' => 'editor', 'teeny' => true, 'media_buttons' => false)
        );

        static $tabs = array(
            'Conteúdo' => array(),
            'Teasers' => array('teaser', 'description')
        );

        static $editable_by = array(
            'Informações' => array('fields' => array('next'), 'placement' => 'side')
        );

        static $collumns = array(
            'video' => 'Vídeos',
            'next_collumn' => 'Próxima?'
        );

        static function build(){
            $class = get_called_class();
            parent::build();
        }

        public function next_collumn(){
            return $this->next ? 'Sim' : 'Não' ;
        }

        static function next(){
            $results = static::all(array(
                'meta_key' => 'next', 'meta_value' => 1
            ));
            return !empty($results) ? $results[0] : null ; 
        }

        static function others(){
            $next = static::next();
            $next = $next ? array($next->ID) : array() ;
            $results = static::all(array(
                'post__not_in' => $next, 'posts_per_page' => 3
            ));
            return $results ; 
        }

        public function related($ammount = 3){
            $related = array();
            if(!empty(static::$taxonomies)){
                foreach (static::$taxonomies as $tax) {
                    $children = array(); $parents = array();
                    $terms = $this->terms($tax);
                    foreach ($terms as $term) {
                        if($term->parent){
                            $parents[]= $term;
                        } else { $children[]= $term; }
                    }
                    foreach (array_merge($children, $parents) as $term) {
                        if(sizeof($related) > $ammount) break;
                        foreach(static::all(array($tax => $term->slug, 'not' => array_merge(array($this), $related))) as $post) {
                            if(sizeof($related) >= $ammount) break;
                            $related[]= $post ;    
                        }

                    }
                }
            }
            if(sizeof($related) < $ammount){
                $more = array();
                if(!$this->next){
                    $next = static::next(); if($next && !in_array($next, $related)) $more[]= $next ;
                }
                $more = array_merge($more, static::all(array(
                    'not' => array_merge($more, array($this->ID), $related)  
                )));
                foreach($more as $post) {
                    if(sizeof($related) >= $ammount) break;
                    $related[]= $post ;
                }
            }

            return $related ;
        }
    }

 ?>