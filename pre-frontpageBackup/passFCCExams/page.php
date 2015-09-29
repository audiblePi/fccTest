<?php get_header(); ?>


<?php #Main Content Wrapper ?>
<section id="content-wrapper" class="container" role="main">
	<div class="row">
		<div class="twelve columns">
			<?php #BEGIN LOOP FOR PAGE ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<section class="entry-content">
						<?php the_content(); ?>
					</section>

				</div>

			<?php endwhile; endif; #END LOOP FOR PAGE ?>

		</div>
		<!-- <div class="four columns">
			<div class="sidebar">
				<?php
				// $sidebarOption = get_field('sidebar_option');
				// switch ($sidebarOption){
				// 	case "sidebar1":
				// 	dynamic_sidebar( "Sidebar 1" );
				// 	break;
				// 	case "sidebar2":
				// 	dynamic_sidebar( "Sidebar 2" );
				// 	break;
				// 	case "sidebar3":
				// 	dynamic_sidebar( "Sidebar 3" );
				// 	break;
				// 	case "sidebar4":
				// 	dynamic_sidebar( "Sidebar 4" );
				// 	break;
				// 	default:
				// 	dynamic_sidebar( "Sidebar 1" );
				// 	break;
				// }
				?>
			</div> -->


		</div>
	</div>

</section>

<?php get_footer(); ?>