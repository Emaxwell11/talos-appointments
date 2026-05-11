<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoanManagement extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_staff() && !is_user()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Loan Managemant';      
        $data['page'] = 'Loan_Managemant';   
        // $data['customer'] = FALSE;
        $data['loanmanagement'] = $this->admin_model->select_by_user('loan_management');
        $data['main_content'] = $this->load->view('admin/loanmanagement/loan',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function profile_detail($id)
    {
     $data = array();
     $data['page_title'] = 'Edit';
     $data['loan_management'] = $this->admin_model->get_by_id($id, 'loan_management');
     $data['disabled']=true;
     $data['main_content'] = $this->load->view('admin/loanmanagement/loan',$data,TRUE);
     $this->load->view('admin/index',$data);
 }

 public function report()
 {
    $data = array();
    $data['page_title'] = 'Past Due Obligation (PDO)';      
    $data['page'] = 'Loan_Managemant_report';  
    $WHERE='';
    $data['from'] = isset($_POST['from']) ? date('Y-m-d' ,strtotime($_POST['from'])) : date('Y-m-d' ,strtotime('first day of this month'));
    $data['to'] = isset($_POST['to']) ? date('Y-m-d' ,strtotime($_POST['to'])) : date('Y-m-d' ,strtotime('last day of this month'));
    $data['paid_status'] = isset($_POST['paid_status']) && !empty($_POST['paid_status']) ? $_POST['paid_status'] : '';
    $data['loan_management_id']=isset($_POST['loan_management_id']) ? $_POST['loan_management_id'] : '';
    $data['account_number']=isset($_POST['account_number']) ? $_POST['account_number'] : '';
    $WHERE.="and DATE_FORMAT(`due_date`, '%Y-%m-%d') >= '".$data['from']."' AND  DATE_FORMAT(`due_date`, '%Y-%m-%d') <= '".$data['to']."' ";
    if (isset($data['loan_management_id']) && $data['loan_management_id']!='') {
        $WHERE.=" AND loan_management_id=".$data['loan_management_id'];
    }
    if (isset($data['account_number']) && $data['account_number']!='') {
        $WHERE.=" AND lm.account_number=".$data['account_number'];
    }
    $WHERE.=isset($_POST['paid_status']) && $_POST['paid_status']=='paid' ? " AND paid_status=1" : '';
    $WHERE.=isset($_POST['paid_status']) && $_POST['paid_status']=='unpaid' ? " AND paid_status=0" : '';
    $loan_management_detail_q="SELECT lmd.*,lm.loan_booked_amount,lm.customer_code,lm.account_number,lm.email,lm.customer_name FROM loan_management_detail as lmd INNER JOIN loan_management as lm on lmd.loan_management_id=lm.id WHERE lm.user_id = ".user()->id." $WHERE ORDER BY lmd.id ASC";
    $data['loan_management_detail']=$this->common_model->universal($loan_management_detail_q)->result();
    $data['main_content'] = $this->load->view('admin/loanmanagement/loan_details_report',$data,TRUE);
    $this->load->view('admin/index',$data);
}

public function add_profile()
{   
    if($_POST)
    {   

        $id = $this->input->post('id', true);

            //validate inputs
        $loan_mg_lst_id_q="SELECT MAX(id) as last_id FROM loan_management"; 
        $loan_mg_lst_id=$this->common_model->universal($loan_mg_lst_id_q)->row();
        $last_id=isset($loan_mg_lst_id->last_id) && !empty($loan_mg_lst_id->last_id) ? $loan_mg_lst_id->last_id + 1 : '1';
        $data=array(
            'customer_rating_repayment' => $this->input->post('customer_rating_repayment', true),
            'bad_debt_recovery_appointment' => $this->input->post('bad_debt_recovery_appointment', true),
            'customer_behavior' => $this->input->post('customer_behavior', true),
        );
        $data = $this->security->xss_clean($data);
        if ($id != '') {
            $this->admin_model->edit_option($data, $id, 'loan_management');
        }
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
    } 
    redirect(base_url('admin/LoanManagement'));
}  
public function add()
{	
    if($_POST)
    {   
        $id = $this->input->post('id', true);
        $loan_mg_lst_id_q="SELECT MAX(id) as last_id FROM loan_management"; 
        $loan_mg_lst_id=$this->common_model->universal($loan_mg_lst_id_q)->row();
        $last_id=isset($loan_mg_lst_id->last_id) && !empty($loan_mg_lst_id->last_id) ? $loan_mg_lst_id->last_id + 1 : '1';
        $data=array(
            'user_id' => user()->id,
            'customer_code' => $last_id,
            'account_number' => $this->input->post('account_number', true),
            'national_id' => $this->input->post('national_id', true),
            'customer_name' => $this->input->post('customer_name', true),
            'father_name' => $this->input->post('father_name', true),
            'mobile_no' => $this->input->post('mobile_no', true),
            'phone_no' => $this->input->post('phone_no', true),
            'email' => $this->input->post('email', true),
            'country' => $this->input->post('country', true),
            'city' => $this->input->post('city', true),
            'address' => $this->input->post('address', true),
            'loan_booked_amount' => $this->input->post('loan_booked_amount', true),
            'loan_booked_date' => $this->input->post('loan_booked_date', true),
            'repayment_due_date' => $this->input->post('repayment_due_date', true),
            'no_of_installaments' => $this->input->post('no_of_installaments', true),
            'per_installment_amount' => $this->input->post('per_installment_amount', true),
            'nature_of_bussiness' => $this->input->post('nature_of_bussiness', true),
            'customer_rating_repayment' => $this->input->post('customer_rating_repayment', true),
            'bad_debt_recovery_appointment' => $this->input->post('bad_debt_recovery_appointment', true),
            'customer_behavior' => $this->input->post('customer_behavior', true),
            'start_date' => $this->input->post('start_date', true),
            'period' => $this->input->post('period', true),
            'period_type' => $this->input->post('period_type', true),
            'guarantor1' => $this->input->post('guarantor1', true),
            'guarantor2' => $this->input->post('guarantor2', true),
            'created_at' => my_date_now(),
        );
        $data = $this->security->xss_clean($data);
        if ($id != '') {
            $this->admin_model->edit_option($data, $id, 'loan_management');
            $delete="DELETE FROM loan_management_detail WHERE loan_management_id=".$id; 
            $this->common_model->universal($delete);
            $last_id = $id;
            if (isset($last_id) && !empty($last_id)) {
                $total_amount=0;
                $due_date=$this->input->post('start_date', true);
                $due_date=date('Y-m-d' , strtotime($due_date));
                for ($i=0; $i < $_POST['no_of_installaments']  ; $i++) { 
                    $installment_no=$i+1;
                    $total_amount+=$this->input->post('per_installment_amount', true);
                    $period=$this->input->post('period', true);
                    if (isset($_POST['period_type']) && $_POST['period_type']=='Days' && $i!=0) {
                     $due_date = strtotime($due_date);
                     $due_date =date('Y-m-d', strtotime($period." day", $due_date));
                 }
                 if (isset($_POST['period_type']) && $_POST['period_type']=='Month' && $i!=0) {
                    $due_date = strtotime($due_date);
                    $due_date=date('Y-m-d', strtotime($period." month", $due_date));
                }
                $data_detail=array(
                    'user_id' => user()->id,
                    'loan_management_id' => $last_id,
                    'no_of_installment' => $installment_no,
                    'due_date' => $due_date,
                    'per_installment_amount' => $this->input->post('per_installment_amount', true),
                    'created_at' => my_date_now(),
                );
                $this->admin_model->insert($data_detail, 'loan_management_detail');
            }
            $update="UPDATE loan_management_detail SET total_amount='".$total_amount."',pending_amount='".$total_amount."' WHERE loan_management_id=".$last_id; 
            $this->common_model->universal($update);
        }
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
    } else {
        $this->admin_model->insert($data, 'loan_management');
        $last_id = $this->db->insert_id();
        if (isset($last_id) && !empty($last_id)) {
            $total_amount=0;
            $due_date=$this->input->post('start_date', true);
            $due_date=date('Y-m-d' , strtotime($due_date));
            for ($i=0; $i < $_POST['no_of_installaments']  ; $i++) { 
                $installment_no=$i+1;
                $total_amount+=$this->input->post('per_installment_amount', true);
                $period=$this->input->post('period', true);
                if (isset($_POST['period_type']) && $_POST['period_type']=='Days' && $i!=0) {
                 $due_date = strtotime($due_date);
                 $due_date =date('Y-m-d', strtotime($period." day", $due_date));
             }
             if (isset($_POST['period_type']) && $_POST['period_type']=='Month' && $i!=0) {
                $due_date = strtotime($due_date);
                $due_date=date('Y-m-d', strtotime($period." month", $due_date));
            }
            $data_detail=array(
                'user_id' => user()->id,
                'loan_management_id' => $last_id,
                'no_of_installment' => $installment_no,
                'due_date' => $due_date,
                'per_installment_amount' => $this->input->post('per_installment_amount', true),
                'created_at' => my_date_now(),
            );
            $this->admin_model->insert($data_detail, 'loan_management_detail');
        }
        $update="UPDATE loan_management_detail SET total_amount='".$total_amount."',pending_amount='".$total_amount."' WHERE loan_management_id=".$last_id; 
        $this->common_model->universal($update);
    }
    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
}
redirect(base_url('admin/LoanManagement'));
}
}     

public function getcity_country($country)
{  

    if($country)
    {   
        // trim($country);
        // filter_input(INPUT_GET,"link",FILTER_SANITIZE_STRING);
        $country=urldecode($country);
        $city_q="SELECT * FROM city WHERE country_id='".$country."'";
        $city=$this->common_model->universal($city_q)->result();
        $data='<option value="">Select City</option>';
        foreach ($city as $key => $value) {
            $data.="<option value='".$value->name."'>".$value->name."</option>";
        }
        echo $data;
    }
}
public function edit($id)
{  
    $data = array();
    $data['page_title'] = 'Edit';
    $data['loan_management'] = $this->admin_model->get_by_id($id, 'loan_management');
    $data['main_content'] = $this->load->view('admin/loanmanagement/loan',$data,TRUE);
    $this->load->view('admin/index',$data);
}

public function details($id)
{  
    $data = array();
    $data['page'] = 'Loan_Managemant_report';   
    $data['page_title'] = 'Details';   
    $WHERE='';
    $data['from'] = isset($_POST['from']) && !empty($_POST['from']) ? date('Y-m-d' ,strtotime($_POST['from'])) : '';
    $data['to'] = isset($_POST['to']) && !empty($_POST['to']) ? date('Y-m-d' ,strtotime($_POST['to'])) : '';
    $data['paid_status'] = isset($_POST['paid_status']) && !empty($_POST['paid_status']) ? $_POST['paid_status'] : '';
    if(isset($data['from']) && $data['from']!='' && $data['to'] && $data['to']!=''){
        $WHERE.="AND DATE_FORMAT(`due_date`, '%Y-%m-%d') >= '".$data['from']."' AND  DATE_FORMAT(`due_date`, '%Y-%m-%d') <= '".$data['to']."' ";
    }
    $WHERE.=isset($_POST['paid_status']) && $_POST['paid_status']=='paid' ? " AND paid_status=1" : '';
    $WHERE.=isset($_POST['paid_status']) && $_POST['paid_status']=='unpaid' ? " AND paid_status=0" : '';
    $loan_management_detail_q="SELECT * FROM loan_management_detail WHERE loan_management_id=".$id." $WHERE ORDER BY id ASC";
    $data['loan_management_detail']=$this->common_model->universal($loan_management_detail_q)->result();
    $data['loan_management'] = $this->admin_model->get_by_id($id, 'loan_management');
    $data['main_content'] = $this->load->view('admin/loanmanagement/loan_details',$data,TRUE);
    $this->load->view('admin/index',$data);
}


public function active($id,$detail_id) 
{
    $data_q="SELECT * FROM loan_management_detail WHERE id=".$id; 
    $data=$this->common_model->universal($data_q)->row();
    $per_installment_amount=$data->per_installment_amount;
    $pending_amount=$data->pending_amount - $per_installment_amount;
    $data = array(
        'pending_amount' => '0',
        'pay_date' => my_date_now(),
        'paid_status' => 1
    );
    $data = $this->security->xss_clean($data);
    $this->admin_model->update($data, $id,'loan_management_detail');
    $update="UPDATE loan_management_detail SET pending_amount='".$pending_amount."' WHERE loan_management_id=".$detail_id." AND pending_amount!='0' "; 
    $this->common_model->universal($update);
    $this->session->set_flashdata('msg', trans('activate-successfully')); 
    redirect(base_url('admin/LoanManagement/report'));
}

public function active_report($id,$detail_id) 
{
    $data_q="SELECT * FROM loan_management_detail WHERE id=".$id; 
    $data=$this->common_model->universal($data_q)->row();
    $per_installment_amount=$data->per_installment_amount;
    $pending_amount=$data->pending_amount - $per_installment_amount;
    $data = array(
        'pending_amount' => '0',
        'pay_date' => my_date_now(),
        'paid_status' => 1
    );
    $data = $this->security->xss_clean($data);
    $this->admin_model->update($data, $id,'loan_management_detail');
    $update="UPDATE loan_management_detail SET pending_amount='".$pending_amount."' WHERE loan_management_id=".$detail_id." AND pending_amount!='0' "; 
    $this->common_model->universal($update);
    $this->session->set_flashdata('msg', trans('activate-successfully')); 
    redirect(base_url('admin/LoanManagement/report'));
}

public function deactive($id) 
{
    $data = array(
        'status' => 0
    );
    $data = $this->security->xss_clean($data);
    $this->admin_model->update($data, $id,'customers');
    $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
    redirect(base_url('admin/customers'));
}

public function delete($id)
{
    $this->admin_model->delete($id,'loan_management'); 
    $delete="DELETE FROM loan_management_detail WHERE loan_management_id=".$id; 
    $this->common_model->universal($delete);
    echo json_encode(array('st' => 1));
}

}


