<?php get_header(); ?>

<?php

$paged = max(1, get_query_var('paged'));

$args = [
    'post_type'      => 'doctor',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged,
];

/*
|--------------------------------------------------------------------------
| Search By Doctor Name
|--------------------------------------------------------------------------
*/

if (!empty($_GET['doctor_name'])) {
    $args['s'] = sanitize_text_field($_GET['doctor_name']);
}

/*
|--------------------------------------------------------------------------
| Specialty Filter
|--------------------------------------------------------------------------
*/

if (!empty($_GET['specialty'])) {

    $args['tax_query'] = [
        [
            'taxonomy' => 'specialty',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['specialty'])
        ]
    ];
}

/*
|--------------------------------------------------------------------------
| District Filter
|--------------------------------------------------------------------------
*/

if (!empty($_GET['district'])) {

    $district = sanitize_text_field($_GET['district']);

    $matched_ids = [];

    $doctor_ids = get_posts([
        'post_type'      => 'doctor',
        'posts_per_page' => -1,
        'fields'         => 'ids'
    ]);

    foreach ($doctor_ids as $doctor_id) {

        $chambers = get_post_meta(
            $doctor_id,
            '_doctor_chambers',
            true
        );

        if (!is_array($chambers)) {
            continue;
        }

        foreach ($chambers as $chamber) {

            if (
                !empty($chamber['district']) &&
                strtolower(trim($chamber['district'])) === strtolower(trim($district))
            ) {
                $matched_ids[] = $doctor_id;
                break;
            }
        }
    }

    $args['post__in'] = empty($matched_ids)
        ? [0]
        : $matched_ids;
}

/*
|--------------------------------------------------------------------------
| Query
|--------------------------------------------------------------------------
*/

$query = new WP_Query($args);

/*
|--------------------------------------------------------------------------
| Specialty List
|--------------------------------------------------------------------------
*/

$specialties = get_terms([
    'taxonomy'   => 'specialty',
    'hide_empty' => false
]);

/*
|--------------------------------------------------------------------------
| District List
|--------------------------------------------------------------------------
*/

$districts = [];

$doctor_ids = get_posts([
    'post_type'      => 'doctor',
    'posts_per_page' => -1,
    'fields'         => 'ids'
]);

foreach ($doctor_ids as $doctor_id) {

    $chambers = get_post_meta(
        $doctor_id,
        '_doctor_chambers',
        true
    );

    if (!is_array($chambers)) {
        continue;
    }

    foreach ($chambers as $chamber) {

        if (!empty($chamber['district'])) {

            $districts[] = trim(
                $chamber['district']
            );
        }
    }
}

$districts = array_unique($districts);

sort($districts);

?>
<section class="doctor-hero d-flex align-items-center">

    <div class="container text-center text-white">
        
        <h1 class="display-4 fw-bold mb-3">
            Find Your Doctor
        </h1>

        <p class="lead mb-0">
            Search doctors by specialty and district
        </p>
        <nav aria-label="breadcrumb" class="mb-3" style="--bs-breadcrumb-divider: '›';">

            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo home_url(); ?>" class="text-warning text-decoration-none">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item active text-white">
                    Doctors
                </li>

            </ol>

        </nav>
    </div>
</section>
<section class="pb-5">

    <div class="container">

        <div class="search-wrapper">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-body p-4">

                    <!-- Search Form -->

                    <form method="GET" class="">

                        <div class="row g-3">

                            <div class="col-lg-4">

                                <input
                                    type="text"
                                    name="doctor_name"
                                    class="form-control"
                                    placeholder="Search Doctor Name"
                                    value="<?php echo esc_attr($_GET['doctor_name'] ?? ''); ?>">

                            </div>

                            <div class="col-lg-3">

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

                            <div class="col-lg-3">

                                <select
                                    name="district"
                                    class="form-select">

                                    <option value="">
                                        All Districts
                                    </option>

                                    <?php foreach ($districts as $district) : ?>

                                        <option
                                            value="<?php echo esc_attr($district); ?>"
                                            <?php selected(
                                                $_GET['district'] ?? '',
                                                $district
                                            ); ?>>

                                            <?php echo esc_html($district); ?>

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
                </div>

            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 mt-5">

            <div>

                <h2 class="fw-bold mb-1">
                    Available Doctors
                </h2>

                <div class="doctor-count">

                    <?php echo number_format($query->found_posts); ?>
                    Doctors Found

                </div>

            </div>

        </div>

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

                    $bmdc = get_post_meta(
                        get_the_ID(),
                        '_registration',
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

                    ?>

                    <div class="col-xl-3 col-lg-4 col-md-6">

                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden doctor-card">

                            <?php if (has_post_thumbnail()) : ?>

                                <a href="<?php the_permalink(); ?>">

                                    <?php the_post_thumbnail(
                                        'medium',
                                        [
                                            'class' => 'card-img-top img-fluid'
                                        ]
                                    ); ?>

                                </a>

                            <?php endif; ?>

                            <div class="card-body">

                                <?php if ($specialties) : ?>

                                    <span class="badge rounded-pill bg-primary mb-2 px-3 py-2">

                                        <?php
                                        echo esc_html(
                                            $specialties[0]->name
                                        );
                                        ?>

                                    </span>

                                <?php endif; ?>

                                <h5 class="card-title">

                                    <a
                                        href="<?php the_permalink(); ?>"
                                        class="text-decoration-none text-dark">

                                        <?php the_title(); ?>

                                    </a>

                                </h5>

                                <?php if (!empty($qualification)) : ?>

                                    <div class="small text-muted mb-2">

                                        <?php echo esc_html($qualification); ?>

                                    </div>

                                <?php endif; ?>

                                <?php if (!empty($bmdc)) : ?>

                                    <div class="small text-muted mb-2">

                                        <i class="bi bi-patch-check"></i>

                                        BMDC:
                                        <?php echo esc_html($bmdc); ?>

                                    </div>

                                <?php endif; ?>

                                <?php if (!empty($experience)) : ?>

                                    <div class="small text-muted mb-2">

                                        <i class="bi bi-briefcase"></i>

                                        <?php echo esc_html($experience); ?>
                                        Years Experience

                                    </div>

                                <?php endif; ?>

                                <div class="small text-muted mb-3">

                                    <i class="bi bi-hospital"></i>

                                    <?php echo esc_html($count); ?>
                                    Chambers

                                </div>

                                <a
                                    href="<?php the_permalink(); ?>"
                                    class="btn btn-primary w-100">

                                    View Profile

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else : ?>

                <div class="col-12">

                    <div class="alert alert-warning text-center py-4 rounded-4">

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

                                <?php
                                echo str_replace(
                                    'page-numbers',
                                    'page-link',
                                    $page
                                );
                                ?>

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