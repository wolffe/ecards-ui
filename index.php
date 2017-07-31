<?php get_header(); ?>

<div class="content">
    <ul class="list_1">
        <?php
        $args = array('posts_per_page' => 4, 'offset'=> 0, 'category_name' => 'Featured');
        $myposts = get_posts($args);
        foreach($myposts as $post) : setup_postdata($post); ?>
            <li style="display: inline-block;">
                <figure class="thumbnail featured-thumbnail">
                    <?php the_post_thumbnail('homepage-thumbnail'); ?>
                </figure>

                <div class="caption">
                    <h5><i class="fa fa-link"></i> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <span class="sub_title"><time class="timemeta"><i class="fa fa-clock-o"></i> <?php echo get_the_date(get_option('date_format')); ?></time></span>
                    <div class="excerpt"><?php the_excerpt(); ?></div>
                </div>
                <div class="clear"></div>
            </li>
        <?php endforeach; 
        wp_reset_postdata();?>
    </ul>
</div>
<div class="content">
    <?php if(have_posts()) : ?>
        <?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$total_post_count = wp_count_posts();
		$published_post_count = $total_post_count->publish;
		$total_pages = ceil($published_post_count / $posts_per_page);

		if('1' < $paged ) : ?>
			<div class="page-title">
				<h4><?php printf(__('Page %s of %s', 'ecards'), $paged, $wp_query->max_num_pages); ?></h4>
			</div> <!-- /page-title -->
			<div class="clear"></div>
		<?php endif; ?>

		<div class="posts" id="posts">
	    	<?php while(have_posts()) : the_post(); ?>
	    		<?php get_template_part('content', get_post_format()); ?>
	        <?php endwhile; ?>
		<?php endif; ?>
	</div> <!-- /posts -->

	<?php if($wp_query->max_num_pages > 1) : ?>
		<div class="archive-nav">
			<?php echo get_next_posts_link(__('Older posts', 'ecards') . ' &rarr;'); ?>
			<?php echo get_previous_posts_link('&larr; ' . __('Newer posts', 'ecards')); ?>
			<div class="clear"></div>
		</div> <!-- /archive-nav -->
	<?php endif; ?>
</div> <!-- /content -->
	              	        
<?php get_footer(); ?>