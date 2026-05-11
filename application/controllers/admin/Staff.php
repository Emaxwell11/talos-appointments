<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends Home_Controller {

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
        $data['page_title'] = 'Staff';      
        $data['page'] = 'Staff';   
        $data['staff'] = FALSE;
        $data['staffs'] = $this->admin_model->select_by_user('staffs');
        $data['services'] = $this->admin_model->select_by_user('services');
        $data['locations'] = $this->admin_model->get_locations(0);
        $data['sub_locations'] = $this->admin_model->get_locations(1);
        $data['main_content'] = $this->load->view('admin/user/staff',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {	
        check_status();

        if($_POST)
        {   

            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('name', trans('name'), 'required|max_length[100]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/staff'));
            } else {
                if ($id != '') {
                    $password = $this->input->post('password');
                    if (empty($password)) {
                        $staff = $this->admin_model->get_by_id($id, 'staffs');
                        $password = $staff->password;
                    } else {
                        $password = hash_password($this->input->post('password'));
                    }
                    
                    
                } else {
                    $password = hash_password($this->input->post('password'));
                }

                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'name' => $this->input->post('name', true),
                    'slug' => str_slug($this->input->post('name', true)),
                    'email' => $this->input->post('email', true),
                    'phone' => $this->input->post('phone', true),
                    'status' => $this->input->post('status'),
                    'image' => 'assets/images/no-photo.png',
                    'thumb' => 'assets/images/no-photo-sm.png',
                    'password' => $password,
                    'created_at' => my_date_now(),
                );
                $data = $this->security->xss_clean($data);

                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'staffs');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {

                    $total = get_total_value('staffs');
                    if (ckeck_plan_limit('staffs', $total) == FALSE) {
                        $this->session->set_flashdata('error', trans('reached-maximum-limit'));
                        redirect(base_url('admin/staff'));
                        exit();
                    }
                    
                    $id = $this->admin_model->insert($data, 'staffs');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }

                if (!empty($this->input->post('location_id'))) {
                    $this->admin_model->delete_staff_location($id, 'staff_locations');
                    foreach ($this->input->post('sub_location_id') as $sub_location) {
                        $sub_locations = explode(",", $sub_location);
                        for ($i=0; $i < count($sub_locations); $i++) { 

                            $lc_data = array(
                                'business_id' => $this->business->uid,
                                'staff_id' => $id,
                                'location_id' => $this->input->post('location_id'),
                                'sub_location_id' => $sub_locations[$i]
                            );
                            $this->admin_model->insert($lc_data, 'staff_locations');
                        }
                    }
                }

                redirect(base_url('admin/staff'));

            }
        }      
        
    }

    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['staff_locations'] = $this->admin_model->get_staff_locations($id);
        $data['staff_sub_locations'] = $this->admin_model->get_staff_sub_locations($data['staff_locations'][0]->location_id);
        $data['staff'] = $this->admin_model->select_option($id, 'staffs');
        $data['services'] = $this->admin_model->select_by_user('services');
        $data['locations'] = $this->admin_model->get_locations(0);
        $data['sub_locations'] = $this->admin_model->get_locations(1);
        $data['main_content'] = $this->load->view('admin/user/staff',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'staffs');
        $this->session->set_flashdata('msg', trans('activate-successfully')); 
        redirect(base_url('admin/staff'));
    }

    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'staffs');
        $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        redirect(base_url('admin/staff'));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'staffs'); 
        echo json_encode(array('st' => 1));
    }

}
	

