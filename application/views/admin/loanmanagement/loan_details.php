<div class="content-wrapper">



  <!-- Content Header (Page header) -->

  <?php $this->load->view('admin/include/breadcrumb'); ?>


  <!-- Main content -->

  <div class="content">

    <div class="container-fluid">

      <div class="row">





        <div class="col-md-12">
          <form method="post" action="" class="validate-form">
            <div class="row">
              <div class="col-lg-3">
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
            <div class="col-lg-3">
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
          <div class="col-lg-3">
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
        <div class="col-lg-3 mt-2 pt-4">
          <button type="submit" required name="submit" class="btn btn-success" >Filter</button>
        </div>
      </div>
    </form>

    <?php if (isset($loan_management) && !empty($loan_management)): ?>

    <div class="card pl-3">

      <div class="card-header">

        <h5 class="card-title mb-0">Personal Detail</h5>



        <div class="card-tools pull-right"><a class="pull-right btn btn-secondary btn-sm" href="<?php echo base_url('admin/LoanManagement') ?>"><i class="fas fa-angle-left"></i> Back</a></div>

      </div>



      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-valign-middle <?php if(count($loan_management_detail) > 10){echo "datatable";} ?>">

          <thead>

            <tr>

              <th>Installment No</th>

              <th>Total Amount</th>

              <th>Pending Amount</th>

              <th>Per Installment Amount</th>

              <th>Status</th>

              <th>Pay Date</th>

              <th>Due Date</th>

              <th>Action</th>

            </tr>

          </thead>

          <tbody>
            <?php foreach ($loan_management_detail as $row) {?>
              <tr>

                <td>

                  <p class="mb-0 fs-13"> <?php echo html_escape($row->no_of_installment); ?></p>

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

                  <p class="mb-0 fs-13"> <?php echo isset($row->paid_status) && $row->paid_status==1 ? '<button class="btn btn-info">PAID</button>' : '<button class="btn btn-danger">UNPAID</button>'; ?></p>

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