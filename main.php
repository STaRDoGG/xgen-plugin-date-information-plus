<?php
/**
 * Plugin Name: xGen Plugin Date Information Plus
 * Plugin URI: http://xgensolutions.in/xgen-plugin-date-information
 * Description: It shows the plugin's Install Date, Last Activated Date, Last Deactivated Date and Plugin Last Update Date. Plus we have given a provision where the user can select which information they want to see and which they don't want to. We have also provided an option to change the column name i.e. user can change the default 'Last Activated Date' to something they want. Time/date formatting can also be customized. This plugin helps user to track each and every plugin activation, deactivation, install and if they know fom what date and time they are facing the problem then with this provided information they will have ideas as which plugin is facing the problem.
 * Version: 1.2
 * Author: xGen Solutions. Additional modifications by J. Scott Elblein (GeekDrop.com)
 * Author URI: http://xgensolutions.in, http://geekdrop.com
 * License: GPL2
 */
class xGenPluginDateInfo {

	public function __construct() {
		error_reporting(0);
		ini_set('display_errors', 0);

		add_filter('admin_init',										array($this,'xgenpc_add_option'));
		add_action('activate_plugin',								array($this,'xgenpc_activate_plugin_status'));
		add_action('deactivate_plugin',							array($this,'xgenpc_deactive_plugin_status'));
		add_filter('manage_plugins_columns', 				array($this,'xgenpc_date_columns'));
    add_action('manage_plugins_custom_column',	array($this,'xgenpc_show_date_column'),10,3);
		add_filter('plugin_row_meta',								array($this,'xgenpc_plugin_meta'), 10, 2);
		add_action('admin_menu',										array($this,'register_xgen_plugin_date_info_menu'));
	}

	function register_xgen_plugin_date_info_menu() {
		/* Scott: changed to add_options_page to clean up the main menu */
		$page_value = add_options_page('xGen Plugin Date Information | Shows Install, Active, Inactive and Plugin Update Dates', 'xGen Plugin Date Information', 'edit_private_pages', 'xgen_plugin_date_information', array($this,'set_xgen_plugin_date_info_setting'));
		add_action('admin_print_styles-' . $page_value, array($this,'xgen_pdi_load_stylesheet'));
	}

	function xgen_pdi_load_stylesheet() {
		 wp_enqueue_style('xgen_plugin_data_stylesheet');
	}

	public function set_xgen_plugin_date_info_setting() {
		if(isset($_POST) && !empty($_POST)){
			$install_date_value							=	strip_tags(esc_sql($_POST['install_date_value']));
			$activated_date_value						=	strip_tags(esc_sql($_POST['activated_date_value']));
			$deactivated_date_value					= strip_tags(esc_sql($_POST['deactivated_date_value']));
			$updated_date_value							=	strip_tags(esc_sql($_POST['updated_date_value']));
			$install_column_text						=	strip_tags(esc_sql($_POST['install_column_text']));
			$activated_column_text					=	strip_tags(esc_sql($_POST['activated_column_text']));
			$deactivated_column_text				=	strip_tags(esc_sql($_POST['deactivated_column_text']));
			$update_column_text							= strip_tags(esc_sql($_POST['update_column_text']));
			$timestamp_format_columns_date	= strip_tags(esc_sql($_POST['timestamp_format_columns_date']));
			$timestamp_format_columns_time	= strip_tags(esc_sql($_POST['timestamp_format_columns_time']));
			$timestamp_format_desc					= strip_tags(esc_sql($_POST['timestamp_format_desc']));

			update_option('install_date_value', $install_date_value);
			update_option('activated_date_value', $activated_date_value);
			update_option('deactivated_date_value', $deactivated_date_value);
		 	update_option('updated_date_value', $updated_date_value);
			update_option('install_column_text', $install_column_text);
		 	update_option('activated_column_text', $activated_column_text);
			update_option('deactivated_column_text', $deactivated_column_text);
			update_option('update_column_text', $update_column_text);
			update_option('timestamp_format_columns_date', $timestamp_format_columns_date);
			update_option('timestamp_format_columns_time', $timestamp_format_columns_time);
			update_option('timestamp_format_desc', $timestamp_format_desc);
			$message = 'Settings have been successfully saved';
		}
		include('xgen_set_plugin_setting_form.php');
	}

	public function xgenpc_activate_plugin_status($plugin_name) {
		$plugin_info								= unserialize(get_option('xgenpc_plugin_activate_date'));
		$plugin_info[$plugin_name]	= array(
			'status'		=> 'activated',
			'timestamp'	=> current_time('timestamp')
		);
		update_option('xgenpc_plugin_activate_date', serialize($plugin_info));
	}

	public function xgenpc_deactive_plugin_status($plugin_name) {
		$plugin_info								= unserialize(get_option('xgenpc_plugin_deactivate_date'));
		$plugin_info[$plugin_name]	= array(
			'status'		=> 'deactivated',
			'timestamp'	=> current_time('timestamp')
		);
		update_option('xgenpc_plugin_deactivate_date', serialize($plugin_info));
	}

	public function xgenpc_add_option() {
		add_option('xgenpc_plugin_activate_date');
		add_option('xgenpc_plugin_deactivate_date');
		add_option('install_date_value');
		add_option('activated_date_value');
		add_option('deactivated_date_value');
	 	add_option('updated_date_value');
	 	add_option('install_column_text');
		add_option('activated_column_text');
	 	add_option('deactivated_column_text');
		add_option('update_column_text');
		add_option('timestamp_format_columns_date');
		add_option('timestamp_format_columns_time');
		add_option('timestamp_format_desc');
		wp_register_style('xgen_plugin_data_stylesheet', plugins_url('css/style.css', __FILE__ ));
	}

