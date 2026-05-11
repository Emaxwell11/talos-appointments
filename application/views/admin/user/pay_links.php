<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- service area -->
        <?php if (isset($page_title) && $page_title != "Edit Category"): ?>
          <div class = "col-md-12">
 
            <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
                <div class="card-header with-border">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2"><?php echo trans('edit') ?></h3>
                  <?php else: ?>
                    <h3 class="card-title pt-2"><?php echo trans('create-new') ?> </h3>
                  <?php endif; ?>

                  <div class="card-tools pull-right">
                    <?php if (isset($page_title) && $page_title == "Edit"): ?>
                      <a href="<?php echo base_url('admin/paylinks') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>
                    <?php else: ?>
                      <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm"><?php echo trans('pay-links') ?></a>
                    <?php endif; ?>
                  </div>
                </div>


                <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/paylinks/add')?>" role="form" novalidate>
                  <div class="card-body">

                    <div class="form-group">
                      <label><?php echo trans('product-name') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="product_name" value="<?php if(isset($paylinks[0]['product_name'])){echo html_escape($paylinks[0]['product_name']);} ?>" >
                    </div>
                    <div class="form-group">
                      <label><?php echo trans('product-description') ?> <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" required name="product_description" value="<?php if(isset($paylinks[0]['product_description'])){echo html_escape($paylinks[0]['product_description']);} ?>" >
                    </div>
                    
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script type="text/javascript">
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
                    
                            $('input[name="status"]:checked').change();
                        });
                    </script>
                    
                   <script type="text/javascript">
                      document.addEventListener("DOMContentLoaded", function() {
                        //   alert("welcome")
                        const categorySelect = document.querySelector("select[name='category']");
                        const categoryInput = document.querySelector("input[name='payment_description']");
                    
                        const categories = <?php echo json_encode($categoriesx); ?>;
                        const categoryMap = categories.reduce(function(acc, category) {
                          acc[category.name] = category.details;
                          return acc;
                        }, {});
                    
                        categorySelect.addEventListener("change", function() {
                          const selectedCategoryId = categorySelect.value;
                    
                          if (selectedCategoryId && categoryMap[selectedCategoryId]) {
                            categoryInput.value = categoryMap[selectedCategoryId];
                          } else {
                            categoryInput.value = ''; // Clear if no category selected
                          }
                        });
                      });
                      
                    </script>

                    
                    <div class="row mt-4 mb-2">

                      <div class="col-md-6 ">
                          <div class="form-group">
                            <label class="control-label" for="example-input-normal"><?php echo trans('category') ?> <span class="text-danger">*</span></label>
                            <select class="form-control" name="category">
                                <option value=""><?php echo trans('select') ?></option>
                                <?php foreach ($categoriesx as $category): ?>
                                    <option value="<?php echo html_escape($category->name); ?>" 
                                      <?php echo (isset($paylinks[0]['category']) && $paylinks[0]['category'] == $category->name) ? 'selected' : ''; ?>>
                                      <?php echo html_escape($category->name); ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                          </div>
                      </div>
                        
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo trans('currency') ?> <span class="text-danger">*</span></label>
                          <select class="form-control" name="currency">
                            <option value=""><?php echo trans('select') ?></option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo html_escape($country->currency_code); ?>" 
                                  <?php echo (isset($paylinks[0]['currency']) && $paylinks[0]['currency'] == $country->currency_code) ? 'selected' : ''; ?>>
                                  <?php echo html_escape($country->currency_code); ?>
                                </option>
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                        
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo trans('price-min') ?> <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <input type="number" class="form-control" name="price_min" value="<?php if(isset($paylinks[0]['price_min'])){echo html_escape($paylinks[0]['price_min']);} ?>" required>
                          </div>
                          <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> Set a minimum amount</p>
                        </div>
                      </div>
                        
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><?php echo trans('price-max') ?> <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <input type="number" class="form-control" name="price_max" value="<?php if(isset($paylinks[0]['price_max'])){echo html_escape($paylinks[0]['price_max']);} ?>" required>
                          </div>
                          <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> Set a maximum amount</p>
                        </div>
                      </div>

                    </div>
                    <div class="form-group">
                      <label><?php echo trans('payment-description') ?> <span class="text-danger">*</span></label>
                      <input type="text" readonly class="form-control" required name="payment_description" value="<?php if(isset($paylinks[0]['payment_description'])){echo html_escape($paylinks[0]['payment_description']);} ?>" >
                      <p class="text-muted small pt-2"><i class="fas fa-info-circle"></i> Select a category to get description</p>
                    </div>
                    <div class="form-group clearfix">
                      <label><?php echo trans('status') ?></label><br>

                      <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                        <input type="radio" id="radioPrimary5" value="active" name="status" <?php if(isset($paylinks[0]['status']) && $paylinks[0]['status'] == 'active'){echo "checked";} ?>>
                        <label for="radioPrimary5"> <?php echo trans('active') ?>
                        </label>
                      </div>

                      <div class="icheck-primary radio radio-inline d-inline">
                        <input type="radio" id="radioPrimary6" value="inactive" name="status" <?php if(isset($paylinks[0]['status']) && $paylinks[0]['status'] == 'inactive'){echo "checked";} ?>>
                        <label for="radioPrimary6"> <?php echo trans('inactive') ?>
                        </label>
                      </div>
                    </div>
                    
                    <div class="form-group clearfix" style=" <?php if(isset($paylinks[0]['payment_modal_type'])){echo "display:none";} ?>">
                      <label><?php echo trans('payment-modal-type') ?></label><br>
                      <div class="icheck-primary radio radio-inline d-inline mr-4 mt-2">
                        <input type="radio" id="radioPrimary3" value="element" name="payment_modal_type" <?php if(isset($paylinks[0]['payment_modal_type']) && $paylinks[0]['payment_modal_type'] == 'element'){echo "checked";} ?>>
                        <label for="radioPrimary3"> <?php echo trans('payment-element') ?>
                        </label>
                      </div>

                      <div class="icheck-primary radio radio-inline d-inline">
                        <input type="radio" id="radioPrimary4" value="checkout" name="payment_modal_type" <?php if(isset($paylinks[0]['payment_modal_type']) && $paylinks[0]['payment_modal_type'] == 'checkout'){echo "checked";} ?>>
                        <label for="radioPrimary4"> <?php echo trans('payment-checkout') ?>
                        </label>
                      </div>
                    </div>
                 <!-- Payment Plan Logos -->
                    <div id="stripeLogo" class="rounded" style="display:none;">
                        <img src="https://us1.discourse-cdn.com/bubble/original/3X/5/8/58346b17fb5d561fd2842ae0c6c874a58355b789.png" alt="Stripe Logo" width="400" height="400">
                    </div>
                    
                    <div id="paypalLogo" class="rounded" style="display:none;">
                        <img src="https://b.stripecdn.com/docs-statics-srv/assets/checkout-hosted-hover.180c6ab2498a8c65daefb5bedae835bf.png" width="400" height="400" alt="PayPal Logo">
                    </div>
                  </div>

                  <div class="card-footer">
                    <input type="hidden" name="id" value="<?php if(isset($paylinks[0]['id'])){echo html_escape($paylinks[0]['id']);} ?>">
                    <!-- csrf token -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                    <?php if (isset($page_title) && $page_title == "Edit"): ?>
                      <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save-changes') ?></button>
                      <?php else: ?>
                        <button type="submit" class="btn btn-primary pull-left"> <?php echo trans('save') ?></button>
                      <?php endif; ?>
                    </div>

                </form>

            </div>

            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header with-border">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/services') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                    <?php else: ?>
                      <h3 class="card-title pt-2"><?php echo trans('services') ?> </h3>
                    <?php endif; ?>

                    <div class="card-tools pull-right">
                      <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                    </div>
                </div>

                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap <?php if(count($pay_links) > 10){echo "datatable";} ?>">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th><?php echo trans('product-name') ?></th>
                          <th><?php echo trans('product-description') ?></th>
                          <th><?php echo trans('category') ?></th>
                          <th><?php echo trans('payment-description') ?></th>
                          <th><?php echo trans('payment-modal-type') ?></th>
                          <th><?php echo trans('currency') ?></th>
                          <th><?php echo trans('price') ?></th>
                          <th><?php echo trans('status') ?></th>
                          <th><?php echo trans('pay-link') ?></th>
                          <th><?php echo trans('action') ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; foreach ($pay_links as $service): ?>
                        <tr id="row_<?php echo html_escape($service->id); ?>">

                          <td><?= $i; ?></td>
                          <td>
                            <p class="mb-1"><?php echo html_escape($service->product_name); ?></p>
                          </td>
                          <td>
                            <p class="mb-1"><?php echo html_escape($service->product_description); ?></p>
                          </td>
                          <td>
                            <span class="badge badge-primary"><?php if(isset($category)){echo html_escape($service->category);} ?></span>
                          </td>
                          <td>
                            <p class="mb-1"><?php echo html_escape($service->payment_description); ?></p>
                          </td>
                          <td>
                            <p class="mb-1"><?php echo html_escape($service->payment_modal_type); ?></p>
                          </td> 
                          <td>
                            <p class="mb-1"><?php echo html_escape($service->currency); ?>
                            </p>
                          </td>
                          <td>
                            <p class="p-0 m-0">
                                flexible
                              <!--<?php echo html_escape ($service->price_min); ?>-->
                            </p>
                          </td>
                          <td>
                            <p class="p-0 m-0">
                              <?php echo html_escape ($service->status); ?>
                            </p>
                          </td>
                          <td>
                            <p class="p-0 m-0">
                             <?php echo html_escape ($service->payment_link); ?>
                            </p>
                          </td>
                          <td class="actions">
                            <div class="btn-group">
                              <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <!--<a type="button" data-toggle="modal" data-target="#exampleModal" href="#exampleModal<?php echo $i ?>" class="dropdown-item"><?php echo trans('reviews') ?></a>-->
                                <a type="button" data-toggle="modal" data-target="#exampleModal" href="#"  class="dropdown-item" data-service-id="<?php echo $service->id ?>"><?php echo trans('reviews') ?></a>

                                <a href="<?php echo base_url('admin/paylinks/edit/'.html_escape($service->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
                                
                                <a data-val="Category" data-id="<?php echo html_escape($service->id); ?>" href="<?php echo base_url('admin/paylinks/delete/'.html_escape($service->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                              </div>
                            </div>
                          </td>
                        </tr>

                        <?php $i++; endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            <?php endif; ?>

          </div>
        <?php endif; ?>
        

      </div>
    </div>
  </div>
  
  <!--<script>-->
    
  <!--  $(document).on('click', 'a[data-toggle="modal"]', function () {-->
  <!--      var serviceId = $(this).data('service-id');-->
  <!--      var pageUrl = '<?php echo base_url("admin/paylinks/get_transactions/") ?>' + serviceId;-->
        console.log("Requesting pageUrl:", pageUrl); // 👈 Add this line
  <!--      var BASE_URL = '<?= base_url(); ?>';-->
        console.log("Requesting BASE_URL:", BASE_URL); // 👈 Add this line
  <!--      var transactionTable = $('#transaction-list');-->
        
        // 1. Immediately show loading message
  <!--      transactionTable.html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');-->
        
  <!--      $.ajax({-->
  <!--          url: pageUrl,-->
  <!--          method: 'GET',-->
  <!--          success: function (data) {-->
  <!--              try {-->
  <!--                  var transactions = JSON.parse(data);-->
  <!--                  transactionTable.empty();-->
    
                    // if (transactions.length === 0) {
                    //     transactionTable.append('<tr><td colspan="4">No transactions found.</td></tr>');
                    // } else {
                    //     transactions.forEach(function (transaction) {
                    //         var row = '<tr>' +
                    //             '<td>' + transaction.product_id + '</td>' +
                    //             '<td>' + transaction.price + '</td>' +
                    //             '<td>' + transaction.status + '</td>' +
                    //             '<td>' + transaction.created_at + '</td>' +
                    //             '</tr>';
                    //         transactionTable.append(row);
                    //     });
                    // }
  <!--                  if (transactions.length === 0) {-->
  <!--                      transactionTable.append('<tr><td colspan="5" class="text-center">No transactions found.</td></tr>');-->
  <!--                  } else {-->
  <!--                      transactions.forEach(function (t) {-->
                            // prefer t.amount, fall back to t.price
  <!--                          var amount = typeof t.amount !== 'undefined' ? t.amount : t.price;-->
                            var id = t.id || t.transaction_id || product_id; // support either id field
                    
  <!--                          var invoiceUrl = BASE_URL + 'admin/paylinks/invoice/' + id;-->
  <!--                          var receiptUrl = BASE_URL + 'admin/paylinks/receipt/' + id + '?download=1';-->
                    
  <!--                          var row = '<tr>' +-->
  <!--                              '<td>' + id + '</td>' +-->
  <!--                              '<td>' + amount + '</td>' +-->
  <!--                              '<td>' + (t.status || '') + '</td>' +-->
  <!--                              '<td>' + (t.created_at || t.createdAt || '') + '</td>' +-->
  <!--                              '<td>' +-->
  <!--                                  '<a class="btn btn-sm btn-outline-primary mr-1" href="' + invoiceUrl + '" target="_blank">Generate invoice</a>' +-->
  <!--                                  '<a class="btn btn-sm btn-outline-success" href="' + receiptUrl + '">Download receipt</a>' +-->
  <!--                              '</td>' +-->
  <!--                          '</tr>';-->
                    
  <!--                          transactionTable.append(row);-->
  <!--                      });-->
  <!--                  }-->
  <!--              } catch (e) {-->
  <!--                  console.error("JSON parse error:", e);-->
  <!--                  transactionTable.html('<tr><td colspan="4" class="text-danger text-center">Error loading transactions.</td></tr>');-->
                    // alert('Invalid data format.');
  <!--              }-->
  <!--          },-->
  <!--          error: function (xhr, status, error) {-->
  <!--              console.error("AJAX error:", status, error);-->
  <!--              transactionTable.html('<tr><td colspan="4" class="text-danger text-center">Error loading transactions.</td></tr>');-->
                // alert('Error loading transactions.');
  <!--          }-->
  <!--          });-->
  <!--  });-->
  <!--</script>-->
  <script>
    var BASE_URL = '<?= base_url(); ?>';
    
    function renderTransactions(list) {
      var tbody = document.getElementById('transactionTable');
      tbody.innerHTML = '';
      if (!list || list.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No transactions found.</td></tr>';
        return;
      }
      list.forEach(function(t) {
        var id = t.id;
        var amount = t.amount;
        var currency = t.currency || 'NGN';
        var created = t.created_at || '';
        var status = t.status || '';
    
        var invoiceUrl = BASE_URL + 'admin/paylinks/invoice/' + id;
        var receiptUrl = BASE_URL + 'admin/paylinks/receipt/' + id + '?download=1';
    
        var tr = document.createElement('tr');
        tr.innerHTML =
          '<td>'+id+'</td>' +
          '<td>'+amount+'</td>' +
          '<td>'+currency+'</td>' +
          '<td>'+status+'</td>' +
          '<td>'+created+'</td>' +
          '<td>' +
            '<a class="btn btn-sm btn-outline-primary mr-1" target="_blank" href="'+invoiceUrl+'">Generate invoice</a>' +
            '<a class="btn btn-sm btn-outline-success" href="'+receiptUrl+'">Download receipt</a>' +
          '</td>';
        tbody.appendChild(tr);
      });
    }
    
    // Example modal trigger, adapt selector to yours
    $(document).on('click', '.open-transactions', function () {
      var userPayLinkId = $(this).data('user-pay-link-id'); // set this on your button
      $.getJSON('<?= base_url("admin/paylinks/transactions_by_paylink") ?>/'+userPayLinkId, function(resp) {
        renderTransactions(resp || []);
      });
    });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Transaction history</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                tbody id="transactionTable"></tbody>
                <!--<tbody id="transaction-list">-->
                    <!-- Rows will be injected here -->
                <!--</tbody>-->
            </table>
          </div>
          <!--<div class="modal-footer">-->
          <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
          <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
          <!--</div>-->
        </div>
      </div>
    </div>
    
    

