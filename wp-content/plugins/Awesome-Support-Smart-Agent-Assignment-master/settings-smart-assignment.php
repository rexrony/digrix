<?php
add_action( 'wp_ajax_post_algo', 'post_algo',10, 0 );
add_filter( 'wpas_plugin_settings', 'wpas_settings_smart_assignment', 10, 1 );
if ( is_admin()&&($_GET['page']=='wpas-settings')&&($_GET['tab']=='smart-assignment-options')){
add_action( 'admin_enqueue_scripts','sm_enqueue_scripts', 10, 0 );
}
/**
 * Add settings for Smart Agent Assignment addon.
 * @since 2.0
 * @param  (array) $def Array of existing settings
 * @return (array)      Updated settings
 */
function wpas_settings_smart_assignment( $def ) {
	$algos = get_algorithms();
	
	$default_algo=5; //default algo set to 5th one
	$sma_algo=wpas_get_option('smart_agent_algorithm');  //get algorithm value
	if(!$sma_algo){ //if default setting is not saved
		$opt=unserialize(get_option('wpas_options'));
		$opt['smart_agent_algorithm']=$default_algo;
		update_option('wpas_options',serialize($opt));
	}
	$note='';
	if(!wpas_get_option('support_products')){
		$note.= __( '<p><em><strong>NOTE:</strong> Enable multiple product support in Awesome Support settings for algorithms - Product and Agent Availability #1, Product and Agent Availability #2</em></p>', 'smart-agent-assignment' );	
		}
		if(!wpas_get_option('departments')){
		$note.= __( '<p><em><strong>NOTE:</strong> Enable departments in Awesome Support settings for algorithms - Department and Agent Availability #1, Department and Agent Availability #2</em></p>', 'smart-agent-assignment' );	
		}
	
		
	$settings = array(
		'smart-assignment-options' => array(
			'name'    => __( 'Smart Assignment', 'smart-agent-assignment' ),
			'options' => array(
				array(
					'name' => __( 'Set the algorithm used to check available agents', 'smart-agent-assignment' ),
					'type' => 'heading',
				),
				array(
					'name'    => __( "Assignment Algorithm", 'smart-agent-assignment' ),
					'id'      => 'smart_agent_algorithm',
					'type'    => 'select',
					'default' => $default_algo,
					'options' => $algos,
					'desc'=>$note,
					
				),
							
			)
		)
	);

	return array_merge( $def, $settings );

}
/**
 * Get all agorithm options
 *
 * @return array The list of algo names
 * @since  2.0
 */
function get_algorithms() {

	$algos = array(
	'1'  => __( 'Product and Agent Availability #1', 'smart-agent-assignment' ),
	'2'  => __( 'Product and Agent Availability #2', 'smart-agent-assignment' ),
	'3'  => __( 'Departments and Agent Availability #1', 'smart-agent-assignment' ),
	'4'  => __( 'Departments and Agent Availability #2', 'smart-agent-assignment' ),
	'5'  => __( 'Agent Availability #1', 'smart-agent-assignment' ),
	);

	return $algos;

}
/**
* Scripts to include on settings page
*/
 function sm_enqueue_scripts() {
		wp_register_script( 'esa-admin-script', AS_ESA_URL . 'js/algo.js', array( 'jquery' ), AS_ESA_VERSION, true );
		wp_localize_script( 'esa-admin-script', 'esma', array(
		'algourl'=> AS_ESA_URL.'assignment-algorithms.php',
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		));
		wp_enqueue_script( 'esa-admin-script' );
	}

/**
* Get algorithm detail using ajax
* requires id of the algo $_POST['algo']
* the description sent as response
*/	
function post_algo() {
	  global $wpdb;
	 $algo=$_POST['algo'];
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
	switch ($algo){
	case 1:
		echo (__( "<strong>Product and Agent Availability #1</strong><br/>1. Check for a set of agents that supports the product the user selected on the ticket. Then, from that set of agents, check for an agent currently working (based on the day and times set in their agent/user profile). <br/><br/> 2. If a working agent isn't found, then assign the ticket to the default agent (currently any agent with the least number of tickets). <br/><br/>3. If no product is entered on the ticket then check for any agent currently working regardless of product. If an agent is not found then assign the ticket to the default agent (any agent with the last number of tickets).",'smart-agent-assignment'));
		break;

	case 2:
		echo(__( "<strong>Product And Agent Availability #2</strong><br/>1. Check for a set of agents that supports the product the user selected on the ticket. Then, from that set of agents, check for an agent currently working (based on the day and times set in their agent/user profile). <br/><br/> 2. If an agent isn't found, then check for any agent assigned to that product regardless of working hours. <br/><br/>3. If one is not found then check for any agent with current working hours regardless of product. <br/><br/>4. If an agent is still not found then assign the ticket to the default agent (any agent with the least number of tickets). <br/> <br/>5. If no product is entered on the ticket then check for any currently working agent agent. If no agent is found then assign to the default agent.",'smart-agent-assignment'));
		break;

	case 3:
		echo(__( "<strong>Departments And Agent Availability #1</strong><br/>1. Try to find a current working agent who has the same department as the ticket. <br/><br/>2. If no match then use the default agent (any agent with the least number of tickets).",'smart-agent-assignment'));
		break;

	case 4:
		echo( __("<strong>Departments And Agent Availability #2</strong><br/>1. Try to find a current agent who has the same department as the ticket. <br/><br/>2. If no agent is found then use any available agent regardless of department. <br/><br/>3. If an agent is still not found then use the default agent (any agent with the least number of tickets).",'smart-agent-assignment'));
		break;
	case 5:
		echo( __("<strong>Agent Availability #1</strong><br/>Check for a set of agents based on agents day and time availabilty only. If no agents exist use the default agent (any agent with the least number of tickets).",'smart-agent-assignment'));
		break;
	default:
		echo(__("Undefined Algorithm",'smart-agent-assignment'));
}
		die();
	}
	else {
		echo(__("No algorithm selected",'smart-agent-assignment'));
		exit();
	}
}
