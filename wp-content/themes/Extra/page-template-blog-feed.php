<?php
/*
Template Name: Blog Feed
*/

get_header(); ?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="<?php extra_sidebar_class(); ?> clearfix">
			<div class="et_pb_extra_column_main">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>
				<?php $blog_feed_page_options = extra_get_blog_feed_page_options(); ?>
				<div class="posts-blog-feed-module <?php echo esc_attr( $blog_feed_page_options['display_style'] ); ?> module" style="<?php echo esc_attr( $blog_feed_page_options['border_color_style'] ); ?>">
					<div class="paginated_content">
						<div class="paginated_page" <?php echo 'masonry' == $blog_feed_page_options['display_style'] ? 'data-columns' : ''; ?>>
							<?php
							if ( $blog_feed_page_options['posts_query']->have_posts() ) :
								while ( $blog_feed_page_options['posts_query']->have_posts() ) : $blog_feed_page_options['posts_query']->the_post();
									$post_format = et_get_post_format();
									?>
										<article id="post-<?php the_ID(); ?>" <?php post_class( 'et-format-'.$post_format ); ?>>
											<div class="header">
												<?php
												$thumb_args = array(
													'size'      => 'extra-image-medium',
													'img_after' => '<span class="et_pb_extra_overlay"></span>',
												);
												$score_bar = extra_get_the_post_score_bar();
												require locate_template( 'post-top-content.php' );
												?>
											</div>
											<?php
											if ( !in_array( $post_format, array( 'quote', 'link' ) ) ) {
											?>
											<div class="post-content">
												<?php $color = !empty( $category_color ) ? $category_color : extra_get_post_category_color(); ?>
												<h2 class="post-title entry-title"><a class="et-accent-color" style="color:<?php echo esc_attr( $color ); ?>;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

												<div class="post-meta">
													<?php
													$meta_args = array(
														'author_link' => $blog_feed_page_options['show_author'],
														'post_date'   => $blog_feed_page_options['show_date'],
														'date_format' => $blog_feed_page_options['date_format'],
														'categories'  => $blog_feed_page_options['show_categories'],
													);
													?>
													<p><?php echo et_extra_display_post_meta( $meta_args ); ?></p>
												</div>
												<div class="excerpt entry-summary">
													<p><?php
													if ( 'excerpt' == $blog_feed_page_options['content_length'] ) {
														if ( has_excerpt() ) {
															the_excerpt();
														} else {
															if ( in_array( $post_format, array( 'audio', 'map' ) ) ) {
																$excerpt_length = '100';
															} else {
																$excerpt_length = get_post_thumbnail_id() ? '100' : '230';
															}

															et_truncate_post( $excerpt_length );
														}
													} else {
														echo extra_get_de_buildered_content();
													}
													?></p>
													<a class="read-more-button" href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Leia mais', 'extra' ); ?></a>
												</div>
											</div>
											<?php } ?>
										</article>
									<?php
								endwhile;
								wp_reset_postdata();
							else :
								?>
								<article class='nopost'>
									<h5><?php esc_html_e( 'Desculpe, artigo não encontrada', 'extra' ); ?></h5>
								</article>
								<?php
							endif;
							?>
						</div><!-- /.paginated_page -->
					</div><!-- /.paginated_content -->
					<?php if ( $blog_feed_page_options['posts_query']->max_num_pages > 1 ) { ?>
						<div class="archive-pagination">
							<?php echo extra_archive_pagination( $blog_feed_page_options['posts_query'] ); ?>
						</div>
					<?php } ?>
				</div><!-- /.posts-blog-feed-module -->
			<?php
				endwhile;
			else :
			?>
				<h2><?php esc_html_e( 'Artigo não encontrado', 'extra' ); ?></h2>
			<?php
			endif;
			?>
			</div><!-- /.et_pb_extra_column.et_pb_extra_column_main -->

			<?php get_sidebar(); ?>

		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer();
