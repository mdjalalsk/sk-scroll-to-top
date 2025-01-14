<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main Plugin Class
 *
 * This class initializes the plugin, sets up core properties and methods,
 * and handles instantiation through a singleton pattern.
 *
 * @package Plugin
 */
class SKST_Admin {

    /**
     * Singleton instance of the Plugin class.
     *
     * @var SKST_Admin|null
     */
    public static $instance = null;

    /**
     * Current version of the plugin.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The main plugin file.
     *
     * @var string
     */
    public $file;

    /**
     * Private constructor to prevent multiple instances of the plugin class.
     *
     * @param string $file Main plugin file.
     * @param string $version Plugin version.
     */
    private function __construct( $file, $version ) {
        $this->version              = $version;
        $this->file                 = $file;
        $this->define_constants();
        $this->init_hooks();
        $this->includes();
    }

    /**
     * Retrieves the singleton instance of the Plugin class.
     *
     * @param string $file Main plugin file.
     * @param string $version Plugin version.
     * @return SKST_Admin The singleton instance of the Plugin class.
     */
    public static function get_instance( $file, $version ) {
        if ( null === self::$instance ) {
            self::$instance = new SKST_Admin( $file, $version );
        }
        return self::$instance;
    }

    /**
     * Defines necessary constants for the plugin.
     *
     * @return void
     */
    private function define_constants() {
        define( 'SKST_PLUGIN_VERSION', $this->version );
        define( 'SKST_PLUGIN_PATH', plugin_dir_path( $this->file ) );
        define( 'SKST_PLUGIN_URL', plugin_dir_url( $this->file ) );
        define( 'SKST_PLUGIN_BASENAME', plugin_basename( $this->file ) );
    }

    /**
     * Initializes necessary hooks for the plugin.
     *
     * @return void
     */
    private function init_hooks() {
        add_action( 'admin_menu', array( $this, 'skst_admin_menu' ) );
        add_action( 'admin_post_skst_save_general_settings', [ $this, 'skst_save_general_settings' ] );

    }

    /**
     * Includes necessary files for the plugin's functionality.
     *
     * @return void
     */
    private function includes() {
        add_action( 'wp_enqueue_scripts', [ $this, 'skst_enqueue_frontend_assets' ] );

    }

