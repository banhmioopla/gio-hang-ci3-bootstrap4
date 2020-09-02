<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghCustomer');
	}
	public function index()
	{
		$this->show();
    }

	private function show(){
		$this->load->model('ghCustomer'); // load model ghUser
		$data['list_customer'] = $this->ghCustomer->getAll();
		
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('customer/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		$data['birthdate'] = strtotime($data['birthdate']);

		if(!empty($data['name'])) {
			$result = $this->ghCustomer->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'thêm khách hàng: '.$data['name'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-customer');
		}
	}

	// Ajax
	public function update() {
		$customer_id = $this->input->post('customer_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
		if(!empty($customer_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghCustomer->updateById($customer_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$customer_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');
		if(!empty($customer_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_customer = $this->ghCustomer->getById($customer_id);
			$old_log = json_encode($old_customer[0]);
			if($field_name == 'birthdate') {
				$data['birthdate'] = strtotime($data['birthdate']);
			}

			$result = $this->ghCustomer->updateById($customer_id, $data);
			
			$modified_customer = $this->ghCustomer->getById($customer_id);
			$modified_log = json_encode($modified_customer[0]);
			
			$log = [
				'table_name' => 'gh_customer',
				'old_content' => $old_log,
				'modified_content' => $modified_log,
				'time_insert' => time(),
				'action' => 'update'
			];
			$tracker = $this->ghActivityTrack->insert($log);

			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function delete(){
		$customer_id = $this->input->post('customer_id');
		if(!empty($customer_id)) {
			$old_customer = $this->ghCustomer->getById($customer_id);

			$log = [
				'table_name' => 'gh_customer',
				'old_content' => null,
				'modified_content' => json_encode($old_customer[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghCustomer->delete($customer_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */