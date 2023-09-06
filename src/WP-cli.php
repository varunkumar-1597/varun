<?php
/**
 * WP-CLI command to delete a transient.
 *
 * @package YourPluginOrTheme
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    /**
     * Delete a transient.
     *
     * ## OPTIONS
     *
     * <varun_content>
     * : The name of the transient to delete.
     *
     * ## EXAMPLES
     *
     * wp your-plugin delete_transient my_transient
     *
     * @param array $args       Command arguments.
     * @param array $assoc_args Command associative arguments.
     */
    function your_plugin_delete_transient( $args, $assoc_args ) {
        $transient_name = 'varun_content';

        // Check if the transient exists before attempting to delete it.
        if ( false === get_transient( $transient_name ) ) {
            WP_CLI::error( 'Transient does not exist.' );
        }

        // Delete the transient.
        delete_transient( $transient_name );

        WP_CLI::success( 'Transient deleted successfully.' );
    }

    WP_CLI::add_command( 'varun refresh', 'your_plugin_delete_transient' );
}
