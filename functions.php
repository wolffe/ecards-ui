<?php
add_action('after_setup_theme', 'ecards_setup');

function ecards_ui_custom_logo() {
    if(function_exists('the_custom_logo')) {
        the_custom_logo();
    }
}

function ecards_setup() {
	global $content_width;

    if(!isset($content_width))
        $content_width = 620;

    add_theme_support('custom-logo', array(
        'width'       => 270,
        //'height'      => 48,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));

	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');

	add_image_size('post-image', 1080, 320, true);
	add_image_size('post-thumb', 480, 320, true);
	add_image_size('homepage-thumbnail', 600, 250, true);

	add_theme_support('post-formats', array('gallery', 'image', 'video'));

	add_theme_support('infinite-scroll', array(
        'type' 		=> 'click',
        'container'	=> 'posts',
        'footer' 	=> false,
    ));

    register_nav_menu('primary', __('Primary Menu', 'ecards'));

    load_theme_textdomain('ecards', get_template_directory() . '/languages');
}

function ecards_load_javascript_files() {
    if(!is_admin()) {
        wp_enqueue_script('masonry');
        wp_enqueue_script('ecards_flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array('jquery'), '', true);
        wp_enqueue_script('ecards_global', get_template_directory_uri() . '/js/global.js', array('jquery'), '', true);
    }
}

add_action('wp_enqueue_scripts', 'ecards_load_javascript_files');

function ecards_load_style() {
    if(!is_admin()) {
        wp_enqueue_style('fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
	    wp_enqueue_style('ecards_googleFonts', 'https://fonts.googleapis.com/css?family=Merriweather:300,400,700|Montserrat:400,700');
	    wp_enqueue_style('ecards_style', get_stylesheet_uri());
	}
}

add_action('wp_print_styles', 'ecards_load_style');
add_action('widgets_init', 'ecards_sidebar_reg');

function ecards_sidebar_reg() {
	register_sidebar(array(
	  'name' => __('Sidebar', 'ecards'),
	  'id' => 'sidebar',
	  'description' => __('Widgets in this area will be shown in the sidebar.', 'ecards'),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
	  'after_widget' => '</div><div class="clear"></div></div>'
	));
}

function html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action('wp_head', 'html_js_class', 1);

add_filter('next_posts_link_attributes', 'ecards_posts_link_attributes_1');
add_filter('previous_posts_link_attributes', 'ecards_posts_link_attributes_2');

function ecards_posts_link_attributes_1() {
    return 'class="archive-nav-older fleft"';
}
function ecards_posts_link_attributes_2() {
    return 'class="archive-nav-newer fright"';
}

function ecards_custom_excerpt_length($length) {
    return 28;
}
add_filter('excerpt_length', 'ecards_custom_excerpt_length', 999);

function ecards_new_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'ecards_new_excerpt_more');

add_filter('body_class', 'ecards_is_mobile_body_class');

function ecards_is_mobile_body_class($classes) {
    if(wp_is_mobile())
        $classes[] = 'wp-is-mobile';
    else
        $classes[] = 'wp-is-not-mobile';

    return $classes;
}

add_shortcode('wp_caption', 'ecards_fixed_img_caption_shortcode');
add_shortcode('caption', 'ecards_fixed_img_caption_shortcode');

function ecards_fixed_img_caption_shortcode($attr, $content = null) {
	if(!isset($attr['caption'])) {
		if(preg_match('#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches)) {
			$content = $matches[1];
			$attr['caption'] = trim($matches[2]);
		}
	}

	$output = apply_filters('img_caption_shortcode', '', $attr, $content);

	if($output != '') return $output;
	extract(shortcode_atts(array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	), $attr));

	if(1 > (int) $width || empty($caption))
	return $content;
	if($id) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >' . do_shortcode($content) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

function ecards_get_comment_excerpt($comment_ID = 0, $num_words = 20) {
    $comment = get_comment($comment_ID);
	$comment_text = strip_tags($comment->comment_content);
	$blah = explode(' ', $comment_text);
	if(count($blah) > $num_words) {
		$k = $num_words;
		$use_dotdotdot = 1;
	} else {
		$k = count($blah);
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for($i=0; $i<$k; $i++) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ($use_dotdotdot) ? '&hellip;' : '';
	return apply_filters('get_comment_excerpt', $excerpt);
}

function ecards_flexslider($size) {
    if(is_page())
        $attachment_parent = $post->ID;
	else
		$attachment_parent = get_the_ID();

    if($images = get_posts(array(
		'post_parent'    => $attachment_parent,
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
	))) { ?>
        <div class="flexslider">
            <ul class="slides">
                <?php foreach($images as $image) { 
					$attimg = wp_get_attachment_image($image->ID, $size); ?>
					<li><?php echo $attimg; ?></li>
                <?php }; ?>
			</ul>
		</div><?php
	}
}

if(!function_exists('ecards_comment')) :
function ecards_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	switch($comment->comment_type) :
		case 'pingback' :
		case 'trackback' :
            ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <?php __('Pingback:', 'ecards'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Edit', 'ecards'), '<span class="edit-link">', '</span>'); ?>
            </li>
            <?php
            break;
        default :
            global $post;
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment">
                    <div class="comment-header">
                        <?php echo get_avatar($comment, 160); ?>
                        <div class="comment-header-inner">
                            <h4><?php echo get_comment_author_link(); ?></h4>
                            <div class="comment-meta">
                                <a class="comment-date-link" href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>" title="<?php echo get_comment_date() . ' at ' . get_comment_time(); ?>"><?php echo get_comment_date(get_option('date_format')); ?></a>
                            </div> <!-- /comment-meta -->
                        </div> <!-- /comment-header-inner -->
                    </div>
                    <div class="comment-content post-content">
                        <?php comment_text(); ?>
                    </div><!-- /comment-content -->
                    <div class="comment-actions">
                        <?php if('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation fright"><?php _e('Your comment is awaiting moderation.', 'ecards'); ?></p>
                        <?php endif; ?>
                        <div class="fleft">
                            <?php 
                            comment_reply_link(array(
                                'reply_text' 	=> __('Reply', 'ecards'),
                                'depth'			=> $depth, 
                                'max_depth' 	=> $args['max_depth'],
                                'before'		=> '',
                                'after'			=> ''
                            )); 
                            ?><?php edit_comment_link(__('Edit', 'ecards'), '<span class="sep">/</span>', ''); ?>
                        </div>
                        <div class="clear"></div>
                    </div> <!-- /comment-actions -->
                </div><!-- /comment-## -->
                <?php
            break;
    endswitch;
}
endif;

add_action('add_meta_boxes', 'ecards_cd_meta_box_add');
function ecards_cd_meta_box_add() {
    add_meta_box('post-video-url', __('Video URL', 'ecards'), 'ecards_cd_meta_box_video_url', 'post', 'side', 'high');
}

function ecards_cd_meta_box_video_url($post) {
    $values = get_post_custom( $post->ID );
    $video_url = isset($values['video_url']) ? esc_attr($values['video_url'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
	?>
    <p><input type="text" class="widefat" name="video_url" id="video_url" value="<?php echo $video_url; ?>"></p>
	<?php		
}

add_action('save_post', 'ecards_cd_meta_box_save');
function ecards_cd_meta_box_save($post_id) {
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if(!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce')) return;
	if(!current_user_can('edit_post')) return;

    $allowed = array( 
        'a' => array(
            'href' => array()
        )
    );

    if(isset($_POST['video_url'])) {
        update_post_meta($post_id, 'video_url', wp_kses($_POST['video_url'], $allowed));
	}
}

function ecards_meta_box_post_format_toggle() {
    wp_enqueue_script('jquery');

    $script = '<script>
    jQuery(document).ready(function($){
        $("#post-video-url").hide();
        $("#post-quote-content-box").hide();
        $("#post-quote-attribution-box").hide();

        if($("#post-format-video").is(":checked"))
            $("#post-video-url").show();

        $("input[name=\"post_format\"]").change(function(){
            $("#post-video-url").hide();
        });

        $("input#post-format-video").change(function(){
            $("#post-video-url").show();
        });
    });
    </script>';

    return print $script;
}
add_action('admin_footer', 'ecards_meta_box_post_format_toggle');

// Noir Customizer
function noir_customize_register($wp_customize) {
    $wp_customize->add_section('noir' , array(
        'title' => __('eCards UI Colours', 'noir'),
        'description' => __('Welcome to eCards UI theme. Customize your theme colours below.', 'noir'),
        'priority' => 30,
    ));

    $colors = array();

    $colors[] = array('slug' => 'noir_global_bg_color', 'default' => '#FFFFFF', 'label' => __('Background colour', 'noir'));
    $colors[] = array('slug' => 'noir_global_text_color', 'default' => '#576A67', 'label' => __('Text colour', 'noir'));
    $colors[] = array('slug' => 'noir_global_link_color', 'default' => '#5FBBB5', 'label' => __('Link colour', 'noir'));
    $colors[] = array('slug' => 'noir_sidebar_color', 'default' => '#f5efdd', 'label' => __('Sidebar background colour', 'noir'));

    foreach($colors as $color) {
        // SETTINGS
        $wp_customize->add_setting(
            $color['slug'], array(
                'default' => $color['default'],
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options'
            )
        );
        // CONTROLS
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                $color['slug'], 
                array('label' => $color['label'], 
                      'section' => 'noir',
                      'settings' => $color['slug'])
            )
        );
    }
}
add_action('customize_register', 'noir_customize_register');