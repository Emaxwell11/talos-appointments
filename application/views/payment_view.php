
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
                <?php foreach ($products as $product): ?>
                    <div class="col-md-6">
                        <div class=" h-100">
                            <img src="<?= base_url('uploads/' . $product['image']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['product_name'] ?></h5>
                                <p class="card-text"><?= $product['product_description'] ?></p>
                                <p class="card-text"><?= $product['category'] ?></p>
                                <p class="card-text"><?= $product['currency'] ?> <span id="price">0.00</span></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="col-md-6">
                    <div class="">
                        <?php echo validation_errors(); ?>
                        <div class="card-body">
                            <?php if (isset($post_method) && $post_method == 'checkout'):?>
                                <form action="<?= base_url('/create_checkout_session') ?>" method="POST" enctype="multipart/form-data" class="validate-form" role="form" novalidate>
                            <?php elseif (isset($post_method) && $post_method == 'element'): ?>
                                <form action="<?= base_url('/element_return') ?>" method="POST" enctype="multipart/form-data" class="validate-form" id="payment-form" role="form" novalidate> 
                            <?php endif; ?>
                                <!-- Set Price -->
                                <div class="form-group">
                                    <label for="set_price">Amount</label>
                                    <input type="text" name="customer_price" id="set_price" class="form-control" placeholder="Input an amount">
                                    <p id="error_message" class="text-danger small pt-2" style="display:none;">
                                        <i class="fas fa-info-circle"></i> <span id="error_text"></span>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="product_id" id="product_id" value="<?= $product_id ?>" class="form-control">
                                </div>
                                
                            
                                <!-- Payment Modal Type -->
                                <div class="form-group clearfix">
                                    <label>Customer Profile</label><br>
                                    <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                                        <input type="radio" id="radioPrimary3" value="old" name="payment_modal_type">
                                        <label for="radioPrimary3"> Existing customer </label>
                                    </div>
                                    <div class="icheck-primary radio radio-inline d-inline">
                                        <input type="radio" id="radioPrimary4" value="new" name="payment_modal_type">
                                        <label for="radioPrimary4"> New customer </label>
                                    </div>
                                </div>
                            
                                <!-- Customer Selection or Creation -->
                                <div id="stripeLogo" style="display:none;">
                                    <div class="form-group">
                                        <label for="new_customer_id">Email</label>
                                        <input type="text" name="customer_id" id="new_customer_id" class="form-control" placeholder="Input your email address">
                                        <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> Enter a previously used email address</p>
                                    </div>
                                </div>
                            
                                <div id="paypalLogo" style="display:none;">
                                    <div class="form-group">
                                        <label for="new_customer_name">Name</label>
                                        <input type="text" name="name" id="new_customer_name" class="form-control" placeholder="Input your names">
                                        <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> First name and Last name</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_customer_email">Email</label>
                                        <input type="text" name="email" id="new_customer_email" class="form-control" placeholder="Input your email address">
                                        <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> Use a valid existing email address</p>
                                    </div>
                                </div>
                            
                                <!-- Stripe's Payment Element -->
                                <div id="payment-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                            
                                <!-- Error message display -->
                                <div id="payment-errors" role="alert"></div>
        
                                <!-- csrf token -->
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                <button type="submit" class="btn btn-primary mb-3" id="submit_button" disabled>Proceed to payment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    <?php endif; ?>

    
    <!--<div class="container mt-5" style="display: <?php echo (isset($products[0]['status']) && $products[0]['status'] == 'active') ? 'block' : 'none'; ?>;">-->

</section>

<script src="https://js.stripe.com/v3/"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    $(document).ready(function(){
        // alert("ywk")
        $('#stripeLogo, #paypalLogo').hide();
        
        $('input[name="payment_modal_type"]').change(function() {
            $('#stripeLogo, #paypalLogo').hide();

            if($('#radioPrimary3').prop('checked')) {
                $('#stripeLogo').show();
            }
            if($('#radioPrimary4').prop('checked')) {
                $('#paypalLogo').show();
            }
        });

    });
    
    document.getElementById('set_price').addEventListener('focus', function() {
        const priceMin = <?= $product['price_min'] ?>;
        const priceMax = <?= $product['price_max'] ?>;
        const errorMessage = document.getElementById('error_message');
        const errorText = document.getElementById('error_text');
        const submitButton = document.getElementById('submit_button');
        const radioButtons = document.querySelectorAll('input[name="payment_modal_type"]');
        const priceSpan = document.getElementById('price'); // reference to the price span
    
        // Function to check if any radio button is checked
        function isRadioChecked() {
            return Array.from(radioButtons).some(radio => radio.checked);
        }
    
        // Function to enable/disable the button based on the conditions
        function toggleButtonState() {
            const inputValue = parseFloat(document.getElementById('set_price').value);
            if (isNaN(inputValue) || inputValue < priceMin || inputValue > priceMax || !isRadioChecked()) {
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }
    
        // Event listener for input changes
        this.addEventListener('input', function() {
            const inputValue = parseFloat(this.value);
            
            if (this.value === '') {
                // If input is erased, reset the price span to default color and clear error messages
                priceSpan.textContent = '0.00';  // Reset the displayed price to 0.00
                priceSpan.style.color = '';  // Reset the color to default
                errorMessage.style.display = 'none';  // Hide error message
                // document.getElementById('set_price').value = '0.00';  // Set the input field to 0.00
                toggleButtonState();  // Re-check button state
                return;
            }
            
            if (isNaN(inputValue)) {
                // If input is not a number, hide the error message and disable the button
                errorMessage.style.display = 'none';
                toggleButtonState();
                return;
            }
            
            const formattedValue = new Intl.NumberFormat('en-US', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(inputValue);
            
            priceSpan.textContent = formattedValue;
            priceSpan.style.color = ''; 
            
            if (inputValue < priceMin) {
                // Show error message if the value is less than the minimum
                errorText.textContent = `The minimum amount is ${priceMin}.`;
                errorMessage.style.display = 'block';
                priceSpan.style.color = 'red';
            } else if (inputValue > priceMax) {
                // Show error message if the value is greater than the maximum
                errorText.textContent = `The maximum amount is ${priceMax}.`;
                errorMessage.style.display = 'block';
                priceSpan.style.color = 'red';
            } else {
                // Hide error message if the input value is valid
                errorMessage.style.display = 'none';
            }
    
            // Re-check button state after input validation
            toggleButtonState();
        });
    
        // Event listener for radio buttons to check if one is selected
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                toggleButtonState();
            });
        });
    });


    
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
