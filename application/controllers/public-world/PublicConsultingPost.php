<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicConsultingPost extends CI_Controller {

    public function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        parent::__construct();
        $this->load->model(['ghRoom', 'ghContract', 'ghUser','ghCustomer', 'ghContractPartial']);
        $this->load->model('ghApartment');
        $this->load->model('ghImage');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghPublicConsultingPost');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->load->library('LibUser', null, 'libUser');
        $this->public_dir = 'public-world/';

        $this->timeFrom = date("06-m-Y");
        $this->timeTo = date("05-m-Y",strtotime($this->timeFrom.' +1 month'));
        if(strtotime(date("d-m-Y")) < strtotime(date("5-m-Y"))){
            $this->timeFrom = date("06-m-Y", strtotime("-1 month"));
            $this->timeTo = date("05-m-Y");
        }

    }

    public function detailShow(){
        $post_id = $this->input->get('id');
        $this_post = $this->ghPublicConsultingPost->getFirstById($post_id);
        $this_post_img = json_decode($this_post['image_set'], true);
        $room = $this->ghRoom->getFirstById($this_post['room_id']);
        $user = $this->ghUser->getFirstByAccountId($this_post['user_create_id']);
        $apartment = null;
        if($room) {
            $apartment = $this->ghApartment->getFirstById($room['apartment_id']);
        }

        $list_img = [];
        if($this_post_img && count($this_post_img)) {
            foreach ($this_post_img as $img_id) {
                $img_model = $this->ghImage->getFirstById($img_id);
                if($img_model) {
                    $list_img[] = $img_model;
                }
            }
        }

        $this->load->view($this->public_dir.'components/header', [
            'title_page' => "Sinva Home - Dự Án ". $this_post['title'],
            'post_title' => $this_post['title'],
        ]);
        $this->load->view($this->public_dir.'consulting-post/detail-show', [
            'list_img' => $list_img,
            'apartment' => $apartment,
            'room' => $room,
            'post' => $this_post,
            'user' => $user,
            'libBaseRoomType' => $this->libBaseRoomType
        ]);
        $this->load->view($this->public_dir.'components/footer');

    }

    public function exportToGoogleSheet(){
        $token = $this->input->get('token');
        $timeFrom = $this->input->get('timeFrom');
        $timeTo = $this->input->get('timeTo');
        $data = [];
        $timeFrom = $this->timeFrom;
        $timeTo = $this->timeTo;

        $income_standard_rate = .55;

        if(!empty($token)){
            switch ($token){

                case 1: // Đội nhóm Thu nhập
                        $list_user = $this->ghUser->get(['active' => 'YES']);
                        $list_contract_supporter = $this->ghContract->get([
                            'time_check_in >=' => strtotime($timeFrom),
                            'time_check_in <=' => strtotime($timeTo) +86399,
                            'arr_supporter_id <>' => null,
                            'status' => "Active"
                        ]);
                        foreach ($list_user as $user) {
                            $count_contract = $income = 0;


                            foreach ($list_contract_supporter as $con) {
                                if(!empty($con["arr_supporter_id"])){
                                    $arr = json_decode($con["arr_supporter_id"], true);
                                    if(in_array($user['account_id'], $arr)){
                                        $count_contract++;
                                    }
                                }
                            }

                            $list_contract = $this->ghContract->get([
                                'time_check_in >=' => strtotime($timeFrom),
                                'time_check_in <=' => strtotime($timeTo) +86399,
                                'consultant_id' =>$user['account_id'],
                                'status' => "Active"
                            ]);
                            $count_contract+= count($list_contract);
                            $rate_star = $this->ghContract->getTotalRateStar($user['account_id'], $timeFrom, $timeTo);


                            if($rate_star >= 6){
                                foreach ($list_contract as $con){
                                    $income += $con['commission_rate']*$con['room_price']/100 * $income_standard_rate;
                                }
                            } else {
                                foreach ($list_contract as $con){
                                    $income += $con['commission_rate']*$con['room_price']/100 * (1-$income_standard_rate);
                                }
                            }
                            if($count_contract) {
                                $data[] = [
                                    "Source" => "GH",
                                    "Account" => $user["account_id"],
                                    "Tên" => $user["name"],
                                    "Ngày vào làm" => date("d-m-Y", $user["time_joined"]),
                                    "Số (*)" => $rate_star,
                                    "Số hợp đồng" => $count_contract,
                                    "Thu nhập" => round($income,2)
                                ];
                            }

                        }
                    break;
                case 2: // Hợp đồng tháng hiện tại
                    $list_contract = $this->ghContract->get([
                        "time_check_in >=" => strtotime($timeFrom),
                        "time_check_in <=" => strtotime($timeTo)+86399,
                        'status' => "Active"
                    ],'consultant_id', 'ASC');
                    foreach ($list_contract as $contract){
                        $apm = $this->ghApartment->getFirstById($contract['apartment_id']);
                        $room = $this->ghRoom->getFirstById($contract['room_id']);
                        $user = $this->ghUser->getFirstByAccountId($contract['consultant_id']);
                        $user_support = "";
                        if(!empty($contract["arr_supporter_id"])){
                            $arr = json_decode($contract["arr_supporter_id"], true);
                            $arr_name = [];
                            foreach ($arr as $aid){
                                $arr_name[] = $this->libUser->getNameByAccountid($aid);
                            }
                            $user_support = implode(" ,", $arr_name);
                        }

                        $customer = $this->ghCustomer->getFirstById($contract['customer_id']);
                        $status = "Cọc";
                        if(time() >= $contract["time_check_in"]){
                            $status = "Đã ký";
                        }
                        $data[] = [
                            "Source" => "GH",
                            "ID" => $contract["id"],
                            "Dự án" =>$apm["address_street"] . ", Phường ". $apm["address_ward"],
                            "Mã phòng" => $room["code"],
                            "Giá thuê" => $contract["room_price"],
                            "Giá cọc" => $contract["deposit_price"],
                            "Ngày ký" => date("d-m-Y", $contract["time_check_in"]),
                            "Số tháng" => $contract["number_of_month"],
                            "Hết Hạn" => date("d-m-Y", $contract["time_expire"]),
                            "Hoa hồng" => $contract['commission_rate'],
                            "Doanh số" => $contract['room_price']*$contract['commission_rate']/100,
                            "Doanh thu" => $this->ghContractPartial->getTotalByContractId($contract['id']),
                            "Số (*)" => $contract["rate_type"],
                            "Sale Chốt" => $user["name"],
                            "Sale Hỗ trợ" => $user_support,
                            "Khách Hàng" => $customer["name"],
                            "Phone" => $customer["phone"],
                        ];
                    }
                    break;
                default: //

            }

            echo json_encode($data); die;
        }
        return false;
    }

}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */