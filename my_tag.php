<?php

Class Elementor_post_meta extends \Elementor\Core\DynamicTags\Tag {

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
		return 'post-meta-field';
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
		return __( 'Post Meta field', 'elementor-pro' );
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


	private function getMetafields() {
		global $my_filtered_meta_fields;
		global $wpdb;

		if(!isset($my_filtered_meta_fields)){
			$myvals = $wpdb->get_col("SELECT DISTINCT meta_key FROM {$wpdb->postmeta}");
			asort($myvals);
			$my_filtered_meta_fields=$myvals;
		}
		return $my_filtered_meta_fields;
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
		$myvals = $this->getMetafields();
        if($myvals!==false){
			$myvals=
			array_filter($myvals, function($k) {
				return substr( $k, 0, 1 ) !== "_" ;
			});
        
			$this->add_control(
				'meta_field_name',
				[
					'label' => __( 'Feld Name', 'elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $myvals,
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
		$field_Number = $this->get_settings( 'meta_field_name' );
		$myvals =  $this->getMetafields();
		$field_Name=$myvals[$field_Number];


        if ( ! $field_Name ) {
			return;
		}
        $metasPostField = get_post_meta(get_the_ID(),$field_Name,true);

		if(is_numeric($metasPostField)){
			$metasPostField=intval($metasPostField);
		}
		echo wp_kses_post( $metasPostField );
	}
}

?>