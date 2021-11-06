<?php

$check_contract = in_array($this->auth['role_code'], ['human-resources','product-manager', 'ceo', 'customer-care']);
$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

$check_profile = false;
if(isYourPermission('Apartment', 'showProfile', $this->permission_set)){
    $check_profile = true;
}

$check_contract = false;
if(isYourPermission('Contract', 'createShow', $this->permission_set)){
    $check_contract = true;
}

$check_option = true;
$check_commission_rate = false;
$check_create_promotion = false;
if(isYourPermission('Apartment', 'showCommmissionRate', $this->permission_set)){
    $check_commission_rate = true;
}

if(isYourPermission('ApartmentPromotion', 'create', $this->permission_set)){
    $check_create_promotion = true;
}



$check_update_room = false;
if(isYourPermission('Room', 'updateEditable', $this->permission_set)){
    $check_update_room = true;

}
$show_sortable = false;
if(isYourPermission('Apartment', 'showSortable', $this->permission_set)){
    $show_sortable = true;
}

?>

<div class="wrapper">

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Giỏ Hàng</a></li>
                            <li class="breadcrumb-item active">Danh sách dự án</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
        </div>
        <?php if($check_update_room): ?>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card-box">
                        <h4 class="text-primary">Cập nhật thông tin phòng</h4>
                        <div>
                            <select id="apartment_update_ready" class=" form-control">
                                <option value="">Cập nhật thông tin phòng</option>
                                <?php foreach ($list_apm_ready as $apm_move): ?>
                                    <option value="<?= $apm_move['id'] ?>"><?= $apm_move['address_street'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mt-2">
                            <h4 class="text-primary">Ghim 1 Thông báo</h4>
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" id="input-pin-notification" value="<?= $this->pin_notification['content'] ?>" class="form-control mt-2 border border-info">
                                    <div class="text-success p-1" id="status-pin-notification"></div>
                                </div>
                                <div class="col-4">
                                    <button id="update-pin-notification" class="btn btn-danger waves-effect mt-2" >Ghim</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h4 class="text-primary">Update toàn bộ dự án [?]</h4>
                            <div class="row">
                                <div class="col-4">
                                    <button id="update-time_available" class="btn btn-danger waves-effect mt-2" >Xoá ngày sắp trống <i>đã cũ</i></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-8">
                    <?php  $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?>
                </div>

            </div>
            <hr>
            <?php else: ?>
            <div class="col-md-12">
                <?php  $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?>
            </div>
        <?php endif;?>
        <div class="row">
            <div class="col-12">
                <h2 class="font-weight-bold text-danger">Danh sách dự án Q. <?= $libDistrict->getNameByCode($district_code) ?></h2>
            </div>
            <div class="col-md-3 d-md-block d-none">
                <?php if($check_profile):?>
                <?php $this->load->view('apartment/five-days-ago', ['check_profile' => $check_profile]) ?>
                <?php endif; ?>
                <?php $this->load->view('apartment/metric', ['district_code' => $district_code]) ?>
                <?php if(count($contract_noti) && isYourPermission('Apartment', 'showNotificaton', $this->permission_set)):?>
                    <div class="mt-1 text-center font-weight-bold">Thông báo các lượt tạo hợp đồng</div>
                    <?php foreach($contract_noti as $item):?>
                        <div class="m-2 alert alert-<?= $item['is_approve'] =='YES' ?"success" :'warning' ?> alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?= $item['message'] . ' <br> Tạo lúc '. date('d/m/Y H:i', $item['time_insert']) ?>
                            <br><a href="/admin/detail-contract?id=<?= $item['object_id'] ?>">>> thông tin hợp đồng</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if(count($consultant_booking)):?>
                    <div class="mt-3 text-center font-weight-bold">Đăng ký lịch dẫn khách</div>
                    <?php foreach($consultant_booking as $booking):?>
                        <div class=" m-2 alert alert-primary alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?= '<strong>'.$this->libUser->getNameByAccountid($booking['booking_user_id']) . '</strong> đã đăng ký dẫn khách ngày </strong> <strong>'. date('d/m/Y', $booking['time_booking']). '</strong> tại '. $this->libRoom->getAddressById($booking['room_id']) . ' : <strong>' . $this->libRoom->getCodeById($booking['room_id']). '</strong>'  ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="card card-body col-12 col-md-9">
                <!--<div class="text-center w-100">-->
                <!--</div>-->

                <?php

                $covidColor = $this->input->get('apmTag') ? 'text-danger' :'text-purple';

                ?>
                <div class="list-action">
                    <span class="d-flex justify-content-center flex-wrap ">
                        <?php
                        foreach($this->list_OPEN_DISTRICT as $district):
                            $district_btn = 'btn-outline-success';
                            ?>

                            <a href="<?= base_url().'admin/list-apartment?district-code='.$district ?>"
                               class="btn m-1 btn-sm <?= $district_btn ?>
                                <?= $district_code == $district ? 'active':'' ?>
                                btn-rounded waves-light waves-effect">
                            Q. <?= $district ?> </a>

                        <?php endforeach; ?>
                    </span>
                    <span class="d-flex justify-content-center flex-wrap ">
                        <a href="<?= base_url().'admin/list-apartment?apmTag=5' ?>"
                           class="btn m-1 btn-sm <?= $this->input->get('apmTag') ? 'active' :'' ?> btn-outline-danger btn-small btn-rounded waves-light waves-effect"> <i class="fa fa-ambulance"></i> Covid</a>

                        <a href="<?= base_url().'admin/list-apartment?rangeTime=Today' ?>"
                           class="btn m-1 btn-sm <?= $this->input->get('rangeTime') ? 'active' :'' ?> btn-outline-danger btn-small btn-rounded waves-light waves-effect"> <i class="fa fa-calendar-o"></i> Update Hôm Nay</a>

                    </span>

                </div>
                <div class="card">
                    <div class="form-group row mt-2">
                        <div class="col-md-7 col-12 text-md-left text-center">
                            <input type="text" placeholder="Tìm kiếm dự án, vui lòng nhập địa chỉ..." class="form-control search-address border border-info">
                        </div>
                        <div class="col-md-5 col-12 mt-md-0 mt-2 text-md-right text-center">
                            <a href="/admin/apartment/create"><button class="btn btn-success mt-md-0 mt-1">Tạo Dự Án Mới</button></a>
                            <?php if($show_sortable): ?>
                            <a href="/admin/apartment/sortable?district-code=<?= $district_code ?>"><button class="btn btn-success mt-md-0 mt-1"> <i class=" mdi mdi-format-list-numbers"></i> Sắp xếp</button></a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                        if($this->session->has_userdata('fast_notify')):
                            ?>
                            <div class="alert alert-<?= $this->session->flashdata('fast_notify')['status']?> alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('fast_notify')['message']?>
                            </div>
                            <?php unset($_SESSION['fast_notify']); endif; ?>
                    </div>
                </div>
                <div id="sortable-ui">
                <?php foreach ($list_apartment as $apartment):
                    $list_promotion = $ghApartmentPromotion->get(['apartment_id' => $apartment['id'], 'end_time >=' => strtotime(date('d-m-Y'))]);
                    $tag_promotion = '';
                    $color_promotion = 'text-purple';
                    $bg_promotion = '';
                    $promotion_txt = '';
                    $is_editable_apartment = false;
                    if($this->product_category === "APARTMENT_GROUP" && in_array($apartment["id"], $this->list_apartment_CRUD )){
                        $is_editable_apartment = true;
                    }
                    if($this->product_category === "DISTRICT_GROUP" && in_array($apartment["district_code"], $this->list_district_CRUD )){
                        $is_editable_apartment = true;
                    }

                    if(count($list_promotion) > 0) {
                        $tag_promotion = '<span class="badge badge-danger"><i class="mdi mdi-gift mr-2"></i> '.count($list_promotion). '</span>';
                        $color_promotion =  $this->input->get('apmTag') ? $covidColor : 'text-white';
                        $bg_promotion = 'bg-danger';
                    }
                    $list_comment = $ghApartmentComment->get(['apartment_id' => $apartment['id']]);

                    $surrounding_facilities = !empty($apartment['surrounding_facilities']) ? json_decode($apartment['surrounding_facilities'], true) : [];

                    ?>
                    <!-- item -->
                    <div class="sort-apm-item" data-apm-id="<?=$apartment['id']?>">
                    <div class="card-header apartment-block mt-1" role="tab" id="headingThree">
                        <div class="row">
                            <div class="col-md-6 text-right text-md-left">
                                <i class=" mdi mdi-dots-vertical text-danger"></i>
                                <span class="text-primary "><?= '<i class="mdi mdi-update"></i> '.date('d/m/Y H:i', $this->ghApartment->getUpdateTimeByApm($apartment['id'])) ?></span>

                            </div>

                            <div class=" col-md-6 text-center text-md-right">
                                <div class="text-md-right d-none d-md-block ">
                                    <a class="text-primary"
                                       target="_blank"
                                       href="/admin/list-dashboard">Thông tin dịch vụ (<strong><?= $libApartment->completeInfoRate($apartment['id'])['counter'] ?></strong>) <small class="text-danger">[?] click để xem tiêu chí </small></a>
                                </div>
                            </div>


                            <!--ADDRESS SECTION-->
                            <div class=" col-12 <?= $bg_promotion ?>">
                                <a href="/admin/apartment/show-image?apartment-id=<?= $apartment['id'] ?>">
                                    <div class="address-text <?= $color_promotion ?> font-weight-bold ml-2">
                                        <?=$apartment['address_street'] ?> <?=$apartment['address_ward'] ? ', Ph. '.$apartment['address_ward']:'' ?>
                                    </div>
                                </a>
                            </div>


                            <div class="col-md-6 col-12 text-center text-md">
                                <span class="text-success"><i class="mdi mdi-calendar-multiple-check d-inline d-md-none"></i> <span class="d-md-inline d-none">Trống: </span><strong><?= $ghRoom->getNumberByStatus($apartment['id'], 'Available') ?></strong></span>
                                <span class="text-warning ml-2"><i class="mdi mdi-calendar-multiple d-inline d-md-none"></i> <span class="d-md-inline d-none">Sắp Trống: </span> <strong><?= $ghRoom->getNumberByTimeavailable($apartment['id']) ?></strong></span>
                                <span class="text-danger ml-2"> <i class="mdi mdi-sigma d-inline d-md-none"></i> <span class="d-md-inline d-none"> Tổng P: </span><strong><?= $ghRoom->getNumber($apartment['id']) ?></strong></span>
                                <span class="text-info ml-2"> <i class="mdi mdi-eye d-inline d-md-none"></i> <span class="d-md-inline d-none"> View: </span><strong><?= $ghApartmentView->getNumber($apartment['id']) ?></strong></span>
                                <span class="text-info ml-2"> <i class="mdi mdi-car-hatchback d-inline d-md-none"></i> <span class="d-md-inline d-none"> Book: </span><strong><?= $ghConsultantBooking->getNumber($apartment['id']) ?></strong></span>
                            </div>


                        </div>
                        <div class="row">
                            <?php
                            foreach ($list_promotion as $p):
                                ?>
                                <button type="button" class="btn btn-sm m-1 btn-danger" data-toggle="modal" data-target="#promotion-md-<?= $p['id'] ?>">
                                    <?= $p['title'] ?>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="promotion-md-<?= $p['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $p['title'] ?></h5>
                                            </div>
                                            <div class="modal-body"><?= $p['description'] ?></div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;

                            ?>
                        </div>
                        <div class="row mt-3 hide-in-sortable text-danger">
                            <div class="col-md-3 col-4 border-right border-danger">
                                <i class="mdi mdi-lumx"></i> <span class="d-none d-md-inline">Brand: </span><strong><?= $apartment['partner_id'] ? $libPartner->getNameById($apartment['partner_id']) :'...' ?></strong>
                            </div>
                            <div class="col-md-3 col-4 border-right border-danger">
                                <i class="mdi mdi-sign-direction"></i><span class="d-none d-md-inline">Hướng: </span><strong><?= $apartment['direction']? $label_apartment[$apartment['direction']] : '...' ?></strong>
                            </div>

                            <div class="col-md-3 col-4 border-right border-danger">
                                <i class="mdi mdi-tag-faces"></i> <span class="d-none d-md-inline">TAG: </span><?= $apartment['tag_id'] ? ' <span class="badge badge-pink">'.$libTag->getNameById($apartment['tag_id']).'</span>':'...' ?>
                                <?php if((strtotime(date('d-m-Y')) - $apartment['time_insert']) < (86400 * 30)): ?>
                                    <span class="badge badge-dark">DỰ ÁN MỚI </span>
                                <?php endif; ?>

                                <?php if($ghRoom->getNumberByStatus($apartment['id'], 'Available') == 0): ?>
                                    <span class="badge badge-danger">FULL </span>
                                <?php endif; ?>
                                <?= $tag_promotion ?>
                            </div>
                            <div class="col-md-3 col-12 text-md text-center">
                                <i class="mdi mdi-pistol"></i> <span class="d-none d-md-inline">QLDA: </span><strong><?= $apartment['user_collected_id'] ? ''.$libUser->getNameByAccountid($apartment['user_collected_id'])."<br>".$libUser->getPhoneByAccountid($apartment['user_collected_id']):"SINVA" ?></strong>
                            </div>
                        </div>
                        <div class="row hide-in-sortable mt-2">
                            <div class="col-12">
                                <?php if($apartment['description']): ?>
                                <h5 class="text-danger"><u>Mô Tả Dự Án</u></h5>
                                <?php endif;?>
                                <div class="mb-3">
                                <?php foreach ($surrounding_facilities as $uu):?>

                                    <span class="ml-2 badge badge-danger"><strong><?= $uu ?></strong></span>
                                <?php endforeach;?>
                                </div>
                                <?php if($apartment['description']): ?>
                                <div class="p-1 apm-description" style="white-space: pre-line; background:#fee69c">
                                    <?= $apartment['description'] ? $apartment['description'] : '' ?>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="row hide-in-sortable">
                            <div class="col-12 list-action  text-center text-md-right mt-2" >

                                <?php if($is_editable_apartment): ?>
                                    <a class="m-1" href="/admin/apartment/duplicate?id=<?= $apartment['id'] ?>" >
                                        <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-credit-card-multiple"></i> </button>
                                    </a>
                                    <a class="m-1" href="/admin/profile-apartment?id=<?= $apartment['id'] ?>" >
                                        <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-lead-pencil"></i> <span class="d-none d-md-inline"></span></button>
                                    </a>


                                    <a href="/admin/room/show-create?apartment-id=<?= $apartment['id'] ?>">
                                        <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"><i class="mdi mdi-lead-pencil"></i> P </button></a>

                                    <a class="m-1" href="/admin/list-apartment-promotion?apartment-id=<?= $apartment['id'] ?>">
                                        <button class="btn btn-sm btn-outline-primary btn-rounded waves-light waves-effect"> <i class="mdi mdi-gift"></i></button></a>

                                <?php endif;?>


                                <span class="m-1"><button data-address="<?= $apartment['address_street'] ?>"
                                                          data-apm="<?= $apartment['id'] ?>"
                                                          class="btn report-issue-apm-info btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-alert-box"></i> <span class="d-none d-md-inline"></span></button></span>
                                <a href="/admin/download-all-image-apartment?apm=<?= $apartment['id'] ?>"><button class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-cloud-download"></i> Tải Full Ảnh</button></a>

                                <a class="m-1" href="/sale/apartment-export?id=<?= $apartment['id'] ?>" >
                                    <button class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect"><i class="mdi mdi-file-excel"></i> <span class="d-none d-md-inline"></span></button>
                                </a>
                                <a class="m-1 collapsed"
                                   data-toggle="collapse"
                                   data-parent="#accordion"
                                   href="#modal-apartment-comment-<?=$apartment['id'] ?>" aria-expanded="false" aria-controls="#modal-apartment-comment-<?=$apartment['id'] ?>">
                                    <button class="btn btn-sm btn-outline-danger btn-rounded waves-light waves-effect ">
                                        <i class="mdi mdi-comment-outline"></i> <span class="d-none d-md-inline"></span>
                                        <?php if(count($list_comment) > 0):?>
                                            <span class="badge badge-danger badge-pill mr-2 noti-icon-badge"><?= count($list_comment) ?></span>
                                        <?php endif; ?>
                                    </button>
                                </a>

                                <button type="button" class="btn m-1 apm-plus-view btn-sm btn-outline-danger btn-rounded waves-light waves-effect"
                                        data-toggle="collapse"
                                        data-apartment-id="<?=$apartment['id'] ?>"
                                        data-parent="#accordion"
                                        aria-controls="#modal-apartment-detail-<?=$apartment['id'] ?>"
                                        data-target="#modal-apartment-detail-<?=$apartment['id'] ?>">
                                    <i class="mdi mdi-eye"></i> <span class="d-none d-md-inline"></span></button>

                                <a data-souce="image" href="/admin/apartment/show-image?apartment-id=<?= $apartment['id'] ?>" target="_blank">
                                    <button type="button"
                                            data-apartment-id="<?=$apartment['id'] ?>"
                                            class="btn m-1 apm-plus-view  btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                        <i class="mdi mdi-folder-multiple-image"></i> <span class="d-none d-md-inline"></span>
                                    </button>
                                </a>

                                <?php if($check_consultant_booking): ?>
                                    <a href="<?= base_url() ?>admin/create-new-consultant-booking?apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create">
                                        <button type="button" class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                            <i class="mdi mdi-car-hatchback"></i> <span class="d-none d-md-inline"></span>
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div id="modal-apartment-comment-<?=$apartment['id'] ?>" class="collapse" role="tabpanel" aria-labelledby="modal-apartment-comment-<?=$apartment['id'] ?>">

                        <div class="card-body">
                            <h5 class="mb-1 text-muted"><u>Bình luận gần đây</u></h5>
                            <div class="comment-list border-bottom slimscroll">
                                <div id='newContentComment'></div>
                                <?php if(count($list_comment) > 0): ?>
                                    <?php foreach($list_comment as $comment): ?>
                                        <div class="comment-box-item taskList border-bottom">
                                            <p class="commnet-item-date"><?= date('d/m/Y, H:i', $comment['time_insert']) ?></p>
                                            <p class="commnet-item-msg"><span class="text-danger" style="font-size:12px"> <u><?= $libUser->getLastNameByAccountId($comment['user_id']) ?></u>:</span> <i><?= $comment['content'] ?></i></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif;?>

                                <div class="comment-box-item mt-3">
                                    <input type="text" id="apm-comment-<?= $apartment['id'] ?>" class="new-comment border border-info form-control" placeholder = "nhập bình luận ...">
                                </div>
                                <button type="button" data-apm-id="<?= $apartment['id'] ?>" class="btn m-1 add-new-comment room-delete btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                    +<i class="mdi mdi-comment-plus-outline"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div id="modal-apartment-detail-<?=$apartment['id'] ?>" class="collapse" role="tabpanel" aria-labelledby="modal-apartment-detail-<?=$apartment['id'] ?>">
                        <div class="card-body">
                            <ul class="nav nav-pills navtab-bg nav-justified pull-in ">
                                <li class="nav-item">
                                    <a href="#apm-note-<?= $apartment['id'] ?>"
                                       data-toggle="tab"
                                       aria-expanded="false"
                                       class="nav-link">
                                        Ghi Chú Quan Trọng
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#apm-service-<?= $apartment['id'] ?>"
                                       data-toggle="tab"
                                       aria-expanded="true"
                                       class="nav-link active">
                                        Dịch Vụ Tòa Nhà
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#apm-room-<?= $apartment['id'] ?>" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        Danh Sách Phòng
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="#apm-map" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-google-maps mr-2"></i>
                                    </a>
                                </li> -->
                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane apm-note" id="apm-note-<?= $apartment['id'] ?>">
                                    <p><?= $apartment['note'] ?></p>
                                </div>
                                <div class="tab-pane service-list show active" id="apm-service-<?= $apartment['id'] ?>">
                                    <div id="carouselButton-<?= $apartment['id'] ?>" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php $this->load->view('apartment/service', ['apartment' => $apartment, 'label_apartment' => $label_apartment, 'check_commission_rate' => $check_commission_rate]) ?>
                                        </div>
                                        <a class="carousel-control-prev"
                                           href="#carouselButton-<?= $apartment['id'] ?>"
                                           role="button"
                                           data-slide="prev"><i class="dripicons-chevron-left"></i> </a>
                                        <a class="carousel-control-next"
                                           href="#carouselButton-<?= $apartment['id'] ?>"
                                           role="button"
                                           data-slide="next"><i class="dripicons-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="tab-pane" id="apm-room-<?= $apartment['id'] ?>">
                                    <?php $this->load->view('apartment/room',[
                                        'apartment' => $apartment,
                                        'libRoom' => $libRoom,
                                        'check_option' =>$check_option,
                                        'check_contract' =>$check_contract,
                                        'check_consultant_booking' => $check_consultant_booking,
                                        'ghApartmentShaft' => $ghApartmentShaft
                                    ]) ?>
                                </div>
                                <div class="tab-pane" id="apm-map">
                                    <!-- Develop -->
                                </div>
                            </div> <!-- end tab content , end item-->

                        </div>
                    </div>
                    </div>
                <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    commands.push(function() {
        $('#update-time_available').click(function () {
            $.ajax({
                type: 'GET',
                url:'<?= base_url()."admin/room/time-available/get" ?>',
                dataType: 'json',
                success:function(response) {
                    let title = 'Không có dự án nào có ngày sắp trống "Không hợp lệ" !';
                    let has_available_time = false;
                    let html = "<ul class='text-left m'>";
                    for (const [key, value] of Object.entries(response)) {
                        has_available_time = true;

                        html += "<li class='mt-2'>" + value['address'] + ": <ul>";
                        for (const _room of value['list_room']) {
                            html += '<li class="font-weight-bold"> ' + _room + ' </li>';
                        }
                        html += "</ul></li>";
                    }
                    html += "</ul>";
                    if(has_available_time) {
                        title = 'Review thông tin "Ngày sắp trống" ';
                    }
                    swal({
                        title: title,
                        type: 'warning',
                        html: html,
                        showCancelButton: true,
                        showConfirmButton: has_available_time,
                        confirmButtonClass: 'btn btn-confirm mt-2',
                        cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                        confirmButtonText: 'Xác nhận Xóa',
                        cancelButtonText: 'Huỷ'
                    }).then(function () {
                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() . "admin/update-room-editable" ?>',
                            data: {mode: 'empty_time_available'},
                            dataType: 'json',
                            success: function (response) {
                                console.log(response);
                                swal({
                                    title: response.content,
                                    type: 'success',
                                    confirmButtonClass: 'btn btn-confirm mt-2'
                                });
                            }
                        });

                    });
                }
            });


            /*swal({
                title: 'Xác nhận xoá thông tin "Ngày sắp trống" ',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-confirm mt-2',
                cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                confirmButtonText: 'Xóa',
            }).then(function () {
                $.ajax({
                    type: 'POST',
                    url:'<//?= base_url()."admin/update-room-editable" ?>',
                    data: {pk: room_id, name: 'active', value: 'NO'},
                    success:function(response) {
                        let data = JSON.parse(response);
                        if(data.status > 0) {
                            this_btn.parents('tr').remove();
                        }
                    }
                });
                swal({
                    title: 'Đã Xóa Thành Công!',
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
            });*/

        });



        $("#update-pin-notification").click(function () {
            let content = $('#input-pin-notification').val();
            $.ajax({
                url: '/admin/update-apartment-editable',
                method: "POST",
                data: {mode: "pin_notification", value: content},
                dataType: 'json',
                success: function (res) {
                    if(res.status === true) {
                        $('#status-pin-notification').text(res.content);
                        $('#pin-notification').text(content);
                        $('#pin-notification-section').addClass("bg-success");
                        setTimeout(function () {
                            $('#pin-notification-section').removeClass("bg-success");
                        }, 2500);

                        $('#status-pin-notification').fadeOut(2500);
                    }
                }
            })
        });



        $('.report-issue-apm-info').click(function () {
            let address = $(this).data('address');
            let apm_id = $(this).data('apm');
            swal({
                title: 'Báo cáo thiếu thông tin',
                text: 'dự án '+address+' thiếu thông tin',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-confirm mt-2',
                cancelButtonClass: 'btn btn-cancel ml-2 mt-2',
                confirmButtonText: 'Báo cáo',
                cancelButtonText: 'Hủy',
            }).then(function () {
                $.ajax({
                    type: 'POST',
                    url:'<?= base_url()."report/issue-apm-info" ?>',
                    data: {apm: apm_id, type: 'IssueApmInfo'},
                    dataType: 'json',
                    success:function(response) {
                    }
                });
                swal({
                    title: 'Đã báo cáo Thành Công!',
                    type: 'success',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                });
            })
        });

        $('.apm-plus-view').click(function () {
            if($(this).attr("aria-expanded") === undefined || $(this).attr("aria-expanded") === "false" || $(this).data("source") === 'image') {
                $.ajax({
                    url: '/admin/apartment-view/create',
                    data: {apartment_id: $(this).data('apartment-id')},
                    method: "POST"
                });
            }
        });

        var t_room = $('.list-room').DataTable({
            columnDefs: [
                { type: 'sort-numbers-ignore-text', targets : 0 }
            ],
        });
        function sortNumbersIgnoreText(a, b, high) {
            var reg = /[+-]?((\d+(\.\d*)?)|\.\d+)([eE][+-]?[0-9]+)?/;
            a = a.match(reg);
            a = a !== null ? parseFloat(a[0]) : high;
            b = b.match(reg);
            b = b !== null ? parseFloat(b[0]) : high;
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        }
        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "sort-numbers-ignore-text-asc": function (a, b) {
                return sortNumbersIgnoreText(a, b, Number.POSITIVE_INFINITY);
            },
            "sort-numbers-ignore-text-desc": function (a, b) {
                return sortNumbersIgnoreText(a, b, Number.NEGATIVE_INFINITY) * -1;
            }
        });
        $('.apartment-block').find('.list-action').show();
        // $('.apartment-block').mouseenter(function() {
        //     $(this).find('.list-action').show(600);
        // }).mouseleave(function() {
        //     $(this).find('.list-action').hide(600);
        // });

        $('.search-address').on('keyup', function(){
            var value = $(this).val().toLowerCase();
            $(".card-header.apartment-block").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('.add-new-comment').click(function() {
            var apm_id = $(this).data('apm-id');
            var content = $('#apm-comment-'+ apm_id).val();
            var account_id = '<?= $this->auth['account_id'] ?>';
            var user_name = '<?= $this->auth['name'] ?>';
            var time = "<?= date('d/m/Y, H:i') ?>";
            if(content.length > 0) {
                $.ajax({
                    url: '/admin/create-apartment-comment',
                    method: 'POST',
                    data: {content: content, accountId: account_id, apmId: apm_id},
                    success: function() {
                        console.log('123');
                        $('#newContentComment').after(function() {
                            return `<div class='comment-box-item'>
                                    <p class='commnet-item-date'>${time}</p>
                                    <p class='commnet-item-msg text-info'>${content}</p>
                                    <small class='commnet-item-user text-danger text-right'>${user_name}</small>`;
                        });
                    }
                })
            }
        });

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy"
        });

        $('#roomDistrict').change(function () {
            let district = $(this).val();
            $.ajax({
                url: '/admin/apartment-get-ward',
                method: "POST",
                data: {district:district},
                success:function (response) {
                    let html = "<option value=''>Chọn phường...</option>";
                    if(response.length) {
                        response = JSON.parse(response);
                        for(let i of response) {
                            html += "<option value='"+i.value+"'>"+i.text+"</option>";
                        }
                        $('#roomWard').html(html);
                    }

                }
            });
        });
        $('#apartment_update_ready').select2();
        $('#apartment_update_ready').change(function () {
            window.location = '/admin/room/show-create?apartment-id='+$(this).val();
        });



    });
</script>
