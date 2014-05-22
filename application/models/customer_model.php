<?php
class Customer_model extends CI_Model {

   public function __construct()
   {
      $this->load->database();
   }

   public function save_customer()
   {

      $data = array(
         'name'        => $this->input->post('name'),
         'state'       => $this->input->post('state'),
         'prospect_id' => $this->input->post('prospect_id')
      );

      return $this->db->insert('customers', $data);
   }

   public function update_customer()
   {

   }

   public function get_all()
   {
      $this->db->select('*');
      $this->db->from('customers');
      $query = $this->db->get();
      return $query->result();
   }

}