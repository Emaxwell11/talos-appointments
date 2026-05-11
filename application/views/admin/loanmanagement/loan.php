<div class="content-wrapper">
 <?php $this->load->view('admin/include/breadcrumb'); ?>
 <?php $controller = &get_instance();
 $controller->load->model('common_model'); ?> 
 <div class="content">
  <div class="container-fluid">
   <div class="row">
    <div class="col-lg-12">
     <div class="card add_area <?php if(isset($page_title) && $page_title == "Edit"){echo "d-block";}else{echo "hide";} ?>">
      <div class="card-header with-border">
       <?php if (isset($page_title) && $page_title == "Edit"): ?>
         <h3 class="card-title"><?php echo trans('edit') ?></h3>
         <?php else: ?>
           <h3 class="card-title pt-2">
             Personal Information
           </h3>
         <?php endif; ?>
         <div class="card-tools pull-right">
          <?php if (isset($page_title) && $page_title == "Edit"): ?>
            <a href="<?php echo base_url('admin/LoanManagement') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> Back</a>
            <?php else: ?>
              <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm">Loan Managment</a>
            <?php endif; ?>
          </div>
        </div>
        <?php $action=base_url('admin/LoanManagement/add'); 
        if (isset($disabled)) {
          $action=base_url('admin/LoanManagement/add_profile'); 
        }
        ?>
        <form method="post" action="<?php echo $action; ?>" class="validate-form" role="form" novalidate>
         <div class="card">
          <div class="card-body">
           <?php $loan_mg_lst_id_q="SELECT MAX(id) as last_id FROM loan_management"; 
           $loan_mg_lst_id=$controller->common_model->universal($loan_mg_lst_id_q)->row();
           $last_id=isset($loan_mg_lst_id->last_id) && !empty($loan_mg_lst_id->last_id) ? $loan_mg_lst_id->last_id + 1 : '1';
           ?>
           <div class="row">
            <div class="col-lg-3">
             <div class="form-group mb-4">
              <label>Customer Code<span style="color:red;">*</span></label>
              <input type="text" class="form-control" required name="customer_code" placeholder="Customer Code Auto Generated" <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->customer_code) ? $loan_management->customer_code : $last_id ?>" disabled>
            </div>
          </div>
          <div class="col-lg-3">
           <div class="form-group mb-4">
            <label>Customer Account Number<span style="color:red;">*</span></label>
            <input type="text" class="form-control" required name="account_number" <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->account_number) ? $loan_management->account_number : '' ?>" placeholder="2345675876756">
          </div>
        </div>
        <div class="col-lg-3">
         <div class="form-group mb-4">
          <label>National ID:<span style="color:red;">*</span></label>
          <input type="text" class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->national_id) ? $loan_management->national_id : '' ?>" name="national_id" placeholder="National ID">
        </div>
      </div>
      <div class="col-lg-3">
       <div class="form-group mb-4">
        <label>Customer Full Name:<span style="color:red;">*</span></label>
        <input type="text" class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->customer_name) ? $loan_management->customer_name : '' ?>" name="customer_name" placeholder="Customer Full Name">
      </div>
    </div>
    <div class="col-lg-3">
     <div class="form-group mb-4">
      <label>Father Name:<span style="color:red;">*</span></label>
      <input type="text" class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->father_name) ? $loan_management->father_name : '' ?>" name="father_name" placeholder="Father Name">
    </div>
  </div>
  <div class="col-lg-3">
   <div class="form-group mb-4">
    <label>Mobile No:<span style="color:red;">*</span></label>
    <input class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->mobile_no) ? $loan_management->mobile_no : '' ?>" name="mobile_no" type="number" placeholder="(0345)63343466">
  </div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>Customer Phone Number:</label>
  <input class="form-control" <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->phone_no) ? $loan_management->phone_no : '' ?>" name="phone_no" type="number" placeholder="345678679054">
</div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>Email Address:<span style="color:red;">*</span></label>
  <input class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->email) ? $loan_management->email : '' ?>" name="email" type="email" placeholder="Email Address">
</div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>Country:<span style="color:red;">*</span></label>
  <select class="form-control country" <?php echo isset($disabled) ? 'disabled' : ''; ?> required  name="country">
   <option value="">Select country</option>
   <?php 
   $country_q="SELECT name,id FROM country"; 
   $country=$controller->common_model->universal($country_q)->result();
   foreach ($country as $key => $value) { ?>
     <option value="<?php echo $value->name; ?>" <?php echo isset($loan_management->country) && $loan_management->country==$value->name ? 'selected' : ''; ?>><?php echo $value->name; ?></option>
   <?php } ?>
 </select>
