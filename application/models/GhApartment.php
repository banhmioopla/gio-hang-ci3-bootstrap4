<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartment extends CI_Model {
    private $table = 'gh_apartment';

	public function get($where = [], $orderByString = null) {
	    if($orderByString) {
            $this->db->order_by($orderByString);
        } else {
            $this->db->order_by('order_item ASC,  id DESC, address_street ASC'); // comment xxx
        }

        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getLike($like = []) {
        $this->db->from($this->table);
        $this->db->or_like($like);
        return $this->db->get()->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
	}
	
	public function getByDistrictId($district_id) {
        return $this->db->get_where($this->table, ['district_id' => $district_id])->result_array();
    }

    public function getById($apartment_id) {
        return $this->db->get_where($this->table, ['id' => $apartment_id])->result_array();
    }

    public function getAll() {
        $this->db->order_by('id','DESC'); 
        $result = $this->db->get_where($this->table)->result_array();
        return $result;
    }

    public function getByUserDistrict($account_id) {
        $q = "SELECT * FROM gh_apartment, gh_user_district 
                WHERE gh_apartment.district_code = gh_user_district.district_code AND gh_user_district.user_id = $account_id
        ";
        // if($account_id == 2019 or $account_id == 171020010) {
        //     $q = "SELECT * FROM gh_apartment, gh_user_district 
        //         WHERE gh_apartment.district_code = gh_user_district.district_code AND gh_user_district.user_id = $account_id AND gh_apartment.district_code = '7'";
        // }
        $result = $this->db->query($q);
        return $result->result_array();
    }

    public function getByDistrictReport($set_district) {
        $q = "SELECT * FROM gh_apartment 
                WHERE FIND_IN_SET(gh_apartment.district_code, '".$set_district."')  
                AND gh_apartment.active = 'YES'
        ";
        $result = $this->db->query($q);
        return $result->result_array();
    }

    public function getFirstById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateById($apartment_id, $data) {
        $this->db->where('id', $apartment_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($apartment_id) {
        $this->db->where('id' , $apartment_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getListCol() {
        $result = $this->db->get_where($this->table, ['id > ' => 1])->row_array();
        $out =  [];

        foreach ($result as $col => $val) {
            $out[] = $col;
        }

        return $out;
	}
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */