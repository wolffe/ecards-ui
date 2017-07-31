<?php if(post_password_required()) return; ?>

<?php if(have_comments()) : ?>
	<div class="comments-container">
		<div class="comments-inner">
			<a name="comments"></a>
			<h2 class="comments-title">
				<?php echo count($wp_query->comments_by_type['comment']) . ' ';
				echo _n('Comment', 'Comments', count($wp_query->comments_by_type['comment']), 'ecards'); ?>
			</h2>

			<div class="comments">
				<ol class="commentlist">
				    <?php wp_list_comments(array('type' => 'comment', 'callback' => 'ecards_comment')); ?>
				</ol>

				<?php if(!empty($comments_by_type['pings'])) : ?>
					<div class="pingbacks">
						<h3 class="pingbacks-title">
							<?php echo count($wp_query->comments_by_type['pings']) . ' ';
							echo _n('Pingback', 'Pingbacks', count($wp_query->comments_by_type['pings']), 'ecards'); ?>
						</h3>

						<ol class="pingbacklist">
						    <?php wp_list_comments(array('type' => 'pings', 'callback' => 'ecards_comment')); ?>
						</ol>
					</div> <!-- /pingbacks -->
				<?php endif; ?>

				<?php if(get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
					<div class="comments-nav" role="navigation">
						<div class="fleft">
							<?php previous_comments_link('&larr; ' . __('Older', 'ecards') . '<span> ' . __('Comments', 'ecards') . '</span>'); ?>
						</div>
						<div class="fright">
							<?php next_comments_link(__('Newer', 'ecards') . '<span> ' . __('Comments','ecards') . '</span>' . ' &rarr;'); ?>
						</div>
						<div class="clear"></div>
					</div> <!-- /comment-nav-below -->
				<?php endif; ?>
			</div> <!-- /comments -->
		</div> <!-- /comments-inner -->
	</div> <!-- /comments-container -->
<?php endif; ?>

<?php if(!comments_open() && !is_page()) : ?>
	<div class="comments-container">
		<div class="comments-inner">
			<p class="no-comments"><?php _e('Comments are closed.', 'ecards'); ?></p>
		</div>
	</div>
<?php endif; ?>

<?php
if(comments_open()) {
    echo '<div class="respond-container">';
}

comment_form();

if(comments_open()) {
    echo '</div> <!-- /respond-container -->';
}
?>