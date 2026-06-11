<?php

$hero_title = 'Find The Best Doctors Near You';

$hero_subtitle = 'WELCOME TO DOCHIVE';

$hero_description = 'Search by name, specialty, location or hospital to find the best doctors.';

$hero_image = get_template_directory_uri() . '/assets/images/hero-doctors.png';

$specialties = get_terms([
    'taxonomy'   => 'specialty',
    'hide_empty' => false
]);

?>

<section class="dochive-hero">

    <div class="container">

        <div class="row align-items-center">

            <!-- LEFT CONTENT -->

            <div class="col-lg-6">

                <div class="hero-content">

                    <span class="hero-subtitle">
                        <?php echo esc_html($hero_subtitle); ?>
                    </span>

                    <h1 class="hero-title">
                        Find The Best
                        <br>
                        Doctors Near
                        <span>You</span>
                    </h1>

                    <p class="hero-description">
                        <?php echo esc_html($hero_description); ?>
                    </p>

                </div>

            </div>

            <!-- RIGHT IMAGE -->

            <div class="col-lg-6">

                <div class="hero-image">

                    <img
                        src="<?php echo esc_url($hero_image); ?>"
                        alt="Doctors"
                        class="img-fluid">

                </div>

            </div>

        </div>

        <!-- SEARCH BOX -->

        <div class="hero-search-box">

            <form
                method="get"
                action="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>">

                <div class="row g-3 align-items-center">

                    <div class="col-lg-4">

                        <input
                            type="text"
                            name="doctor_name"
                            class="form-control"
                            placeholder="Search Doctor...">

                    </div>

                    <div class="col-lg-3">

                        <select
                            name="specialty"
                            class="form-select">

                            <option value="">
                                Select Specialty
                            </option>

                            <?php foreach ($specialties as $specialty) : ?>

                                <option
                                    value="<?php echo esc_attr($specialty->slug); ?>">

                                    <?php echo esc_html($specialty->name); ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-lg-3">

                        <input
                            type="text"
                            name="location"
                            class="form-control"
                            placeholder="Select Location">

                    </div>

                    <div class="col-lg-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>