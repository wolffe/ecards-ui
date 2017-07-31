<!doctype html>
<html <?php language_attributes(); ?>>
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php if(is_singular()) wp_enqueue_script('comment-reply'); ?>
<?php wp_head(); ?>

<!-- CUSTOM CSS STYLES -->
<?php
// get or assign theme default settings
$noir_global_bg_color = get_theme_mod('noir_global_bg_color', '#FFFFFF');
$noir_global_text_color = get_theme_mod('noir_global_text_color', '#576A67');
$noir_global_link_color = get_theme_mod('noir_global_link_color', '#5FBBB5');
$noir_sidebar_color = get_theme_mod('noir_sidebar_color', '#f5efdd');
?>
<style>
body { background-color: <?php echo $noir_global_bg_color; ?>; }
body, select,
.blog-title a, .main-menu a, .main-menu a:hover, .main-menu .current-menu-item > a, .main-menu .current_page_item > a,
.widget-title, .widget_archive li a, .widget_categories li a, .widget_meta li a, .widget_nav_menu li a, .widget_pages li a,
.rssSummary,
#wp-calendar caption, #wp-calendar thead, #wp-calendar tfoot a:hover,
.widget_ecards_recent_posts .title, .widget_ecards_recent_comments .title,
.posts .post-title, .posts .post-title a, .post-excerpt p, .posts-meta a:hover, .post.single .post-title a, .page-links > span:nth-of-type(2), .post-meta-bottom li a:hover,
.post-navigation p,
.post-content, .post-content blockquote, .post-content .wp-caption-text, .post-content .gallery-caption,
.post-content input[type="text"], .post-content input[type="tel"], .post-content input[type="url"], .post-content input[type="email"], .post-content input[type="password"], .post-content textarea,
.comments-title, .comment-reply-title, .comment-header h4, .comment-header h4 a, .comment-meta a:hover, .comments-nav a, .comment-notes, .comment-form label, .comment-form input[type="text"], .comment-form input[type="email"], .comment-form textarea,
.page-title h4, .archive-nav a, .archive-nav a:hover, #infinite-handle span, #infinite-handle span:hover, .search-field, .search-button .genericon,
.credits p a:hover
{ color: <?php echo $noir_global_text_color; ?>; }

.blog-title a { border: 3px solid <?php echo $noir_global_text_color; ?>; }

.blog-title a:hover, .post-navigation a:hover, .post-content pre, .post-content input[type="submit"], .post-content input[type="reset"], .post-content input[type="button"], .form-submit #submit, label.radio > span.pip
{ background-color: <?php echo $noir_global_text_color; ?>; }

.flex-direction-nav a { background: <?php echo $noir_global_text_color; ?> no-repeat center; }

body a, body a:hover, .main-menu .current-menu-item:before, .main-menu .current_page_item:before,
.widget-content .textwidget a:hover, .widget_archive li a:hover, .widget_categories li a:hover, .widget_meta li a:hover, .widget_nav_menu li a:hover, .widget_pages li a:hover, .widget_rss .widget-content ul a.rsswidget:hover,
#wp-calendar thead, .widget_ecards_recent_posts a:hover .title, .widget_ecards_recent_comments a:hover .title,
.posts .post-title a:hover, .post.single .post-title a:hover, .post-content blockquote:before, .comment-header h4 a:hover,
.comments .pingbacks li a:hover, .comments-nav a:hover, .search-button:hover .genericon, .mobile-menu .current-menu-item:before, .mobile-menu .current_page_item:before
{ color: <?php echo $noir_global_link_color; ?>; }

.widget_tag_cloud a:hover, .flex-direction-nav a:hover, .page-links a:hover, .post-content fieldset legend, .post-content input[type="submit"]:hover, .post-content input[type="reset"]:hover, .post-content input[type="button"]:hover, .comment.bypostauthor > .comment .comment-header:before, .form-submit #submit:hover, .nav-toggle.active, label.radio.on
{ background-color: <?php echo $noir_global_link_color; ?>; }

.wrapper { box-shadow: -300px 0 0 <?php echo $noir_sidebar_color; ?>; }
</style>
</head>
<body <?php body_class(); ?>>

<div class="mobile-navigation">
    <ul class="mobile-menu">
        <?php wp_nav_menu(array('container' => '', 'items_wrap' => '%3$s', 'theme_location' => 'primary')); ?>
    </ul>
</div> <!-- /mobile-navigation -->
<div class="sidebar">
    <?php if(has_custom_logo()) {
        the_custom_logo();
    } else { ?>
        <h1 class="blog-title"><a href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('title')); ?> &mdash; <?php echo esc_attr(get_bloginfo('description')); ?>" rel="home"><?php echo esc_attr(get_bloginfo('title')); ?></a></h1>
    <?php } ?>

    <a class="nav-toggle hidden" title="<?php _e('Click to view the navigation','ecards') ?>" href="#">
        <p>
            <span class="menu"><i class="fa fa-bars"></i></span>
            <span class="close"><i class="fa fa-times"></i></span>
        </p>
    </a>
    <ul class="main-menu">
        <?php wp_nav_menu(array('container' => '', 'items_wrap' => '%3$s', 'theme_location' => 'primary')); ?>
    </ul>
    <div class="widgets">
        <?php dynamic_sidebar('sidebar'); ?>
    </div>
    <div class="credits">
        <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>.</p>
        <p><?php _e('Powered by', 'ecards'); ?> <a href="https://www.wordpress.org">WordPress</a> and <a href="https://getbutterfly.com">eCards</a>.</p>
    </div>
    <div class="clear"></div>
</div> 
<div class="wrapper" id="wrapper">