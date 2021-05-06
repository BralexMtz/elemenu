<?php
/**
 * Elementor Elemenu Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Navbar_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Elemenu widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'menu';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Elemenu widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'navbar', 'elemenu' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Elemenu widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-bars';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Elemenu widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	} 

	/**
	 * Register Elemenu widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_menu_items',
			[
				'label' => __( 'List of items', 'elemenu' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Logo', 'elemenu' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => __( 'text', 'elemenu' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __('home','elemenu'),
				'default' => __('home','elemenu'),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'elemenu' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'elemenu' ),
			]
		);

		

		$this->add_control(
			'menu_items',
			[
				'label' => __( 'Menu items', 'elemenu' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => __( 'home', 'elemenu' ),
					],
					[
						'text' => __( 'about us', 'elemenu' ),
					],
					[
						'text' => __( 'contact', 'elemenu' ),
					],
				],
				'title_field' => '{{{ text }}}',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'is_fixed',
			[
				'label' => __('navbar fixed?','elemenu'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Fixed','elemenu'),
				'label_off' => __('Normal','elemenu'),
				'frontend_available' => true,
			]
		);
		

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elemenu' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label' => __( 'Items style', 'elemenu' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'elemenu' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #elemenu li a' => 'color: {{VALUE}};',
				],
				
			]
		);

		$this->add_control(
			'text_color_hover',
			[
				'label' => __( 'Hover', 'elemenu' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #elemenu li:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'items_typography',
				'selector' => '{{WRAPPER}} #elemenu li a',
				
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} #elemenu li a',
			]
		);

		$this->end_controls_section();

	

	}

	/**
	 * Render Elemenu widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		?>
		<?php 
			echo ($settings['is_fixed'])?'<div class="fixed">':'';
		?>
			<nav id="elemenu" class="navbar">
		 		<span class="navbar-toggle" id="js-navbar-toggle">
		 			<i class="fas fa-bars"></i>
		 		</span>
		 		<a href="#" class="logo">
		 			<img src="<?php echo $settings['image']['url']; ?>" alt="" width="50">
		 		</a>
				 
		 		<ul class="main-nav" id="js-menu">
					<?php
		 				foreach ( $settings['menu_items'] as $index => $item ) {
		 					echo '<li>';
		 						echo '<a href="'.$item['link']['url'].'" class="nav-links">';
		 							echo $item['text'];
		 						echo '</a>';
		 					echo '</li>';
		 				}
		 			?>
		 		</ul>
		 	</nav>
		

		<?php 
			echo ($settings['is_fixed'])?'</div>':'';
		?>		 	
		 <?php
	}

}