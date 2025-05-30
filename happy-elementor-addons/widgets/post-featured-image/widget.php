<?php

/**
 * Post Feature_Image widget class
 *
 * @package Happy_Addons
 */

namespace Happy_Addons\Elementor\Widget;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

defined('ABSPATH') || die();

class Post_Featured_Image extends Base {

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __('Post Featured Image', 'happy-elementor-addons');
	}

	public function get_custom_help_url() {
		return 'https://happyaddons.com/docs/happy-addons-for-elementor/widgets/post-title/';
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'hm hm-tb-featured-image';
	}

	public function get_keywords() {
		return ['post image', 'image'];
	}

	public function get_categories() {
        return [ 'happy_addons_category', 'happy_addons_theme_builder' ];
    }

	/**
	 * Register widget content controls
	 */
	protected function register_content_controls() {

		$this->start_controls_section(
			'_section_post_thumbnail',
			[
				'label' => __('Post Featured Image', 'happy-elementor-addons'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_feature_image',
				'default' => 'full',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'happy-elementor-addons'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'happy-elementor-addons'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'happy-elementor-addons'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'happy-elementor-addons'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justify', 'happy-elementor-addons'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',
					'{{WRAPPER}}:not(:has(.elementor-widget-container))' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'image_caption',
			[
				'label' => __('Show Caption', 'happy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'happy-elementor-addons'),
				'label_off' => __('no', 'happy-elementor-addons'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'enable_link',
			[
				'label' => esc_html__('Enable Link', 'happy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'happy-elementor-addons'),
				'label_off' => esc_html__('No', 'happy-elementor-addons'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'link_type',
			[
				'label' => esc_html__('Link Type', 'happy-elementor-addons'),
				'type' => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic' => esc_html__('Dynamic', 'happy-elementor-addons'),
					'custom' => esc_html__('Custom', 'happy-elementor-addons')
				],
				'condition' => [
					'enable_link!' => ''
				]
			]
		);

		$this->add_control(
			'dynamic_link_options',
			[
				'label' => esc_html__( 'Link Options', 'happy-elementor-addons' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => esc_html__( 'Default', 'happy-elementor-addons' ),
				'label_on' => esc_html__( 'Custom', 'happy-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_link!' => '',
					'link_type' => 'dynamic'
				]
			]
		);

		$this->start_popover();

		$this->add_control(
			'dynamic_link_external',
			[
				'label' => esc_html__('Open in new window', 'happy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'happy-elementor-addons'),
				'label_off' => esc_html__('No', 'happy-elementor-addons'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'dynamic_link_nofollow',
			[
				'label' => esc_html__('Add nofollow', 'happy-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'happy-elementor-addons'),
				'label_off' => esc_html__('No', 'happy-elementor-addons'),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->end_popover();

		$this->add_control(
			'custom_link',
			[
				'label' => esc_html__('Custom Link', 'happy-elementor-addons'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'happy-elementor-addons'),
				'options' => ['url', 'is_external', 'nofollow'],
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'enable_link!' => '',
					'link_type' => 'custom'
				]
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles related controls
	 */
	protected function register_style_controls() {
		$this->__thumbnail_style_controls();
		$this->__caption_style_controls();
	}


	protected function __thumbnail_style_controls() {

		$this->start_controls_section(
			'_section_thumbnail_style',
			[
				'label' => __('Image Style', 'happy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'thumbnail_width',
			[
				'label' => esc_html__('Size', 'happy-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'vw'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thumbnail_margin',
			[
				'label' => __('Margin', 'happy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}:not(:has(.elementor-widget-container))' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thumbnail_padding',
			[
				'label' => __('Padding', 'happy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}:not(:has(.elementor-widget-container))' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumbnail_border',
				'label' => __('Border', 'happy-elementor-addons'),
				'selector' => '{{WRAPPER}} .wrapper',
			]
		);

		$this->add_control(
			'thumbnail_radius',
			[
				'label' => __('Border Radius', 'happy-elementor-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}:not(:has(.elementor-widget-container))' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-widget-container img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}:not(:has(.elementor-widget-container)) img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function __caption_style_controls() {

		$this->start_controls_section(
			'_section_caption_style',
			[
				'label' => __('Caption Style', 'happy-elementor-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image_caption' => 'yes'
				]
			]
		);

		$this->add_control(
			'caption_margin',
			[
				'label' => esc_html__('Spacing (px)', 'happy-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ha-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => esc_html__('Color', 'happy-elementor-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ha-image-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'label' => __('Typography', 'happy-elementor-addons'),
				'selector' => '{{WRAPPER}} .ha-image-caption',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings_for_display();

		if (ha_elementor()->editor->is_edit_mode()) {
			if (!empty($settings['enable_link'])) {
				$link_type = isset($settings['link_type']) ? $settings['link_type'] : 'dynamic';
				if ($link_type == 'dynamic') {
					$this->add_link_attributes('single_link', [
						'url' => get_the_permalink(),
						'is_external' => ((!empty($settings['dynamic_link_options']))? ($settings['dynamic_link_external'] == 'yes'): false),
						'nofollow' => ((!empty($settings['dynamic_link_options']))? ($settings['dynamic_link_nofollow'] == 'yes'): false),
					]);
				} else if (! empty( $settings['custom_link']['url'] )){
					$this->add_link_attributes('single_link', $settings['custom_link']);
				}
				echo '<a '.$this->get_render_attribute_string( 'single_link' ).'>';
			}
			echo '<img src="' . Utils::get_placeholder_image_src() . '" alt="place holder image">';
			if (!empty($settings['enable_link'])) {
				echo '</a>';
			}
		} else {
			if (has_post_thumbnail()) {

				if (!empty($settings['enable_link'])) {
					$link_type = isset($settings['link_type']) ? $settings['link_type'] : 'dynamic';
					if ($link_type == 'dynamic') {
						$this->add_link_attributes('single_link', [
							'url' => get_the_permalink(),
							'is_external' => ((!empty($settings['dynamic_link_options']))? ($settings['dynamic_link_external'] == 'yes'): false),
							'nofollow' => ((!empty($settings['dynamic_link_options']))? ($settings['dynamic_link_nofollow'] == 'yes'): false),
						]);
					} else if (! empty( $settings['custom_link']['url'] )){
						$this->add_link_attributes('single_link', $settings['custom_link']);
					}
					echo '<a '.$this->get_render_attribute_string( 'single_link' ).'>';
				}

				if ($settings['post_feature_image_size'] == 'custom') {
					the_post_thumbnail(array($settings['post_feature_image_custom_dimension']['width'], $settings['post_feature_image_custom_dimension']['height']));
				} else {
					the_post_thumbnail($settings['post_feature_image_size']);
				}

				if ('yes' == $settings['image_caption']) { ?>
					<figcaption class="ha-image-caption"><?php echo wp_kses_post(get_the_post_thumbnail_caption()); ?></figcaption>
				<?php }

				if (!empty($settings['enable_link'])) {
					echo '</a>';
				}
			}
		}
	}
}
