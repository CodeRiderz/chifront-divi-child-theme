<?php
// include './modules/tribe-events.php';
include './modules/utils.php';

/**
 * Loads the Chifront parent theme stylesheet & js.
 */

function chifront_theme_enqueue_styles() {
    wp_enqueue_script('chifrontscript', get_stylesheet_directory_uri() . '/js/chifront.js', array('jquery'), '1.0.0');
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'chifront_theme_enqueue_styles' );

/**
 * DIVI OVERRIDE FUNCTIONS
 * ==================================================
 */

function custom_role_options() {
	// get all the modules and build array of capabilities for them
	$all_modules_array = ET_Builder_Element::get_modules_array();
	$module_capabilies = array();

	foreach ( $all_modules_array as $module => $module_details ) {
		if ( ! in_array( $module_details['label'], array( 'et_pb_section', 'et_pb_row', 'et_pb_row_inner', 'et_pb_column' ) ) ) {
			$module_capabilies[ $module_details['label'] ] = array(
				'name'    => sanitize_text_field( $module_details['title'] ),
				'default' => 'on',
			);
		}
	}

	// we need to display some options only when theme activated
	$theme_only_options = ! et_is_builder_plugin_active()
		? array(
			'theme_customizer' => array(
				'name'           => esc_html__( 'Theme Customizer', 'et_builder' ),
				'default'        => 'on',
				'applicability'  => array( 'administrator' ),
			),
			'module_customizer' => array(
				'name'           => esc_html__( 'Module Customizer', 'et_builder' ),
				'default'        => 'on',
				'applicability'  => array( 'administrator', 'client-administrator' ),
			),
			'role_customizer' => array(
				'name'           => esc_html__( 'Role Costumizer', 'et_builder' ),
				'default'        => 'on'
			),
			'page_options' => array(
				'name'    => esc_html__( 'Page Options', 'et_builder' ),
				'default' => 'on',
			),
		)
		: array();

	$all_role_options = array(
		'general_capabilities' => array(
			'section_title' => '',
			'options'       => array(
				'theme_options' => array(
					'name'           => et_is_builder_plugin_active() ? esc_html__( 'Plugin Options', 'et_builder' ) : esc_html__( 'Theme Options', 'et_builder' ),
					'default'        => 'on',
					'applicability'  => array( 'administrator' ),
				),
				'divi_library' => array(
					'name'    => esc_html__( 'Divi Library', 'et_builder' ),
					'default' => 'on',
				),
				'ab_testing' => array(
					'name'    => esc_html__( 'Split Testing', 'et_builder' ),
					'default' => 'on',
				),
			),
		),
		'builder_capabilities' => array(
			'section_title' => esc_html__( 'Builder Interface', 'et_builder'),
			'options'       => array(
				'add_module' => array(
					'name'    => esc_html__( 'Add/Delete Item', 'et_builder' ),
					'default' => 'on',
				),
				'edit_module' => array(
					'name'    => esc_html__( 'Edit Item', 'et_builder' ),
					'default' => 'on',
				),
				'move_module' => array(
					'name'    => esc_html__( 'Move Item', 'et_builder' ),
					'default' => 'on',
				),
				'disable_module' => array(
					'name'    => esc_html__( 'Disable Item', 'et_builder' ),
					'default' => 'on',
				),
				'lock_module' => array(
					'name'    => esc_html__( 'Lock Item', 'et_builder' ),
					'default' => 'on',
				),
				'divi_builder_control' => array(
					'name'    => esc_html__( 'Toggle Divi Builder', 'et_builder' ),
					'default' => 'on',
				),
				'load_layout' => array(
					'name'    => esc_html__( 'Load Layout', 'et_builder' ),
					'default' => 'on',
				),
				'use_visual_builder' => array(
					'name'    => esc_html__( 'Use Visual Builder', 'et_builder' ),
					'default' => 'on',
				),
				'custom_fonts_management' => array(
					'name'    => esc_html__( 'Upload/Remove Fonts', 'et_builder' ),
					'default' => 'on',
				),
			),
		),
		'library_capabilities' => array(
			'section_title' => esc_html__( 'Library Settings', 'et_builder' ),
			'options'       => array(
				'save_library' => array(
					'name'    => esc_html__( 'Save To Library', 'et_builder' ),
					'default' => 'on',
				),
				'add_library' => array(
					'name'    => esc_html__( 'Add From Library', 'et_builder' ),
					'default' => 'on',
				),
				'edit_global_library' => array(
					'name'    => esc_html__( 'Edit Global Items', 'et_builder' ),
					'default' => 'on',
				),
			),
		),
		'module_tabs' => array(
			'section_title' => esc_html__( 'Settings Tabs', 'et_builder' ),
			'options'       => array(
				'general_settings' => array(
					'name'    => esc_html__( 'Content Settings', 'et_builder' ),
					'default' => 'on',
				),
				'advanced_settings' => array(
					'name'    => esc_html__( 'Design Settings', 'et_builder' ),
					'default' => 'on',
				),
				'custom_css_settings' => array(
					'name'    => esc_html__( 'Advanced Settings', 'et_builder' ),
					'default' => 'on',
				),
			),
		),
		'general_module_capabilities' => array(
			'section_title' => esc_html__( 'Settings Types', 'et_builder' ),
			'options'       => array(
				'edit_colors' => array(
					'name'    => esc_html__( 'Edit Colors', 'et_builder' ),
					'default' => 'on',
				),
				'edit_content' => array(
					'name'    => esc_html__( 'Edit Content', 'et_builder' ),
					'default' => 'on',
				),
				'edit_fonts' => array(
					'name'    => esc_html__( 'Edit Fonts', 'et_builder' ),
					'default' => 'on',
				),
				'edit_buttons' => array(
					'name'    => esc_html__( 'Edit Buttons', 'et_builder' ),
					'default' => 'on',
				),
				'edit_layout' => array(
					'name'    => esc_html__( 'Edit Layout', 'et_builder' ),
					'default' => 'on',
				),
				'edit_configuration' => array(
					'name'    => esc_html__( 'Edit Configuration', 'et_builder' ),
					'default' => 'on',
				),
			),
		),
		'module_capabilies' => array(
			'section_title' => esc_html__( 'Module Use', 'et_builder' ),
			'options'       => $module_capabilies,
		),
	);

	$all_role_options['general_capabilities']['options'] = array_merge( $all_role_options['general_capabilities']['options'], $theme_only_options );

	// Set portability capabilities.
	$registered_portabilities = et_core_cache_get_group( 'et_core_portability' );

	if ( ! empty( $registered_portabilities ) ) {
		$all_role_options['general_capabilities']['options']['portability'] = array(
			'name'    => esc_html__( 'Portability', 'et_builder' ),
			'default' => 'on',
		);
		$all_role_options['portability'] = array(
			'section_title' => esc_html__( 'Portability', 'et_builder' ),
			'options'       => array(),
		);

		// Dynamically create an option foreach portability.
		foreach ( $registered_portabilities as $portability_context => $portability_instance ) {
			$all_role_options['portability']['options']["{$portability_context}_portability"] = array(
				'name'    => esc_html( $portability_instance->name ),
				'default' => 'on',
			);
		}
	}

	return $all_role_options;
}