</div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>City:<span style="color:red;">*</span></label>
  <select class="form-control city_data" <?php echo isset($disabled) ? 'disabled' : ''; ?> required name="city">
   <option value="">Select City</option>
   <?php
   if (isset($loan_management->city)) {
     $city_q="SELECT name,id FROM city"; 
     $city=$controller->common_model->universal($city_q)->result();
     foreach ($city as $key => $value) { ?>
       <option value="<?php echo $value->name; ?>" <?php echo isset($loan_management->city) && $loan_management->city==$value->name ? 'selected' : ''; ?>><?php echo $value->name; ?></option>
     <?php } 
   }
   ?>
 </select>
</div>
</div>
<div class="col-lg-6">
 <div class="form-group mb-4">
  <label>Address:<span style="color:red;">*</span></label>
  <textarea class="form-control" required name="address" <?php echo isset($disabled) ? 'disabled' : ''; ?> id="" cols="10" rows="1"><?php echo isset($loan_management->address) ? $loan_management->address : '' ?></textarea>
</div>
</div>
</div>
</div>
</div>
<div class="card">
  <div class="card-header with-border">
   <h3 class="card-title  ">  Loan Information</h3>
 </div>
 <div class="card-body">
   <div class="row">
    <div class="col-lg-3">
     <div class="form-group mb-4">
      <label>Loan Booked Amount:<span style="color:red;">*</span></label>
      <input type="text" class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->loan_booked_amount) ? $loan_management->loan_booked_amount : '' ?>" name="loan_booked_amount" placeholder="Loan Booked Amount">
    </div>
  </div>
  <div class="col-lg-3">
   <div class="form-group mb-4">
    <label>Loan Booked Date:<span style="color:red;">*</span></label>
    <div class="input-group">
      <input type="text" class="form-control datepicker" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->loan_booked_date) ? $loan_management->loan_booked_date : '' ?>" name="loan_booked_date" placeholder="Loan Booked Date">
      <span class="input-group-append">
       <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
     </span>
   </div>
 </div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>PDO repayment commitment:<span style="color:red;">*</span></label>
  <div class="input-group">
    <input type="text" class="form-control datepicker" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->repayment_due_date) ? $loan_management->repayment_due_date : '' ?>" name="repayment_due_date" placeholder="PDO repayment commitment">
    <span class="input-group-append">
     <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
   </span>
 </div>
</div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>No of Installments:<span style="color:red;">*</span></label>
  <input type="text" class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->no_of_installaments) ? $loan_management->no_of_installaments : '' ?>" name="no_of_installaments" placeholder="Installments">
</div>
</div>
<div class="col-lg-3">
 <div class="form-group">
  <label>Loan tenor<span class="text-danger">*</span></label>
  <div class="input-group">
    <input type="number" class="form-control cus-ra-right"  <?php echo isset($disabled) ? 'disabled' : ''; ?>  value="<?php echo isset($loan_management->period) ? $loan_management->period : '' ?>" name="period" value="" required="" aria-invalid="false">
    <div>
      <select class="form-control cus-ra-left" name="period_type" aria-invalid="false"  <?php echo isset($disabled) ? 'disabled' : ''; ?> >
       <option value="Days" <?php echo isset($loan_management->period_type) && $loan_management->period_type=='Days' ? 'selected' : 'selected'; ?> >Days</option>
       <option value="Month"  <?php echo isset($loan_management->period_type) && $loan_management->period_type=='Month' ? 'selected' : ''; ?>>Month</option>
       <!-- <option value="day" >Day</option> -->
     </select>
   </div>
 </div>
</div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>PDO commitment date:<span style="color:red;">*</span></label>
  <div class="input-group">
    <input type="text" class="form-control datepicker" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->start_date) ? $loan_management->start_date : '' ?>" name="start_date" placeholder="PDO commitment date">
    <span class="input-group-append">
     <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
   </span>
 </div>
</div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>Per Past Due Obligations:<span style="color:red;">*</span></label>
  <input class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->per_installment_amount) ? $loan_management->per_installment_amount : '' ?>" name="per_installment_amount" type="text" placeholder="Per Past Due Obligations">
</div>
</div>
<div class="col-lg-3">
 <div class="form-group mb-4">
  <label>Nature of Business:<span style="color:red;">*</span></label>
  <input class="form-control" required value="<?php echo isset($loan_management->nature_of_bussiness) ? $loan_management->nature_of_bussiness : '' ?>"  <?php echo isset($disabled) ? 'disabled' : ''; ?>  name="nature_of_bussiness" type="text" placeholder="Nature of Business">
</div>
</div>
<div class="col-lg-4">
 <div class="form-group mb-4">
  <label>Customers rating on PDO repayment:<span style="color:red;">*</span></label>
  <input class="form-control" required value="<?php echo isset($loan_management->customer_rating_repayment) ? $loan_management->customer_rating_repayment : '' ?>" name="customer_rating_repayment" type="text" placeholder="Rating">
