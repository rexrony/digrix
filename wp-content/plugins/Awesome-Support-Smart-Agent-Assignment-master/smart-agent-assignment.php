<?php
/**
 * @package   Awesome Support Smart Agent Assignment
 * @author    Awesome Support <https://www.getawesomesupport.com>
 * @license   GPL-2.0+	
 * @link      https://www.getawesomesupport.com
 * @copyright 2016
 * 
 * @wordpress-plugin
 *
 * Plugin Name:       Awesome Support: Smart Agent Assignment
 * Plugin URI:        
 * Description:       This addon will extend the current ticket assigning system to check the availability of agents according to day and time therefore adding capability to add the days and time at which agents are available.
 * Version:           2.0
 * Author:            Awesome Support
 * Author URI:        https://www.getawesomesupport.com
 * Text Domain:       smart-agent-assignment
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Instantiate the plugin
 *----------------------------------------------------------------------------*/

/**
 * Register the activation hook
 */
register_activation_hook( __FILE__, array( 'Smart_Agent_Assignment', 'activate' ) );

add_action( 'plugins_loaded', array( 'Smart_Agent_Assignment', 'get_instance' ) );
/**
 * Instanciate the addon.
 *
 * This method runs a few checks to make sure that the addon
 * can indeed be used in the current context, after what it
 * registers the addon to the core plugin for it to be loaded
 * when the entire core is ready.
 *
 * @since  0.1.0
 * @return void
 */
class Smart_Agent_Assignment{

	/**
	 * ID of the item.
	 *
	 * The item ID must match teh post ID on the e-commerce site.
	 * Using the item ID instead of its name has the huge advantage of
	 * allowing changes in the item name.
	 *
	 * If the ID is not set the class will fall back on the plugin name instead.
	 *
	 * @since 0.1.3
	 * @var int
	 */
	protected $item_id;

	/**
	 * Required version of the core.
	 *
	 * The minimum version of the core that's required
	 * to properly run this addon. If the minimum version
	 * requirement isn't met an error message is displayed
	 * and the addon isn't registered.
	 *
	 * @since  0.1.0
	 * @var    string
	 */
	protected $version_required = '3.2.5';

	/**
	 * Required version of PHP.
	 *
	 * Follow WordPress latest requirements and require
	 * PHP version 5.4 at least.
	 * 
	 * @var string
	 */
	protected $php_version_required = '5.4';

	/**
	 * Plugin slug.
	 *
	 * @since  0.1.0
	 * @var    string
	 */
	protected $slug = 'smart_agent_assignment';

	/**
	 * Instance of this loader class.
	 *
	 * @since    0.1.0
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Instance of the addon itself.
	 *
	 * @since  0.1.0
	 * @var    object
	 */
	public $addon = null;

	/**
	 * Possible error message.
	 * 
	 * @var null|WP_Error
	 */
	protected $error = null;
	
	/**
	 *Smart Agent default Settings
	 * @since  2.0
	 * @var array
	 */
//	public $sma_default_settings	= array('smart_agent_algorithm' => '5');
	