function custom_display_role_editor() {
	$all_role_options = custom_role_options();
	$option_tabs = '';
	$menu_tabs = '';
	$builder_roles_array = et_pb_get_all_roles_list();

	foreach( $builder_roles_array as $role => $role_title ) {
		$option_tabs .= et_pb_generate_roles_tab( $all_role_options, $role );

		$menu_tabs .= sprintf(
			'<a href="#" class="et-pb-layout-buttons%4$s" data-open_tab="et_pb_role-%3$s_options" title="%1$s">
				<span>%2$s</span>
			</a>',
			esc_attr( $role_title ),
			esc_html( $role_title ),
			esc_attr( $role ),
			'administrator' === $role ? ' et_pb_roles_active_menu' : ''
		);
	}

	printf(
		'<div class="et_pb_roles_main_container">
			<a href="#" id="et_pb_save_roles" class="button button-primary button-large">%3$s</a>
			<h3 class="et_pb_roles_title"><span>%2$s</span></h3>
			<div id="et_pb_main_container" class="post-type-page">
				<div id="et_pb_layout_controls">
					%1$s
					<a href="#" class="et-pb-layout-buttons et-pb-layout-buttons-reset" title="Reset all settings">
						<span class="icon"></span><span class="label">Reset</span>
					</a>
					%4$s
				</div>
			</div>
			<div class="et_pb_roles_container_all">
				%5$s
			</div>
		</div>',
		$menu_tabs,
		esc_html__( 'Divi Role Editor', 'et_builder' ),
		esc_html__( 'Save Divi Roles', 'et_builder' ),
		et_core_portability_link( 'et_pb_roles', array( 'class' => 'et-pb-layout-buttons et-pb-portability-button' ) ),
		$option_tabs
	);
}


