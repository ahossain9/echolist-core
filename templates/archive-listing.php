<?php

/**
 * Archive Template for Listing Custom Post Type
 *
 * @package Echolist_Core
 */

get_header();

if (have_posts()) : ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4"><?php _e('Listings', 'echolist-core'); ?></h1>
        <div class="row">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <p class="card-text"><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e('View Listing', 'echolist-core'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="mt-4">
            <?php the_posts_pagination(); ?>
        </div>
    </div>
<?php else : ?>
    <div class="container mt-5">
        <h1 class="text-center"><?php _e('No Listings Found', 'echolist-core'); ?></h1>
    </div>
<?php endif;

get_footer();