</div>
</div>
<div class="col-lg-4">
 <div class="form-group mb-4">
  <label>PDO recovery appointment schedule:</label>
  <div class="input-group">
    <input class="form-control datepicker"value="<?php echo isset($loan_management->bad_debt_recovery_appointment) ? $loan_management->bad_debt_recovery_appointment : '' ?>" name="bad_debt_recovery_appointment" type="text" placeholder="Date">
    <span class="input-group-append">
     <button type="button" class="btn btn-default"><i class="fas fa-calendar-alt"></i></button>
   </span>
 </div>
</div>
</div>
<div class="col-lg-4">
 <div class="form-group mb-4">
  <label>Customers Behavior:</label>
  <textarea class="form-control" name="customer_behavior" id="" cols="30" rows="1"><?php echo isset($loan_management->customer_behavior) ? $loan_management->customer_behavior : 'is he trying to avoid payments' ?></textarea>
</div>
</div>
<div class="col-lg-6">
 <div class="form-group mb-4">
  <label>Guarantor 1<span style="color:red;">*</span></label>
  <input class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->guarantor1) ? $loan_management->guarantor1 : '' ?>" name="guarantor1" type="text" placeholder="Guarantor 1">
</div>
</div>
<div class="col-lg-6">
 <div class="form-group mb-4">
  <label>Guarantor 2<span style="color:red;">*</span></label>
  <input class="form-control" required  <?php echo isset($disabled) ? 'disabled' : ''; ?> value="<?php echo isset($loan_management->guarantor2) ? $loan_management->guarantor2 : '' ?>" name="guarantor2" type="text" placeholder="Guarantor 2">
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
       <h3 class="card-title pt-2">Loan Management</h3>
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
      <th>Loan Amount</th>
      <th>Total Amount Paid</th>
      <th>Pending Amount</th>
      <th>Total Installments</th>
      <th>Outstanding PDO</th>
      <!-- <th><?php echo trans('summary') ?></th> -->
      <th><?php echo trans('action') ?></th>
    </tr>
  </thead>
  <tbody>
   <?php
   $i=1; foreach ($loanmanagement as $row):
   $loan_detail_q="SELECT * FROM loan_management_detail WHERE loan_management_id=".$row->id; 
   $loan_detail=$controller->common_model->universal($loan_detail_q)->row(); ?>
   <tr id="row_<?php echo html_escape($row->id); ?>">
    <td><?= $i; ?></td>
    <td>
      <a href="<?php echo base_url('admin/LoanManagement/profile_detail/'.html_escape($row->id));?>"><p class="mb-0"><?php echo html_escape($row->customer_name); ?></p></a>
      <p class="mb-0"><?php echo html_escape($row->email); ?></p>
    </td>

    <td><?php echo html_escape($row->loan_booked_amount); ?></td>
    <td><?php echo html_escape($loan_detail->total_amount); ?></td>
    <?php 
    $pending_amount_q="SELECT pending_amount FROM loan_management_detail WHERE pending_amount!='0' AND loan_management_id=".$row->id; 
    $pending_amount=$controller->common_model->universal($pending_amount_q)->row(); 
    ?>
    <td><?php echo html_escape($pending_amount->pending_amount); ?></td>
    <td><?php echo html_escape($row->no_of_installaments); ?></td>
    <?php 
    $pending_installments_q="SELECT COUNT(id) as pending_installments FROM loan_management_detail WHERE loan_management_id=".$row->id." AND paid_status=0"; 
    $pending_installments=$controller->common_model->universal($pending_installments_q)->row(); ?>
    <td><?php echo html_escape($pending_installments->pending_installments); ?></td>
   <!-- <td>
     <a href="<?php echo base_url('admin/LoanManagement/details/'.html_escape($row->id));?>" class="badge badge-primary-soft"><i class="far fa-eye"></i> <?php echo trans('view-details') ?></a>
   </td> -->
   <td class="actions">
     <div class="btn-group">
      <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-ellipsis-h"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-right" role="menu" >
       <a href="<?php echo base_url('admin/LoanManagement/edit/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>
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
<script type="text/javascript">
 var base_url='<?php echo base_url(); ?>';
 document.addEventListener('DOMContentLoaded', function() {
   $('body').on('change','.country',function(e){
     e.preventDefault();
     var country=$(this).val();
     $.ajax({
       beforeSend: function() {
         $('.city_data').html('<option value="">Processing</option>');
       },
       url: base_url+'admin/LoanManagement/getcity_country/'+country,
       success:function(response){
         $('.city_data').html('');
         $('.city_data').html(response);
       }
     });
   })
 }, false);
</script>