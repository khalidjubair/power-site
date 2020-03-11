<?php
namespace PowerSiteBuilder\Controls;
use PowerSiteBuilder\Helpers\Partials as Partials;


use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Base;
	/**
	 * Created by PhpStorm.
	 * User: j3sha
	 * Date: 6/13/2019
	 * Time: 11:08 AM
	 */
	
	class Post extends Group_Control_Base{
		protected static $fields;
		/**
		 * Init fields.
		 * 
		 * Initialize group control fields.
		 *
		 * @since 1.2.2
		 * @access protected
		 */
		protected function init_fields() {
			// TODO: Implement init_fields() method.
			$fields = [];
			
			$fields['post_type'] = [
				'label' => __('Source', 'power-site-builder'),
				'type' => Controls_Manager::SELECT,
			];
			
			$fields['posts_ids'] = [
				'label' => __('Search & Select', 'power-site-builder'),
				'type' => Controls_Manager::SELECT2,
				'post_type' => '',
				'options' => Partials::get_all_types_post(),
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'post_type' => 'by_id',
				],
			];
			
			$fields['authors'] = [
				'label' => __('Author', 'power-site-builder'),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'default' => [],
				'options' => $this->get_authors(),
				'condition' => [
					'post_type!' => [
						'by_id',
					],
				],
			];
			
			return $fields;
		}
		
		/**
		 * Get group control type.
		 *
		 * Retrieve the group control type.
		 *
		 * @since 1.0.0
		 * @access public
		 * @static
		 */
		public static function get_type() {
			// TODO: Implement get_type() method.
			return 'powerpost';
		}
		
		protected function prepare_fields($fields){
			
			$post_types = Partials::get_post_types();
			
			$post_types_options = $post_types;
			
			$post_types_options['by_id'] = __('Manual Selection', 'power-site-builder');
			
			$fields['post_type']['options'] = $post_types_options;
			
			$fields['post_type']['default'] = key($post_types);
			
			$fields['posts_ids']['object_type'] = array_keys($post_types);
			
			$taxonomy_filter_args = [
				'show_in_nav_menus' => true,
			];
			
			if (!empty($args['post_type'])) {
				$taxonomy_filter_args['object_type'] = [$args['post_type']];
			}
			
			$taxonomies = get_taxonomies($taxonomy_filter_args, 'objects');
			
			foreach ($taxonomies as $taxonomy => $object) {
				$taxonomy_args = [
					'label' => $object->label,
					'type' => Controls_Manager::SELECT2,
					'label_block' => true,
					'multiple' => true,
					'object_type' => $taxonomy,
					'options' => [],
					'condition' => [
						'post_type' => $object->object_type,
					],
				];
				
				$options = [];
				
				$taxonomy_args['type'] = Controls_Manager::SELECT2;
				
				$terms = get_terms($taxonomy);
				
				foreach ($terms as $term) {
					$options[$term->term_id] = $term->name;
				}
				
				$taxonomy_args['options'] = $options;
				
				$fields[$taxonomy . '_ids'] = $taxonomy_args;
			}
			
			unset($fields['post_format_ids']);
			
			return parent::prepare_fields($fields);
		}
		
		/**
		 * All authors name and ID, who published at least 1 post.
		 * @return array
		 */
		public function get_authors(){
			$user_query = new \WP_User_Query(
				[
					'who' => 'authors',
					'has_published_posts' => true,
					'fields' => [
						'ID',
						'display_name',
					],
				]
			);
			
			$authors = [];
			
			foreach ($user_query->get_results() as $result) {
				$authors[$result->ID] = $result->display_name;
			}
			
			return $authors;
		}
		
		protected function get_default_options() {
			return [
				'popover' => false,
			];
		}
	}