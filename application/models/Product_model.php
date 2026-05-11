<?php
class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all products
    public function get_all_products() {
        $query = $this->db->get('products');  // 'products' is the table name in your database
        return $query->result_array();
    }

    // Get a single product by ID
    public function get_product($product_id) {
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        return $query->row_array();
    }
}
?>
