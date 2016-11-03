<?php
/*
Plugin Name: The Andy Parmo Random Insult Generator
Plugin URI:  https://andyparmo.co.uk
Description: Adds a random insult generator. Use shortcode [insult-generator] to display the random insult generator anywhere in your site.
Version:     1.0.0
Author:      Andy Parmo
Author URI:  https://andyparmo.co.uk
Text Domain: aprig
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/gpl-3.0.html.
*/

if( !class_exists( 'APRIG' ) ){	
	
	
	class APRIG{
	

		public function __construct(){

			add_action( 'wp_enqueue_scripts', array( $this, 'aprig_scripts' ) );
			add_action( 'wp_ajax_aprig_insult', array( $this, 'aprig_insult' ) );
			add_action( 'wp_ajax_nopriv_aprig_insult', array( $this, 'aprig_insult' ) );
			add_action( 'wp_footer', array( $this, 'aprig_insult_javascript' ) );
			add_shortcode( 'insult-generator', array( $this, 'aprig_display_generator' ) );
			 
		}
		
		
		
		
		
		public function aprig_scripts(){
					 
			wp_enqueue_style( 'aprig-style', plugin_dir_url( __FILE__ ) . 'assets/css/aprig-style.css' );

		}
		
		
		
		
		
		public function aprig_insult_javascript(){
		
			?>
			<script>
			jQuery('#aprig-get-new-insult').on( 'click', function( e ){
				e.preventDefault();
				var data = {
					'action': 		'aprig_insult',
					'security': 	'<?php echo wp_create_nonce("aprig_insult_nonce"); ?>'
				};
				var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
				function ajax_refresh(){
					jQuery.post(ajaxurl, data, function(response){
						jQuery('#aprig-container h3#aprig-insult').html(response);
						
					});
				}
				ajax_refresh();
			});
			</script>
			
			<?php
		}
		
		
		
		

		public static function aprig_insult(){

			check_ajax_referer( 'aprig_insult_nonce', 'security' );
			
			$list1 = array(
				'jizz',
				'fuck',
				'shit',
				'turd',
				'piss',
				'cum',
				'twat',
				'butt',
				'minge',
				'bollock',
				'cunt',
				'hoof',
				'scrote'
			);

			$list2 = array(
				'wizzling',
				'gargling',
				'wangling',
				'nudging',
				'licking',
				'wanking',
				'hoofing',
				'slurping',
				'eating',
				'guzzling',
				'snorting',
				'shitting',
				'farting'
			);

			$list3 = array(
				'piss',
				'cum',
				'jizz',
				'twat',
				'shit',
				'nad',
				'scrote',
				'turd',
				'fuck',
				'spunk',
				'faeces',
				'fuck',
				'arse'
			);

			$list4 = array(
				'weasel',
				'stoat',
				'flute',
				'monkey',
				'fish',
				'twat',
				'gibbon',
				'badger',
				'bear',
				'fuck',
				'trumpet',
				'turd',
				'fucker',
				'panda',
				'cunt',
				'whisk',
				'nugget'
			);
			
			$part1 = array_rand($list1, 1);
			$part2 = array_rand($list2, 1);
			$part3 = array_rand($list3, 1);
			$part4 = array_rand($list4, 1);
			$part1 = strtoupper($list1[$part1]);
			$part2 = strtoupper($list2[$part2]);
			$part3 = strtoupper($list3[$part3]);
			$part4 = strtoupper($list4[$part4]);
			
			echo $part1 . $part2 . ' ' . $part3 . $part4;
			
			die();

		}
		
		
		
		
		public function aprig_display_generator(){
		
			$output = '<div id="aprig-container">';
				$output .= '<h3 id="aprig-insult"></h3>';
				$output .= '<p><button class="button btn submit" id="aprig-get-new-insult">Insult me!</button></p>';
			$output .= '</div>';
			
			return $output;
			
		}


	}


}

$aprig = new APRIG();