<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <?php $this->load->view('admin/include/breadcrumb'); ?>
  <?php $controller = &get_instance();

  $controller->load->model('common_model'); ?> 

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
            <div class="card-header with-border">
              <?php if (isset($page_title) && $page_title == "Edit"): ?>
                <h3 class="card-title"><?php echo trans('edit') ?></h3>
                <?php else: ?>
                  <h3 class="card-title pt-2">County Detail</h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/LoanManagement') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> Back</a>
                    <?php else: ?>
                      <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm">Loan Managment</a>
                    <?php endif; ?>
                  </div>
                </div>


                <form method="post" action="<?php echo base_url('admin/Area/add_country')?>" class="validate-form" role="form" novalidate>

                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Customer Code<span style="color:red;">*</span></label>
                           <input type="text" class="form-control" required name="code" placeholder="Customer Code Auto Generated" value="" readonly>
                         </div>
                       </div>

                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Account Number<span style="color:red;">*</span></label>
                           <input type="text" class="form-control" required name="account_number" value="<?php echo isset($loan_management->account_number) ? $loan_management->account_number : '' ?>" placeholder="2345675876756">
                         </div>
                       </div>

                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>National ID:<span style="color:red;">*</span></label>
                           <input type="text" class="form-control" required  value="<?php echo isset($loan_management->national_id) ? $loan_management->national_id : '' ?>" name="national_id" placeholder="National ID">
                         </div>
                       </div>

                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Customer Name:<span style="color:red;">*</span></label>
                           <input type="text" class="form-control" required  value="<?php echo isset($loan_management->customer_name) ? $loan_management->customer_name : '' ?>" name="customer_name" placeholder="Customer Name">
                         </div>
                       </div>

                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Father Name:<span style="color:red;">*</span></label>
                           <input type="text" class="form-control" required  value="<?php echo isset($loan_management->father_name) ? $loan_management->father_name : '' ?>" name="father_name" placeholder="Father Name">
                         </div>
                       </div>


                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Mobile No:<span style="color:red;">*</span></label>
                           <input class="form-control" required  value="<?php echo isset($loan_management->mobile_no) ? $loan_management->mobile_no : '' ?>" name="mobile_no" type="number" placeholder="(0345)63343466">
                         </div>
                       </div>

                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Phone No:<span style="color:red;">*</span></label>
                           <input class="form-control" required  value="<?php echo isset($loan_management->phone_no) ? $loan_management->phone_no : '' ?>" name="phone_no" type="number" placeholder="345678679054">
                         </div>
                       </div>

                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Email Address:<span style="color:red;">*</span></label>
                           <input class="form-control" required  value="<?php echo isset($loan_management->email) ? $loan_management->email : '' ?>" name="email" type="email" placeholder="Email Address">
                         </div>
                       </div>

                       <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Country:<span style="color:red;">*</span></label>
                           <select class="form-control" required  name="country">

                            <option value="">Select country</option>
                            <option value="Pakistan" <?php echo isset($loan_management->country) && $loan_management->country=='Pakistan' ? 'selected' : ''; ?>>Pakistan </option>
                            <option value="China" <?php echo isset($loan_management->country) && $loan_management->country=='China' ? 'selected' : ''; ?>>China </option>
                          </select>
                        </div>
                      </div>
                    </div>                          
                  </div>
                </div>
                <div class=" ">
                  <input type="hidden" name="id" value="<?php if(isset($loan_management->id)){echo html_escape($loan_management->id);} ?>">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                  <button type="submit" required name="submit" class="btn btn-success mt-1">SUBMIT</button>
                </div>
              </form>

            </div>


            <?php if (isset($page_title) && $page_title != "Edit"): ?>
              <div class="card list_area">
                <div class="card-header with-border">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <h3 class="card-title pt-2"><?php echo trans('edit') ?> <a href="<?php echo base_url('admin/LoanManagement') ?>" class="pull-right btn btn-sm btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
                    <?php else: ?>
                      <h3 class="card-title pt-2">Country Detail</h3>
                    <?php endif; ?>

                    <div class="card-tools pull-right">
                     <a href="#" class="pull-right btn btn-sm btn-secondary add_btn"><i class="fa fa-plus"></i> <?php echo trans('create-new') ?></a>
                   </div>
                 </div>

                 <div class="card-body table-responsive p-0">

                  <table class="table table-hover text-nowrap <?php if(count($loanmanagement) > 10){echo "datatable";} ?>">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th><?php echo trans('name') ?></th>
                        <th>Code</th>
                        <th><?php echo trans('action') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i=1; foreach ($country as $row):?>
                      <tr id="row_<?php echo html_escape($row->id); ?>">
                        <td><?= $i; ?></td>
                        <td>
                          <p class="mb-0"><?php echo html_escape($row->name); ?></p>
                        </td>
                        <td><?php echo html_escape($row->code); ?></td>
                        <td class="actions">
                          <div class="btn-group">
                            <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu" >
                              <a href="<?php echo base_url('admin/Area/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>

                              <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/LoanManagement/delete/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
                            </div>
                          </div>

                        </td>
                      </tr>

                      <?php $i++; endforeach; ?>
                    </tbody>
                  </table>

                </div>

              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>
