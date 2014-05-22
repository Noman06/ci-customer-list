<?php
class Customer extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->model('customer_model');
   }

   public function create()
   {
      $this->customer_model->save_customer();
   }

   public function update()
   {
      $this->customer_model->update_customer();
   }

   public function get_all()
   {
      $result = $this->customer_model->get_all();
      echo json_encode($result);

   }

   public function remove()
   {
      $this->customer_model->delete();
   }
}