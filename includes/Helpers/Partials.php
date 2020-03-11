<?php

namespace PowerSiteBuilder\Helpers; 
use PowerSiteBuilder\Helpers\Utils as Utils;

class Partials{

    function __construct(){}

    private static $post_args = [
        // content ticker
        'power_ticker_type',
        'power_ticker_custom_contents',
        
        // post grid
        'power_post_grid_columns',
        
        // common 
        'meta_position',
        'power_show_meta',
        'image_size',
        'power_show_image',
        'power_show_title',
        'power_show_excerpt',
        'power_excerpt_length',
        'power_show_read_more',
        'power_read_more_text',
        'show_load_more',
        'show_load_more_text',
        
        // query_args
        'post_type',
        'post__in',
        'posts_per_page',
        'post_style',
        'tax_query',
        'post__not_in',
        'power_post_authors',
        'eaeposts_authors',
        'offset',
        'orderby',
        'order',
    ];
    
    /**
     * Get all types of post.
     * @return array
     */
    public static function get_all_types_post(){
        $posts_args = [
            'post_type' => 'any',
            'post_style' => 'all_types',
            'post_status' => 'publish',
            'posts_per_page' => '-1',
        ];
        $posts = self::load_more_ajax($posts_args);
        
        $post_list = [];
        
        foreach ($posts as $post) {
            $post_list[$post->ID] = $post->post_title;
        }
        
        return $post_list;
    }
    
    
		/**
		 * Get All POst Types
		 * @return array
		 */
		public static function get_post_types(){
			$power_cpts = get_post_types(['public' => true, 'show_in_nav_menus' => true], 'object');
			$power_exclude_cpts = ['elementor_library', 'attachment'];
			
			foreach ($power_exclude_cpts as $exclude_cpt) {
				unset($power_cpts[$exclude_cpt]);
			}
			$post_types = array_merge($power_cpts);
			foreach ($post_types as $type) {
				$types[$type->name] = $type->label;
			}
			
			return $types;
		}
		
		/**
		 * Post Settings Parameter
		 * @param  array $settings
		 * @return array
		 */
		public static function get_post_settings($settings){
			foreach ($settings as $key => $value) {
				if (in_array($key, self::$post_args)) {
					$post_args[$key] = $value;
				}
			}
			$post_args['post_status'] = 'publish';
			
			return $post_args;
		}
		
		public static function get_query_args($control_id, $settings, $widget_id){
			$defaults = [
				$control_id . '_post_type' => 'post',
				$control_id . '_posts_ids' => [],
				'orderby' => 'date',
				'order' => 'desc',
				'posts_per_page' => 3,
				'offset' => 0,
			];
			
			$settings = wp_parse_args($settings, $defaults);
			
			$post_type = $settings[$control_id . '_post_type'];
			
			$query_args = [
				'orderby' => $settings['psb_'.$widget_id.'_orderby'],
				'order' => $settings['psb_'.$widget_id.'_order'],
				'ignore_sticky_posts' => 1,
				'post_status' => 'publish', // Hide drafts/private posts for admins
			];
			
			if ('by_id' === $post_type) {
				$query_args['post_type'] = 'any';
				$query_args['post__in'] = $settings[$control_id . '_posts_ids'];
				
				if (empty($query_args['post__in'])) {
					// If no selection - return an empty query
					$query_args['post__in'] = [0];
				}
			} else {
				$query_args['post_type'] = $post_type;
				$query_args['posts_per_page'] = $settings['psb_'.$widget_id.'_posts_per_page'];
				$query_args['tax_query'] = [];
				
				$query_args['offset'] = $settings['psb_'.$widget_id.'_offset'];
				
				$taxonomies = get_object_taxonomies($post_type, 'objects');
				foreach ($taxonomies as $object) {
					$setting_key = $control_id . '_' . $object->name . '_ids';
					
					if (!empty($settings[$setting_key])) {
						$query_args['tax_query'][] = [
							'taxonomy' => $object->name,
							'field' => 'term_id',
							'terms' => $settings[$setting_key],
						];
					}
				}
			}
			
			if (!empty($settings[$control_id . '_authors'])) {
				$query_args['author__in'] = $settings[$control_id . '_authors'];
			}
			
			$post__not_in = [];
			if (!empty($settings['psb_'.$widget_id.'_post__not_in'])) {
				$post__not_in = array_merge($post__not_in, $settings['post__not_in']);
				$query_args['post__not_in'] = $post__not_in;
			}
			
			if (isset($query_args['tax_query']) && count($query_args['tax_query']) > 1) {
				$query_args['tax_query']['relation'] = 'OR';
			}
			
			return $query_args;
		}
		