<!--<script>-->
<!--    $(document).ready(function () {-->
<!--    // When the "reviews" button is clicked-->
<!--    $('a[data-toggle="modal"]').on('click', function () {-->
<!--        var serviceId = $(this).data('target').split('exampleModal')[1]; // Get the service ID from the modal ID-->
<!--        var pageUrl = '<?php echo base_url("admin/paylinks/get_transactions/") ?>' + serviceId,-->
        
<!--        // Perform an AJAX request to fetch the transactions for the clicked service-->
<!--        $.ajax({-->
<!--            url: pageUrl  // Adjust the URL to match your backend route-->
<!--            method: 'GET',-->
<!--            success: function (data) {-->
<!--                // Parse and populate the modal with transaction data-->
<!--                var transactions = JSON.parse(data);  // Assuming the data is in JSON format-->
<!--                var transactionTable = $('#transaction-list-' + serviceId);-->
<!--                transactionTable.empty();  // Clear the previous data-->

<!--                // Loop through transactions and append them to the table-->
<!--                transactions.forEach(function (transaction) {-->
<!--                    var row = '<tr>' +-->
<!--                        '<td>' + transaction.product_id + '</td>' +-->
<!--                        '<td>' + transaction.price + '</td>' +-->
<!--                        '<td>' + transaction.status + '</td>' +-->
<!--                        '<td>' + transaction.created_at + '</td>' +-->
<!--                        '</tr>';-->
<!--                    transactionTable.append(row);-->
<!--                });-->
<!--            },-->
<!--            error: function () {-->
<!--                alert('Error loading transactions.' );-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--});-->

<!--</script>-->




</div>



