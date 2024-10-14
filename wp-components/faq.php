<?php
/* Template Name: FAQ */
get_header();
?>

<section class="faq-bnner" style="background-image:url('<?php echo get_template_directory_uri().'/images/about-banner.png' ?>')">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-10 m-auto hero-section">
                <h1 class="font-bold text-white text-center"> frequently asked questions </h1>
            </div>
        </div>
    </div>
</section>

<!-- FAQ-section -->
<section class="section-gap">
    <div class="container">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <?php if( have_rows('faq_section') ){
            $id= 1 ;
            while( have_rows('faq_section') ) { the_row();
            ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading<?php echo $id;?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse<?php echo $id;?>" aria-expanded="false"
                        aria-controls="flush-collapse<?php echo $id;?>">
                        <?php the_sub_field('faq_title'); ?>
                    </button>
                </h2>
                <div id="flush-collapse<?php echo $id;?>" class="accordion-collapse collapse"
                    aria-labelledby="flush-heading<?php echo $id;?>" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body"><?php the_sub_field('faq_content'); ?></div>
                </div>
            </div>
            <?php
    $id++ ;
        }
    }
    ?>
        </div>
    </div>
</section>


<?php
get_footer();
?>

<!-- button text with link in acf field -->
        <?php
       $banner_btn = get_field('button');
        ?>
        <div class="btn_wrapper">
            <a href="<?php echo $banner_btn['url']; ?>" target="_blank" class="button"> <?php echo $banner_btn['title']; ?></a>
        </div>