
  <?php include APPPATH.'views/include/js_msg_list.php'; ?>

  <?php $success = $this->session->flashdata('msg'); ?>
  <?php $error = $this->session->flashdata('error'); ?>
  <input type="hidden" id="success" value="<?php echo html_escape($success); ?>">
  <input type="hidden" id="lc" value="<?php echo strlen(settings()->ind_code); ?>">
  <input type="hidden" id="error" value="<?php echo html_escape($error);?>">
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <?php echo trans('version') ?> <?php echo html_escape(settings()->version) ?>
    </div>
    <!-- Default to the left -->
    <strong><?php echo trans('copyright') ?> &copy; <?php echo date('Y') ?>  <?php echo trans('all-rights-reserved') ?>.
  </footer>
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Admin App -->
<script src="<?php echo base_url() ?>assets/admin/js/admin.js?var=<?= settings()->version ?>&time=<?=time();?>"></script>

<script src="<?php echo base_url() ?>assets/admin/js/validation.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/sweet-alert.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap-tagsinput.min.js"></script>

<!-- select2 js -->
<script src="<?php echo base_url()?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- nice select js -->
<script src="<?php echo base_url()?>assets/admin/js/nice-select.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/js/tata.js"></script>

<!-- date & time picker -->
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/js/timepicker.min.js"></script>
<!-- animation js -->
<script src="<?php echo base_url() ?>assets/front/js/aos.js"></script>

<!-- bs-custom-file-input -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url() ?>assets/admin/plugins/summernote/summernote-bs4.min.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap-colorpicker.min.js"></script>


<!-- stripe js -->
<?php include'stripe-js.php'; ?>

<!-- chart js -->
<?php if (isset($page) && $page == 'Dashboard'): ?>
  <?php $this->load->view('admin/include/charts'); ?>
<?php elseif (isset($page) && $page == 'Reports'): ?>
  <?php $this->load->view('admin/include/user-charts'); ?>
<?php endif ?>

<!-- calendar js -->
<?php if (isset($page_title) && $page_title == 'Calendars'): ?>
<?php include'calendar-js.php'; ?>
<?php endif ?>

<script type="text/javascript">
  $(document).ready(function () {

      //Colorpicker
      $('.colorpicker').colorpicker();

      $('.default').click(function () {    
        $('.default').not($(this)).removeClass('active');
        $(this).toggleClass('active').next().find('.sub-table-wrap').slideToggle();
        $(".toggle-row").not($(this).next()).find('.sub-table-wrap').slideUp('fast');
      });
      
      //$('[data-toggle="tooltip"]').tooltip();  
      
      $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
      });

      $.datepicker.regional ['en'] = {
          clearText: 'Clear', 
          clearStatus: '',
          closeText: 'Close',
          closeStatus: 'Close without modifying',
          prevStatus: 'See previous month',
          nextStatus: 'See next month',
          currentText: 'Current',
          currentStatus: 'See current month',
          monthNames: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
          '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'],
          monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          monthStatus: 'See another month',
          yearStatus: 'See another year',
          weekHeader: 'Sm',
          weekStatus: '',
          dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
          dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
          dayNamesMin: ['<?php echo trans('su') ?>', '<?php echo trans('mo') ?>', '<?php echo trans('tu') ?>', '<?php echo trans('we') ?>', '<?php echo trans('th') ?>', '<?php echo trans('fr') ?>', '<?php echo trans('sa') ?>'],
          dayStatus: 'Use DD as the first day of the week',
          dateStatus: 'Choose the DD, MM of',
          firstDay: 0,
          initStatus: 'Choose date',
          isRTL: false
      }; 

      $.datepicker.setDefaults($.datepicker.regional['en']);

  });
</script>

<script type="text/javascript">
  <?php if ($this->business->time_format == 'HH'): ?>
    $(document).on("focusin",".timepicker", function () {
      $('input.timepicker').timepicker({ timeFormat: 'HH:mm', interval: 30 });
    });

    $(document).on("focusin",".hourpicker", function () {
      $('input.hourpicker').timepicker({ timeFormat: 'HH:mm', interval: 60 });
    });
  <?php else: ?>
    $(document).on("focusin",".timepicker", function () {
      $('input.timepicker').timepicker({ timeFormat: 'hh:mm p', interval: 30 });
    });

    $(document).on("focusin",".hourpicker", function () {
      $('input.hourpicker').timepicker({ timeFormat: 'hh:mm p', interval: 60 });
    });
  </script>
<?php endif ?>





<?php if (isset($page) && $page == 'Appointment'): ?>
<script src="<?php echo base_url() ?>assets/admin/js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {

        $("body").on('click','.time_btn',function(){
            $('.step2_btn').prop('disabled', false);
            $('.time_btn').removeClass('active');
            $(this).addClass('active');
        });


        var $datePicker = $("#datepickers");
        var base_url = $('#base_url').val();
        var business_id = <?php echo html_escape($this->business->uid) ?>;
        var arrayFromPHP = <?php echo json_encode($not_available) ?>;

        $.datepicker.regional ['en'] = {
            clearText: 'Clear', 
            clearStatus: '',
            closeText: 'Close',
            closeStatus: 'Close without modifying',
            prevStatus: 'See previous month',
            nextStatus: 'See next month',
            currentText: 'Current',
            currentStatus: 'See current month',
            monthNames: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
            '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            monthStatus: 'See another month',
            yearStatus: 'See another year',
            weekHeader: 'Sm',
            weekStatus: '',
            dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            dayNamesMin: ['<?php echo trans('su') ?>', '<?php echo trans('mo') ?>', '<?php echo trans('tu') ?>', '<?php echo trans('we') ?>', '<?php echo trans('th') ?>', '<?php echo trans('fr') ?>', '<?php echo trans('sa') ?>'],
            dayStatus: 'Use DD as the first day of the week',
            dateStatus: 'Choose the DD, MM of',
            firstDay: 0,
            initStatus: 'Choose date',
            isRTL: false
        }; 

        $.datepicker.setDefaults($.datepicker.regional['en']);

        $datePicker.datepicker({
            daysOfWeekDisabled: [0],
            changeMonth: false,
            changeYear: false,
            showOtherMonths: true,
            selectOtherMonths: true,
            showButtonPanel: true,
            minDate: 0,
            todayBtn: false,
            dateFormat: 'yy-mm-dd',
            onSelect: function(){
                var date = $(this).val();
                $('.booking_time').val('');

                var url = base_url+'company/get_time/'+date+'/'+business_id;
                var post_data = {
                    'csrf_test_name' : csrf_token
                };

                $('#load_data').html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: post_data,
                    success: function(data) {
                        if (data.status == 0) {
                            $('.step2_btn').prop('disabled', true);
                        }
                        $('#load_data').html(data.result);
                    }
                })

            },

            beforeShowDay: function(date) {
                var show = true;
                //foreach
                $.each(arrayFromPHP, function (i, elem) {
                    if(date.getDay() == elem-1) show = false
                });
                
                return [show];
            }

        });
    });
</script>
<?php endif ?>


</script>

</body>
</html>
