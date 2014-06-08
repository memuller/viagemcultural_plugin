<?php
	namespace ViagemCultural\Presenters ;
	use Presenter ;

	class Base extends Presenter {

		static function build(){
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
		}
	}
?>