<?php

$hero_image = get_template_directory_uri() . '/assets/images/hero-doctors.png';

$specialties = get_terms([
    'taxonomy'   => 'specialty',
    'hide_empty' => false
]);

?>

<section class="dochive-hero">

    <!-- Background Shapes -->
    <div class="hero-shape shape-1"></div>
    <div class="hero-shape shape-2"></div>
    <div class="hero-shape shape-3"></div>

    <div class="container">

        <div class="row align-items-center">

            <!-- LEFT -->
            <div class="col-lg-6">

                <div class="hero-content">

                    <span class="hero-badge">
                        <i class="bi bi-patch-check-fill"></i>
                        Bangladesh's Trusted Doctor Directory
                    </span>

                    <h1 class="hero-title">
                        Find The Right
                        <span>Doctor</span>
                        For Your Health
                    </h1>

                    <p class="hero-description">
                        Discover verified doctors, specialists, clinics and hospitals.
                        Search by specialty, location and experience to get the best healthcare support.
                    </p>

                    <div class="hero-buttons">

                        <a href="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>" class="btn btn-primary btn-lg">
                            Find Doctors
                        </a>

                        <a href="#specialties" class="btn btn-outline-light btn-lg">
                            Browse Specialties
                        </a>

                    </div>

                    <div class="hero-stats">

                        <div class="stat-item">
                            <h3>15K+</h3>
                            <span>Doctors</span>
                        </div>

                        <div class="stat-item">
                            <h3>500+</h3>
                            <span>Hospitals</span>
                        </div>

                        <div class="stat-item">
                            <h3>64</h3>
                            <span>Districts</span>
                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-6">

                <div class="hero-image-wrapper">

                    <img
                        src="<?php echo esc_url($hero_image); ?>"
                        alt="Doctors"
                        class="img-fluid hero-image">

                    <!-- Floating Card -->
                    <div class="floating-card card-one">

                        <div class="icon">
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <div>
                            <strong>4.9 Rating</strong>
                            <span>Trusted by Patients</span>
                        </div>

                    </div>

                    <!-- Floating Card -->
                    <div class="floating-card card-two">

                        <div class="icon">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>

                        <div>
                            <strong>15,000+</strong>
                            <span>Verified Doctors</span>
                        </div>

                    </div>

                    <!-- Floating Card -->
                    <div class="floating-card card-three">

                        <div class="icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>

                        <div>
                            <strong>Easy Booking</strong>
                            <span>Fast Appointments</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="hero-trust">

            <div class="trust-item">
                <i class="bi bi-patch-check-fill"></i>
                Verified Doctors
            </div>

            <div class="trust-item">
                <i class="bi bi-shield-check"></i>
                Secure Data
            </div>

            <div class="trust-item">
                <i class="bi bi-people-fill"></i>
                Trusted by Patients
            </div>

            <div class="trust-item">
                <i class="bi bi-clock-fill"></i>
                24/7 Support
            </div>

        </div>

    </div>

</section>

<!-- SEARCH BOX -->
<div class="container">

    <div class="hero-search-box">

        <form
            method="get"
            action="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>">

            <div class="row g-3">

                <div class="col-lg-4">

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="doctor_name"
                            class="form-control"
                            placeholder="Search Doctor">

                    </div>

                </div>

                <div class="col-lg-3">

                    <select
                        name="specialty"
                        class="form-select">

                        <option value="">
                            Select Specialty
                        </option>

                        <?php foreach ($specialties as $specialty) : ?>

                            <option value="<?php echo esc_attr($specialty->slug); ?>">
                                <?php echo esc_html($specialty->name); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-lg-3">

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-geo-alt"></i>
                        </span>

                        <input
                            type="text"
                            name="location"
                            class="form-control"
                            placeholder="Location">

                    </div>

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