function custom_divi_menu () {
	$core_page = add_menu_page( 'Divi', 'Divi', 'switch_themes', 'et_divi_options', 'et_build_epanel' );

	// Add Theme Options menu only if it's enabled for current user
	if ( et_pb_is_allowed( 'theme_options' ) ) {

		if ( isset( $_GET['page'] ) && 'et_divi_options' === $_GET['page'] && isset( $_POST['action'] ) ) {
			if (
				( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'epanel_nonce' ) )
				||
				( 'reset' === $_POST['action'] && isset( $_POST['_wpnonce_reset'] ) && wp_verify_nonce( $_POST['_wpnonce_reset'], 'et-nojs-reset_epanel' ) )
			) {
				epanel_save_data( 'js_disabled' ); //saves data when javascript is disabled
			}
		}

		add_submenu_page( 'et_divi_options', esc_html__( 'Theme Options', 'Divi' ), esc_html__( 'Theme Options', 'Divi' ), 'manage_options', 'et_divi_options' );
	}
	// Add Theme Customizer menu only if it's enabled for current user
	if ( et_pb_is_allowed( 'theme_customizer' ) ) {
		add_submenu_page( 'et_divi_options', esc_html__( 'Theme Customizer', 'Divi' ), esc_html__( 'Theme Customizer', 'Divi' ), 'manage_options', 'customize.php?et_customizer_option_set=theme' );
	}
	// Add Module Customizer menu only if it's enabled for current user
	if ( et_pb_is_allowed( 'module_customizer' ) ) {
		add_submenu_page( 'et_divi_options', esc_html__( 'Module Customizer', 'Divi' ), esc_html__( 'Module Customizer', 'Divi' ), 'manage_options', 'customize.php?et_customizer_option_set=module' );
	}
	if ( et_pb_is_allowed( 'role_customizer' ) ) {
		add_submenu_page( 'et_divi_options', esc_html__( 'Role Editor', 'Divi' ), esc_html__( 'Role Editor', 'Divi' ), 'manage_options', 'et_divi_role_editor', 'custom_display_role_editor' );
	}
	// Add Divi Library menu only if it's enabled for current user
	if ( et_pb_is_allowed( 'divi_library' ) ) {
		add_submenu_page( 'et_divi_options', esc_html__( 'Divi Library', 'Divi' ), esc_html__( 'Divi Library', 'Divi' ), 'manage_options', 'edit.php?post_type=et_pb_layout' );
	}

	add_action( "load-{$core_page}", 'et_pb_check_options_access' ); // load function to check the permissions of current user
	add_action( "load-{$core_page}", 'et_epanel_hook_scripts' );
	add_action( "admin_print_scripts-{$core_page}", 'et_epanel_admin_js' );
	add_action( "admin_head-{$core_page}", 'et_epanel_css_admin');
	add_action( "admin_print_scripts-{$core_page}", 'et_epanel_media_upload_scripts');
	add_action( "admin_head-{$core_page}", 'et_epanel_media_upload_styles');
}

function remove_menus() {
    // remove themes menu from Appearance
    global $submenu;
    unset($submenu['themes.php'][5]);
    unset($submenu['themes.php'][15]);

    // remove projects menu
    remove_menu_page( 'edit.php?post_type=project' );
}

function child_remove_parent_function() {
    remove_action( 'admin_menu', 'et_add_divi_menu' );
    add_action('admin_menu', 'custom_divi_menu', 99);
    // add_action('admin_menu', 'remove_menus', 99);
}

add_action( 'wp_loaded', 'child_remove_parent_function' );

/* 
 * Enable divi builder to all custom post type
 * ============================================== */

/* Enable Divi Builder on all post types with an editor box */
function myprefix_add_post_types($post_types) {
	foreach(get_post_types() as $pt) {
		if (!in_array($pt, $post_types) and post_type_supports($pt, 'editor')) {
			$post_types[] = $pt;
		}
	} 
	return $post_types;
}
add_filter('et_builder_post_types', 'myprefix_add_post_types');

/* Add Divi Custom Post Settings box */
function myprefix_add_meta_boxes() {
	foreach(get_post_types() as $pt) {
		if (post_type_supports($pt, 'editor') and function_exists('et_single_settings_meta_box')) {
			add_meta_box('et_settings_meta_box', __('Divi Custom Post Settings', 'Divi'), 'et_single_settings_meta_box', $pt, 'side', 'high');
		}
	} 
}
add_action('add_meta_boxes', 'myprefix_add_meta_boxes');

/* Ensure Divi Builder appears in correct location */
function myprefix_admin_js() { 
	$s = get_current_screen();
	if(!empty($s->post_type) and $s->post_type!='page' and $s->post_type!='post') { 
?>
	<script>
		jQuery(function($){
			$('#et_pb_layout').insertAfter($('#et_pb_main_editor_wrap'));
		});
	</script>
	<style>
		#et_pb_layout { margin-top:20px; margin-bottom:0px }
	</style>
<?php
	}
}
add_action('admin_head', 'myprefix_admin_js');


/* 
 * Using Layouts with Custom Post Types
 * ============================================== */

// Ensure that Divi Builder framework is loaded - required for some post types when using Divi Builder plugin
add_filter('et_divi_role_editor_page', 'myprefix_load_builder_on_all_page_types');
function myprefix_load_builder_on_all_page_types($page) { 
	return isset($_GET['page'])?$_GET['page']:$page; 
}

add_filter( 'et_pb_show_all_layouts_built_for_post_type', 'myprefix_et_pb_show_all_layouts_built_for_post_type' );

function myprefix_et_pb_show_all_layouts_built_for_post_type() {
    return 'page';
}

// Prevent featured post cropping 
function disable_cropping_on_featured_images() {
	add_image_size( 'extra-image-single-post', 1280, 1000, true );
}
add_action('after_setup_theme', 'disable_cropping_on_featured_images', 11);