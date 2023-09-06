<?php

namespace Varun {
	final class Varun {

        public function __construct() {
        }

        public static function init_actions() {
            add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue' ) );
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'frontend_enqueue' ) );
            add_action( 'wp_ajax_varun_content',  array( __CLASS__, 'varun_content' ) );
            add_action( 'wp_ajax_nopriv_varun_content',  array( __CLASS__, 'varun_content' ) );
			add_action( 'wp_ajax_varun_content_api_fetch',  array( __CLASS__, 'varun_content_api_fetch' ) );
            add_action( 'wp_ajax_nopriv_varun_content_api_fetch',  array( __CLASS__, 'varun_content_api_fetch' ) );
            add_action( 'enqueue_block_editor_assets',  array( __CLASS__, 'enqueue_miusage_block') );
            add_action( 'admin_menu',  array( __CLASS__, 'varun_add_menu' ) );
			//add_action('rest_api_init', array( __CLASS__, 'register_custom_rest_route' ) );
        }

        public static function enqueue_miusage_block() {
            $varun_content = self::varun_content_fetch();
            wp_enqueue_script(
                'miusage-block',
                VARUN_PLUGIN_URL . 'dist/block.js',
                [ 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ],
                '1.0',
                true
            );
            wp_localize_script('miusage-block', 'values', array(
                'varun_content' => $varun_content
            ));
        }

		public static function varun_content_api_fetch() {
			$varun_content = json_encode( self::varun_content_fetch() );
			error_log($varun_content);
			die( $varun_content );
		}

        public static function varun_content_fetch() {
            $varun_content = get_transient( 'varun_content' );

            if( empty( $varun_content ) ) {
                $url = 'https://miusage.com/v1/challenge/1/'; 
                $response = wp_remote_get( $url );
                // Check if the request was successful
                if ( is_wp_error( $response ) ) {
                    // Handle the error
                    esc_html__( 'API request failed: ' . $response->get_error_message(), VARUN_PLUGIN_SLUG );
                } else {
                    // The request was successful
                    $body = wp_remote_retrieve_body( $response );

                    // Process the API response (e.g., decode JSON)
                    $data = json_decode( $body );

                    if ( $data !== null ) {
                        // saving the API data to transient to keep alive for next 24 hours.
                        set_transient( 'varun_content',  $data, 86400 ); 
                    } else {
                        esc_html__( 'Error decoding JSON response.',  VARUN_PLUGIN_SLUG );
                    }
                }
                return $data;
            }
            return $varun_content;
        }

        public static function varun_content() {
            delete_transient( 'varun_content' ); 
            $varun_content = self::varun_refresh();
            die( $varun_content );
        }

        public static function varun_add_menu() {

            $access_capability = 'manage_options';

            add_menu_page(
                esc_html__( 'varun',  VARUN_PLUGIN_SLUG ),
                esc_html__( 'varun',  VARUN_PLUGIN_SLUG ),
                $access_capability,
                VARUN_PLUGIN_SLUG,
                [__CLASS__,'varun_dashboard'],
            );
        }
        public static function varun_dashboard() {?>
            <div class="varun_miusage_container">
                <?php echo ( self::varun_refresh() ); ?>
            </div>
            <button class='reset-btn button button-primary'>  <?php esc_html_e( ' Refresh/Restore ', VARUN_PLUGIN_SLUG ); ?> </button>
            <?php
        }

        public static function varun_refresh() {
            ob_start();
            $varun_content = (array) self::varun_content_fetch();?>
            <div class="varun_miusage"><?php
                if( !empty ( $varun_content ) ) { ?>
                    <h1><?php esc_html_e( $varun_content['title'], VARUN_PLUGIN_SLUG );?></h1>
                    <table>
                        <thead>
                            <tr>
                                <?php
                                    foreach ( $varun_content['data']->headers as $header ) {
                                        _e( "<th>$header</th>", VARUN_PLUGIN_SLUG );
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ( $varun_content['data']->rows as $row ) {
                                    echo "<tr>";
                                    foreach ( $row as $value ) {
                                        _e( "<td>$value</td>", VARUN_PLUGIN_SLUG );
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }?>
            </div> 
            <?php
        }

        public static function admin_enqueue() {
            wp_enqueue_script(
                'varun-ajax',
                VARUN_PLUGIN_URL . 'dist/varun.js',
                [ 'jquery' ],
                '3.3.4',
                false
            );
            wp_enqueue_script(
                'varuns',
                VARUN_PLUGIN_URL . 'dist/varun_table.js',
                [ 'jquery' ],
                '3.3.4',
                false
            );
            wp_localize_script( 'varun-ajax', 'varun', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        }

		public static function frontend_enqueue() {
            wp_enqueue_script(
                'varun-ajax',
                VARUN_PLUGIN_URL . 'dist/varun.js',
                [ 'jquery' ],
                '3.3.4',
                false
            );
            wp_enqueue_script(
                'varuns',
                VARUN_PLUGIN_URL . 'dist/varun_table.js',
                [ 'jquery' ],
                '3.3.4',
                false
            );
            wp_localize_script( 'varun-ajax', 'varun', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        }
        
    }
}

namespace {

	/**
	 * The function which returns the one Varun instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Varun\Varun
	 */
	function varun() {

		return Varun\Varun::init_actions();
	}

	/**
	 * Adding an alias for backward-compatibility with plugins
	 * that still use class_exists( 'Varun' )
	 * instead of function_exists( 'wpforms' ), which is preferred.
	 *
	 * In 1.5.0 we removed support for PHP 5.2
	 * and moved former Varun class to a namespace: Varun\Varun.
	 *
	 * @since 1.5.1
	 */
	class_alias( 'Varun\Varun', 'Varun' );
}

