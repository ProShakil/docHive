<?php
get_header();

$term = get_queried_object();
$specialties_page = get_page_by_path('specialties');
$specialties_url = $specialties_page
    ? get_permalink($specialties_page->ID)
    : home_url('/');
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
                <li class="breadcrumb-item">
                    <a href="<?php echo esc_url($specialties_url); ?>" class="text-warning text-decoration-none">
                        Specialties
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">
                    <?php echo esc_html($term->name); ?>
                </li>
            </ol>
        </nav>
        <span class="doctor-count text-white">
            <?php echo $term->count; ?> Doctors Found
        </span>
    </div>
</section>

<section class="dochive-page-content py-5">
    <div class="container">
        <div class="row g-4">

            <?php if (have_posts()) : ?>

                <?php 
                    while (have_posts()) : the_post(); 
                    $specialties = get_the_terms(get_the_ID(), 'specialty');
                    $qualification = get_post_meta(get_the_ID(), '_qualification', true);
                    $experience = get_post_meta(get_the_ID(),'_experience', true);
                    $experience = get_post_meta(get_the_ID(),'_experience',true);
                    $bmdc = get_post_meta(get_the_ID(),'_registration',true);
                    $chambers = get_post_meta(get_the_ID(),'_doctor_chambers',true);
                    $count = is_array($chambers) ? count($chambers) : 0;
                
                
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
                                    <?php echo esc_html($specialties[0]->name);?>
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
                    <div class="alert alert-warning text-center rounded-4 py-4">
                        No doctors found in this specialty.
                    </div>
                </div>

            <?php endif; ?>

        </div>
        <?php
            global $wp_query;
            if ($wp_query->max_num_pages > 1) :
                $pagination = paginate_links([
                    'base'      => str_replace(
                        999999999,
                        '%#%',
                        esc_url(get_pagenum_link(999999999))
                    ),
                    'format'    => '?paged=%#%',
                    'current'   => max(1, get_query_var('paged')),
                    'total'     => $wp_query->max_num_pages,
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'type'      => 'array'
                ]);

            if ($pagination) :
        ?>

        <nav class="mt-5">

            <ul class="pagination justify-content-center">

                <?php foreach ($pagination as $page) :

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

        <?php
            endif;
            endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>