	public function __construct() {
		$this->declare_constants();
		$this->init();
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     3.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Return an instance of the addon.
	 *
	 * @since  0.1.0
	 * @return object
	 */
	public function scope() {
		return $this->addon;
	}

	public function declare_constants() {
		define( 'AS_ESA_VERSION', '1.0' );
		define( 'AS_ESA_URL',     trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'AS_ESA_PATH',    trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	/**
	 * Activate the plugin.
	 *
	 * The activation method just checks if the main plugin
	 * Awesome Support is installed (active or inactive) on the site.
	 * If not, the addon installation is aborted and an error message is displayed.
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public static function activate() {

		if ( ! class_exists( 'Awesome_Support' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				sprintf( __( 'You need Awesome Support to activate this addon. Please <a href="%s" target="_blank">install Awesome Support</a> before continuing.', 'wpascr' ), esc_url( 'http://getawesomesupport.com/?utm_source=internal&utm_medium=addon_loader&utm_campaign=Addons' ) )
			);
		}

	}

	/**
	 * Initialize the addon.
	 *
	 * This method is the one running the checks and
	 * registering the addon to the core.
	 *
	 * @since  0.1.0
	 * @return boolean Whether or not the addon was registered
	 */
	public function init() {

		$plugin_name = $this->plugin_data( 'Name' );

		if ( ! $this->is_core_active() ) {
			$this->add_error( sprintf( __( '%s requires Awesome Support to be active. Please activate the core plugin first.', 'smart-agent-assignment' ), $plugin_name ) );
			
		}

		if ( ! $this->is_php_version_enough() ) {
			$this->add_error( sprintf( __( 'Unfortunately, %s can not run on PHP versions older than %s. Read more information about <a href="%s" target="_blank">how you can update</a>.', 'smart-agent-assignment' ), $plugin_name, $this->php_version_required, esc_url( 'http://www.wpupdatephp.com/update/' ) ) );
		}

		if ( ! $this->is_version_compatible() ) {
			$this->add_error( sprintf( __( '%s requires Awesome Support version %s or greater. Please update the core plugin first.', 'smart-agent-assignment' ), $plugin_name, $this->version_required ) );
		}

		if ( is_a( $this->error, 'WP_Error' ) ) {
			add_action( 'admin_notices', array( $this, 'display_error' ), 10, 0 );
			add_action( 'admin_init',    array( $this, 'deactivate' ),    10, 0 );
			return false;
		}

		/**
		 * Add the addon license field
		 */
		if ( is_admin() ) {

			// Add the license admin notice
			$this->add_license_notice();

			add_filter( 'wpas_addons_licenses', array( $this, 'addon_license' ),       10, 1 );
			add_filter( 'plugin_row_meta',      array( $this, 'license_notice_meta' ), 10, 4 );
		}
		$this->includes();
		/**
		 * Register the addon
		 */
		wpas_register_addon( $this->slug, array( $this, 'load' ) );

		return true;

	}
/**
		 * Include all files used sitewide
		 *
		 * @since 3.2.5
		 * @return void
		 */
		private function includes() {
					
			require( AS_ESA_PATH . 'settings-smart-assignment.php' );	
					
		}
	/**
	 * Get the plugin data.
	 *
	 * @since  0.1.0
	 * @param  string $data Plugin data to retrieve
	 * @return string       Data value
	 */
	protected function plugin_data( $data ) {

		if ( ! function_exists( 'get_plugin_data' ) ) {
			$admin_path = str_replace( get_site_url() . '/', ABSPATH, get_admin_url() );
			require_once( $admin_path . 'includes/plugin.php' );
		}

		$plugin = get_plugin_data( __FILE__, false, false );

		if ( array_key_exists( $data, $plugin ) ){
			return $plugin[$data];
		} else {
			return '';
		}

	}

	/**
	 * Check if core is active.
	 *
	 * Checks if the core plugin is listed in the acitve
	 * plugins in the WordPress database.
	 *
	 * @since  0.1.0
	 * @return boolean Whether or not the core is active
	 */
	protected function is_core_active() {
		if ( in_array( 'awesome-support/awesome-support.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if the core version is compatible with this addon.
	 *
	 * @since  0.1.0
	 * @return boolean
	 */
	protected function is_version_compatible() {

		/**
		 * Return true if the core is not active so that this message won't show.
		 * We already have the error saying the plugin is disabled, no need to add this one.
		 */
		if ( ! $this->is_core_active() ) {
			return true;
		}

		if ( empty( $this->version_required ) ) {
			return true;
		}

		if ( ! defined( 'WPAS_VERSION' ) ) {
			return false;
		}

		if ( version_compare( WPAS_VERSION, $this->version_required, '<' ) ) {
			return false;
		}

		return true;

	}

	/**
	 * Check if the version of PHP is compatible with this addon.
	 *
	 * @since  0.1.0
	 * @return boolean
	 */
	protected function is_php_version_enough() {

		/**
		 * No version set, we assume everything is fine.
		 */
		if ( empty( $this->php_version_required ) ) {
			return true;
		}

		if ( version_compare( phpversion(), $this->php_version_required, '<' ) ) {
			return false;
		}

		return true;

	}

	/**
	 * Add error.
	 *
	 * Add a new error to the WP_Error object
	 * and create the object if it doesn't exist yet.
	 *
	 * @since  0.1.0
	 * @param string $message Error message to add
	 * @return void
	 */
	public function add_error( $message ) {

		if ( ! is_object( $this->error ) || ! is_a( $this->error, 'WP_Error' ) ) {
			$this->error = new WP_Error();
		}

		$this->error->add( 'addon_error', $message );

	}

	/**
	 * Display error.
	 *
	 * Get all the error messages and display them
	 * in the admin notices.
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function display_error() {

		if ( ! is_a( $this->error, 'WP_Error' ) ) {
			return;
		}

		$message = $this->error->get_error_messages(); ?>
		<div class="error">
			<p>
				<?php
				if ( count( $message ) > 1 ) {

					echo '<ul>';

					foreach ( $message as $msg ) {
						echo "<li>$msg</li>";
					}

					echo '</li>';

				} else {
					echo $message[0];
				}
				?>
			</p>
		</div>
	<?php

	}

	/**
	 * Deactivate the addon.
	 *
	 * If the requirements aren't met we try to
	 * deactivate the addon completely.
	 * 
	 * @return void
	 */
	public function deactivate() {
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
		}
	}

	/**
	 * Add license option.
	 *
	 * @since  0.1.0
	 * @param  array $licenses List of addons licenses
	 * @return array           Updated list of licenses
	 */
	public function addon_license( $licenses ) {

		$plugin_name = $this->plugin_data( 'Smart Agent Assignment' );
		$plugin_name = trim( str_replace( 'Awesome Support:', '', $plugin_name ) ); // Remove the Awesome Support prefix from the addon name

		$licenses[] = array(
			'name'      => $plugin_name,
			'id'        => "license_{$this->slug}",
			'type'      => 'edd-license',
			'default'   => '',
			'server'    => esc_url( 'http://getawesomesupport.com' ),
			'item_name' => $plugin_name,
			'item_id'   => $this->item_id,
			'file'      => __FILE__
		);

		return $licenses;
	}

	/**
	 * Display notice if user didn't set his Envato license code
	 *
	 * @since 0.1.4
	 * @return void
	 */
	public function add_license_notice() {

		/**
		 * We only want to display the notice to the site admin.
		 */
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		$license = wpas_get_option( "license_{$this->slug}", '' );

		/**
		 * Do not show the notice if the license key has already been entered.
		 */
		if ( ! empty( $license ) ) {
			return;
		}

		$link = wpas_get_settings_page_url( 'licenses' );
		WPAS()->admin_notices->add_notice( 'error', "lincense_{$this->slug}", sprintf( __( 'Please <a href="%s">fill-in your product license</a> now. If you don\'t, your copy of the plugin <strong>will never be updated</strong>.', 'wpbp' ), $link ) );

	}

	/**
	 * Add license warning in the plugin meta row
	 *
	 * @since 0.1.0
	 *
	 * @param array  $plugin_meta The current plugin meta row
	 * @param string $plugin_file The plugin file path
	 *
	 * @return array Updated plugin meta
	 */
	public function license_notice_meta( $plugin_meta, $plugin_file ) {

		$license   = wpas_get_option( "license_{$this->slug}", '' );

		if( ! empty( $license ) ) {
			return $plugin_meta;
		}

		$license_page = add_query_arg( array( 'post_type' => 'ticket', 'page' => 'settings', 'tab' => 'licenses' ), admin_url( 'edit.php' ) );

		if ( plugin_basename( __FILE__ ) === $plugin_file ) {
			$plugin_meta[] = '<strong>' . sprintf( __( 'You must fill-in your product license in order to get future plugin updates. <a href="%s">Click here to do it</a>.', 'wpas' ), $license_page ) . '</strong>';
		}
		
		return $plugin_meta;
	}


	/**
	 * Load the addon.
	 *
	 * Include all necessary files and instanciate the addon.
	 *
	 * @since  1.0
	 * @return void
	 */
	public function load() {

		// Load the addon here.
		// We load scripts on profile page only
	if ( is_admin()&&(is_numeric( strpos( $_SERVER["REQUEST_URI"], '/profile.php' ) )|| is_numeric( strpos( $_SERVER["REQUEST_URI"], '/user-edit.php'))||($_GET['page']=='smart-assignment-options'))) {
add_action( 'admin_enqueue_scripts',    array( $this, 'enqueue_styles' ), 10, 0 );
add_action( 'admin_enqueue_scripts',    array( $this, 'enqueue_scripts' ), 10, 0 );	
	}
	
add_action( 'edit_user_profile',array( $this, 'user_profile_esa_custom_fields' ) ); // Add user preferences
add_action( 'show_user_profile',array( $this, 'user_profile_esa_custom_fields' ) ); // Add user preferences

add_action( 'personal_options_update',    array( $this, 'save_user_esa_custom_fields' ) );    // Save the user preferences
add_action( 'edit_user_profile_update',   array( $this, 'save_user_esa_custom_fields' ) );    // Save the user preferences when modified by admins

//keep availability column hidden
$user = wp_get_current_user();
$user_sc_options=get_user_option('manageuserscolumnshidden',$user->ID);
if(!$user_sc_options){
	if ( ! $user = wp_get_current_user() )
		wp_die( -1 );
$user_sc_options[]='esa_availability';
update_user_option($user->ID, 'manageuserscolumnshidden',$user_sc_options, true );
}

add_action( 'user_register', array( $this, 'enable_days_assignment' ), 10, 1 );   // Enable auto-assignment of days for new users

add_filter( 'manage_users_columns',       array( $this, 'availability_column' ) );
add_filter( 'manage_users_custom_column', array( $this, 'availability_column_content' ), 10, 3 );


//if multiple products are supported
if(wpas_get_option('support_products'))
		{
add_filter( 'manage_users_custom_column', array( $this, 'product_column_content' ), 10, 3 );
		}
//if departments are enabled
if(wpas_get_option('departments'))
		{
add_filter( 'manage_users_custom_column', array( $this, 'department_column_content' ), 10, 3 );
		}
add_filter( 'wpas_find_available_agent', array( $this, 'new_wpas_find_agent'),10,2 );// New agent function
add_filter( 'esa_get_ticket_product', array( $this,'get_ticket_product'),10,1 );
add_filter( 'esa_get_ticket_department', array( $this,'get_ticket_department'),10,1 );
		

		
if(wpas_get_option('departments')){
	
add_action( 'wpas_user_profile_fields', array( WPAS_User, 'profile_field_agent_department' ), 10, 1 );//turn on departments
}
add_action( 'wpas_user_esa_profile_fields', array( $this, 'days_time_available' ), 10, 1 );// Custom profile fields

	}
	
		/**
		 * Stylesheets to include on admin profile.php page
		 */
public function enqueue_styles() {

		wp_enqueue_style( 'jquery-timepicker-css', AS_ESA_URL . 'assets/jquery-timepicker/jquery.timepicker.css', array(), '1.11.1', 'all' );
		
	
	}
		/**
		 * Scripts to include on admin profile.php page
		 */
	public function enqueue_scripts() {
	
		wp_enqueue_script( 'jquery-timepicker-script', AS_ESA_URL . 'assets/jquery-timepicker/jquery.timepicker.min.js', array( 'jquery' ), AS_ESA_VERSION, true );
		wp_enqueue_script( 'jquery-datepair-script-1', AS_ESA_URL . 'assets/jquery-datepair/dist/datepair.js', array( 'jquery' ), '0.4.14', true );
		wp_enqueue_script( 'jquery-datepair-script-2', AS_ESA_URL . 'assets/jquery-datepair/dist/jquery.datepair.min.js', array( 'jquery' ), '0.4.14', true );
		wp_register_script( 'esa-admin-script', AS_ESA_URL . 'js/admin.js', array( 'jquery' ), AS_ESA_VERSION, true );
		wp_localize_script( 'esa-admin-script', 'esma', array(
		'algourl'=> AS_ESA_URL.'assignment-algorithms.php',
		));
		wp_enqueue_script( 'esa-admin-script' );
	}
	/**
	 * Add user preferences to the profile page.
	 *
	 * @since  1.0
	 * @param WP_User $user
	 *
	 * @return bool|void
	 */
	public function user_profile_esa_custom_fields( $user ) {
		
		if ( ! user_can( $user->ID, 'edit_ticket' ) ) {
			return;
		}
		 ?>

		<h3><?php _e( 'Awesome Support: Set Product and Availability Of Agent', 'smart-agent-assignment' ); ?></h3>
		<table class="form-table">
			<tbody>
				<?php do_action( 'wpas_user_esa_profile_fields', $user ); ?>
			</tbody>
		</table>
        
	<?php }
	
	/**
	 * User profile field "Days & Time available"
	 *
	 * @since  1.0
	 * @param WP_User $user
	 *
	 * @return void
	 */
	public function days_time_available( $user ) {

		if ( ! user_can( $user->ID, 'edit_ticket' ) ) {
			return;
		}

		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}
		//if mulitple products are supported by site
		if(wpas_get_option('support_products'))
		{
		 ?>
<tr class="esa_set_product_wrap">
<th><label><?php _e( 'Set Product', 'smart-agent-assignment' ); ?></label></th>
<td>
<?php

		$products = get_terms( array(
			'taxonomy'   => 'product',
			'hide_empty' => false,
		) );

		if ( empty( $products ) ) {
			
			echo __( 'No products are available!', 'smart-agent-assignment' );
		}

		$current = get_user_meta( $user->ID , 'esa_product',true); 
		if(empty($current)){
			$current=array();
		}
		foreach ( $products as $product ) {
		
		$checked = in_array( $product->term_id, $current ) ? 'checked="checked"' : '';
		printf( '<label for="esa_product_%1$s"><input type="checkbox" name="%3$s" id="esa_product_%1$s" value="%2$d" %5$s> %4$s</label><br>', $product->slug, $product->term_id, 'esa_products[]', $product->name, $checked );		
				}
		?>
    <p class="description"><?php esc_html_e( 'Which product(s) does this agent provide support for?', 'smart-agent-assignment' ); ?></p>
</td>
</tr>
<?php
		}
		?>
		<tr class="esa_days_available_wrap">
			<th><label><?php _e( 'Days Available', 'smart-agent-assignment' ); ?></label></th>
			<td>
            <table class="form-table">
            <tbody>
				<?php 
	//$days=[0=>'Sunday',1=>'Monday',2=> 'Tuesday',3=>'Wednesday',4=> 'Thursday',5=>'Friday',6=>'Saturday',7=>'All'];
		$timestamp = strtotime('Sunday');
		$days = array();
		for ($i = 0; $i < 7; $i++) {
			$days[] = strftime('%A', $timestamp);
			$timestamp = strtotime('+1 day', $timestamp);
		}
		
				$days_available =  get_user_meta( $user->ID,'esa_days_available',true ) ; 
				//var_dump($days_available);
				if(empty($days_available)){
						$days_av=[];
						$time_from_1=$time_from_2=$time_from_3=$time_from_4=[];
						$time_to_1=$time_to_2=$time_to_3=$time_to_4=[];
						}else{
							foreach($days_available as $dav){
							$days_av[]=$dav[0];
						$time_from_1[]=	$dav[1];
						$time_to_1[]= $dav[2];
						$time_from_2[]=isset($dav[3])?$dav[3]:'';
						$time_to_2[]=isset($dav[4])?$dav[4]:'';
						$time_from_3[]=isset($dav[5])?$dav[5]:'';
						$time_to_3[]=isset($dav[6])?$dav[6]:'';
						$time_from_4[]=isset($dav[7])?$dav[7]:'';
						$time_to_4[]=isset($dav[8])?$dav[8]:'';					
							}
						}
				
				foreach($days as $key=>$day){
				//check days when agent is available
				if(in_array($day,$days_av) ){
					$checked ='checked="checked"';
					
					$ar_key=array_keys($days_av,$day);
					$ar_key=$ar_key[0];
					
				    $fromtime_1=$time_from_1[$ar_key];
					$totime_1=$time_to_1[$ar_key];
					
					$fromtime_2=!empty($time_from_2[$ar_key])?$time_from_2[$ar_key]:'';
					$totime_2=!empty($time_to_2[$ar_key])?$time_to_2[$ar_key]:'';
					$fromtime_3=!empty($time_from_3[$ar_key])?$time_from_3[$ar_key]:'';
					$totime_3=!empty($time_to_3[$ar_key])?$time_to_3[$ar_key]:'';
					$fromtime_4=!empty($time_from_4[$ar_key])?$time_from_4[$ar_key]:'';
					$totime_4=!empty($time_to_4[$ar_key])?$time_to_4[$ar_key]:'';
    			}
				else{
					$checked ='';
					$fromtime_1=$fromtime_2=$fromtime_3=$fromtime_4='';
					$totime_1=$totime_2=$totime_3=$totime_4='';
					}

				//time  when agent is available on that day
				
				echo "<tr><td>";
				printf(__('<label for="esa_days_available_%4$s"><input type="checkbox" class="esa" name="%1$s" value="%2$s" id="esa_%4$s" %3$s> %2$s</label>','smart-agent-assignment'), 'esa_days_available[]', $day, $checked,$key );
				
				echo "</td><td class='daterange esa_%1$s_am_wrapper'>";
				
				for($co=1;$co<=4;$co++)
				{
				$ft="fromtime_$co";$tt="totime_$co";
				printf(__('<label for="esa_%1$s_from_time_'.$co.'">
				<input type="text" id="esa_%1$s_from_'.$co.'" class="time start" name="esa_from_time_'.$co.'[]" value="%2$s" ></label>','smart-agent-assignment'), $key,${$ft});
				
				printf(__('<label for="esa_%1$s_to_time_'.$co.'">To
				<input type="text" id="esa_%1$s_to_'.$co.'" class="time end" name="esa_to_time_'.$co.'[]" value="%2$s" ></label><br/>','smart-agent-assignment'), $key,${$tt} );
				}
				
				echo "</td></tr>";
					}
				?>
                </tbody>
                </table>
                 <p class="description"><?php printf(esc_html__( 'All times are based on the time zone of the server which is currently set to: %1s', 'smart-agent-assignment' ),date_default_timezone_get()); ?></p>
                  <p class="description"><?php printf(esc_html__( 'The current time now is %1s', 'smart-agent-assignment' ),date("h:ia")); ?></p>
			</td>
		</tr>
        

	<?php 
		}
	/**
	 * Save the user preferences.
	 *
	 * @since  1.0
	 * @param  integer $user_id ID of the user to modify
	 *
	 * @return void
	 */
	public function save_user_esa_custom_fields( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}
		$esa_days_available= array();
		if(isset( $_POST['esa_days_available'] )){
			 for($i=0;$i<sizeof($_POST['esa_days_available']);$i++){
			$esa_available=[];
			$esa_available[]=$_POST['esa_days_available'][$i];
			$esa_available[]=!empty($_POST['esa_from_time_1'][$i])?$_POST['esa_from_time_1'][$i]:'12:00am';
			$esa_available[]=!empty($_POST['esa_to_time_1'][$i])?$_POST['esa_to_time_1'][$i]:'11:59pm';
			//save second set of time only if it is not empty
			if(!empty($_POST['esa_from_time_2'][$i])){
			$esa_available[]=$_POST['esa_from_time_2'][$i];
			$esa_available[]=!empty($_POST['esa_to_time_2'][$i])?$_POST['esa_to_time_2'][$i]:$_POST['esa_from_time_2'][$i];			
			}
			if(!empty($_POST['esa_from_time_3'][$i])){
			$esa_available[]=$_POST['esa_from_time_3'][$i];
			$esa_available[]=!empty($_POST['esa_to_time_3'][$i])?$_POST['esa_to_time_3'][$i]:$_POST['esa_from_time_3'][$i];
			}
			if(!empty($_POST['esa_from_time_4'][$i])){
			$esa_available[]=$_POST['esa_from_time_4'][$i];
			$esa_available[]=!empty($_POST['esa_to_time_4'][$i])?$_POST['esa_to_time_4'][$i]:$_POST['esa_from_time_4'][$i];
			}
			$esa_days_available[]=$esa_available;
			 }
		}
	$product= isset( $_POST['esa_products'] ) ? array_map( 'intval', $_POST['esa_products'] ) : array();
		
	
		update_user_meta( $user_id, 'esa_days_available', $esa_days_available );		
		update_user_meta( $user_id, 'esa_product', $product );
		

	}
	/**
	 * Enable auto-assignment for new agents
	 *
	 * @since  1.0
	 * @param int $user_id
	 *
	 * @return void
	 */
	public function enable_days_assignment( $user_id ) {
		if ( user_can( $user_id, 'edit_ticket' ) && ! user_can( $user_id, 'administrator' ) ) {
			$timestamp = strtotime('Sunday');
			$days = array();
			for ($i = 0; $i < 7; $i++) {
				$day = array();
				$day[]= strftime('%A', $timestamp);
				$day[]='12:00am';$day[]='11:59pm';
				$days[]=$day;
				$timestamp = strtotime('+1 day', $timestamp);
			}
			update_user_meta( $user_id, 'esa_days_available', $days );
			
			//if departments are enabled add to meta
			if(wpas_get_option('departments')){
				update_user_meta( $user_id, 'wpas_department', array());
			}
		}
	}
	/**
	 * Add availability column in users table
	 *
	 * @since  1.0
	 * @param array $columns
	 *
	 * @return mixed
	 */
	public function availability_column( $columns ) {

		$columns['esa_availability'] = __( 'Availability', 'smart-agent-assignment' );
		
		if(wpas_get_option('support_products'))
		{
			$columns['esa_products'] = __( 'Products', 'smart-agent-assignment' );
		}
		if(wpas_get_option('departments'))
		{
			$columns['esa_departments'] = __( 'Departments', 'smart-agent-assignment' );
		}
		return $columns;
	}

	/**
	 * Add availability user column content
	 *
	 * @since  1.0
	 * @param mixed  $value       Column value
	 * @param string $column_name Column name
	 * @param int    $user_id     Current user ID
	 *
	 * @return string
	 */
	public function availability_column_content( $value, $column_name, $user_id ) {

		if ( 'esa_availability' !== $column_name ) {
			return $value;
		}

		$agent = new WPAS_Member_Agent( $user_id );

		if ( true !== $agent->is_agent() ) {
			return 'N/A';
		}
		
		$days_available =  get_user_meta( $user_id,'esa_days_available',true ) ; 
		if(empty($days_available)){
						$days_av=[];
						}else{
						foreach($days_available as $dav){
						if (sizeof($dav)==3){
						$days_av[]= $dav[0]." <br/> ".$dav[1]." - ".$dav[2];
						}
						if (sizeof($dav)>3){
							$stri_days='';
							$stri_days.=$dav[0]."<br/>";
							for($s=1;$s<8;){
								if($dav[$s]){
								$stri_days.=$dav[$s]."-".$dav[$s+1];
								if(isset($dav[$s+2])){
									$stri_days.=', ';
								}
								}
								$s=$s+2;
							}
						$days_av[]= $stri_days;	
						}
							}
						}
		$days_av = is_array($days_av)?implode('<br/> ',$days_av): '' ;
		if(!empty($days_av)){
		return __($days_av, 'smart-agent-assignment' );
		}else{
			return __( 'Not set', 'smart-agent-assignment' );
		}

	}
	/**
	 * Add product column content
	 *
	 * @since 1.0
	 *
	 * @param mixed  $value       Column value
	 * @param string $column_name Column name
	 * @param int    $user_id     Current user ID
	 *
	 * @return string
	 */
	public function product_column_content( $value, $column_name, $user_id ) {

		if ( 'esa_products' !== $column_name ) {
			return $value;
		}
		$agent = new WPAS_Member_Agent( $user_id );

		if ( true !== $agent->is_agent() ) {
			return 'N/A';
		}
		$products =  get_user_meta( $user_id,'esa_product',true ) ; 
		if(empty($products)){
						$product_list=[];
						}else{
						foreach($products as $id){
						$term = get_term($id); 
						$product_list[]= $term->name;
							}
						}
		$product_list = is_array($product_list)?implode('<br/> ',$product_list): '' ;
		if(!empty($product_list)){
		return $product_list;
		}else{
			return __( 'Not set', 'smart-agent-assignment' );
		}

	}
	/**
	 * Add department column content
	 *
	 * @since 1.0
	 *
	 * @param mixed  $value       Column value
	 * @param string $column_name Column name
	 * @param int    $user_id     Current user ID
	 *
	 * @return string
	 */
	public function department_column_content( $value, $column_name, $user_id ) {

		if ( 'esa_departments' !== $column_name ) {
			return $value;
		}
		$agent = new WPAS_Member_Agent( $user_id );

		if ( true !== $agent->is_agent() ) {
			return 'N/A';
		}
		$dept_arr =  get_user_meta( $user_id,'wpas_department',true ) ; 
		if(empty($dept_arr)){
						$dept_list=[];
						}else{
						foreach($dept_arr as $id){
						$term = get_term($id); 
						$dept_list[]= $term->name;
							}
						}
		$dept_list = is_array($dept_list)?implode('<br/> ',$dept_list): '' ;
		if(!empty($dept_list)){
		return $dept_list;
		}else{
			return __( 'Not set', 'smart-agent-assignment' );
		}

	}
		

	
	/* Get the current algorithm used my Smart Agent Plugin for assigning ticket
	* @since  2.0
	* @return integer ID of the algorithm
	*/
	protected function get_smart_agent_algorithm(){
		return wpas_get_option('smart_agent_algorithm');
	}
	
	
/*Find product associated with a ticket.
* @since  2.0
* @param  boolean|integer $ticket_id 
* @return integer  term ID of the product
*/
public function get_ticket_product($ticket_id){
		//check if product support is turned on
			if(!wpas_get_option('support_products'))
			{
			return;
			}
		
		//get taxonomies associated with ticket
		$ticket_taxonomy=get_post_taxonomies($ticket_id);
		//check if product is set for a ticket
				if(in_array('product',$ticket_taxonomy)){
					$pro_arr = get_the_terms($ticket_id,'product');
					$tkt_pro_id=$pro_arr[0]->term_id;
					}else{
					$tkt_pro_id='';
					}
			return $tkt_pro_id;
			
	}
	
/*Find department associated with a ticket.
* @since  2.0
* @param  boolean|integer $ticket_id 
* @return integer  term ID of the department
*/
public function get_ticket_department($ticket_id){
		//check if product support is turned on
			if(!wpas_get_option('departments'))
			{
			return;
			}
		
		//get taxonomies associated with ticket
		$ticket_taxonomy=get_post_taxonomies($ticket_id);
		//check if DEPARTMENT is set for a ticket
			if(in_array('department',$ticket_taxonomy)){
				$dep_arr = get_the_terms($ticket_id,'department');
				$tkt_dept_id=$dep_arr[0]->term_id;
				}else{
				$tkt_dept_id='';
			}
			return $tkt_dept_id;
			
	}
	
/* Does agent provide product support
* @since  2.0
* @param  object|integer the user $user and the tickets product id $tkt_pro_id 
* @return boolean true or false 
*/
public function is_agent_product($user,$tkt_pro_id){
	
	$products= get_user_meta( $user->ID , 'esa_product',true); 
		if(empty($products)){
			$products=[];
		}
		
		//check user provides support for the product		
		if(!empty($tkt_pro_id)&&in_array($tkt_pro_id,$products)!==true){
		//error_log('product not supported by user');	
		return false;
			}else{
		return true;
			}
		
}

/* Is agent of department
* @since  2.0
* @param  object|integer the user $user and the tickets product id $tkt_dept_id 
* @return boolean true or false 
*/
public function is_agent_department($user,$tkt_dept_id){
	
	$departments= get_user_meta( $user->ID , 'wpas_department',true); 
		if(empty($departments)){
			$departments=[];
		}
		
		//check user provides support for the product		
		if(!empty($tkt_dept_id)&&in_array($tkt_dept_id,$departments)!==true){
		//error_log('department not supported by user');	
		return false;
			}else{
		return true;
			}
		
}

		
/* Create time from string in g:ia format
* @since  2.0
* @param  string the time $time 
* @return formatted time from string
*/
		public function createTime($time){
		return DateTime::createFromFormat('g:ia', $time);	
		}
		
/* Is agent available on day
* @since  2.0
* @param  object the user $user 
* @return boolean true or false
*/
public function is_agent_available($user, $checkday=true,$checktime=true){
	$days=$time_from=$time_to=$time_from_2=$time_to_2=[];
		$now_day=date('l');
		$current_time=date('g:ia');
		
		//days and time agent is available
		$days_available =  get_user_meta( $user->ID,'esa_days_available',true ) ; 
				
		if(empty($days_available)){
						$days=[];
						$time_from_1=$time_from_2=$time_from_3=$time_from_4=[];
						$time_to_1=$time_to_2=$time_to_3=$time_to_4=[];
						}else{
						foreach($days_available as $dav){
						$days[]=$dav[0];
						$time_from_1[]=$dav[1];
						$time_to_1[]=$dav[2];
						
						$time_from_2[]=isset($dav[3])?$dav[3]:'';
						$time_to_2[]=isset($dav[4])?$dav[4]:'';
						
						$time_from_3[]=isset($dav[5])?$dav[5]:'';
						$time_to_3[]=isset($dav[6])?$dav[6]:'';
						
						$time_from_4[]=isset($dav[7])?$dav[7]:'';
						$time_to_4[]=isset($dav[8])?$dav[8]:'';	
						
						}
		}
			
		$ntime = $this->createTime($current_time);
		
		//check if agent is available on ticket submission
		//if check for day only
			if($checkday){
				if(in_array($now_day,$days)!==true){
				return false;
				}		
			return true;	
			}
			
			if($checktime){
			//get key of the day
			$key=array_search($now_day,$days);
			//get from and to time of that day
			$ftime = $this->createTime($time_from_1[$key]);
			$ttime = $this->createTime($time_to_1[$key]);
			//24 hour time rep
			$ntime=$ntime->format('H:i');
			$ftime=$ftime->format('H:i');
			$ttime=$ttime->format('H:i');
			//second time set
			if(!empty($time_from_2)&&!empty($time_to_2)){ 
			if(!empty($time_from_2[$key])&&!empty($time_to_2[$key])){
			$ftime2 = $this->createTime($time_from_2[$key]);
			$ttime2 = $this->createTime($time_to_2[$key]);	
			//24 hour time rep
			$ftime2=$ftime2->format('H:i');
			$ttime2=$ttime2->format('H:i');	
			}
			}
			
			//third time set
			if(!empty($time_from_3)&&!empty($time_to_3)){ 
			if(!empty($time_from_3[$key])&&!empty($time_to_3[$key])){
			$ftime3 = $this->createTime($time_from_3[$key]);
			$ttime3 = $this->createTime($time_to_3[$key]);	
			//24 hour time rep
			$ftime3=$ftime3->format('H:i');
			$ttime3=$ttime3->format('H:i');	
			}
			}
			
			//fourth time set
			if(!empty($time_from_4)&&!empty($time_to_4)){ 
			if(!empty($time_from_4[$key])&&!empty($time_to_4[$key])){
			$ftime4 = $this->createTime($time_from_4[$key]);
			$ttime4 = $this->createTime($time_to_4[$key]);	
			//24 hour time rep
			$ftime4=$ftime4->format('H:i');
			$ttime4=$ttime4->format('H:i');	
			}
			}
			//check time within the agents support time
			if (($ntime >= $ftime && $ntime <= $ttime)!=1)
			{
			  //check time in 2nd slot
			  		if(isset($ftime2)&&isset($ttime2)){
					if (($ntime >= $ftime2 && $ntime <= $ttime2)==1){
						return true;	
					}
					}
					
					if(isset($ftime3)&&isset($ttime3)){
					if (($ntime >= $ftime3 && $ntime <= $ttime3)==1){
						return true;	
					}
					}
					
					if(isset($ftime3)&&isset($ttime3)){
					if (($ntime >= $ftime3 && $ntime <= $ttime3)==1){
						return true;	
					}
					}
					
			return false;
			}else{
			//error_log('found in first time slot');
			return true;	
			}
						
			}
}
/* first algo
* Product and Agent Availability #1
* It finds the agent on following conditions
* 1. product check -if agent doesnot provides support for project move to next agent
* 2. day -if agent doesnot provides support on this particular day move to next agent
* 3. time -if agent doesnot provides support on the time of the day move to next agent
* If agent is found assign to the one with the less tickets currently open.
* If no product is entered on the ticket then check for time and day against any agent.
* If no agent is found then assign to the default agent.
* @since 1.0
* @param  boolean|integer $ticket_id The ticket that needs an agent
* return intger the agent id of the found agent or defult assignee
*
*/
public function product_agent_availability($ticket_id){
	$users = shuffle_assoc( wpas_get_users( apply_filters( 'wpas_find_agent_get_users_args', array( 'cap' => 'edit_ticket') ) ) );
	$agent = array();


		//extra
		//if product support is enabled
		if(wpas_get_option('support_products')){
		$tkt_pro_id=apply_filters('esa_get_ticket_product',$ticket_id); //get ticket product
		}
		
	foreach ($users->members as $user ) {

		$wpas_agent = new WPAS_Member_Agent( $user );

		/**
		 * Make sure the user really is an agent and that he can currently be assigned
		 */
		if ( true !== $wpas_agent->is_agent() || false === $wpas_agent->can_be_assigned() ) {
			continue;
		}	
		//if ticket has product
		if(isset($tkt_pro_id)&&!empty($tkt_pro_id)){
			//check if user supports product
			if(!$this->is_agent_product($user,$tkt_pro_id)){
			continue;
			}
		}
		
		if(!$this->is_agent_available($user,$checkday=true,$checktime=false))
		{
		continue;
		}
		if(!$this->is_agent_available($user,$checkday=false,$checktime=true))
		{
		continue;
		}
		//end extra
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
		}
	}
		
	//check if agent is found
	if ( is_array( $agent ) && isset( $agent['user_id'] ) ) {
		$agent_id = $agent['user_id'];
	} else {

		$default_id = wpas_get_option( 'assignee_default', 1 );

		if ( empty( $default_id ) ) {
			$default_id = 1;
		}

		$agent_id = $default_id;

	}
	return $agent_id;
}


/* second algo
*  Product And Agent Availability #2
* Check for a set of agents that supports that particular product.
* Then, from that set of agents, check time and day to assign an agent.
* If an agent isn't found, then check for any agent assigned to that product.
* If one is not found check for any agent with working hours.
* If still none found, assign to the default agent.
* If no product is entered on the ticket then check for time and day against any agent.
* If no agent is found then assign to the default agent. 
* @since 2.0
* @param  boolean|integer $ticket_id The ticket that needs an agent
* return intger the agent id of the found agent or defult assignee
*
*/
public function product_agent_availability_2($ticket_id){
	$users = shuffle_assoc( wpas_get_users( apply_filters( 'wpas_find_agent_get_users_args', array( 'cap' => 'edit_ticket') ) ) );
	$agent = array();


		//extra
		//if product support is enabled
		if(wpas_get_option('support_products')){
		$tkt_pro_id=apply_filters('esa_get_ticket_product',$ticket_id); //get ticket product
		}
		
		$check1=true; $check2=false;$check3=false;

checkallusers:
	foreach ($users->members as $user ) {
		$wpas_agent = new WPAS_Member_Agent( $user );

		/**
		 * Make sure the user really is an agent and that he can currently be assigned
		 */
		if ( true !== $wpas_agent->is_agent() || false === $wpas_agent->can_be_assigned() ) {
			continue;
		}

		//error_log('user'.$user->ID);
		if($check1)
		{
		//if ticket has product
		if(isset($tkt_pro_id)&&!empty($tkt_pro_id)){
			//check if user supports product
			if(!$this->is_agent_product($user,$tkt_pro_id)){
			continue;
			}
		}
		
		if(!$this->is_agent_available($user,$checkday=true,$checktime=false))
		{
		continue;
		}
		if(!$this->is_agent_available($user,$checkday=false,$checktime=true))
		{
		continue;
		}
		//end extra
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
			}
		}
		
		if($check2)
		{
			
		//if ticket has product
		if(isset($tkt_pro_id)&&!empty($tkt_pro_id)){
			//check if user supports product
			if(!$this->is_agent_product($user,$tkt_pro_id)){
			continue;
			}
		}
		//end extra
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
			}
		}
		
		if($check3)
		{
			if(!$this->is_agent_available($user,$checkday=true,$checktime=false))
		{
		continue;
		}
		if(!$this->is_agent_available($user,$checkday=false,$checktime=true))
		{
		continue;
		}
		//end extra
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
		}
		}
				
	}
	if(!isset($agent['user_id'] )){
				if($check1)
				{	
					$check1=false;
					$check2=true;
					goto checkallusers;
				}
				if($check2){
					$check2=false;
					$check3=true;
					goto checkallusers;
				}
			}
		
		//check if agent is found
	if ( is_array( $agent ) && isset( $agent['user_id'] ) ) {
		$agent_id = $agent['user_id'];
	} else {
		$default_id = wpas_get_option( 'assignee_default', 1 );
		if ( empty( $default_id ) ) {
			$default_id = 1;
		}
		$agent_id = $default_id;
	}
	
	return $agent_id;
}

/* third algo
* Departments And Agent Availability #1
* Try to find an agent with working hours who has the same department as the ticket.
* If no match then use the default agent. 
* @since 2.0
* @param  boolean|integer $ticket_id The ticket that needs an agent
*return intger the agent id of the found agent or defult assignee
*
*/
public function department_agent_availability($ticket_id){
	$users = shuffle_assoc( wpas_get_users( apply_filters( 'wpas_find_agent_get_users_args', array( 'cap' => 'edit_ticket') ) ) );
	$agent = array();
		
		//if departments are enabled
		if(wpas_get_option('departments')){
		$tkt_dept_id=apply_filters('esa_get_ticket_department',$ticket_id); //get ticket department
		}
				
	foreach ($users->members as $user ) {

		$wpas_agent = new WPAS_Member_Agent( $user );

		/**
		 * Make sure the user really is an agent and that he can currently be assigned
		 */
		if ( true !== $wpas_agent->is_agent() || false === $wpas_agent->can_be_assigned() ) {
			continue;
		}

	
		//$products=$days=$time_from=$time_to=$time_from_2=$time_to_2=[];	
		//error_log('user'.$user->ID);
		//check for dept and working hours of day 
		
		//if ticket has dept
		if(isset($tkt_dept_id)&&!empty($tkt_dept_id)){
			//check if user supports dept
			if(!$this->is_agent_department($user,$tkt_dept_id)){
			continue;
			}
		}			
		if(!$this->is_agent_available($user,$checkday=true,$checktime=false))
		{
		continue;
		}
		if(!$this->is_agent_available($user,$checkday=false,$checktime=true))
		{
		continue;
		}
		//end extra
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
			}
	}

	//check if agent is found
	if ( is_array( $agent ) && isset( $agent['user_id'] ) ) {
		$agent_id = $agent['user_id'];
	} else {

		$default_id = wpas_get_option( 'assignee_default', 1 );

		if ( empty( $default_id ) ) {
			$default_id = 1;
		}

		$agent_id = $default_id;

	}
	
	return $agent_id;
}

/* fourth algo
*  Departments And Agent Availability #2
* Try to find an agent with working hours who has the same department as the ticket.
* Then, from that set of agents, check time and day to assign an agent.
* If no agent is found then use any agent with working hours otherwise use the default agent.
* @since 2.0
* @param  boolean|integer $ticket_id The ticket that needs an agent
* return intger the agent id of the found agent or defult assignee
*
*/
public function department_agent_availability_2($ticket_id){
	$users = shuffle_assoc( wpas_get_users( apply_filters( 'wpas_find_agent_get_users_args', array( 'cap' => 'edit_ticket') ) ) );
	$agent = array();

		//if departments are enabled
		if(wpas_get_option('departments')){
		$tkt_dept_id=apply_filters('esa_get_ticket_department',$ticket_id); //get ticket department
		}
	$check1=true; $check2=false;	
checkallusers:	
	foreach ($users->members as $user ) {

		$wpas_agent = new WPAS_Member_Agent( $user );

		/**
		 * Make sure the user really is an agent and that he can currently be assigned
		 */
		if ( true !== $wpas_agent->is_agent() || false === $wpas_agent->can_be_assigned() ) {
			continue;
		}
		//error_log('user'.$user->ID);
		if($check1)
		{
		//if ticket has dept
		if(isset($tkt_dept_id)&&!empty($tkt_dept_id)){
			//check if user supports dept
			if(!$this->is_agent_department($user,$tkt_dept_id)){
			continue;
			}
		}
				
		if(!$this->is_agent_available($user,$checkday=true,$checktime=false))
		{
		continue;
		}
		if(!$this->is_agent_available($user,$checkday=false,$checktime=true))
		{
		continue;
		}
		//end extra
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
			}
		}
		//second check for any agent available on that day
		if($check2){
		{
		if(!$this->is_agent_available($user,$checkday=true,$checktime=false))
		{
		continue;
		}
		if(!$this->is_agent_available($user,$checkday=false,$checktime=true))
		{
		continue;
		}
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
			}
		}	
		}
	}
	//no agent found after product match repeat search for day & time only
	//if no agent found after checks
	if(!isset($agent['user_id'] )){
				if($check1)
				{				
					$check1=false;
					$check2=true;
					goto checkallusers;
				}
				
	}
	
	
	if ( is_array( $agent ) && isset( $agent['user_id'] ) ) {
		$agent_id = $agent['user_id'];
	} else {

		$default_id = wpas_get_option( 'assignee_default', 1 );

		if ( empty( $default_id ) ) {
			$default_id = 1;
		}

		$agent_id = $default_id;

	}
	
	return $agent_id;
}

/* fifth algo
*  Agent Availability #1
* Check for a set of agents based on time only. If no agents exist use the default agent. 
* since 2.0
* @param  boolean|integer $ticket_id The ticket that needs an agent
* return intger the agent id of the found agent or defult assignee
*
*/
public function agent_availability($ticket_id){
	$users = shuffle_assoc( wpas_get_users( apply_filters( 'wpas_find_agent_get_users_args', array( 'cap' => 'edit_ticket') ) ) );
	$agent = array();

	foreach ($users->members as $user ) {

		$wpas_agent = new WPAS_Member_Agent( $user );

		/**
		 * Make sure the user really is an agent and that he can currently be assigned
		 */
		if ( true !== $wpas_agent->is_agent() || false === $wpas_agent->can_be_assigned() ) {
			continue;
		}

		//error_log('user'.$user->ID);
		
		if(!$this->is_agent_available($user,$checkday=true,$checktime=false))
		{
		continue;
		}
		if(!$this->is_agent_available($user,$checkday=false,$checktime=true))
		{
		continue;
		}
		//end extra
			$count = $wpas_agent->open_tickets(); // Total number of open tickets for this agent

			if ( empty( $agent ) ) {
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
			} else {
				if ( $count < $agent['tickets'] ) { 
				
				$agent = array( 'tickets' => $count, 'user_id' => $user->ID );
				}
		}
	}
	//return the found agent
	
	//check if agent is found
	if ( is_array( $agent ) && isset( $agent['user_id'] ) ) {
		$agent_id = $agent['user_id'];
	} else {

		$default_id = wpas_get_option( 'assignee_default', 1 );

		if ( empty( $default_id ) ) {
			$default_id = 1;
		}

		$agent_id = $default_id;

	}
	
	return $agent_id;
}

/**
 * Find an available agent to assign a ticket to based on algorithm in use.
 *
 * @since  1.0
 *
 * @param  boolean|integer $agent_id, $ticket_id The ticket that needs an agent
 *
 * @return integer  ID of the best agent for the job
 */

public function new_wpas_find_agent( $agent_id,$ticket_id = false ) {
		
	do_action( 'wpas_open_ticket_before_assigned', $ticket_id, $data );


	if ( defined( 'WPAS_DISABLE_AUTO_ASSIGN' ) && true === WPAS_DISABLE_AUTO_ASSIGN ) {
		return apply_filters( 'wpas_find_available_agent', wpas_get_option( 'assignee_default' ), $ticket_id );
	}

		
		//get the algorithm in use
		$algo= $this->get_smart_agent_algorithm();
		//error_log($algo);
		switch ($algo){
			case 1:
			//error_log('first algo in use');
		    $agent_id=$this->product_agent_availability($ticket_id);
			break;
			
			case 2:
			//error_log('second algo in use');
			 $agent_id=$this->product_agent_availability_2($ticket_id);
			break;
			
			case 3:
			//error_log('third algo in use');
			$agent_id=$this->department_agent_availability($ticket_id);
			break;
			
			case 4:
			//error_log('fourth algo in use');
			$agent_id=$this->department_agent_availability_2($ticket_id);
			break;
			
			case 5:
			//error_log('5th algo in use');
			$agent_id=$this->agent_availability($ticket_id);
			break;
			
			default:
			//error_log('default 1st algo as algo not matched');
			$agent_id=$this->product_agent_availability($ticket_id);
		}
	
	//erro_log($agent_id);
	return $agent_id;
}
	
	
}
//end of class

	