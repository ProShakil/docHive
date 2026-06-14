<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
<?php

$title = get_the_title();

if (is_archive()) {
    $title = post_type_archive_title('', false);
}

?>
<section class="doctor-hero d-flex align-items-center">

    <div class="container text-center text-white">
        
        <h1 class="display-4 fw-bold mb-3">
            <?php echo esc_html($title); ?>
        </h1>
        
        <nav aria-label="breadcrumb" class="mb-3" style="--bs-breadcrumb-divider: '›';">

            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo home_url(); ?>" class="text-warning text-decoration-none">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item active text-white">
                    <?php echo esc_html($title); ?>
                </li>

            </ol>

        </nav>
    </div>
</section>

<section class="dochive-page-content py-5">

    <div class="container">

        <div class="row">

            <div class="col-lg-10 mx-auto">

                <?php the_content(); ?>

            </div>

        </div>

    </div>

</section>
<?php endwhile; ?>
<?php get_footer(); ?>