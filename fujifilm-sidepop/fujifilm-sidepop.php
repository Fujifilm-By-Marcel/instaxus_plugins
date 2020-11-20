<?php
/**
 * Plugin Name: Fujifilm Sidepop
 * Plugin URI: 
 * Description: Adds a sidepop to the site.
 * Version: 1.0
 * Author: Marcel Munevar
 * Author URI: 
 */

$currentBlogID = get_current_blog_id();

// create custom plugin settings menu
add_action('admin_menu', 'sidepop_plugin_create_menu');

function sidepop_plugin_create_menu() {

	if ( empty ( $GLOBALS['admin_page_hooks']['fujifilm-usa'] ) ){
		add_menu_page('Fujifilm USA', 'Fujifilm USA', 'administrator', 'fujifilm-usa' );
	}
	add_submenu_page( 'fujifilm-usa', 'Sidepop Settings', 'Sidepop Settings', 'administrator', 'fujifilm-sidepop-plugin', 'sidepop_plugin_settings_page' );
	remove_submenu_page('fujifilm-usa','fujifilm-usa');

	//call register settings function
	add_action( 'admin_init', 'register_sidepop_plugin_settings' );
}


function register_sidepop_plugin_settings() {
	//register our settings
	register_setting( 'sidepop-plugin-settings-group', 'include_product_pages' );
	register_setting( 'sidepop-plugin-settings-group', 'front_page_only' );
	register_setting( 'sidepop-plugin-settings-group', 'activate_1' );
	register_setting( 'sidepop-plugin-settings-group', 'button_text_1' );
	register_setting( 'sidepop-plugin-settings-group', 'popup_class_1' );
	register_setting( 'sidepop-plugin-settings-group', 'link_1' );
	register_setting( 'sidepop-plugin-settings-group', 'new_window_1' );
	register_setting( 'sidepop-plugin-settings-group', 'activate_2' );
	register_setting( 'sidepop-plugin-settings-group', 'button_text_2' );
	register_setting( 'sidepop-plugin-settings-group', 'popup_class_2' );
	register_setting( 'sidepop-plugin-settings-group', 'link_2' );
	register_setting( 'sidepop-plugin-settings-group', 'new_window_2' );
}

function sidepop_plugin_settings_page() {
?>
<div class="wrap">
<h1>Sidepop</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'sidepop-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'sidepop-plugin-settings-group' ); ?>

	<table class="form-table">
		<tr valign="top">
			<th scope="row">Front page only:</th>
			<td><input type="checkbox"  name="front_page_only" value="activate" <?php checked( get_option('front_page_only'), 'activate' ); ?> /></td>
	    </tr>
	    <tr valign="top">
			<th scope="row">Include product pages:</th>
			<td><input type="checkbox"  name="include_product_pages" value="activate" <?php checked( get_option('include_product_pages'), 'activate' ); ?> /></td>
	    </tr>
    </table>

    <h3>Button 1</h3>
    <table class="form-table">    	
		<tr valign="top">
			<th scope="row">Avtivate:</th>
			<td><input type="checkbox"  name="activate_1" value="activate" <?php checked( get_option('activate_1'), 'activate' ); ?> /></td>
        </tr>
        <tr valign="top">
			<th scope="row">Text:</th>
			<td><input type="text"  size="60" name="button_text_1" value="<?php echo esc_attr( get_option('button_text_1') ); ?>" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Class:</th>
			<td><input type="text"  size="100" name="popup_class_1" value="<?php echo esc_attr( get_option('popup_class_1') ); ?>" /></td>
        </tr>
        <tr valign="top">
			<th scope="row">Link:</th>
			<td><input type="text"  size="100" name="link_1" value="<?php echo esc_attr( get_option('link_1') ); ?>" /></td>
        </tr>
        <tr valign="top">
			<th scope="row">New Window:</th>
			<td><input type="checkbox"  name="new_window_1" value="activate" <?php checked( get_option('new_window_1'), 'activate' ); ?> /></td>
        </tr>
    </table>
    <h3>Button 2</h3>
    <table class="form-table">
        <tr valign="top">
			<th scope="row">Avtivate:</th>
			<td><input type="checkbox"  name="activate_2" value="activate" <?php checked( get_option('activate_2'), 'activate' ); ?> /></td>
        </tr>
        <tr valign="top">
			<th scope="row">Text:</th>
			<td><input type="text"  size="60" name="button_text_2" value="<?php echo esc_attr( get_option('button_text_2') ); ?>" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Class:</th>
			<td><input type="text"  size="100" name="popup_class_2" value="<?php echo esc_attr( get_option('popup_class_2') ); ?>" /></td>
        </tr>
        <tr valign="top">
			<th scope="row">Link:</th>
			<td><input type="text"  size="100" name="link_2" value="<?php echo esc_attr( get_option('link_2') ); ?>" /></td>
        </tr>
        <tr valign="top">
			<th scope="row">New Window:</th>
			<td><input type="checkbox"  name="new_window_2" value="activate" <?php checked( get_option('new_window_2'), 'activate' ); ?> /></td>
        </tr>
		
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } 




class Sidepop {

	function addCSS(){
		wp_enqueue_style( 'modal', plugin_dir_url( __FILE__ ).'modal.css', array(), '1.0.11' );
		wp_enqueue_script( 'modal', plugin_dir_url( __FILE__ ).'modal.js', array(), '1.0.4', true );
	}
	function addButton(){
	  	if( get_option('new_window_1') ) { $window1 = "_blank"; } else { $window1 = "_self"; }
	  	if( get_option('new_window_2') ) { $window2 = "_blank"; } else { $window2 = "_self"; }
		?>	
		<div id="sidepop-container">
			<?php if( get_option('activate_1') ) { ?>
			<?php if(get_option('link_1')){ ?><a href="<?php echo get_option('link_1') ?>" target="<?php echo $window1 ?>"><?php } ?>
			 	<div id="newsletter-myBtn" class="sidepop-button <?php echo get_option( 'popup_class_1'); ?>">
			 		<?php echo get_option( 'button_text_1'); ?>
			 	</div>
			<?php if(get_option('link_1')){ ?></a><?php } ?>
			<?php } if( get_option('activate_2') ) { ?>		
		 	<?php if(get_option('link_2')){ ?><a href="<?php echo get_option('link_2') ?>" target="<?php echo $window2 ?>"><?php } ?>
			 	<div id="review-myBtn" class="sidepop-button <?php echo get_option( 'popup_class_2'); ?>">
			 		<?php echo get_option( 'button_text_2'); ?>
			 	</div>
		 	<?php if(get_option('link_2')){ ?></a><?php } ?>
		 	<?php } ?>
		</div>
		<?php
		}

}


function checkFrontPage(){
	$mySidepopClass = new Sidepop();
	
	if ( (get_option('front_page_only') &&  is_front_page() && ( get_option('activate_1') || get_option('activate_2') ) ) || (get_option('include_product_pages') && class_exists('WooCommerce') &&  is_product() ) ) {
		add_action('get_footer', array($mySidepopClass, 'addCSS'));
		add_action('get_footer', array($mySidepopClass, 'addButton'));
	}
	elseif ( !get_option('front_page_only') && ( get_option('activate_1') || get_option('activate_2') ) ){
		add_action('get_footer', array($mySidepopClass, 'addCSS'));
		add_action('get_footer', array($mySidepopClass, 'addButton'));
	}
}

add_action('wp_head', 'checkFrontPage');


