<?php
	namespace ViagemCultural\Presenters ;
	use Presenter ;

	class Base extends Presenter {

		static function build(){
			$presenter = get_called_class() ;
			parent::build();

			# removes image from the W3TC menu background (so it can use the Dashicons font).
			add_action('admin_footer', function(){?>
				<script>
					jQuery(function($){
						$('#toplevel_page_w3tc_dashboard .wp-menu-image').attr('style', "background: none !important;")
					});
				</script>
			<?php });

			# removes W3TC cache purge action from post lists at the admin.
			add_action( 'admin_head', function() {
				$screen = get_current_screen();
				add_filter('post_row_actions', function($actions) {
					if(isset($actions['pgcache_purge'])) unset($actions['pgcache_purge']) ;
					return $actions ;
				});
				add_filter('mce_css', function($css){
					$css .= ",http://fonts.googleapis.com/css?family=Overlock+SC|Bitter:400%2C400italic%2C700";
					return $css ;
				});
			});

			add_action('admin_notices', function(){
				$results = \ViagemCultural\Video::all(array('meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'travel', 'value' => false, 'type' => 'BOOLEAN'
					),
					array(
						'key' => 'travel', 'compare' => 'NOT EXISTS', 'value' => 'none'
					)
				), 'post_status' => 'draft'));
				if(empty($results)) return null ;
			?> 
				<div class='update-nag'>
					<a href="<?php echo admin_url('/edit.php?post_type=video'); ?>">Novos vídeos encontrados</a>
					 - associe-os a uma Viagem ou exclua-os.
				</div>	
			<?php });

			add_action('admin_menu', function() use($presenter){
				add_submenu_page('edit.php?post_type=video', 'Configurações do Youtube', 'Configurações', 'manage_options', 'viagemcultural_video_options', function() use($presenter){
						$options = get_option('tern_wp_youtube');
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							$options['channels'][1]['channel'] = $_POST['viagemcultural_video_options']['channel'];
							update_option('tern_wp_youtube', $options);
						}
						if($_REQUEST['import']){
							WP_ayvpp_add_posts(1,'*');
						}

						$presenter::render('admin/video', array(
							'page' => '?page=viagemcultural_video_options',
							'options' => array('channel' => $options['channels'][1]['channel'])
						));
				});	
			});
			add_action('admin_init', function(){
				register_setting('viagemcultural_video_options', 'viagemcultural_video_options') ;
			
			});

			add_action('request', function($query){
				if(isset($query['feed'])){
					$query['post_type'] = array('travel','video');
				}
				return $query; 
			});
		}
	}
?>