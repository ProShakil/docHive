<?php

$featured_doctors = new WP_Query([
    'post_type'      => 'doctor',
    'post_status'    => 'publish',
    'posts_per_page' => 8
]);

if (!$featured_doctors->have_posts()) {
    return;
}

?>

<section class="dochive-featured-doctors py-5">

    <div class="container">

        <div class="section-header text-center mb-5">

            <span class="section-subtitle">
                FEATURED DOCTORS
            </span>

            <h2 class="section-title">
                Meet Our Specialists
            </h2>

            <p class="section-description">
                Experienced and verified doctors from
                different medical specialties.
            </p>

        </div>

        <div class="row g-4">

            <?php while ($featured_doctors->have_posts()) : $featured_doctors->the_post(); ?>

                <?php

                $qualification = get_post_meta(
                    get_the_ID(),
                    '_qualification',
                    true
                );

                $experience = get_post_meta(
                    get_the_ID(),
                    '_experience',
                    true
                );

                $registration = get_post_meta(
                    get_the_ID(),
                    '_registration',
                    true
                );

                $chambers = get_post_meta(
                    get_the_ID(),
                    '_doctor_chambers',
                    true
                );

                $chamber_count = is_array($chambers)
                    ? count($chambers)
                    : 0;

                $specialties = get_the_terms(
                    get_the_ID(),
                    'specialty'
                );

                ?>

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="doctor-card">

                        <div class="doctor-image">

                            <a href="<?php the_permalink(); ?>">

                                <?php if (has_post_thumbnail()) : ?>

                                    <?php the_post_thumbnail(
                                        'medium',
                                        [
                                            'class' => 'img-fluid'
                                        ]
                                    ); ?>

                                <?php else : ?>

                                    <img
                                        src="https://placehold.co/400x400"
                                        class="img-fluid"
                                        alt="Doctor">

                                <?php endif; ?>

                            </a>

                        </div>

                        <div class="doctor-body">

                            <?php if (!empty($specialties)) : ?>

                                <span class="doctor-specialty">

                                    <?php echo esc_html($specialties[0]->name); ?>

                                </span>

                            <?php endif; ?>

                            <h4>

                                <a href="<?php the_permalink(); ?>">

                                    <?php the_title(); ?>

                                </a>

                            </h4>

                            <?php if ($qualification) : ?>

                                <div class="doctor-meta">

                                    <?php echo esc_html($qualification); ?>

                                </div>

                            <?php endif; ?>

                            <?php if ($experience) : ?>

                                <div class="doctor-meta">

                                    <i class="bi bi-briefcase"></i>

                                    <?php echo esc_html($experience); ?>

                                    Years Experience

                                </div>

                            <?php endif; ?>

                            <?php if ($registration) : ?>

                                <div class="doctor-meta">

                                    <i class="bi bi-patch-check"></i>

                                    BMDC:

                                    <?php echo esc_html($registration); ?>

                                </div>

                            <?php endif; ?>

                            <div class="doctor-meta">

                                <i class="bi bi-hospital"></i>

                                <?php echo esc_html($chamber_count); ?>

                                Chambers

                            </div>

                            <a
                                href="<?php the_permalink(); ?>"
                                class="btn btn-primary w-100 mt-3">

                                View Profile

                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

        <div class="text-center mt-5">

            <a
                href="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>"
                class="btn btn-outline-primary btn-lg">

                View All Doctors

            </a>

        </div>

    </div>

</section>

<?php wp_reset_postdata(); ?>