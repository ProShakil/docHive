<?php get_header(); ?>

<main class="container">

<?php

if ( is_home() && ! is_front_page() ) {

    echo '<h1>Blog Posts</h1>';

    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            ?>
            <article>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div><?php the_excerpt(); ?></div>
            </article>
            <?php
        endwhile;
    else :
        echo '<p>No posts found.</p>';
    endif;

// যদি static front page হয়
} else {

    while ( have_posts() ) : the_post();
        ?>
        <h1><?php the_title(); ?></h1>
        <div>
            <?php the_content(); ?>
        </div>
        <?php
    endwhile;

}
?>

</main>

<?php get_footer(); ?>