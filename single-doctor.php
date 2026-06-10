<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<?php
$qualification = get_post_meta(get_the_ID(), '_qualification', true);
$experience    = get_post_meta(get_the_ID(), '_experience', true);
$gender        = get_post_meta(get_the_ID(), '_gender', true);
$registration  = get_post_meta(get_the_ID(), '_registration', true);
$featured      = get_post_meta(get_the_ID(), '_featured', true);
$specialties = get_the_terms(get_the_ID(), 'specialty');
$chambers = get_post_meta( get_the_ID(), '_doctor_chambers', true);
?>
<section class="doctor-hero d-flex align-items-center">

    <div class="container text-center text-white">
        
        <h1 class="display-4 fw-bold mb-3">
           <?php the_title(); ?>
        </h1>

        <p class="lead mb-0">
            <?php if ($specialties && !is_wp_error($specialties)) : ?>
                <div class="doctor-specialties">

                    <?php foreach ($specialties as $specialty) : ?>

                        <span class="badge rounded-pill bg-primary mb-2 px-3 py-2">
                            <?php echo esc_html($specialty->name); ?>
                        </span>

                    <?php endforeach; ?>

                </div>
            <?php endif; ?>
        </p>
        <nav aria-label="breadcrumb" class="mb-3" style="--bs-breadcrumb-divider: '›';">

            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo home_url(); ?>" class="text-warning text-decoration-none">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a class="text-warning text-decoration-none" href="<?php echo home_url('/doctors'); ?>">Doctors</a>
                </li>
                <li class="breadcrumb-item active text-white">
                    <?php the_title(); ?>
                </li>

            </ol>

        </nav>
    </div>
</section>
<section class="doctor-single mb-5">

    <div class="container">

        <div class="card doctor-profile shadow-sm border-1">

            <div class="row g-0">

                <!-- Image Section -->
                <div class="col-md-4 text-center p-3 bg-light d-flex align-items-center justify-content-center">
                    <div class="w-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'img-fluid rounded']); ?>
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x300" class="img-fluid rounded" alt="Doctor">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="col-md-8">
                    <div class="card-body">

                        <?php if ($featured) : ?>
                            <span class="badge bg-warning text-dark mb-2">
                                ⭐ Featured Doctor
                            </span>
                        <?php endif; ?>

                        <h5 class="card-title mb-3">
                            <?php the_title(); ?>
                        </h5>

                        <?php if (!empty($qualification)) : ?>
                            <p class="mb-1">
                                <strong>Qualification:</strong>
                                <?php echo esc_html($qualification); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($experience)) : ?>
                            <p class="mb-1">
                                <strong>Experience:</strong>
                                <?php echo esc_html($experience); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($gender)) : ?>
                            <p class="mb-1">
                                <strong>Gender:</strong>
                                <?php echo esc_html($gender); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($registration)) : ?>
                            <p class="mb-0">
                                <strong>BMDC Registration:</strong>
                                <?php echo esc_html($registration); ?>
                            </p>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>

        <div class="card doctor-about border-1 shadow-sm mt-4">

            <div class="card-body">

                <h5 class="card-title mb-3">
                    About Doctor
                </h5>

                <div class="card-text">
                    <?php the_content(); ?>
                </div>

            </div>

        </div>

        <div class="doctor-meta">
            <?php if (!empty($chambers)) : ?>
                <div class="doctor-chambers">

                    <h2>Chamber Information</h2>

                    <div class="chamber-grid">

                        <?php foreach ($chambers as $chamber) : ?>

                            <div class="chamber-card">

                                <?php if (!empty($chamber['hospital'])) : ?>
                                    <h3><?php echo esc_html($chamber['hospital']); ?></h3>
                                <?php endif; ?>

                                <?php if (!empty($chamber['district']) || !empty($chamber['area'])) : ?>
                                    <p>
                                        <strong>Location:</strong>
                                        <?php 
                                            echo esc_html($chamber['area'] ?? '');
                                            if (!empty($chamber['area']) && !empty($chamber['district'])) {
                                                echo ', ';
                                            }
                                            echo esc_html($chamber['district'] ?? '');
                                        ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($chamber['address'])) : ?>
                                    <p>
                                        <strong>Address:</strong><br>
                                        <?php echo nl2br(esc_html($chamber['address'])); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($chamber['schedules']) && is_array($chamber['schedules'])) : ?>
                                    <p>
                                        <strong>Schedule:</strong><br>

                                        <?php foreach ($chamber['schedules'] as $schedule) : ?>
                                            <?php if (!empty($schedule['day'])) : ?>
                                                <span>
                                                    <?php echo esc_html($schedule['day']); ?> :
                                                    <?php echo esc_html(date("g:i A", strtotime($schedule['start_time'])) ?? ''); ?> -
                                                    <?php echo esc_html(date("g:i A", strtotime($schedule['end_time'])) ?? ''); ?>
                                                </span><br>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($chamber['contact1']) || !empty($chamber['contact2'])) : ?>
                                    <p>
                                        <strong>Appointment:</strong><br>

                                        <?php if (!empty($chamber['contact1'])) : ?>
                                            <a href="tel:<?php echo esc_attr($chamber['contact1']); ?>">
                                                <?php echo esc_html($chamber['contact1']); ?>
                                            </a><br>
                                        <?php endif; ?>

                                        <?php if (!empty($chamber['contact2'])) : ?>
                                            <a href="tel:<?php echo esc_attr($chamber['contact2']); ?>">
                                                <?php echo esc_html($chamber['contact2']); ?>
                                            </a>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($chamber['whatsapp'])) : ?>
                                    <p>
                                        <strong>WhatsApp:</strong>
                                        <a href="https://wa.me/<?php echo esc_attr($chamber['whatsapp']); ?>" target="_blank">
                                            <?php echo esc_html($chamber['whatsapp']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($chamber['map'])) : ?>
                                    <p>
                                        <strong>Map:</strong>
                                        <a href="<?php echo esc_url($chamber['map']); ?>" target="_blank">
                                            View Location
                                        </a>
                                    </p>
                                <?php endif; ?>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endif; ?>
        </div>

    </div>

</section>

<?php endwhile; ?>
<?php
$floating_phone = '';

if (!empty($chambers) && is_array($chambers)) {
    $first_chamber = $chambers[0] ?? null;
    if (!empty($first_chamber['contact1'])) {
        $floating_phone = $first_chamber['contact1'];
    }
}
?>

<?php if (!empty($floating_phone)) : ?>
    <a class="floating-call-btn"
       href="tel:<?php echo esc_attr($floating_phone); ?>">
        <i class="bi bi-headset"></i> Call Now<br>
        <small><?php echo esc_html($floating_phone); ?></small>
    </a>
<?php endif; ?>
<?php get_footer(); ?>