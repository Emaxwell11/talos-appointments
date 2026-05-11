
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
                <h3>PaymentIntent</h3>
                <!--<p><a href="https://dashboard.stripe.com/test/payments/<?= $paymentIntents->id; ?>" target="_blank">Dashboard</a></p>-->
                <p>ID <?= $paymentIntents->id; ?></p>
                <p>Status: <?= $paymentIntents->status; ?></p>
                <p>Amount: <?= $paymentIntents->amount; ?></p>
                <p>Currency: <?= $paymentIntents->currency; ?></p>
                <p>Payment Method: <?= $paymentIntents->payment_method; ?></p>
            </div> 
        </div> 
    </div>
</section>
