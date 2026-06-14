<?php

$total_doctors = wp_count_posts('doctor')->publish;

$total_specialties = wp_count_terms([
    'taxonomy'   => 'specialty',
    'hide_empty' => false
]);

$doctor_ids = get_posts([
    'post_type'      => 'doctor',
    'posts_per_page' => -1,
    'fields'         => 'ids'
]);

$total_chambers = 0;

foreach ($doctor_ids as $doctor_id) {

    $chambers = get_post_meta(
        $doctor_id,
        '_doctor_chambers',
        true
    );

    if (is_array($chambers)) {
        $total_chambers += count($chambers);
    }
}

?>

<section class="dochive-stats-section">

    <div class="container">

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div
                        class="stat-number counter"
                        data-count="<?php echo esc_attr($total_doctors); ?>">

                        0

                    </div>

                    <h4>Doctors</h4>

                    <p>Verified Medical Professionals</p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div
                        class="stat-number counter"
                        data-count="<?php echo esc_attr($total_chambers); ?>">

                        0

                    </div>

                    <h4>Chambers</h4>

                    <p>Available Practice Locations</p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div
                        class="stat-number counter"
                        data-count="<?php echo esc_attr($total_specialties); ?>">

                        0

                    </div>

                    <h4>Specialties</h4>

                    <p>Medical Categories</p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-number">

                        100%

                    </div>

                    <h4>Verified</h4>

                    <p>Profile Verification</p>

                </div>

            </div>

        </div>

    </div>

</section>