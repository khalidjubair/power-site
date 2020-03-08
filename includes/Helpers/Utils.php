<?php

namespace PowerSiteBuilder\Helpers;

class Utils {

    function __construct(){}

    public static function get_builder_content($content_id){
        $elementor_instance = \Elementor\Plugin::instance();
        return $elementor_instance->frontend->get_builder_content_for_display( $content_id );
    }

    public static function mk_class($dirname){
        $dirname = pathinfo($dirname, PATHINFO_FILENAME);
        $class_name	 = explode( '-', $dirname );
        $class_name	 = array_map( 'ucfirst', $class_name );
        $class_name	 = implode( '_', $class_name );

        return $class_name;
    }

    public static function get_option($key='power_site_builder_options', $c='widget_list', $default = ''){
        $data_all = get_option($key);

        return (isset($data_all[$c]) && $data_all[$c] != '') ? $data_all[$c] : $default;
    }
    public static function update_option($key='power_site_builder_options', $c='widget_list', $value = '', $senitize_func = 'sanitize_text_field'){
        $data_all = get_option($key);
        $value = self::sanitize($value, $senitize_func);
        $data_all[$c] = $value;
        update_option($key, $data_all);
    }
    
    public static function sanitize($value, $senitize_func = 'sanitize_text_field'){
        $senitize_func = (in_array($senitize_func, [
                'sanitize_email', 
                'sanitize_file_name', 
                'sanitize_hex_color', 
                'sanitize_hex_color_no_hash', 
                'sanitize_html_class', 
                'sanitize_key', 
                'sanitize_meta', 
                'sanitize_mime_type',
                'sanitize_sql_orderby',
                'sanitize_option',
                'sanitize_text_field',
                'sanitize_title',
                'sanitize_title_for_query',
                'sanitize_title_with_dashes',
                'sanitize_user',
                'esc_url_raw',
                'wp_filter_nohtml_kses',
            ])) ? $senitize_func : 'sanitize_text_field';
        
        if(!is_array($value)){
            return $senitize_func($value);
        }else{
            return array_map(function($inner_value) use ($senitize_func){
                return self::sanitize($inner_value, $senitize_func);
            }, $value);
        }
    }



    public static function kses($raw){
			
        $allowed_tags = [
            'a'								 => [
                'class'	 => [],
                'href'	 => [],
                'rel'	 => [],
                'title'	 => [],
            ],
            'abbr'							 => [
                'title' => [],
            ],
            'b'								 => [],
            'blockquote'					 => [
                'cite' => [],
            ],
            'cite'							 => [
                'title' => [],
            ],
            'code'							 => [],
            'del'							 => [
                'datetime'	 => [],
                'title'		 => [],
            ],
            'dd'							 => [],
            'div'							 => [
                'class'	 => [],
                'title'	 => [],
                'style'	 => [],
            ],
            'dl'							 => [],
            'dt'							 => [],
            'em'							 => [],
            'h1'							 => [
                'class' => [],
            ],
            'h2'							 => [
                'class' => [],
            ],
            'h3'							 => [
                'class' => [],
            ],
            'h4'							 => [
                'class' => [],
            ],
            'h5'							 => [
                'class' => [],
            ],
            'h6'							 => [
                'class' => [],
            ],
            'i'								 => [
                'class' => [],
            ],
            'img'							 => [
                'alt'	 => [],
                'class'	 => [],
                'height' => [],
                'src'	 => [],
                'width'	 => [],
            ],
            'li'							 => [
                'class' => [],
            ],
            'ol'							 => [
                'class' => [],
            ],
            'p'								 => [
                'class' => [],
            ],
            'q'								 => [
                'cite'	 => [],
                'title'	 => [],
            ],
            'span'							 => [
                'class'	 => [],
                'title'	 => [],
                'style'	 => [],
            ],
            'iframe'						 => [
                'width'			 => [],
                'height'		 => [],
                'scrolling'		 => [],
                'frameborder'	 => [],
                'allow'			 => [],
                'src'			 => [],
            ],
            'strike'						 => [],
            'br'							 => [],
            'strong'						 => [],
            'data-wow-duration'				 => [],
            'data-wow-delay'				 => [],
            'data-wallpaper-options'		 => [],
            'data-stellar-background-ratio'	 => [],
            'ul'							 => [
                'class' => [],
            ],
        ];
        return ( function_exists( 'wp_kses' ) ) ? wp_kses( $raw, $allowed_tags ) : $raw;
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
        echo \Power_Elements_Pro\Libs\Helpers::kses( $tag );
        comment_class( empty( $args[ 'has_children' ] ) ? '' : 'parent'  );
        ?> id="comment-<?php comment_ID() ?>"><?php if ( 'div' != $args[ 'style' ] ) { ?>
            <div id="div-comment-<?php comment_ID() ?>" class="commenter-div"><?php }
                ?><div class="commenter">
                <?php if ( $args[ 'avatar_size' ] != 0 ) {
                    echo get_avatar( $comment, $args[ 'avatar_size' ], '', '' );
                }?></div>
                <div class="comment-block">
                    <h4 class="commentername"><?php
                        printf( \Power_Elements_Pro\Libs\Helpers::kses( '%s', 'power-elements' ), get_comment_author_link() );
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