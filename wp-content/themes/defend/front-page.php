<?php
/*
Template Name: Front page
*/
?>
<?php get_header();global $post;?>
    <main>
		<?php if ( have_posts() ) {
			while ( have_posts() ) { the_post(); ?>
                <section class="white-bg">
                    <div class="container py-md-5">
                        <div class="row align-items-center mt-4 mt-md-1">
                            <div class="col-md-8">
                                <h1><?php the_title(); ?></h1>
								<?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </section>
			<?php } ?>
		<?php } ?>
    </main>
<?php get_footer(); ?>