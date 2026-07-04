<?php
/*
Template Name: All Specialities
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="doctor-hero d-flex align-items-center">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold mb-3">
            <?php echo esc_html($term->name); ?>
        </h1>
        <nav aria-label="breadcrumb" class="mb-3" style="--bs-breadcrumb-divider: '›';">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo home_url(); ?>" class="text-warning text-decoration-none">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">
                    All Specialties
                </li>
            </ol>
        </nav>
        <span class="doctor-count text-white">
            Browse all medical specialities and find the right doctor for your needs.
        </span>
    </div>
</section>

<section class="dochive-page-content py-5">
    <div class="container">
        <?php get_template_part('template-parts/home/specialties'); ?>
    </div>
</section>

<?php get_footer(); ?>