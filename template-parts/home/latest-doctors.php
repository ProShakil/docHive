<?php

$latest_doctors = new WP_Query([
    'post_type'      => 'doctor',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
]);

if (!$latest_doctors->have_posts()) {
    return;
}

?>

<section class="dochive-latest-doctors py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="section-badge">
                🆕 LATEST DOCTORS
            </span>

            <h2 class="section-title">
                Recently Added Doctors
            </h2>

            <p class="section-desc">
                Explore newly registered verified doctors on DocHive
            </p>

        </div>

        <div class="row g-4">

            <?php while ($latest_doctors->have_posts()) : $latest_doctors->the_post(); ?>

                <?php
                    $specialties = get_the_terms(get_the_ID(), 'specialty');
                ?>

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="doctor-card-modern">

                        <div class="doctor-image">

                            <a href="<?php the_permalink(); ?>">

                                <?php if (has_post_thumbnail()) : ?>

                                    <?php the_post_thumbnail('medium', [
                                        'class' => 'img-fluid'
                                    ]); ?>

                                <?php else : ?>

                                    <img src="https://placehold.co/400x400" class="img-fluid" alt="Doctor">
                                    
                                <?php endif; ?>

                            </a>

                            <?php if (!empty($specialties)) : ?>

                                <span class="doctor-badge">

                                    <?php echo esc_html($specialties[0]->name); ?>

                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="doctor-body">

                            <h5 class="doctor-name">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h5>

                            <div class="doctor-actions">

                                <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary w-100">
                                    View Profile
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </div>

</section>

<?php wp_reset_postdata(); ?>