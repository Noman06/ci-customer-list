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
      $data = array(
         'name'  => $this->input->post('name'),
         'state' => $this->input->post('state'),
         'type'  => $this->input->post('type')
     );
     $this->db->where('id', $this->input->post('id'));
     return $this->db->update('customers', $data);

   }

   public function get_all()
   {
      $this->db->select('*');
      $this->db->from('customers');
      $query = $this->db->get();
      return $query->result();
   }

   public function delete()
   {
      $this->db->where('id', $this->input->post('id'));
      $this->db->delete('customers');
   }

}