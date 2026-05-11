<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends Home_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Product_model');
        // Load the Stripe library
        // require_once(APPPATH.'libraries/Stripe/init.php');
        // Load config
        // $this->load->config('stripe');
        // \Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));
    }
    
     public function index($id) {
        
        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

        $data = array();
        $data['page'] = 'PayLinks';
        $data['page_title'] = 'Payment Link Customer';
        $data['products'] = $this->common_model->select_option($id, 'payment_links'); // Get product by id

        $data['product_id'] = $data['products'][0]['id'];
        $business_id = $data['products'][0]['business_id'];
        $payment_modal_type = $data['products'][0]['payment_modal_type'];
        if($payment_modal_type != 'checkout'){
            redirect(base_url('404_override'));
        }
        // $business_id = $data['products']->business_id;

        //use the product to get the business_id
        $slug = $this->admin_model->get_business_uid($business_id);
        //use the business_id to get the slug
        $data['business_id'] = $business_id;
        $data['slug'] = $slug->slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug->slug, 'business');
        if(empty($data['company'])){
            redirect(base_url('404_override'));
        }
        $data['post_method'] = 'checkout';
        
        $data['main_content'] = $this->load->view('payment_view', $data, TRUE);
        $this->load->view('index', $data);
        
    }
   
    public function confirm_payment() {
        
        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        $data = array();
        $data['page'] = 'PayLinks';
        $data['page_title'] = 'Payment Link Element';

        
        $price = $this->input->post('customer_price');
        $customerId = $this->input->post('customer_id');
        $payment_modal_type = $this->input->post('payment_modal_type');
        $newCustomerName = $this->input->post('name');
        $newCustomerEmail = $this->input->post('email');
        $product_id = $this->input->post('product_id');
        
        $data['products'] = $this->common_model->select_option($product_id, 'payment_links'); // Get product by id

        $data['product_id'] = $data['products'][0]['id'];
        $business_id = $data['products'][0]['business_id'];
        // $business_id = $data['products']->business_id;

        //use the product to get the business_id
        $slug = $this->admin_model->get_business_uid($business_id);
        //use the business_id to get the slug
        $data['business_id'] = $business_id;
        $data['slug'] = $slug->slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug->slug, 'business');
        if(empty($data['company'])){
            redirect(base_url('404_override'));
        }
        
        $product_name = $data['products'][0]['product_name'];
        $product_description = $data['products'][0]['product_description'];
        $product = $data['products'][0]['payment_description'];
        $currency = $data['products'][0]['currency'];
        
        $stripe_customer_id;
    
        if($_POST)
        { 
            
            if ($payment_modal_type = 'new' && !$customerId) {
                $data['customer'] = $this->common_model->select_options($newCustomerEmail, 'email', 'customer'); // Get product by id
                $talos_customer_email = $data['customer'][0]['id'];
                if ($talos_customer_email) {
                    $this->session->set_flashdata('error', 'Error saving customer to database.'); 
                    log_message('error', 'Error saving customer to database.');
                    redirect(base_url('element/'.$product_id));
                }
                $this->form_validation->set_rules('email', 'email', 'required');
                $this->form_validation->set_rules('name', 'name', 'required');
    
                if ($this->form_validation->run() === false) {
                    $this->session->set_flashdata('errors', validation_errors());
                    redirect(base_url('element/'.$product_id));
                }
                else{
                    $customer = \Stripe\Customer::create([
                        'email' => $newCustomerEmail,
                        'name' => $newCustomerName
                    ]);
                    if ($customer) {
                        log_message('info', 'Stripe customer created: ' . $customer->id);
                        
                        $data=array(
                            'uuid' => $customer->id,
                            'name' => $newCustomerName,
                            'email' => $newCustomerEmail,
                            'created_at' => my_date_now()
                        );
                        // Save customer to database
                        $talos_customer_id = $this->common_model->insert($data, 'customer');
                        if (!$talos_customer_id) {
                            log_message('error', 'Error saving customer to database.');
                        }
                        $pay_link=array(
                            'product_id' => $product_id,
                            'price' => $price,
                            'product_name' => $product_name,
                            'product_description' => $product_description,
                            'payment_description' => $product,
                            'customer_id' => $talos_customer_id,
                            'status' => 'pending',
                            'created_at' => my_date_now()
                        );
                        $user_pay_link_id = $this->common_model->insert($pay_link, 'user_pay_link');
                        $stripe_customer_id = $customer->id;
                    }
                }
            }
            elseif ($payment_modal_type = 'old') {
                $data['customer'] = $this->common_model->select_options($customerId, 'email', 'customer'); // Get product by id
                $talos_customer_id = $data['customer'][0]['id'];
                if (!$talos_customer_id) {
                    $this->session->set_flashdata('error', 'Customer not found'); 
                    log_message('error', 'Error saving customer to database.');
                    redirect(base_url('element/'.$product_id));
                }
                $pay_link=array(
                    'product_id' => $product_id,
                    'price' => $price,
                    'product_name' => $product_name,
                    'product_description' => $product_description,
                    'payment_description' => $product,
                    'customer_id' => $talos_customer_id,
                    'status' => 'pending',
                    'created_at' => my_date_now()
                );
                $user_pay_link_id = $this->common_model->insert($pay_link, 'user_pay_link');
                $stripe_customer_id = $data['customer'][0]['uuid'];
            }
            else{
                $this->session->set_flashdata('error', 'No account select set');
                log_message('error', 'no account select set');
                redirect(base_url('element/'.$product_id));
            }
        }
        
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $price * 100,  // Convert to cents
                'currency' => $currency,  // Set currency based on your needs
                'customer' => $stripe_customer_id, // Set the customer
                'metadata' => ['service_id' => $user_pay_link_id, 'product_name' => $data['products'][0]['product_name']],
                'automatic_payment_methods' => ['enabled' => true],
                'description' => $product,
            ]);
            
            // Pass the client secret to the view to process the payment
            $data['client_secret'] = $paymentIntent->client_secret;
        } catch (Exception $e) {
            show_error($e->getMessage());
        }
        
        $data['main_content'] = $this->load->view('payment_element', $data, TRUE);
        $this->load->view('index', $data);
    }

    
    public function element($id) {
        $data = array();
        $data['page'] = 'PayLinks';
        $data['page_title'] = 'Payment Link Customer';
        $data['products'] = $this->common_model->select_option($id, 'payment_links'); // Get product by id

        $data['product_id'] = $data['products'][0]['id'];
        $business_id = $data['products'][0]['business_id'];
        $payment_modal_type = $data['products'][0]['payment_modal_type'];
        if($payment_modal_type != 'element'){
            redirect(base_url('404_override'));
        }
          	
        // $business_id = $data['products']->business_id;

        //use the product to get the business_id
        $slug = $this->admin_model->get_business_uid($business_id);
        //use the business_id to get the slug
        $data['business_id'] = $business_id;
        $data['slug'] = $slug->slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug->slug, 'business');
        if(empty($data['company'])){
            redirect(base_url('404_override'));
        }
        
        // $data['client_secret'] = $this->session->userdata('client_secret');
        // $data['client_secret'] = $paymentIntent->client_secret;
    
        $data['post_method'] = 'element';
        
        $data['main_content'] = $this->load->view('payment_view', $data, TRUE);
        $this->load->view('index', $data);
        
    }

    public function return() {
        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        $data = array();
        $data['page'] = 'PayLinks';
        $data['page_title'] = 'Payment Link Customer';
        $data['slug'] = 'success';
        $data['menu'] = FALSE;
        
        $paymentIntentId = $this->input->get('payment_intent');

        // Fetch the PaymentIntent from Stripe
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            
            // Pass the payment intent data to the view
            $data['paymentIntents'] = $paymentIntent;
              // Store transaction in the database
            $user_pay_id = $paymentIntent->metadata->service_id;
            $existingTransaction = $this->common_model->get_row('transactions', array('user_pay_link_id' => $user_pay_id, 'payment_intent' => $paymentIntent->id));
            if (!$existingTransaction) {
                // Store the transaction only if it doesn't exist already
                $pay_link = array(
                    'user_pay_link_id' => $user_pay_id,
                    'payment_intent' => $paymentIntent->id,
                    'amount' => $paymentIntent->amount_received,
                    'currency' => $paymentIntent->currency,
                    'status' => $paymentIntent->status,
                    'created_at' => my_date_now(),
                );
                $this->common_model->insert($pay_link, 'transactions');
    
                // Update the user pay link status if it's not already set to 'success'
                if ($paymentIntent->status == 'succeeded') {
                    $data = array(
                        'status' => "success"
                    );
                    $this->common_model->edit_option($data, $user_pay_id, 'user_pay_link');
                }
            }

            // Load the view to display payment information
            $data['main_content'] = $this->load->view('success', $data, TRUE);
            $this->load->view('index', $data);
            // $this->load->view('payment_status', $data);
        } catch (Exception $e) {
            // Handle the error if something goes wrong
            $data['error'] = $e->getMessage();
            // $this->load->view('failed', $data);
            $data['main_content'] = $this->load->view('failed', $data, TRUE);
            $this->load->view('index', $data);
        }
        
        
    }
    
    
    public function stripePost()

    {

        require_once('application/libraries/stripe-php/init.php');

    

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

     

        \Stripe\Charge::create ([

                "amount" => 100 * 100,

                "currency" => "usd",

                "source" => $this->input->post('stripeToken'),

                "description" => "Test payment from itsolutionstuff.com." 

        ]);

            

        $this->session->set_flashdata('success', 'Payment made successfully.');

             

        redirect('/my-stripe', 'refresh');

    }
    public function create_checkout_session() {
        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        $price = $this->input->post('customer_price');
        $customerId = $this->input->post('customer_id');                                                                                                                                                                         
        $payment_modal_type = $this->input->post('payment_modal_type');
        $newCustomerName = $this->input->post('name');
        $newCustomerEmail = $this->input->post('email');
        $product_id = $this->input->post('product_id');
        $data['products'] = $this->common_model->select_option($product_id, 'payment_links'); // Get product by id
        $product_name = $data['products'][0]['product_name'];
        $product_description = $data['products'][0]['product_description'];
        $product = $data['products'][0]['payment_description'];
        $currency = $data['products'][0]['currency'];
        $stripe_customer_id;
    
        if ($payment_modal_type = 'new' && !$customerId) {
            $data['customer'] = $this->common_model->select_options($newCustomerEmail, 'email', 'customer'); // Get product by id
            $talos_customer_email = $data['customer'][0]['id'];
            if ($talos_customer_email) {
                $this->session->set_flashdata('error', 'Customer duplication not allowed'); 
                log_message('error', 'Error saving customer to database.');
                redirect(base_url('checkout/'.$product_id));
            }
            $this->form_validation->set_rules('email', 'email', 'required');
            $this->form_validation->set_rules('name', 'name', 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect(base_url('checkout/'.$product_id));
            }
            else{
                $customer = \Stripe\Customer::create([
                    'email' => $newCustomerEmail,
                    'name' => $newCustomerName
                ]);
                if ($customer) {
                    log_message('info', 'Stripe customer created: ' . $customer->id);
                    
                    $data=array(
                        'uuid' => $customer->id,
                        'name' => $newCustomerName,
                        'email' => $newCustomerEmail,
                        'created_at' => my_date_now()
                    );
                    // Save customer to database
                    $talos_customer_id = $this->common_model->insert($data, 'customer');
                    if (!$talos_customer_id) {
                        log_message('error', 'Error saving customer to database.');
                        $this->session->set_flashdata('msg', trans('updated-successfully')); 
                    }
                    $pay_link=array(
                        'product_id' => $product_id,
                        'price' => $price,
                        'product_name' => $product_name,
                        'product_description' => $product_description,
                        'payment_description' => $product,
                        'customer_id' => $talos_customer_id,
                        'status' => 'pending',
                        'created_at' => my_date_now()
                    );
                    $user_pay_link_id = $this->common_model->insert($pay_link, 'user_pay_link');
                    $stripe_customer_id = $customer->id;
                }
            }
        }
        elseif ($payment_modal_type = 'old') {
            $data['customer'] = $this->common_model->select_options($customerId, 'email', 'customer'); // Get product by id
            $talos_customer_id = $data['customer'][0]['id'];
            if (!$talos_customer_id) {
               $this->session->set_flashdata('error', 'Customer not found'); 
                log_message('error', 'Error saving customer to database.');
                redirect(base_url('checkout/'.$product_id));
            }
            $pay_link=array(
                'product_id' => $product_id,
                'price' => $price,
                'product_name' => $product_name,
                'product_description' => $product_description,
                'payment_description' => $product,
                'customer_id' => $talos_customer_id,
                'status' => 'pending',
                'created_at' => my_date_now()
            );
            $user_pay_link_id = $this->common_model->insert($pay_link, 'user_pay_link');
            $stripe_customer_id = $data['customer'][0]['uuid'];
        }
        else{
            $this->session->set_flashdata('error', 'no account select set');
            log_message('error', 'no account select set'); 
            redirect(base_url('checkout/'.$product_id));
        }
    
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $currency,  // Currency type
                        'product_data' => [
                            'name' => $product,
                        ],
                        'unit_amount' => $price * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => base_url('checkout-payment/success?user_pay_link='.$user_pay_link_id.'&session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => base_url(),
            'customer' => $stripe_customer_id,  // Associate customer with the session
        ]);
    
        $this->session->set_flashdata('success', 'Payment made successfully.');
        // Redirect to Stripe checkout
        redirect($session->url);
    }

    

    public function success(){
        
        require_once('application/libraries/stripe-php/init.php');

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        
        $data = array();
        $data['page'] = 'PayLinks';
        $data['page_title'] = 'Payment Link Customer';
        $data['slug'] = 'success';
        $data['menu'] = FALSE;
        
        $user_pay_id = $this->input->get('user_pay_link');
        $sessionId = $this->input->get('session_id');
        $data['$user_pay_id'] = $user_pay_id;
        $data['sessionId'] = $sessionId;

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
            
            $existingTransaction = $this->common_model->get_row('transactions', array('user_pay_link_id' => $user_pay_id, 'payment_intent' => $paymentIntent->id));
        
            if (!$existingTransaction) {
                // Store the transaction only if it doesn't exist already
                $pay_link = array(
                    'user_pay_link_id' => $user_pay_id,
                    'payment_intent' => $paymentIntent->id,
                    'amount' => $paymentIntent->amount_received / 100,
                    'currency' => $paymentIntent->currency,
                    'status' => $paymentIntent->status,
                    'created_at' => my_date_now(),
                );
                $this->common_model->insert($pay_link, 'transactions');
    
                // Update the user pay link status if it's not already set to 'success'
                if ($paymentIntent->status == 'succeeded') {
                    $data = array(
                        'status' => "success"
                    );
                    $this->common_model->edit_option($data, $user_pay_id, 'user_pay_link');
                }
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error
            echo 'Error: ' . $e->getMessage();
        }
        
        $data['main_content'] = $this->load->view('success', $data, TRUE);
        $this->load->view('index', $data);
    }
    
    public function failed(){
        $data = array();
        $data['page'] = 'PayLinks';
        $data['page_title'] = 'Payment Link Customer';
        $data['slug'] = 'failed';
        $data['menu'] = FALSE;
        
        $data['main_content'] = $this->load->view('failed', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function create_payment_link() {
        
        $service = $this->db->get_where('services', ['id' => 234])->row();

        if (!$service) {
            show_error('Service not found');
            return;
        }
 
        
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $service->price * 100,  // Convert to cents
                'currency' => 'usd',  // Set currency based on your needs
                'metadata' => ['service_id' => $service_id],
            ]);
            
            // Pass the client secret to the view to process the payment
            $data['client_secret'] = $paymentIntent->client_secret;
            $data['service'] = $service;
            $this->load->view('product_element', $data);
        } catch (Exception $e) {
            show_error($e->getMessage());
        }
        
        
        // // Create PaymentIntent with price
        // try {
        //     $paymentIntent = \Stripe\PaymentIntent::create([
        //         'amount' => $price * 100, // Convert the price to cents
        //         'currency' => 'eur', // Set your currency
        //         'customer' => $customer->id, // Set the customer
        //         'automatic_payment_methods' => ['enabled' => false],
        //         'payment_method_types' => [
        //             'card',
        //         ],
        //         'description' => "fgg",
        //     ]);
            
        //     // You can save the payment details and customer details as needed
        //     $this->session->set_userdata('client_secret', $paymentIntent->client_secret);
        //     // Return the success or error
        //     echo json_encode(['client_secret' => $paymentIntent->client_secret]);
    
        // } catch (\Stripe\Exception\ApiErrorException $e) {
        //     // Handle error
        //     echo json_encode(['error' => $e->getMessage()]);
        // }
    }


    public function save_customer_details($payment_intent_id) {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        
        // Check if payment is successful
        if ($paymentIntent->status == 'succeeded') {
            $customer = $paymentIntent->charges->data[0]->billing_details;

            // Save customer details in your database (e.g., name, email)
            $data = [
                'email' => $customer->email,
                'name' => $customer->name,
                // Add other details as needed
            ];
            
            $this->db->insert('customers', $data);
        }
    }
}