	public function xgenpc_date_columns($columns) {
		if (get_option('install_date_value') == 'yes') {
			if (get_option('install_column_text') == '') {
				$display_text = 'Install Date';
			}else{
				$display_text = get_option('install_column_text');
			}
			$columns['first_activated_date'] = $display_text;
		}

		if (get_option('activated_date_value') == 'yes') {
	  	if (get_option('activated_column_text') == '') {
				$display_text = 'Last Activated';
			}else{
				$display_text = get_option('activated_column_text');
			}
			$columns['last_activated_date']	= $display_text;
		}

		if (get_option('deactivated_date_value') == 'yes') {
			if (get_option('deactivated_column_text') == '') {
				$display_text = 'Last Deactivated';
			}else{
				$display_text = get_option('deactivated_column_text');
			}
			$columns['last_deactivated_date'] = $display_text;
		}
		return $columns;
	}

	public function xgenpc_show_date_column($column_name, $plugin_file, $plugin_data) {

		/* Center align the dashes when no data available */
		$no_data = "<div align=\"center\">---</div>";

		switch ($column_name) {
			case 'last_activated_date':
				$plugin_date_column	= unserialize(get_option('xgenpc_plugin_activate_date'));
				$current_plugin			= $plugin_date_column[$plugin_file];
				if (!empty($current_plugin['timestamp']))
					echo $this->xgenpc_format_date_value($current_plugin['timestamp']);
				else
					echo $no_data;
				break;
			case 'last_deactivated_date':
				$plugin_date_column = unserialize(get_option('xgenpc_plugin_deactivate_date'));
				$current_plugin = $plugin_date_column[$plugin_file];
				if (!empty($current_plugin['timestamp']) && $current_plugin['status'] == 'deactivated')
					echo $this->xgenpc_format_date_value($current_plugin['timestamp']);
				else
					echo $no_data;
				break;
			case 'first_activated_date':
				$plugin_path					= plugins_url('',$plugin_file);
				$plugin_folder_array	= explode('/plugins/', $plugin_path);
				if (isset($plugin_folder_array[1])) {
					$stat = stat(ABSPATH . 'wp-content/plugins/' . $plugin_folder_array[1]);
					if (isset($stat['ctime'])) {
						echo $this->xgenpc_format_date_value($stat['ctime']);
					}else{
						echo $no_data;
					}
				}else{
					echo $no_data;
				}
				break;
		}
	}

	public function xgenpc_plugin_last_update($plugin_file) {
		list($plugin_slug)	= explode('/', $plugin_file);
		$slug_hash					= md5($plugin_slug);
		$last_updated_date	= get_transient("xgenpc_{$slug_hash}");
		if (false === $last_updated_date) {
			$last_updated_date = $this->xgenpc_fetch_last_update($plugin_slug);
			if (empty($last_updated_date)) {
				$plugin_slug_array	= explode('/',$plugin_data['PluginURI']);
				$plugin_slug				= $plugin_slug_array[count($plugin_slug_array)-2];
				$last_updated_date	= $this->xgenpc_fetch_last_update($plugin_slug);
			}
			set_transient( "xgenpc_{$slug_hash}", $last_updated_date, 86400 );
		}
		return $last_updated_date;
	}

	public function xgenpc_plugin_meta($plugin_meta, $plugin_file) {
		if (get_option('updated_date_value') == 'yes') {
			if (get_option('update_column_text') == '') {
				$display_text = 'Latest Update:';
			}else{
				$display_text = get_option('update_column_text');
			}
			$plugin_meta['last_updated'] = "$display_text " . $this->xgenpc_format_date_value(strtotime($this->xgenpc_plugin_last_update($plugin_file)), 'yes');
			return $plugin_meta;
		}
	}
	public function xgenpc_format_date_value($unix_time_stamp, $is_last_updated = '') {
		if ($is_last_updated == '') {
		/* Handles formatting the info in the plugin's description */

			/* We have to do this separately since PHP wont allow use of !Empty on anything other than a variable */
			$strDate = get_option('timestamp_format_columns_date');
			$strTime = get_option('timestamp_format_columns_time');

			/* If user entered a custom format, use it, otherwise use the default WordPress settings */
			$strDate = (!empty($strDate)) ? $strDate : get_option('date_format');
			$strTime = (!empty($strTime)) ? $strTime : get_option('time_format');

			return date_i18n(sprintf('%s   %s', $strDate, $strTime), $unix_time_stamp);
		}else{
		/* Handles formatting the info in the plugin's description */

			$check = get_option('timestamp_format_desc');
			$check = (!empty($check)) ? $check : get_option('date_format');
			return date_i18n(sprintf('%s ', $check), $unix_time_stamp);
		}
	}

	function xgenpc_fetch_last_update($plugin_name) {
		$request = wp_remote_post(
			'http://api.wordpress.org/plugins/info/1.0/',
			array(
				'body'		=> array(
				'action'	=> 'plugin_information',
				'request'	=> serialize(
					(object) array(
						'slug'		=> $plugin_name,
						'fields'	=> array( 'last_updated' => true )
					)
				)
				)
			)
		);

		if (200 != wp_remote_retrieve_response_code($request)) {
			return false;
		}else{
			$response = unserialize(wp_remote_retrieve_body($request));

			// Return an empty but cachable response if the plugin isn't in the .org repo
			if (empty($response)) {
				return '';
			}elseif (isset($response->last_updated)) {
				return sanitize_text_field($response->last_updated);
			}else{
				return false;
			}
		}
	}
}

$obj = new xGenPluginDateInfo();