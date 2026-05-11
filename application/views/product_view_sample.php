<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Select a Product</h2>
        <div class="row">
            <!-- Dummy Product Example -->
            <div class="col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Dummy Product">
                    <div class="card-body">
                        <h5 class="card-title">Dummy Product</h5>
                        <p class="card-text">This is a dummy product for testing the payment process.</p>
                        <p class="card-text">$49.99</p>
                        <!-- Trigger the modal when the "Pay Now" button is clicked -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#paymentModal" data-product-id="1">Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Checkout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('checkout/create_checkout_session'); ?>" method="post">
                        <input type="hidden" name="product_id" id="product_id" value="1">
                        <div class="form-group">
                            <label for="customer_id">Select Customer</label>
                            <select name="customer_id" id="customer_id" class="form-control">
                                <option value="">Select a customer</option>
                                <!-- Example of existing customers (you can dynamically populate this) -->
                                <option value="cus_J8k4dS7Ppphvn3">John Doe</option>
                                <option value="cus_J8k4dS7Ppphvn4">Jane Smith</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="new_customer_name">Add New Customer</label>
                            <input type="text" name="new_customer_name" id="new_customer_name" class="form-control" placeholder="Enter customer name">
                        </div>

                        <div class="row">
                        
                            <div class="col-md-12 center">
                                <!-- csrf token -->
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                                <!--<button type="submit" class="btn btn-primary btn-block mt-4 mb-0 signin_btn"><?php echo trans('sign-in') ?> </button>-->
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Script -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Set the product ID in the modal dynamically
        $('#paymentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);  // Button that triggered the modal
            var productId = button.data('product-id');  // Extract product ID
            var modal = $(this);
            modal.find('#product_id').val(productId);  // Set the product ID to the hidden input
        });
    </script>
</body>
</html>
