<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_staff() && !is_admin()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Country';      
        $data['page'] = 'Settings';   
        // $data['customer'] = FALSE;
        $data['loanmanagement'] = $this->admin_model->select_by_user('country');
        $data['main_content'] = $this->load->view('admin/area/city',$data,TRUE);
        $this->load->view('admin/index',$data);
    }
    public function city()
    {
        $data = array();
        $data['page_title'] = 'Country';      
        $data['page'] = 'Settings';   
        $data['city'] = $this->common_model->get_all('city');
        $data['main_content'] = $this->load->view('admin/area/city',$data,TRUE);
        $this->load->view('admin/index',$data);
    }
    public function add_area()
    {	
        if($_POST)
        {   
            $id = $this->input->post('id', true);
            $code = $this->input->post('code', true);
            $where_city_q=isset($id) && $id!= '' ? ' AND id!='.$id : ''; 
            $city_code_q="SELECT * FROM city WHERE code='".$code."' ".$where_city_q.""; 
            $city_code=$this->common_model->universal($city_code_q);
            if($city_code->num_rows() > 0) {   
                $this->session->set_flashdata('msg', 'This City Code '.$code.' Already Exists');
                if ($id != '') {
                    redirect(base_url('admin/Area/edit_city/'.$id));
                }
            }else{
                $data=array(
                    'country_id' => $this->input->post('country_id', true),
                    'code' => $this->input->post('code', true),
                    'name' => $this->input->post('name', true),
                );
                $data = $this->security->xss_clean($data);
                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'city');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    $this->admin_model->insert($data, 'city');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }
            }
            redirect(base_url('admin/Area/city'));
        }
    }     

    public function edit_city($id)
    {  
        $data = array();
        $data['page_title'] = 'Country';   
        $data['page'] = 'Settings';  
        $data['city'] = $this->common_model->get_by_id($id, 'city');
        $data['main_content'] = $this->load->view('admin/area/city',$data,TRUE);
        $this->load->view('admin/index',$data);
    }
    public function delete_city($id)
    {
        $this->admin_model->delete($id,'city'); 
        echo json_encode(array('st' => 1));
    }

}


