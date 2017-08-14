<?php
/*
Plugin Name:Wordpress Moodle
Description:Wordpress Moodle plugin used to resgiter wordpress users into moodle
Version:1
Author:sony7596, miraclewebssoft, reachbaljit
Author URI:http://www.miraclewebsoft.com
License:GPL2
License URI:https://www.gnu.org/licenses/gpl-2.0.html
*/
if (!defined('ABSPATH')) {
    exit;
}

if (!defined("WP_MOODLE_VERSION_CURRENT")) define("WP_MOODLE_VERSION_CURRENT", '1');
if (!defined("WP_MOODLE_URL")) define("WP_MOODLE_URL", plugin_dir_url( __FILE__ ) );
if (!defined("WP_MOODLE_PLUGIN_DIR")) define("WP_MOODLE_PLUGIN_DIR", plugin_dir_path(__FILE__));
if (!defined("WP_MOODLE_PLUGIN_NM")) define("WP_MOODLE_PLUGIN_NM", 'WP Moodle');
if (!defined("WP_MOODLE_DOMAIN")) define("WP_MOODLE_DOMAIN", 'WPM');


Class WP_MOODLE
{
    public $pre_name = 'wp_moodle';

    public function __construct()
    {
        // Installation and uninstallation hooks
        register_activation_hook(__FILE__, array($this, $this->pre_name . '_activate'));
        register_deactivation_hook(__FILE__, array($this, $this->pre_name . '_deactivate'));
        add_action('admin_menu', array($this, $this->pre_name . '_setup_admin_menu'));
        add_action("admin_init", array($this, $this->pre_name . '_backend_plugin_js_scripts'));
        add_action("admin_init", array($this, $this->pre_name . '_backend_plugin_css_scripts'));
        add_action('admin_init', array($this, $this->pre_name . '_settings'));
        add_action('admin_init', array($this, $this->pre_name . '_settings'));
        add_action( 'user_register', array($this, $this->pre_name . '_registration_save'), 10, 1 );
    }


    public function wp_moodle_setup_admin_menu()
    {
        add_menu_page(__(WP_MOODLE_PLUGIN_NM, WP_MOODLE_DOMAIN), 'Wp Moodle', 'activate_plugins', 'wp_moodle_handler',
            array($this, 'wp_moodle_admin_page'), WP_MOODLE_URL . 'assets/image/icon.png');

    }

    public function wp_moodle_admin_page()
    {
        include(WP_MOODLE_PLUGIN_DIR . 'views/dashboard.php');
    }

    function wp_moodle_backend_plugin_js_scripts()
    {
        wp_enqueue_script("jquery");
        wp_enqueue_script("wp_moodle.js", WP_MOODLE_URL . "assets/js/wp_moodle.js");
        wp_enqueue_script("bootstrap.min.js", WP_MOODLE_URL . "assets/js/bootstrap.min.js");

    }

    function wp_moodle_backend_plugin_css_scripts()
    {

        wp_enqueue_style("bootstrap.min.css", WP_MOODLE_URL . "assets/css/bootstrap.min.css");
        wp_enqueue_style("wp_moodle.css", WP_MOODLE_URL . "assets/css/wp_moodle.css");
    }

    public function wp_moodle_activate()
    {

    }

    public function wp_moodle_deactivate()
    {
    }


    function wp_moodle_settings()
    {    //register our settings
        register_setting('wp_moodle_group', 'moodle_url');
        register_setting('wp_moodle_group', 'moodle_token');
        register_setting('wp_moodle_group', 'moodle_disable');

    }

    //moodle register user

    function wp_moodle_registration_save( $user_id )
    {
        if(isset($_POST['email'])){
            $email = sanitize_email($_POST['email'])?sanitize_email($_POST['email']):sanitize_email($_POST['user_email']);
            $user_login = sanitize_text_field($_POST['user_login']);
            $first_name = sanitize_text_field($_POST['first_name'])? sanitize_text_field($_POST['first_name']): "no-first-name";
            $last_name = sanitize_text_field($_POST['last_name'])? sanitize_text_field($_POST['last_name']): "no-last-name";

            $password = $_POST['pass1'];

            $role = 5; //student
            $restformat = 'json';
            $auth ="manual";
            $createpassword = 1;


            $domainname = get_option( 'moodle_url' );
            $token = get_option( 'moodle_token' );

            $params = '&users[0][username]=' . $user_login .
                '&users[0][firstname]=' . $first_name .
                '&users[0][lastname]=' . $last_name .
                '&users[0][auth]=' . $auth .
                '&users[0][createpassword]=' . $createpassword .
                '&users[0][email]=' . $email;



            $functionname = 'core_user_create_users';



            $serverurl = $domainname . '/webservice/rest/server.php' . '?wstoken=' . $token . '&wsfunction=' . $functionname . '&moodlewsrestformat=' . $restformat . $params;

            echo $serverurl;

            $contents = file_get_contents($serverurl);

            $contents_arr = json_decode($contents);


            if(isset($contents_arr->id)) {
                update_user_meta($user_id, 'lms_id', sanitize_text_field($contents_arr->id));
            }

            return true;

        }
    }


}

$WP_MOODLE_OBJ = new WP_MOODLE();
