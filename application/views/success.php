
<?php $bg_image = base_url('assets/front/img/vericla-cover.jpg'); ?>

<section class="py-md-10 bannerimg overlay overlay-black overlay-40"
    style="background-image: url(<?php echo html_escape($bg_image) ?>);">
    <div class="container pt-12 ">
        <div class="row align-items-center justify-content-center text-center min-height-lg-35vh">
            <div class="col-md-10 col-lg-7">
                <h1 class="display-5 mb-0 text-light font-weight-bold"><?php echo html_escape($slug) ?></h1>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2 class="text-center">Payment Link</h2>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                     <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Your payment was successful </h2>
                   <p> Thank you for your payment. we will <br>
be in contact with more details shortly </p>      
            </div> 
        </div> 
    </div>
</section>