    /**
     * Registers the plugin's admin menu and Submenu in the WordPress dashboard.
     *
     * Adds a custom menu item in the WordPress admin sidebar for accessing
     * the plugin's settings and options. This method is typically hooked to
     * WordPress's `admin_menu` action.
     *
     * @return void
     */
    public function skst_admin_menu() {
        add_menu_page(
            esc_html__( 'SK Scroll to Top', 'sk-scroll-to-top' ),
            esc_html__( 'SK Scroll to Top', 'sk-scroll-to-top' ),
            'manage_options',
            'sk-scroll-to-top',
            array( $this, 'skst_scroll_to_top_render' ),
             'dashicons-arrow-up-alt',
            58
        );
        remove_submenu_page( 'sk-scroll-to-top', 'sk-scroll-to-top' );
    }
    /**
     * Render the settings page for Scroll to Top plugin.
     */
    function skst_scroll_to_top_render() {
        $icon_size             = get_option( 'skst_icon_size',25 );
        $background_color      = get_option( 'skst_background_color', '#ffffff' );
        $icon_color            = get_option( 'skst_icon_color', '#000000' );
        $button_width          = get_option( 'skst_button_width', 50 );
        $button_height         = get_option( 'skst_button_height', 50 );
        $button_border_radius  = get_option( 'skst_button_border_radius', 50 );
        $button_position       = get_option( 'skst_button_position', 'bottom-right' );
        $button_position_x     = get_option( 'skst_button_position_x', 30 );
        $button_position_y    = get_option( 'skst_button_position_y', 30 );

        ?>
        <div class="wrap">
            <h2><?php esc_html_e( 'General Settings', 'sk-scroll-to-top' ); ?></h2>
            <div>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="icon_size"><?php esc_html_e( 'Icon Size(px)', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="number" name="icon_size" id="icon_size" value="<?php echo esc_attr( $icon_size ); ?>"/>
                            <p><?php esc_html_e( 'Select scroll to top button icon size pixels.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="background_color"><?php esc_html_e( 'Background Color', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="color" name="background_color" id="background_color" value="<?php echo esc_attr( $background_color ); ?>"/>
                            <p><?php esc_html_e( 'Select scroll to top button background color.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="icon_color"><?php esc_html_e( 'Icon Color', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="color" name="icon_color" id="icon_color" value="<?php echo esc_attr( $icon_color ); ?>"/>
                            <p><?php esc_html_e( 'Select scroll to top button icon color.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="button_width"><?php esc_html_e( 'Button Width (px)', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="number" name="button_width" id="button_width" min="1" value="<?php echo esc_attr( $button_width ); ?>"/>
                            <p><?php esc_html_e( 'Enter the width of the button in pixels.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="button_height"><?php esc_html_e( 'Button Height (px)', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="number" name="button_height" id="button_height" min="1" value="<?php echo esc_attr( $button_height ); ?>"/>
                            <p><?php esc_html_e( 'Enter the height of the button in pixels.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="button_border_radius"><?php esc_html_e( 'Border Radius (px)', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="number" name="button_border_radius" id="button_border_radius" min="1" value="<?php echo esc_attr( $button_border_radius ); ?>"/>
                            <p><?php esc_html_e( 'Enter the border radius of the button in pixels.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="button_position"><?php esc_html_e( 'Button Position', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <select name="button_position" id="button_position">
                                <option value="bottom-left" <?php selected( $button_position, 'bottom-left' ); ?>><?php esc_html_e( 'Bottom Left', 'sk-scroll-to-top' ); ?></option>
                                <option value="bottom-right" <?php selected( $button_position, 'bottom-right' ); ?>><?php esc_html_e( 'Bottom Right', 'sk-scroll-to-top' ); ?></option>
                            </select>
                            <p><?php esc_html_e( 'Select the position of the button.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="button_position_x"><?php esc_html_e( 'Button positionX (px)', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="number" name="button_position_x" id="button_position_x" min="1" value="<?php echo esc_attr( $button_position_x ); ?>"/>
                            <p><?php esc_html_e( 'Enter the  positionX of the button in pixels.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="button_position_y"><?php esc_html_e( 'Button positionY(px)', 'sk-scroll-to-top' ); ?></label></th>
                        <td>
                            <input type="number" name="button_position_y" id="button_position_y" min="1" value="<?php echo esc_attr( $button_position_x ); ?>"/>
                            <p><?php esc_html_e( 'Enter the  positionY of the button in pixels.', 'sk-scroll-to-top' ); ?></p>
                        </td>
                    </tr>
                </table>
                <?php wp_nonce_field( 'skst_general_settings' ); ?>
                <input type="hidden" name="action" value="skst_save_general_settings">
                <?php submit_button( __( 'Save Settings', 'sk-scroll-to-top' ) ); ?>
            </form>

           </div>
        </div>
        <?php
    }

    /**
     * Save the settings for the Scroll to Top plugin.
     */
    function skst_save_general_settings() {
        check_admin_referer( 'skst_general_settings' );
        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }
        $icon_size          = isset( $_POST['icon_size'] ) ? absint( wp_unslash( $_POST['icon_size'] ) ) : 25;
        $background_color   = isset( $_POST['background_color'] ) ? sanitize_hex_color( wp_unslash( $_POST['background_color'] ) ) : '#ffffff';
        $icon_color         = isset( $_POST['icon_color'] ) ? sanitize_hex_color( wp_unslash( $_POST['icon_color'] ) ) : '#000000';
        $button_width         = isset( $_POST['button_width'] ) ? absint( wp_unslash( $_POST['button_width'] ) ) : 50;
        $button_height        = isset( $_POST['button_height'] ) ? absint( wp_unslash( $_POST['button_height'] ) ) : 50;
        $button_border_radius = isset( $_POST['button_border_radius'] ) ? absint( wp_unslash( $_POST['button_border_radius'] ) ) : 50;
        $button_position    = isset( $_POST['button_position'] ) ? sanitize_text_field( wp_unslash( $_POST['button_position'] ) ) : 'bottom-right';
        $button_position_x    = isset( $_POST['button_position_x'] ) ? absint( wp_unslash( $_POST['button_position_x'] ) ) : 30;
        $button_position_y    = isset( $_POST['button_position_y'] ) ? absint( wp_unslash( $_POST['button_position_y'] ) ) : 30;

        update_option( 'skst_icon_size', $icon_size );
        update_option( 'skst_background_color', $background_color );
        update_option( 'skst_icon_color', $icon_color );
        update_option( 'skst_button_width', $button_width );
        update_option( 'skst_button_height', $button_height );
        update_option( 'skst_button_border_radius', $button_border_radius );
        update_option( 'skst_button_position', $button_position );
        update_option( 'skst_button_position_x', $button_position_x );
        update_option( 'skst_button_position_y', $button_position_y );

        wp_safe_redirect( admin_url( 'admin.php?page=sk-scroll-to-top&status=success' ) );
        exit;
    }
   /**
    * load frontend scripts
    */
   public function skst_enqueue_frontend_assets()
    {
        wp_enqueue_script(
            'skst-scroll-to-top',
            SKST_PLUGIN_URL . 'assets/js/frontend.js',
            array( 'jquery' ),
            $this->version,
            true
        );
        $settings = [
            'iconSize'          => get_option( 'skst_icon_size', 25 ),
            'backgroundColor'   => get_option( 'skst_background_color', '#ffffff' ),
            'iconColor'         => get_option( 'skst_icon_color', '#000000' ),
            'buttonWidth'         => get_option( 'skst_icon_width', 50 ),
            'buttonHeight'        => get_option( 'skst_icon_height', 50 ),
            'iconBorderRadius'  => get_option( 'skst_icon_border_radius', 50 ),
            'buttonPosition'    => get_option( 'skst_button_position', 'bottom-right' ),
            'buttonPositionX'    => get_option( 'skst_button_position_x', 30 ),
            'buttonPositionY'    => get_option( 'skst_button_position_y', 30 ),


        ];
        wp_localize_script( 'skst-scroll-to-top', 'skstSettings', $settings);
    }



}
