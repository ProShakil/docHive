<?php

$specialties = get_terms([
    'taxonomy'   => 'specialty',
    'hide_empty' => false,
    'number'     => 8
]);

if (empty($specialties) || is_wp_error($specialties)) {
    return;
}

?>

<section class="dochive-specialties py-5">

    <div class="container">

        <div class="section-header text-center mb-5">

            <span class="section-subtitle">
                SPECIALTIES
            </span>

            <h2 class="section-title">
                Popular Medical Specialties
            </h2>

            <p class="section-description">
                Find doctors by specialty and explore
                verified medical professionals.
            </p>

        </div>

        <div class="row g-4">

            <?php foreach ($specialties as $specialty) : ?>

                <?php

                $doctor_count = $specialty->count;

                $term_link = get_term_link(
                    $specialty->term_id,
                    'specialty'
                );

                ?>

                <div class="col-lg-3 col-md-6">

                    <div class="specialty-card">

                        <div class="specialty-icon">

                            <i class="bi bi-heart-pulse"></i>

                        </div>

                        <h4>

                            <?php
                            echo esc_html(
                                $specialty->name
                            );
                            ?>

                        </h4>

                        <p>

                            <?php
                            echo esc_html(
                                $doctor_count
                            );
                            ?>

                            Doctors

                        </p>

                        <a
                            href="<?php echo esc_url($term_link); ?>"
                            class="specialty-link">

                            View Doctors

                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>