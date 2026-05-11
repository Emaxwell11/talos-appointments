<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paylinks extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Payment Links';     
        $data['page'] = 'Payment Links';   
        $data['paylinks'] = FALSE;
        $data['category'] = FALSE;
        $data['categoriesx'] = $this->admin_model->select('categories');
        $countries = $this->admin_model->select('country');
        
        $custom_order = ['United States', 'Canada', 'Australia', 'Austria', 'United Kingdom', 'Nigeria', 'Mali', 'Cameroon', 'Uganda', 'South Africa', 'Kenya'];
        
        $selected_countries = array_filter($countries, function($country) use ($custom_order) {
            return in_array($country->name, $custom_order);
        });
        
        usort($selected_countries, function($a, $b) use ($custom_order) {
            $a_index = array_search($a->name, $custom_order);
            $b_index = array_search($b->name, $custom_order);
            return $a_index - $b_index;
        });

        $data['countries'] = $selected_countries;
        $data['servicess'] = $this->admin_model->select_by_user('services');
        $data['staffs'] = $this->admin_model->select_by_user('staffs');
        $data['pay_links'] = $this->admin_model->select_by_user('payment_links');
        $data['main_content'] = $this->load->view('admin/user/pay_links',$data,TRUE);
        $this->load->view('admin/index',$data);
    }
    
    public function invoice($transaction_id) {
        $tx = $this->Common_model->get_transaction_by_id($transaction_id);
        if (!$tx) { show_404(); }
        $data = ['tx' => $tx, 'doc_type' => 'invoice', 'title' => 'Invoice #'.$tx['id']];
        $this->load->view('admin/transactions/invoice_receipt', $data);
    }
    
    public function receipt($transaction_id) {
        $tx = $this->Common_model->get_transaction_by_id($transaction_id);
        if (!$tx) { show_404(); }
        $download = $this->input->get('download') == '1';
    
        // If you have dompdf configured, you can stream a PDF. Otherwise render HTML.
        if ($download && class_exists('Dompdf\Dompdf')) {
            $html = $this->load->view('admin/transactions/invoice_receipt',
                ['tx'=>$tx,'doc_type'=>'receipt','title'=>'Receipt #'.$tx['id']], true);
    
            $dompdf = new Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('receipt_'.$tx['id'].'.pdf', ['Attachment' => true]);
            return;
        }
    
        $data = ['tx' => $tx, 'doc_type' => 'receipt', 'title' => 'Receipt #'.$tx['id']];
        $this->load->view('admin/transactions/invoice_receipt', $data);
    }



    public function add()
    {	
        check_status();

        if($_POST)
        {   
            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('product_name', trans('product-name'), 'required');
            
            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/paylinks'));
            } else {

                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'product_name' => $this->input->post('product_name', true),
                    'product_description' => $this->input->post('product_description', true),
                    'category' => $this->input->post('category', true),
                    'payment_description' => $this->input->post('payment_description', true),
                    'payment_modal_type' => $this->input->post('payment_modal_type', true),
                    'currency' => $this->input->post('currency', true),
                    'price_min' => $this->input->post('price_min', true),
                    'price_max' => $this->input->post('price_max', true),
                    'status' => $this->input->post('status', true),
                    'created_at' => my_date_now()
                );
                
                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'payment_links');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    
                    $id = $this->admin_model->insert($data, 'payment_links'); 
                }

                $data_link = $this->input->post('payment_modal_type');
                if ($data_link == "element") {
                    $data['payment_link'] = "https://marketspace.taloscorporation.com/element/".$id;
                }
                if ($data_link == "checkout") {
                    $data['payment_link'] = "https://marketspace.taloscorporation.com/checkout/".$id;
                }
                $this->admin_model->edit_option($data, $id, 'payment_links');
                
               
                $this->session->set_flashdata('msg', trans('inserted-successfully'));
                redirect(base_url('admin/paylinks'));

            }
        }      
        
    }
    
    public function get_transactions($service_id)
    {
        // Load the necessary model if not already loaded
        // $this->load->model('Transaction_model');
    
        // Fetch transactions based on the service ID
        $transactions = $this->admin_model->get_transactions_by_paylink_id($service_id);
    
        // Return the transactions as JSON
        echo json_encode($transactions);
    }


    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';  
        // $data['categories'] = $this->admin_model->select_by_user('service_category');
        $data['categoriesx'] = $this->admin_model->select('categories');
        $countries = $this->admin_model->select('country');
        
        $custom_order = ['United States', 'Canada', 'Australia', 'Austria', 'United Kingdom', 'Nigeria', 'Mali', 'Cameroon', 'Uganda', 'South Africa', 'Kenya'];
        
        $selected_countries = array_filter($countries, function($country) use ($custom_order) {
            return in_array($country->name, $custom_order);
        });
        
        usort($selected_countries, function($a, $b) use ($custom_order) {
            $a_index = array_search($a->name, $custom_order);
            $b_index = array_search($b->name, $custom_order);
            return $a_index - $b_index;
        });

        // Pass the filtered list to the view
        $data['countries'] = $selected_countries;
        $data['paylinks'] = $this->admin_model->select_option($id, 'payment_links');
        // $data['pay_links'] = $this->admin_model->select_by_user('payment_links');  
        $data['main_content'] = $this->load->view('admin/user/pay_links',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    
    public function add_category()
    {	
        check_status();

        if($_POST)
        {   
            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('name', trans('name'), 'required');
            
            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/pay_links'));
            } else {

                if (empty($this->input->post('orders'))) {
                    $orders = 0;
                }else{
                    $orders = $this->input->post('orders');
                }

                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'name' => $this->input->post('name', true),
                    'status' => $this->input->post('status', true),
                    'orders' => $orders
                );
                $data = $this->security->xss_clean($data);
                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'service_category');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    $id = $this->admin_model->insert($data, 'service_category');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }

                redirect(base_url('admin/pay_links'));

            }
        }      
        
    }

    public function edit_category($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit Category';   
        $data['category'] = $this->admin_model->select_option($id, 'service_category');
        $data['main_content'] = $this->load->view('admin/user/pay_links',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function category_update($status) 
    {
        $data = array(
            'enable_category' => $status
        );
        $this->admin_model->edit_option($data, $this->business->id, 'business');
        
        if ($status == 1) {
            $this->session->set_flashdata('msg', trans('activate-successfully')); 
        } else {
            $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        }
        
        echo json_encode(array('st' => 1));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'payment_links'); 
        echo json_encode(array('st' => 1));
    }

    public function delete_category($id)
    {
        $this->admin_model->delete($id,'service_category'); 
        echo json_encode(array('st' => 1));
    }

}
	

