<div class="Parallax-Hero">

    <?php
    global $post;
    $args = array(
        'post_type' => 'bs_slides',
        'meta_key'  => 'slide_position',
        'orderby'  => 'meta_value_num',
        'order'     => 'ASC'
    );
    $slides = new WP_Query($args);
    $pageClass = 1;
    ?>

    <!--add single slide-->

    <?php if ($slides->have_posts()): while ($slides->have_posts()) : $slides->the_post(); ?>

    <section class="Parallax-panel page<?php echo $pageClass++; ?>">
        <div class="Parallax-background" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>
        <div class="Parallax-wrapper ">
            <div class="bs-content">
                <p class="bs-title" style="color:<?php echo get_post_meta( $post->ID, 'header_color', true ); ?>;">
                    <?php the_title(); ?>
                </p>
                <div class="bs-text" style="color:<?php echo get_post_meta( $post->ID, 'content_color', true ); ?>;">
                    <?php the_content(); ?>
                </div>
                <a style="color:<?php echo get_post_meta($post->ID, 'link_color', 1); ?>;" class="bs-link" href="<?php echo get_post_meta( $post->ID, 'link', true ); ?>">
                    <?php echo get_post_meta( $post->ID, 'link_text', true ); ?>
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
</section>

<?php endwhile; ?>
<?php endif; ?>

<!--end of slide add section-->
<!--***-->
<!--navigation buttons-->

<nav class="Parallax-wayfinder">
    <div class="Parallax-pagination Parallax-pagination--dots ">
        <?php if ($slides->have_posts()): while ($slides->have_posts()) : $slides->the_post(); ?>
            <span class="Parallax-pagination--dot"></span>
        <?php endwhile; ?>
        <?php endif; ?>
    </div>
</nav>

<!--end of navigation buttons-->
<!--***-->
<!--add div for every slide-->

<?php if ($slides->have_posts()): while ($slides->have_posts()) : $slides->the_post(); ?>
    <div class="Parallax-spacer"></div>
<?php endwhile; ?>
<?php endif; ?>

<!--end of add div-->

</div>


