<?php
/*
Plugin Name: Stay Alive
Plugin URI: https://github.com/razzul/stayalive
description: Stay Alive: wordpress plugin to check logged in user's status
Version: 1.0
Author: razzul
Author URI: https://github.com/razzul
License: MIT
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

include __DIR__ . '/stay-alive-widget.php';

/**
 *
 */
class StayAlive
{

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_action('admin_head', array($this, 'stay_alive_css'));
        add_action('admin_footer', array($this, 'stay_alive_checker'));
        add_action('wp_footer', array($this, 'stay_alive_checker'));
        add_action('wp_logout', array($this, 'user_logout'));
        add_action('wp_login', array($this, 'user_in'));
        add_action('wp_ajax_stay_alive_auth', array($this, 'stay_alive_auth'));
        add_shortcode('sa_online_users', array($this, 'stay_alive_shortcode'));
    }

    public function stay_alive_shortcode()
    {
        ?>
        <div class="stay_alive">
            <ul class="stay_alive_users"></ul>
        </div>
        <?php
    }

    public function stay_alive_auth()
    {
        $socket_id = $_POST['socket_id'];
        $channel_name = $_POST['channel_name'];
        $options      = get_option('stay_alive_credentials');
        $current_user = wp_get_current_user();

        require __DIR__ . '/vendor/autoload.php';
        $pusher = new Pusher\Pusher($options['pusher_key'], $options['pusher_secret'], $options['pusher_app_id'], array('cluster' => $options['pusher_cluster']));
         
        //Any data you want to send about the person who is subscribing
        $presence_data = array(
            'name' => $current_user->display_name
        );
         
        echo $pusher->presence_auth(
            $channel_name, //the name of the channel the user is subscribing to 
            $socket_id, //the socket id received from the Pusher client library
            $current_user->id,  //a UNIQUE USER ID which identifies the user
            $presence_data //the data about the person
        );
        exit();
    }

    public function user_in($current_user)
    {
             
    }

    public function user_logout()
    {
        
    }

    public function stay_alive_checker()
    {
        $options      = get_option('stay_alive_credentials');
        $current_user = wp_get_current_user();
        $current_user_id = $current_user->id;

        $channel_name = 'presence-stay-alive-channel';
        $event_name   = 'stay-alive-event';
        $stay_alive_trigger = !empty($options['stay_alive_trigger']) ? $options['stay_alive_trigger'] : 'test_stay_alive';

        echo '
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        <script>
            
            function test_stay_alive(members) {
                console.log(members);
            }
            jQuery(document).ready(function(){
                console.log("StayAlive: loaded");
                var StayAlive = function() {

                    this.pusher = null;
                    this.channel = null;
                    this.current_user_id = "' . $current_user_id . '"
                    this.channel_name = "' .$channel_name . '"
                    this.event_name = "' . $event_name . '"
                    this.status = false

                    this.credentials = function() {
                        return ' . json_encode($options) . '
                    }

                    this.subscribe = function() {
                        this.pusher = new Pusher(this.credentials().pusher_key, { cluster: this.credentials().pusher_cluster , authEndpoint: "'. site_url() .'/wp-admin/admin-ajax.php?action=stay_alive_auth",});
                        this.channel = this.pusher.subscribe(this.channel_name);
                    }

                    this.unsubscribe = function() {
                        this.pusher.unsubscribe(this.channel_name);
                    }

                    this.count = function() {
                        return this.channel.members.count
                    }

                    this.me = function() {
                        return this.channel.members.me
                    }

                    this.users = function() {
                        return this.channel.members.members
                    }

                    this.online = function() {
                        stay_alive.subscribe()
                        this.channel.bind("pusher:subscription_succeeded", function(members)  {

                            jQuery("ul.stay_alive_users").empty()
                            for(var i = 1; i <= members.count; i++) {
                                jQuery("ul.stay_alive_users").append("<li>"+ members.members[i].name +"</li>")
                            }
                            
                        });

                        this.channel.bind("pusher:member_added", function(member) {
                            members = stay_alive.users()
                            jQuery("ul.stay_alive_users").empty()
                            for(var i = 1; i <= stay_alive.count(); i++) {
                                jQuery("ul.stay_alive_users").append("<li>"+ members[i].name +"</li>")
                            }
                        });

                        this.channel.bind("pusher:member_removed", function(member) {
                            members = stay_alive.users()
                            
                            jQuery("ul.stay_alive_users").empty()
                            for(var i = 1; i <= stay_alive.count(); i++) {
                                jQuery("ul.stay_alive_users").append("<li>"+ members[i].name +"</li>")
                            }

                        });
                    }
                }

                var stay_alive = new StayAlive()
                stay_alive.online()
            })
        </script>
        ';
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Stay Alive',
            'Stay Alive',
            'manage_options',
            'stay-alive-admin',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Add custom css
     */
    public function stay_alive_css($value = '')
    {
        echo '<style>
            .stay-alive-form input:not([type="submit"]) {
                width: 25em;
            }
        </style>';
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('stay_alive_credentials');
        ?>

        <div class="wrap">
            <h1>Stay Alive</h1>
            <form method="post" action="options.php" class="stay-alive-form">
                <?php
                // This prints out all hidden setting fields
                settings_fields('my_option_group');
                do_settings_sections('stay-alive-admin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'stay_alive_credentials', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array($this, 'print_section_info'), // Callback
            'stay-alive-admin' // Page
        );

        add_settings_field(
            'pusher_app_id', // ID
            'Pusher App ID', // Title
            array($this, 'pusher_app_id_callback'), // Callback
            'stay-alive-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'pusher_key', // ID
            'Pusher Key', // Title
            array($this, 'pusher_key_callback'), // Callback
            'stay-alive-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'pusher_secret',
            'Pusher Secret',
            array($this, 'pusher_secret_callback'),
            'stay-alive-admin',
            'setting_section_id'
        );

        add_settings_field(
            'pusher_cluster',
            'Pusher Cluster',
            array($this, 'pusher_cluster_callback'),
            'stay-alive-admin',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();
        if (isset($input['pusher_app_id'])) {
            $new_input['pusher_app_id'] = absint($input['pusher_app_id']);
        }

        if (isset($input['pusher_key'])) {
            $new_input['pusher_key'] = sanitize_text_field($input['pusher_key']);
        }

        if (isset($input['pusher_secret'])) {
            $new_input['pusher_secret'] = sanitize_text_field($input['pusher_secret']);
        }

        if (isset($input['pusher_cluster'])) {
            $new_input['pusher_cluster'] = sanitize_text_field($input['pusher_cluster']);
        }

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your pusher credentials below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function pusher_app_id_callback()
    {
        printf(
            '<input type="text" id="pusher_app_id" name="stay_alive_credentials[pusher_app_id]" value="%s" />',
            isset($this->options['pusher_app_id']) ? esc_attr($this->options['pusher_app_id']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function pusher_key_callback()
    {
        printf(
            '<input type="text" id="pusher_key" name="stay_alive_credentials[pusher_key]" value="%s" />',
            isset($this->options['pusher_key']) ? esc_attr($this->options['pusher_key']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function pusher_secret_callback()
    {
        printf(
            '<input type="text" id="pusher_secret" name="stay_alive_credentials[pusher_secret]" value="%s" />',
            isset($this->options['pusher_secret']) ? esc_attr($this->options['pusher_secret']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function pusher_cluster_callback()
    {
        printf(
            '<input type="text" id="pusher_cluster" name="stay_alive_credentials[pusher_cluster]" value="%s" />',
            isset($this->options['pusher_cluster']) ? esc_attr($this->options['pusher_cluster']) : ''
        );
    }

}

$stay_alive_page = new StayAlive();