<div class="content-wrapper">



  <!-- Content Header (Page header) -->

  <?php $this->load->view('admin/include/breadcrumb'); ?>


  <!-- Main content -->

  <div class="content">

    <div class="container-fluid">

      <div class="row">





        <div class="col-md-12">

          <?php if (isset($loan_management) && !empty($loan_management)): ?>

          <div class="card pl-3">

            <div class="card-header">

              <h5 class="card-title mb-0">Personal Detail</h5>



              <div class="card-tools pull-right"><a class="pull-right btn btn-secondary btn-sm" href="<?php echo base_url('admin/LoanManagement') ?>"><i class="fas fa-angle-left"></i> Back</a></div>

            </div>



            <div class="card-body table-responsive p-0">

              <table class="table table-hover table-valign-middle <?php //if(count($loan_management) > 10){echo "datatable";} ?>">

                <thead>

                  <tr>

                    <th>Customer Code</th>

                    <th>Account Number</th>

                    <th>Customer Name</th>

                    <th>Father Name</th>

                    <th>Nation Id</th>

                    <th>Mobile No</th>

                    <th>Phone NO</th>

                    <th>Email</th>

                    <th>Country</th>

                    <th>City</th>

                    <th>Address</th>

                  </tr>

                </thead>

                <tbody>


                  <tr>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->customer_code); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->account_number); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 font-weight-bold"><?php echo html_escape($loan_management->customer_name); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->father_name); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->national_id); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->mobile_no); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->phone_no); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->email); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->country); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->city); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->address); ?></p>

                    </td>
                  </tr>


                </tbody>

              </table>

            </div>

          </div>

          <div class="card pl-3">

            <div class="card-header">

              <h5 class="card-title mb-0">Loan Detail</h5>

            </div>



            <div class="card-body table-responsive p-0">

              <table class="table table-hover table-valign-middle <?php //if(count($loan_management) > 10){echo "datatable";} ?>">

                <thead>

                  <tr>

                    <th>Loan Booked Amount</th>

                    <th>Loan Booked Date</th>

                    <th>Repayment Due Date</th>

                    <th>No Of installments</th>

                    <!-- <th>Period In Days</th> -->

                    <th>Per Installment Amount</th>

                    <th>Nature Of Bussiness</th>

                    <th>Customer Rating Payment</th>

                    <th>Bad Debt Recovery Appoinment</th>

                    <th>Customer Behavior</th>

                    <th>Guarantor 1</th>

                    <th>Guarantor 2</th>

                    <th>Created At</th>

                  </tr>

                </thead>

                <tbody>

                  <tr>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->loan_booked_amount); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->loan_booked_date); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->repayment_due_date); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->no_of_installaments); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->per_installment_amount); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->nature_of_bussiness); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->customer_rating_repayment); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->bad_debt_recovery_appointment); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->customer_behavior); ?></p>

                    </td>

                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->guarantor1); ?></p>

                    </td>
                    
                    <td>

                      <p class="mb-0 fs-13"> <?php echo html_escape($loan_management->guarantor2); ?></p>

                    </td>

                    <td>

                      <span class="small"><i class="far fa-clock"></i> <?php echo html_escape(get_time_ago($loan_management->created_at)); ?></span>

                    </td>



                  </tr>

                </tbody>

              </table>

            </div>

          </div>
          <div class="card pl-3">

            <div class="card-header">

              <h5 class="card-title mb-0">Loan Detail Report</h5>

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