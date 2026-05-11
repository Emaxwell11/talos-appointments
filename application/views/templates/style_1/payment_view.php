
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
    <div class="alert alert-danger mt-5" role="alert">
    </div>
    <?php else: ?>
        <div class="container mt-5">
        <?= 'business is ' .$business_id; ?>
        <?= 'slug is ' .$slug; ?>
        <h2>Select a Product</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= base_url('uploads/' . $product['image']) ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['product_name'] ?></h5>
                            <p class="card-text"><?= $product['product_description'] ?></p>
                            <p class="card-text"><?= $product['category'] ?></p>
                            <p class="card-text"><?= $product['currency']. $product['price_min']. "-" .$product['price_max'] ?></p>	
                            <p class="card-text">$<?= number_format($product['price'], 2) ?></p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#paymentModal" data-product-id="<?= $product['id'] ?>">Proceed</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    
    <!--<div class="container mt-5" style="display: <?php echo (isset($products[0]['status']) && $products[0]['status'] == 'active') ? 'block' : 'none'; ?>;">-->
    
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
                    <form action="<?= base_url('checkout/'.$post_method); ?>" method="POST">
                        <input type="hidden" name="product_id" id="product_id" value="">
                        <div class="form-group">
                            <label for="customer_id">Select Customer</label>
                            <select name="customer_id" id="customer_id" class="form-control">
                                <option value="">Select a customer</option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer->stripe_customer_id ?>"><?= $customer->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="new_customer_name">Add New Customer</label>
                            <input type="text" name="new_customer_name" id="new_customer_name" class="form-control" placeholder="Enter customer name">
                        </div>

                        <!-- csrf token -->
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>