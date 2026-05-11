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
                  <h3 class="card-title pt-2">City Detail</h3>
                <?php endif; ?>

                <div class="card-tools pull-right">
                  <?php if (isset($page_title) && $page_title == "Edit"): ?>
                    <a href="<?php echo base_url('admin/Area/city') ?>" class="pull-right btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> Back</a>
                    <?php else: ?>
                      <a href="#" class="text-right btn btn-secondary cancel_btn btn-sm">City Detail</a>
                    <?php endif; ?>
                  </div>
                </div>
                <form method="post" action="<?php echo base_url('admin/Area/add_area')?>" class="validate-form" role="form" novalidate>
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-3">
                         <div class="form-group mb-4">
                           <label>Country:<span style="color:red;">*</span></label>
                           <select class="form-control" required  name="country_id">
                            <option value="">Select country</option>
                            <?php 
                            $country_q="SELECT name,id FROM country"; 
                            $country=$controller->common_model->universal($country_q)->result();
                            foreach ($country as $key => $value) { ?>
                              <option value="<?php echo $value->name; ?>" <?php echo isset($city->country_id) && $city->country_id==$value->name ? 'selected' : ''; ?>><?php echo $value->name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                       <div class="form-group mb-4">
                        <label>Code<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" required name="code" placeholder="Code" value="<?php echo isset($city->code) ? $city->code : '' ?>">
                      </div>
                    </div>
                    <div class="col-lg-3">
                     <div class="form-group mb-4">
                      <label>Name:<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" required  value="<?php echo isset($city->name) ? $city->name : '' ?>" name="name" placeholder="City Name">
                    </div>
                  </div>
                </div>                          
              </div>
            </div>
            <div class=" ">
              <input type="hidden" name="id" value="<?php if(isset($city->id)){echo html_escape($city->id);} ?>">
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
                  <h3 class="card-title pt-2">City Detail</h3>
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
                    <th>Country</th>
                    <th><?php echo trans('name') ?></th>
                    <th>Code</th>
                    <th><?php echo trans('action') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=1; foreach ($city as $row):
                  $country_q="SELECT name,id FROM country WHERE name='".$row->country_id."'"; 
                  $country=$controller->common_model->universal($country_q)->row();
                  ?>
                  <tr id="row_<?php echo html_escape($row->id); ?>">
                    <td><?= $i; ?></td>
                    <td>
                      <p class="mb-0"><?php echo html_escape($country->name); ?></p>
                    </td>
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
                          <a href="<?php echo base_url('admin/Area/edit_city/'.html_escape($row->id));?>" class="dropdown-item"><?php echo trans('edit') ?></a>

                          <a data-val="Category" data-id="<?php echo html_escape($row->id); ?>" href="<?php echo base_url('admin/Area/delete_city/'.html_escape($row->id));?>" class="dropdown-item delete_item"><?php echo trans('delete') ?></a>
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