		/**
		 * Template for categories lists.
		 *
		 * @param $post_id
		 * @param $no_icon for fontawesome control
		 * @param $taxonomy for custom taxonomy
		 */
		public static function get_categories_lists($post_id, $taxonomy = null){
			if ($taxonomy == null) {
				$getCats = get_the_category($post_id);
			} else {
				$getCats = get_the_terms($post_id, $taxonomy);
			}
			$html ='';
			if (is_array($getCats)) {
				foreach ($getCats as $key => $cat) {
					if (count($getCats)==1 || $key==count($getCats)-1){
						$coma ='';
					}else{
						$coma ='';
					}

					if ($taxonomy==null) { 
						$html .= '<a href="' . get_category_link($cat->term_id) . '">' . " " . $cat->name . ' </a>'.$coma;
					}else{
						$html .= '<a href="' . get_term_link($cat->term_id,$taxonomy) . '">' . " " . $cat->name . ' </a>'.$coma;
					}
				}
			}
			return $html;
		}
		
		public static function load_filter($args, $widget_id){
			
			$args = func_get_args();
			$post_args = $args[0];
			if(is_array($post_args['tax_query']) && !empty($post_args['tax_query']))
				$term_ids = $post_args['tax_query'][0]['terms'];
			else
				$term_ids = null;
			
			$posts = new \WP_Query($post_args);
			
			/**
			 * For returning all types of post as an array
			 * @return array;
			 */
			if (isset($post_args['psb_'.$widget_id.'_post_style']) && $post_args['psb_'.$widget_id.'_post_style'] == 'all_types') {
				return $posts->posts;
			} 
			
			$return = [];
			$return['count'] = $posts->found_posts; 

			
			ob_start();
			
			if ($post_args['psb_'.$widget_id.'_show_filter']=='yes') {
				require( POWER_SITE_BUILDER_DIR_PATH . '/widgets/parts/'.$widget_id.'/wrapper.php' );
				require( POWER_SITE_BUILDER_DIR_PATH . '/widgets/parts/'.$widget_id.'/filter.php' );
				require( POWER_SITE_BUILDER_DIR_PATH . '/widgets/parts/'.$widget_id.'/wrapper-end.php' );
			}
			
			require( POWER_SITE_BUILDER_DIR_PATH . '/widgets/parts/'.$widget_id.'/content-wrapper.php' );
			while ($posts->have_posts()): $posts->the_post();
			
				if ($posts->current_post % 2 == 0):
					$arr = ['left info' , 'right'];
				else:
					$arr = ['right info' , 'left'];
				endif;
				require( POWER_SITE_BUILDER_DIR_PATH . '/widgets/parts/'.$widget_id.'/content.php' );
			endwhile;
			require( POWER_SITE_BUILDER_DIR_PATH . '/widgets/parts/'.$widget_id.'/content-wrapper-end.php' );
			
			$return['content'] = ob_get_clean();
			
			wp_reset_postdata();
			wp_reset_query();
			
			return $return;
        }
        public static function get_all_nested_templates(){
			
			$args = [ 
				'post_type' => 'psb_nested',
				'post_status' => 'publish',
			];
			$query = new \WP_Query( $args );
			
			$templates = [];
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : $query->the_post();
					$templates[get_the_ID()] = get_the_title();
				endwhile;
			endif;
			wp_reset_postdata();

			return $templates;
		}
		public static function get_all_forms(){
			
			$args = [ 
				'post_type' => 'psb_form',
				'post_status' => 'publish',
			];
			$query = new \WP_Query( $args );
			
			$templates = [];
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : $query->the_post();
					$templates[get_the_ID()] = get_the_title();
				endwhile;
			endif;
			wp_reset_postdata();

			return $templates;
		}



		
		public static function comments(){

			if ( post_password_required() ) {
				return;
			}
			
			$comment_number = absint(get_comments_number());
			?>
				<?php if (have_comments()) : ?>
				<div class="power-comment-sec">
					<h2 class="power-comment_title">
						<span><?php
						if(1 === $comment_number){
							printf( '%1$s ' . esc_html__( 'Comment ', 'power-elements' ), $comment_number );
						}else{
							printf( '%1$s ' . esc_html__( 'Comments ', 'power-elements' ), $comment_number );
						}
						?></span>
					</h2>
					<ul class="power-comment-area">
						<?php 
							/*
							* Loop through and list the comments.
							*/
							wp_list_comments( [
								'reply_text'        => '<i class="fa fa-mail-reply-all"></i>'.esc_html__(' Reply', 'power-elements').'',
								'callback'          => [ __CLASS__, 'comment_style' ],
								'style'			 => 'ul',
								'short_ping'	 => false,
								'type'              => 'all',
								'format'            => current_theme_supports( 'html5', 'comment-list' ) ? 'html5' : 'xhtml',
								'avatar_size'	 => 60,
								] );
						?>
						<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
							<div id="comment-nav-below" class="comments-pagination comment" role="navigation">
								<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'power-elements' ); ?></h1>
								<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'power-elements' ) ); ?></div>
								<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'power-elements' ) ); ?></div>
							</div><!-- #comment-nav-below -->
						<?php endif; // Check for comment navigation.  ?>
					</ul>
				</div>
			
				<?php elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
					<p class="nocomments"><?php esc_html_e('Comments are closed.', 'power-elements'); ?></p>
				<?php endif; ?>
				<div class="clearfix"></div>
			
			<div class="comment_form">
				<?php
			
					$post_id = '';
					if ( null === $post_id )
						$post_id = get_the_ID();
					else
						$id		 = $post_id;
			
					$fields = array(
						'author' => '
						<div class="form-container">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="form-group">
										<input type="text" id="name" class="form-control" placeholder="'.  esc_attr__('Your Name*', 'power-elements').'" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '">
									</div>
								</div>',
								'email'	 => '
								<div class="col-lg-6 col-md-12">
									<div class="form-group">
										<input type="email" id="email" class="form-control" placeholder="'.  esc_attr__('E-mail*', 'power-elements').'" value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '">
									</div>
								</div>',
								'subject'	 => '
								<div class="col-lg-6 col-md-12">
									<div class="form-group">
										<input type="text" id="subject" class="form-control" placeholder="'.  esc_attr__('Subject*', 'power-elements').'" value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '">
									</div>
								</div>
							</div>
						</div>',
					);
			
					$defaults = [
						'fields'			 => $fields,
						'comment_field'		 => '
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="form-group">
										<textarea type="text" name="comment" 
										id="message" class="form-control 
										md-textarea" rows="3" 
										placeholder="'.  esc_attr__('Type your comment here*', 'power-elements').'"></textarea>
									</div>
								</div>
							</div>',
						'must_log_in'		 => '
							<p class="must-log-in">
								'.esc_html__('You must be','power-elements').' <a href="'.esc_url(wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )).'">'.esc_html__('logged in','power-elements').'</a> '.esc_html__('to post a comment.','power-elements').'
							</p>',
						'logged_in_as'		 => '
							<p class="logged-in-as">
								'.esc_html__('Logged in as','power-elements').' <a href="'.esc_url(get_edit_user_link()).'">'.esc_html($user_identity).'</a>. <a href="'.esc_url(wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )).'" title="'.esc_attr__('Log out of this account','power-elements').'">'.esc_html__('Log out?','power-elements').'</a>
							</p>',
						'id_form'			 => 'commentform',
						'class_form'			 => 'comment-form',
						'id_submit'			 => 'submit',
						'class_submit' => 'power_button gradient_button',
						'title_reply'		 => esc_html__( 'Comment Here', 'power-elements' ),
						'title_reply_to'	 => esc_html__( 'Comment to %s', 'power-elements' ),
						'cancel_reply_link'	 => esc_html__( 'Cancel reply', 'power-elements' ),
						'label_submit'		 => esc_html__( 'Submit Comment', 'power-elements' ),
						'format'			 => 'xhtml',
					];
			
					comment_form( $defaults );
				?>
			</div><?php
		}
		public static function comment_style( $comment, $args, $depth ) {
			if ( 'div' === $args[ 'style' ] ) {
				$tag		 = 'div';
				$add_below	 = 'comment';
			} else {
				$tag		 = 'li ';
				$add_below	 = 'div-comment';
			}
			?>
		
			<<?php
			echo Utils::kses( $tag );
			comment_class( empty( $args[ 'has_children' ] ) ? '' : 'parent'  );
			?> id="comment-<?php comment_ID() ?>"><?php if ( 'div' != $args[ 'style' ] ) { ?>
				<div id="div-comment-<?php comment_ID() ?>" class="commenter-div"><?php }
					?><div class="commenter">
					<?php if ( $args[ 'avatar_size' ] != 0 ) {
						echo get_avatar( $comment, $args[ 'avatar_size' ], '', '' );
					}?></div>
					<div class="comment-block">
						<h4 class="commentername"><?php
							printf( Utils::kses( '%s', 'power-elements' ), get_comment_author_link() );
							?> <span class="reply"><?php
							comment_reply_link(
							array_merge(
							$args, array(
								'add_below'	 => $add_below,
								'depth'		 => $depth,
								'max_depth'	 => $args[ 'max_depth' ]
							) ) );
							?></span></h4>
						<h6><?php
							printf(
							esc_html__( '%1$s', 'power-elements' ), get_comment_date() );
							?></h6>
						<p><?php comment_text(); ?></p>
					</div>
					<?php if ( 'div' != $args[ 'style' ] ) : ?>
				</div>
				<?php
			endif;
		}
}