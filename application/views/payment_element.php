
<?php if (empty($company->image)):?>
    <?php $bg_image = base_url('assets/front/img/vericla-cover.jpg'); ?>
<?php else: ?>
    <?php $bg_image = base_url($company->image);?>
<?php endif; ?>

<section class="py-md-10 bannerimg overlay overlay-black overlay-40"
    style="background-image: url(<?php echo html_escape($bg_image) ?>);">
    <div class="container pt-12 ">
        <div class="row align-items-center justify-content-center text-center min-height-lg-35vh">
            <div class="col-md-10 col-lg-7">
                <h1 class="display-5 mb-0 text-light font-weight-bold"><?php echo html_escape($company->name) ?></h1>
                <h1 class="display-7 mb-4 text-light font-weight-bold"><?php echo html_escape($company->title) ?></p></h1>
                <?php if(!empty($services)): ?>
                    <a href="<?php echo base_url('booking/'.$company->slug) ?>" class="btn btn-primary btn-md mt-4 rounded-pill "><i class="fas fa-calendar-alt"></i> <?php echo trans('book-now') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section>
    <?php if (isset($products[0]['status']) && $products[0]['status'] != 'active'): ?>
    <div class="container">
        <h2 class="text-center">Payment Link</h2>
        <div class="row d-flex justify-content-center">
           This link has been diactivated by the merchant
        </div>
      </div>
    <?php else: ?>
      <div class="container">
        <h2 class="text-center">Payment Link</h2>
        <div class="card">
            <div class="row d-flex justify-content-center">
                <!--<?php foreach ($products as $product): ?>-->
                <!--    <div class="col-md-6">-->
                <!--        <div class=" h-100">-->
                <!--            <img src="<?= base_url('uploads/' . $product['image']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">-->
                <!--            <div class="card-body">-->
                <!--                <h5 class="card-title"><?= $product['product_name'] ?></h5>-->
                <!--                <p class="card-text"><?= $product['product_description'] ?></p>-->
                <!--                <p class="card-text"><?= $product['category'] ?></p>-->
                <!--                <p class="card-text"><?= $product['currency']. $product['price_min']. "-" .$product['price_max'] ?></p>	-->
                <!--                <p class="card-text">$<?= number_format($product['price'], 2) ?></p>-->
                <!--                <button class="btn btn-primary" data-toggle="modal" data-target="#paymentModal" data-product-id="<?= $product['id'] ?>">Proceed</button>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--<?php endforeach; ?>-->

                <div class="col-md-12">
                    <div class="">
                        <div class="card-body">
                            <form id="payment-form">
                            
                                <!-- Stripe's Payment Element -->
                                <div id="payment-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                            
                                <!-- Error message display -->
                                <div id="payment-errors" role="alert"></div>
        
                                <!-- csrf token -->
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                <button type="submit" class="btn btn-primary mb-3">Proceed to Payment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    <?php endif; ?>

</section>

<script src="https://js.stripe.com/v3/"></script>

<script>
    
    document.addEventListener('DOMContentLoaded', async () => {
        // Initialize Stripe.js with your publishable key
        //  alert("ywk")
        const stripe = Stripe('<?= $this->config->item('stripe_key'); ?>');
        
        // Get the client secret from the backend
        const clientSecret = '<?= $client_secret ?>';

        // Initialize Elements with the client secret
        const elements = stripe.elements({ clientSecret });

        // Create and mount the PaymentElement
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
        const paymentForm = document.querySelector('#payment-form');
        paymentForm.addEventListener('submit', async (e) => {
          // Avoid a full page POST request.
          e.preventDefault();

          // Disable the form from submitting twice.
          paymentForm.querySelector('button').disabled = true;

          // Confirm the card payment that was created server side:
          const {error} = await stripe.confirmPayment({
            elements,
            confirmParams: {
              return_url: '<?= base_url('/return') ?>'
            }
          });
          if(error) {
            addMessage(error.message);

            // Re-enable the form so the customer can resubmit.
            paymentForm.querySelector('button').disabled = false;
            return;
          }
        });
    });
</script>
