<?php

Class Elementor_custom_tax extends \Elementor\Core\DynamicTags\Tag {

	/**
	* Get Name
	*
	* Returns the Name of the tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return string
	*/
	public function get_name() {
		return 'post-custom-tax';
	}

	/**
	* Get Title
	*
	* Returns the title of the Tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return string
	*/
	public function get_title() {
		return __( 'Post custom taxonomy', 'elementor-pro' );
	}
   
	/**
	* Get Group
	*
	* Returns the Group of the tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return string
	*/
	public function get_group() {
		return 'custom';
	}

	/**
	* Get Categories
	*
	* Returns an array of tag categories
	*
	* @since 2.0.0
	* @access public
	*
	* @return array
	*/
	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::POST_META_CATEGORY ];
	}

	/**
	* Register Controls
	*
	* Registers the Dynamic tag controls
	*
	* @since 2.0.0
	* @access protected
	*
	* @return void
	*/
	protected function _register_controls() {

        $all_tax=get_taxonomies();
        
        if($all_tax!==false){
			$this->add_control(
				'custom_tax',
				[
					'label' => __( 'Taxonomy Name', 'elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $all_tax,
				]
			);
		}
	}

	/**
	* Render
	*
	* Prints out the value of the Dynamic tag
	*
	* @since 2.0.0
	* @access public
	*
	* @return void
	*/
	public function render() {
		$tax_name = $this->get_settings( 'custom_tax' );

        if ( ! $tax_name ) {
			return;
		}
        $terms = get_the_terms(get_the_ID(),$tax_name);

		if($terms!==false && is_array($terms)){
			echo wp_kses_post( count($terms) );
		}else{echo wp_kses_post("");}
	}
}

?>