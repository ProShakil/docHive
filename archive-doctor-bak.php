<?php get_header(); ?>

<?php

$paged = max(
    1,
    get_query_var('paged')
);

$args = [
    'post_type'      => 'doctor',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged,
];

if (!empty($_GET['doctor_name'])) {
    $args['s'] = sanitize_text_field($_GET['doctor_name']);
}

if (!empty($_GET['specialty'])) {

    $args['tax_query'] = [
        [
            'taxonomy' => 'specialty',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['specialty'])
        ]
    ];
}

$query = new WP_Query($args);

$specialties = get_terms([
    'taxonomy'   => 'specialty',
    'hide_empty' => false
]);

?>

<section class="py-5">

    <div class="container">

        <div class="row mb-4">

            <div class="col-lg-12 text-center">

                <h1 class="fw-bold mb-2">
                    Find Your Doctor
                </h1>

                <p class="text-muted">
                    Search doctors by name and specialty
                </p>

            </div>

        </div>

        <!-- Search Form -->

        <form method="GET" class="mb-5">

            <div class="row g-3">

                <div class="col-lg-5">

                    <input
                        type="text"
                        name="doctor_name"
                        class="form-control"
                        placeholder="Search Doctor Name"
                        value="<?php echo esc_attr($_GET['doctor_name'] ?? ''); ?>">

                </div>

                <div class="col-lg-5">

                    <select
                        name="specialty"
                        class="form-select">

                        <option value="">
                            All Specialties
                        </option>

                        <?php foreach ($specialties as $specialty) : ?>

                            <option
                                value="<?php echo esc_attr($specialty->slug); ?>"
                                <?php selected(
                                    $_GET['specialty'] ?? '',
                                    $specialty->slug
                                ); ?>>

                                <?php echo esc_html($specialty->name); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

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

        <!-- Doctor Grid -->

        <div class="row g-4">

            <?php if ($query->have_posts()) : ?>

                <?php while ($query->have_posts()) : $query->the_post(); ?>

                    <?php

                    $specialties = get_the_terms(
                        get_the_ID(),
                        'specialty'
                    );

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

                    $chambers = get_post_meta(
                        get_the_ID(),
                        '_doctor_chambers',
                        true
                    );

                    $count = is_array($chambers)
                        ? count($chambers)
                        : 0;
                        
                    $bmdc = get_post_meta(
                        get_the_ID(),
                        '_registration',
                        true
                    );

                    ?>

                    <div class="col-xl-3 col-lg-4 col-md-6">

                        <div class="card border-0 shadow-sm h-100">

                            <?php if (has_post_thumbnail()) : ?>

                                <a href="<?php the_permalink(); ?>">

                                    <?php the_post_thumbnail(
                                        'medium',
                                        [
                                            'class' => 'card-img-top'
                                        ]
                                    ); ?>

                                </a>

                            <?php endif; ?>

                            <div class="card-body">

                                <?php if ($specialties) : ?>

                                    <span class="badge bg-primary mb-2">

                                        <?php
                                        echo esc_html(
                                            $specialties[0]->name
                                        );
                                        ?>

                                    </span>

                                <?php endif; ?>

                                <h5 class="card-title mb-2">

                                    <a
                                        href="<?php the_permalink(); ?>"
                                        class="text-decoration-none text-dark">

                                        <?php the_title(); ?>

                                    </a>

                                </h5>

                                <?php if (!empty($qualification)) : ?>

                                    <div class="small text-muted mb-1">

                                        <?php echo esc_html($qualification); ?>

                                    </div>

                                <?php endif; ?>
                                <?php if (!empty($bmdc)) : ?>
                                    <div class="small text-muted mb-1">
                                        <i class="bi bi-patch-check"></i>
                                        BMDC: <?php echo esc_html($bmdc); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($experience)) : ?>
                                    <div class="small mb-1">
                                        <i class="bi bi-briefcase"></i>
                                        <?php echo esc_html($experience); ?>
                                        Years Experience

                                    </div>

                                <?php endif; ?>
                                <?php if (!empty($chambers)) : ?>
                                    <div class="small text-muted mb-1">
                                        <i class="bi bi-hospital"></i>
                                        <?php echo $count; ?> Chambers
                                    </div>
                                <?php endif; ?>

                                <a
                                    href="<?php the_permalink(); ?>"
                                    class="btn btn-outline-primary btn-sm">
                                    View Profile
                                </a>
                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else : ?>

                <div class="col-lg-12">
                    <div class="alert alert-warning">
                        No doctors found.
                    </div>

                </div>

            <?php endif; ?>

        </div>

        <!-- Pagination -->

        <?php if ($query->max_num_pages > 1) : ?>
            <?php
                $pagination = paginate_links([
                    'base'      => str_replace(
                        999999999,
                        '%#%',
                        esc_url(get_pagenum_link(999999999))
                    ),
                    'format'    => '?paged=%#%',
                    'current'   => max(1, get_query_var('paged')),
                    'total'     => $query->max_num_pages,
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'type'      => 'array'
                ]);
                if ($pagination) :
            ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php foreach ($pagination as $page) : ?>
                            <?php
                                $active = strpos($page, 'current') !== false;
                                $disabled = strpos($page, 'dots') !== false;
                            ?>
                            <li class="page-item <?php echo $active ? 'active' : ''; ?> <?php echo $disabled ? 'disabled' : ''; ?>">
                                <?php echo str_replace('page-numbers','page-link',$page);?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

</section>

<?php get_footer(); ?>