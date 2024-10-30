<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Module
 *
 * @since 1.0
 */
function lc_mailchimp_module_init() {

	// Live Composer not active, do not proceed.
	if ( ! defined( 'DS_LIVE_COMPOSER_VER' ) ) {
		return;
	}

	dslc_register_module( 'LC_Mailchimp_Module' );

}
add_action( 'dslc_hook_register_modules', 'lc_mailchimp_module_init' );

/**
 * Load plugin textdomain.
 *
 * @since 1.0
 */
function lc_mailchimp_module_i18n() {

	load_plugin_textdomain( 'lc-mailchimp', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

} add_action( 'plugins_loaded', 'lc_mailchimp_module_i18n' );

/**
 * Procceed only when all the plugins loaded	
 */
function lc_mailchimp_moduled_class() {

	if ( ! defined( 'DS_LIVE_COMPOSER_VER' ) ) {
		return;
	}

	/**
	 * The Module Class
	 */
	class LC_Mailchimp_Module extends DSLC_Module {

		var $module_id;
		var $module_title;
		var $module_icon;
		var $module_category;

		function __construct() {

			$this->module_id = 'LC_Mailchimp_Module';
			$this->module_title = 'Mailchimp';
			$this->module_icon = 'send';
			$this->module_category = 'elements';

		}

		/**
		 * Module Options
		 *
		 * @since 1.0
		 */
		function options() {

			// The options array
			$dslc_options = array(

				array(
					'label' => __( 'Show On', 'lc-mailchimp' ),
					'id' => 'css_show_on',
					'std' => 'desktop tablet phone',
					'type' => 'checkbox',
					'choices' => array(
						array(
							'label' => __( 'Desktop', 'lc-mailchimp' ),
							'value' => 'desktop',
						),
						array(
							'label' => __( 'Tablet', 'lc-mailchimp' ),
							'value' => 'tablet',
						),
						array(
							'label' => __( 'Phone', 'lc-mailchimp' ),
							'value' => 'phone',
						),
					),
				),

				array(
					'label' => __( 'List ID', 'lc-mailchimp' ),
					'id' => 'list_id',
					'std' => '',
					'type' => 'text'
				),

				array(
					'label' => __( 'Template', 'lc-mailchimp' ),
					'id' => 'columns',
					'std' => '2',
					'type' => 'select',
					'choices' => array(
						array(
							'label' => '1 column',
							'value' => '1'
						),
						array(
							'label' => '2 columns',
							'value' => '2'
						),
						array(
							'label' => '3 columns',
							'value' => '3'
						)
					)
				),
				array(
					'label' => __( 'Padding Horizontal', 'lc-mailchimp' ),
					'id' => 'css_padding_horizontal',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.lc-mailchimp-form',
					'affect_on_change_rule' => 'padding-left,padding-right',
					'ext' => 'px'
				),

				/*
				*	Styling Input
				*/
				array(
					'label' => __( 'Placeholder - Name field', 'lc-mailchimp' ),
					'id' => 'css_input_name_label',
					'std' => 'Your name',
					'type' => 'text',
					'refresh_on_change' => false,
					'section' => 'styling',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Placeholder - Email field', 'lc-mailchimp' ),
					'id' => 'css_input_email_label',
					'std' => 'your@email.com',
					'type' => 'text',
					'refresh_on_change' => false,
					'section' => 'styling',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'BG Color', 'lc-mailchimp' ),
					'id' => 'css_input_bg',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'background-color',
					'section' => 'styling',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Border Color', 'lc-mailchimp' ),
					'id' => 'css_input_border_color',
					'std' => '#ddd',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Border Width', 'lc-mailchimp' ),
					'id' => 'css_input_border_width',
					'std' => '1',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'border-width',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Borders', 'lc-mailchimp' ),
					'id' => 'css_input_border_style',
					'std' => 'top right bottom left',
					'type' => 'checkbox',
					'choices' => array(
						array(
							'label' => __( 'Top', 'lc-mailchimp' ),
							'value' => 'top'
						),
						array(
							'label' => __( 'Right', 'lc-mailchimp' ),
							'value' => 'right'
						),
						array(
							'label' => __( 'Bottom', 'lc-mailchimp' ),
							'value' => 'bottom'
						),
						array(
							'label' => __( 'Left', 'lc-mailchimp' ),
							'value' => 'left'
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'border-style',
					'section' => 'styling',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Border Radius', 'lc-mailchimp' ),
					'id' => 'css_input_border_radius',
					'std' => '5',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'border-radius',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Padding Vertical', 'lc-mailchimp' ),
					'id' => 'css_input_padding_vertical',
					'std' => '12',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'padding-top,padding-bottom',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Padding Horizontal', 'lc-mailchimp' ),
					'id' => 'css_input_padding_horizontal',
					'std' => '12',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'padding-left,padding-right',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Margin - Bottom', 'lc-mailchimp' ),
					'id' => 'css_input_margin',
					'std' => '12',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Input Field', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Size', 'lc-mailchimp' ),
					'id' => 'css_input_font_size',
					'std' => '16',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-input',
					'affect_on_change_rule' => 'font-size',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Input Field', 'lc-mailchimp')
				),

				/**
				*	Styling - Button
				*/
				array(
					'label' => __( 'Align', 'lc-mailchimp' ),
					'id' => 'css_button_align',
					'std' => 'center',
					'type' => 'text_align',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'text-align',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Button Label', 'lc-mailchimp' ),
					'id' => 'button_label',
					'std' => 'Subscribe',
					'type' => 'text',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Color', 'lc-mailchimp' ),
					'id' => 'css_button_font_color',
					'std' => 'rgb(255, 255, 255)',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Family', 'lc-mailchimp' ),
					'id' => 'css_button_font_family',
					'std' => 'Open Sans',
					'type' => 'font',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'font-family',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Size', 'lc-mailchimp' ),
					'id' => 'css_button_font_size',
					'std' => '16',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'font-size',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Weight', 'lc-mailchimp' ),
					'id' => 'css_button_font_weight',
					'std' => '600',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'font-weight',
					'section' => 'styling',
					'tab' => __( 'Button', 'lc-mailchimp' ),
					'ext' => '',
					'min' => 100,
					'max' => 900,
					'increment' => 100
				),
				array(
					'label' => __( 'BG Color', 'lc-mailchimp' ),
					'id' => 'css_button_bg',
					'std' => 'rgb(88, 144, 229)',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'background-color',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'BG Color - Hover', 'lc-mailchimp' ),
					'id' => 'css_button_bg_hover',
					'std' => 'rgb(75, 123, 194)',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button:hover',
					'affect_on_change_rule' => 'background-color',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Border Color', 'lc-mailchimp' ),
					'id' => 'css_button_border_color',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Border Color - Hover', 'lc-mailchimp' ),
					'id' => 'css_button_border_color_hover',
					'std' => '',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button:hover',
					'affect_on_change_rule' => 'border-color',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Border Width', 'lc-mailchimp' ),
					'id' => 'css_button_border_width',
					'std' => '0',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'border-width',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Borders', 'lc-mailchimp' ),
					'id' => 'css_button_border_style',
					'std' => 'top right bottom left',
					'type' => 'checkbox',
					'choices' => array(
						array(
							'label' => __( 'Top', 'lc-mailchimp' ),
							'value' => 'top'
						),
						array(
							'label' => __( 'Right', 'lc-mailchimp' ),
							'value' => 'right'
						),
						array(
							'label' => __( 'Bottom', 'lc-mailchimp' ),
							'value' => 'bottom'
						),
						array(
							'label' => __( 'Left', 'lc-mailchimp' ),
							'value' => 'left'
						),
					),
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'border-style',
					'section' => 'styling',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Border Radius', 'lc-mailchimp' ),
					'id' => 'css_button_border_radius',
					'std' => '5',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'border-radius',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Padding Vertical', 'lc-mailchimp' ),
					'id' => 'css_button_padding_vertical',
					'std' => '12',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'padding-top,padding-bottom',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Padding Horizontal', 'lc-mailchimp' ),
					'id' => 'css_button_padding_horizontal',
					'std' => '12',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'padding-left,padding-right',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Button', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Margin - Bottom', 'lc-mailchimp' ),
					'id' => 'css_button_margin',
					'std' => '12',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.mailchimp-button',
					'affect_on_change_rule' => 'margin-bottom',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Button', 'lc-mailchimp')
				),

				/*
				*	Message
				*/

				array(
					'label' => __( 'Success Message', 'lc-mailchimp' ),
					'id' => 'success_text',
					'std' => "Success Message: CLICK TO EDIT",
					'type' => 'text',
					'visibility'=>'hidden',
					'section' => 'styling',
					'tab' => __('Success Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Align', 'lc-mailchimp' ),
					'id' => 'success_align_message',
					'std' => 'center',
					'type' => 'text_align',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.success',
					'affect_on_change_rule' => 'text-align',
					'section' => 'styling',
					'tab' => __('Success Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Color', 'lc-mailchimp' ),
					'id' => 'success_result_color',
					'std' => '#78ca4f',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.success',
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __('Success Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Family', 'lc-mailchimp' ),
					'id' => 'success_result_font_family',
					'std' => 'Open Sans',
					'type' => 'font',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.success',
					'affect_on_change_rule' => 'font-family',
					'section' => 'styling',
					'tab' => __('Success Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Size', 'lc-mailchimp' ),
					'id' => 'success_result_font_size',
					'std' => '16',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.success',
					'affect_on_change_rule' => 'font-size',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Success Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Weight', 'lc-mailchimp' ),
					'id' => 'success_result_font_weight',
					'std' => '600',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.success',
					'affect_on_change_rule' => 'font-weight',
					'section' => 'styling',
					'tab' => __('Success Mesage', 'lc-mailchimp'),
					'min' => 100,
					'max' => 900,
					'increment' => 100
				),

				/*
				*	Message
				*/

				array(
					'label' => __( 'Error Message', 'lc-mailchimp' ),
					'id' => 'error_text',
					'std' => "Error Message: CLICK TO EDIT",
					'type' => 'text',
					'visibility' => 'hidden',
					'section' => 'styling',
					'tab' => __('Error Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Align', 'lc-mailchimp' ),
					'id' => 'error_align_message',
					'std' => 'center',
					'type' => 'text_align',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.error',
					'affect_on_change_rule' => 'text-align',
					'section' => 'styling',
					'tab' => __('Error Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Color', 'lc-mailchimp' ),
					'id' => 'error_result_color',
					'std' => '#e55f5f',
					'type' => 'color',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.error',
					'affect_on_change_rule' => 'color',
					'section' => 'styling',
					'tab' => __('Error Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Family', 'lc-mailchimp' ),
					'id' => 'error_result_font_family',
					'std' => 'Open Sans',
					'type' => 'font',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.error',
					'affect_on_change_rule' => 'font-family',
					'section' => 'styling',
					'tab' => __('Error Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Size', 'lc-mailchimp' ),
					'id' => 'error_result_font_size',
					'std' => '16',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.error',
					'affect_on_change_rule' => 'font-size',
					'section' => 'styling',
					'ext' => 'px',
					'tab' => __('Error Mesage', 'lc-mailchimp')
				),
				array(
					'label' => __( 'Font Weight', 'lc-mailchimp' ),
					'id' => 'error_result_font_weight',
					'std' => '600',
					'type' => 'slider',
					'refresh_on_change' => false,
					'affect_on_change_el' => '.result p.error',
					'affect_on_change_rule' => 'font-weight',
					'section' => 'styling',
					'tab' => __('Error Mesage', 'lc-mailchimp'),
					'ext' => '',
					'min' => 100,
					'max' => 900,
					'increment' => 100
				),

			);

			$dslc_options = array_merge( $dslc_options, $this->presets_options() );

			return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

		}

		/**
		 * Module Output
		 *
		 * @since 1.0
		 * @param array $options Saved Module Options.
		 */
		function output( $options ) {

			global $dslc_active;

			if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
				$dslc_is_admin = true;
			else
				$dslc_is_admin = false;

			$this->module_start( $options );
			$input_class = "";
			$button_class = "";
			switch ($options['columns']) {
				case '1':
					$input_class = "col d12 t12 m12";
					$button_class = "col d12 t12 m12";
					break;
				case '2':
					$input_class = "col d6 t6 m12";
					$button_class = "col d12 t12 m12";
					break;
				case '3':
					$input_class = "col d5 t6 m12";
					$button_class = "col d2 t12 m12";
					break;

				default:
					# code...
					break;
			}
			?>	
			<form class="lc-mailchimp-form">
			<div class="row">
				<input type="text" name="fullname" value="" placeholder="<?php echo $options['css_input_name_label']; ?>" class="<?php echo $input_class; ?> mailchimp-input" />
				<input type="email" name="email" value="" placeholder="<?php echo $options['css_input_email_label']; ?>" class="<?php echo $input_class; ?> mailchimp-input" />
				<input type="submit" value="<?php echo $options['button_label']; ?>" name="submit" class="<?php echo $button_class; ?> mailchimp-button"/>
				<?php if($dslc_is_admin): ?>
					<div class="result">
						<p class="success dslca-editable-content" contenteditable data-id="success_text" data-type="simple" style="border-bottom:1px solid <?php echo $options['success_result_color']; ?>"><?php echo $options['success_text']; ?></p>
						<p class="error dslca-editable-content" contenteditable data-id="error_text" data-type="simple" style="border-bottom:1px solid <?php echo $options['error_result_color']; ?>"><?php echo $options['error_text']; ?></p>
					</div>
				<?php else: ?>
					<div class="result"></div>
				<?php endif; ?>
				<input type="hidden" value="<?php echo wp_create_nonce('lc-mailchimp-js'); ?>" name="a" />
				<input type="hidden" value="<?php echo $options['list_id']; ?>" name="b" />
				<input type="hidden" value="<?php echo $options['success_text']; ?>" name="c" />
				<input type="hidden" value="<?php echo $options['error_text']; ?>" name="d" />
			</div>
			</form>
			<?php
			// REQUIRED
			$this->module_end( $options );
		}
	}

} 
add_action( 'plugins_loaded', 'lc_mailchimp_moduled_class' );