<?php

/*
Plugin Name: Social Share
Description: Share posts/pages/CPT on social media (Facebook, Twitter, Google+, LinkedIn, Pinterest, WhatsApp)
Version: 1.0
Author: Milivojevic Ivana
*/

function social_share_menu_item()
{
  add_submenu_page("options-general.php", "Social Share", "Social Share", "manage_options", "social-share", "social_share_page"); 
}

add_action("admin_menu", "social_share_menu_item");


function social_share_page()
{
   ?>
      <div class="wrap">
         <h1>Choose social media</h1>
 
         <form method="post" action="options.php">
            <?php
               settings_fields("social_share_config_section");
               settings_fields( "button_size" );
               settings_fields( "button_position" );

               do_settings_sections("social-share");
               do_settings_sections( "button_size" );
               settings_fields( "button_position" );

               submit_button(); 
            ?>
         </form>
      </div>
   <?php
}

add_action( 'admin_init', 'Dropdown_settings_init' );

function Dropdown_settings_init() { 
    register_setting( 'button_size', 'dropdown_settings' );
    add_settings_section(
        'Dropdown_button_size_section', 
        __( 'Button size', 'dropdown' ), 
        'Dropdown_settings_section_callback', 
        'button_size'
    );

    add_settings_field( 
        'select_field_0', 
        __( 'Choose', 'dropdown' ), 
        'Dropdown_select_field_render', 
        'button_size', 
        'Dropdown_button_size_section' 
    );
}


function Dropdown_select_field_render(  ) { 
    $options = get_option( 'dropdown_settings' );
    ?>
    <select id="choose-size" name='dropdown_settings[select_field_0]'>
        <option value='1' <?php selected( $options['select_field_0'], 1 ); ?>>Big</option>
        <option value='2' <?php selected( $options['select_field_0'], 2 ); ?>>Medium</option>
        <option value='3' <?php selected( $options['select_field_0'], 3 ); ?>>Small</option>
    </select>
<?php
}

add_action( 'admin_init', 'Dropdown_settings_init_position' );

function Dropdown_settings_init_position() { 
    register_setting( 'button_position', 'dropdown_settings_position' );
    add_settings_section(
        'Dropdown_button_position_section', 
        __( 'Button position', 'dropdown' ), 
        'Dropdown_settings_section_callback', 
        'button_position'
    );

    add_settings_field( 
        'select_field_1', 
        __( 'Choose', 'dropdown' ), 
        'Dropdown_select_field_render_position', 
        'button_position', 
        'Dropdown_button_position_section' 
    );
}


function Dropdown_select_field_position(  ) { 
    $option_pos = get_option( 'dropdown_settings_position' );
    ?>
    <select id="choose-position" name='dropdown_settings_position[select_field_1]'>
        <option value='title' <?php selected( $option_pos['select_field_1'], 1 ); ?>>Below the post title</option>
        <option value='left' <?php selected( $option_pos['select_field_1'], 2 ); ?>>Floating on the left area</option>
        <option value='after' <?php selected( $option_pos['select_field_1'], 3 ); ?>>After the post content</option>
        <option value='image' <?php selected( $option_pos['select_field_1'], 4 ); ?>>Inside the featured image</option>
    </select>
<?php
}


function Dropdown_settings_section_callback(  ) { 
    //echo __( 'Choose the size', 'dropdown' );
}


function social_share_settings()
{
    add_settings_section("social_share_config_section", "", null, "social-share");
 
    add_settings_field("social-share-facebook", "Facebook share button", "social_share_facebook_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-twitter", "Twitter share button", "social_share_twitter_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-google", "Google+ share button", "social_share_google_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-linkedin", "LinkedIn share button", "social_share_linkedin_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-pinterest", "Pinterest share button", "social_share_pinterest_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-whatsapp", "Whatsapp share button", "social_share_whatsapp_checkbox", "social-share", "social_share_config_section");
 
    register_setting("social_share_config_section", "social-share-facebook");
    register_setting("social_share_config_section", "social-share-twitter");
    register_setting("social_share_config_section", "social-share-google");
    register_setting("social_share_config_section", "social-share-linkedin");
    register_setting("social_share_config_section", "social-share-pinterest");
    register_setting("social_share_config_section", "social-share-whatsapp");
}
 
function social_share_facebook_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-facebook" value="1" <?php checked(1, get_option('social-share-facebook'), true); ?> />
   <?php
}

function social_share_twitter_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-twitter" value="1" <?php checked(1, get_option('social-share-twitter'), true); ?> /> 
   <?php
}

function social_share_google_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-google" value="1" <?php checked(1, get_option('social-share-google'), true); ?> /> 
   <?php
}

function social_share_linkedin_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-linkedin" value="1" <?php checked(1, get_option('social-share-linkedin'), true); ?> />
   <?php
}

function social_share_pinterest_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-pinterest" value="1" <?php checked(1, get_option('social-share-pinterest'), true); ?> />
   <?php
}

function social_share_whatsapp_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-whatsapp" value="1" <?php checked(1, get_option('social-share-whatsapp'), true); ?> />
   <?php
}

add_action("admin_init", "social_share_settings");


function add_social_share_icons($content)
{
    $html = "<div class='social-share-wrapper'><div class='share-on'>Share on: </div>";

    global $post;

    $url = get_permalink($post->ID);
    $url = esc_url($url);

    if(get_option("social-share-facebook") == 1)
    {
        $html = $html . "<div class='facebook icons'><a target='_blank' href='http://www.facebook.com/sharer.php?u=" . $url . "'>Facebook</a></div>";
    }

    if(get_option("social-share-twitter") == 1)
    {
        $html = $html . "<div class='twitter icons'><a target='_blank' href='https://twitter.com/share?url=" . $url . "'>Twitter</a></div>";
    }

    if(get_option("social-share-google") == 1)
    {
        $html = $html . "<div class='google icons'><a target='_blank' href='https://plus.google.com/share?url=" . $url . "'>Google+</a></div>";
    }

    if(get_option("social-share-linkedin") == 1)
    {
        $html = $html . "<div class='linkedin icons'><a target='_blank' href='http://www.linkedin.com/shareArticle?url=" . $url . "'>LinkedIn</a></div>";
    }

    if(get_option("social-share-pinterest") == 1)
    {
        $html = $html . "<div class='pinterest icons'><a target='_blank' href='http://pinterest.com/pinthis?url=" . $url . "'>Pinterest</a></div>";
    }

    if(get_option("social-share-whatsapp") == 1)
    {
        $html = $html . "<div class='whatsapp icons'><a target='_blank' href='whatsapp://send?text=" . $url . "'>WhatsApp</a></div>";
    }


    $html = $html . "<div class='clear'></div></div>";

    return $content = $content . $html;
}

add_filter("the_content", "add_social_share_icons");


function social_share_style() 
{
    wp_register_style("social-share-style-file", plugin_dir_url(__FILE__) . "style.css");
    wp_enqueue_style("social-share-style-file");
}

add_action("wp_enqueue_scripts", "social_share_style");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
var books = $('#choose-size');
            if (books.val() == '1') {
                $('.icons a').addClass('big');
            };
            if(books.val() == '2'){
                $('.icons a').addClass('medium');
            } else{
                $('.icons a').addClass('small');
            }
</script>