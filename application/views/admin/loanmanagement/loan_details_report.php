  <div class="content-wrapper">



    <!-- Content Header (Page header) -->

    <?php $this->load->view('admin/include/breadcrumb'); ?>



    <?php $controller = &get_instance();

    $controller->load->model('common_model'); ?> 
    <!-- Main content -->

    <div class="content">

      <div class="container-fluid">

        <div class="row">





          <div class="col-md-12">
            <form method="post" action="" class="validate-form">
              <div class="row">
                <div class="col-lg-3">
                 <div class="form-group mb-4">
                  <label>Customer:</label>
                  <select class="form-control select2"  name="loan_management_id">
                    <option value="">Select Customer</option>
                    <?php  
                    $loan_management__q="SELECT * FROM loan_management WHERE user_id = ".user()->id." ORDER BY id DESC"; 
                    $loan_management=$controller->common_model->universal($loan_management__q)->result(); 
                    foreach ($loan_management as $value) {?>
                      <option value="<?php echo $value->id; ?>" <?php echo isset($loan_management_id) && $loan_management_id==$value->id ? 'selected' : ''; ?>><?php echo $value->customer_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-2">
               <div class="form-group mb-4">
                <label>Account No:</label>
                <input class="form-control" name="account_number" value="<?php echo isset($account_number) ? $account_number : ''; ?>">
              </div>
            </div>
            <div class="col-lg-2">
             <div class="form-group mb-4">
              <label>From:</label>
              <div class="input-group">
                <input type="text" class="form-control datepicker" value="<?php echo $from; ?>" name="from" placeholder="From">
                <span class="input-group-append">
                  <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
                </span>
              </div>
            </div>
          </div>
          <div class="col-lg-2">
           <div class="form-group mb-4">
            <label>To:</label>
            <div class="input-group">
              <input type="text" class="form-control datepicker"  value="<?php echo $to; ?>" name="to" placeholder="To">
              <span class="input-group-append">
                <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
              </span>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
         <div class="form-group mb-4">
          <label>Paid Status:</label>
          <select class="form-control" name="paid_status">
            <option value="">Select</option>
            <option value="paid" <?php echo isset($paid_status) && $paid_status=='paid' ? 'selected' : ''; ?>>Paid</option>
            <option value="unpaid"  <?php echo isset($paid_status) && $paid_status=='unpaid' ? 'selected' : ''; ?>>Un Paid</option>

          </select>
        </div>
      </div>

      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      <div class="col-lg-1 mt-2 pt-4">
        <button type="submit" required name="submit" class="btn btn-success" >Filter</button>
      </div>
    </div>
  </form>
  <?php if (isset($loan_management_detail) && !empty($loan_management_detail)): ?>
  <div class="card">

    <div class="card-header">

      <h5 class="card-title mb-0">Loan Detail Report</h5>

    </div>



    <div class="card-body table-responsive p-0">

      <table class="table table-hover table-valign-middle <?php if(count($loan_management_detail) > 10){echo "datatable";} ?>">

        <thead>

          <tr>

            <th>Sr No</th>

            <th>Customer Code</th>

            <th>Customer Name</th>

            <th>Customer Account Number</th>

            <th>Customer Email</th>

            <th>Total Amount</th>

            <th>Pending Amount</th>

            <th>Per Past Due Obligations</th>

            <th>Status</th>

            <th>Pay Date</th>

            <th>Due Date</th>

            <th>Action</th>

          </tr>

        </thead>

        <tbody>
          <?php 
          $srno=1;
          $Total_pending_amount=0;
          foreach ($loan_management_detail as $row) {
            $loan_management_q="SELECT * FROM loan_management WHERE id=".$row->loan_management_id; 
            $loan_management=$controller->common_model->universal($loan_management_q)->row();
            $Total_pending_amount+=$row->pending_amount;
            ?>
            <tr>
              <td>

                <p class="mb-0 fs-13"> <?php echo html_escape($srno++); ?><!-- <a href="<?php echo base_url('admin/LoanManagement/details/'.html_escape($row->loan_management_id));?>" class="badge badge-primary-soft"><i class="far fa-eye"></i> <?php echo trans('view-details') ?></a> --></p>

              </td>

              <td>

                <p class=""><?php echo html_escape($loan_management->customer_code); ?></p>

              </td>
              <td>

                <p class="mb-0 font-weight-bold"><?php echo html_escape($loan_management->customer_name); ?></p>

              </td>
              <td>

                <p class=""><?php echo html_escape($loan_management->account_number); ?></p>

              </td>
              <td>

                <p class=""><?php echo html_escape($loan_management->email); ?></p>

              </td>

              <td>

                <p class="mb-0 fs-13"> <?php echo html_escape($row->total_amount); ?></p>

              </td>

              <td>

                <p class="mb-0 fs-13"> <?php echo html_escape($row->pending_amount); ?></p>

              </td>

              <td>

                <p class="mb-0 fs-13"> <?php echo html_escape($row->per_installment_amount); ?></p>

              </td>

              <td>

                <p class="mb-0 fs-13"> <?php echo isset($row->paid_status) && $row->paid_status==1 ? '
                PDO paid' : 'UNPAID'; ?></p>

              </td>

              <td>

                <p class="mb-0 fs-13"> <?php echo isset($row->pay_date) && !empty($row->pay_date) ? date('Y-m-d' , strtotime($row->pay_date)) : ''; ?></p>

              </td>

              <td>

                <p class="mb-0 fs-13">  <?php echo isset($row->due_date) && !empty($row->due_date) ? date('Y-m-d' , strtotime($row->due_date)) : ''; ?></p>

              </td>

              <td>

                <p class="mb-0 fs-13"><?php if (isset($row->paid_status) && $row->paid_status==0) {?>
                  <a href="<?php echo base_url() ?>admin/LoanManagement/active/<?php echo html_escape($row->id); ?>/<?php echo html_escape($loan_management->id); ?>" class="btn btn-info">PAID</a>
                  <?php }?></p>

                </td>
              </tr>
            <?php } ?>

          </tbody>
          <tfoot>
            <tr>
              <td colspan="6">Total</td>
              <td><?php echo $Total_pending_amount; ?></td>
              <td colspan="4"></td>
            </tr>
          </tfoot>

        </table>

      </div>

    </div>

    <?php else: ?>

      <div class="card mt-5">

        <div class="card-body mt-2 text-center p-5 pt-4">

          <p><?php echo trans('no-data-found') ?></p>

        </div>

      </div>

    <?php endif ?>

  </div>
</div>

</div>

</div>

</div>