<?php
class MySettingsPage
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
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Easy Facebook feed', 
            'manage_options', 
            'easy-facebook-feed', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        $defaults = array(
          'facebook_page_id' => 'bbcnews',
          'facebook_post_limit' => '5',
        );

        // Set class property
        $this->options = get_option( 'eff_options', $defaults );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Easy Facebook feed settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );   
                do_settings_sections( 'my-setting-admin' );
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
            'eff_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'facebook_page_id', // ID
            'Facebook page ID', // Title 
            array( $this, 'facebook_page_id_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'facebook_post_limit', 
            'Number of posts to display', 
            array( $this, 'facebook_post_limit_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['facebook_page_id'] ) )
            $new_input['facebook_page_id'] = sanitize_text_field( $input['facebook_page_id'] );

        if( isset( $input['facebook_post_limit'] ) )
            $new_input['facebook_post_limit'] = absint( $input['facebook_post_limit'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print '<p>Add [easy_facebook_feed] on your page to display the facebook feed on your page. Or you can add the Easy Facebook Feed widget to your widget area.</p>';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function facebook_page_id_callback()
    {
        printf(
            '<input type="text" id="facebook_page_id" name="eff_options[facebook_page_id]" value="%s" />',
            isset( $this->options['facebook_page_id'] ) ? esc_attr( $this->options['facebook_page_id']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function facebook_post_limit_callback()
    {
        printf(
            '<input type="text" id="facebook_post_limit" name="eff_options[facebook_post_limit]" value="%s" />',
            isset( $this->options['facebook_post_limit'] ) ? esc_attr( $this->options['facebook_post_limit']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new MySettingsPage();