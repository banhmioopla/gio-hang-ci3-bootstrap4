<?php
$check_option = true;
$check_contract = true;
$check_consultant_booking = true;

?>
<script>
    commands.push(function () {
        $('.list-room').DataTable();
    });
</script>

<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h2 class="font-weight-bold text-danger">Tạo Phòng Mới - <?= $apartment['address_street'] ?> </h2>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($this->session->has_userdata('fast_notify')) {
            $flash_mess = $this->session->flashdata('fast_notify')['message'];
            $flash_status = $this->session->flashdata('fast_notify')['status'];
            unset($_SESSION['fast_notify']);
        }
        ?>
        <div class="role-alert"></div>
        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <table id="list-room-<?= $apartment['id'] ?>"
                           class="table list-room table-hover ">
                        <thead>
                        <tr>
                            <th class="font-weight-bold">Mã Phòng</th>
                            <th class="text-warning">LP (TN)</th>
                            <th>Loại Phòng</th>
                            <th>Giá</th>
                            <th class="text-center">Diện Tích</th>
                            <th>Trạng Thái</th>
                            <th>Ng.Trống</th>
                            <?php if($check_option):?>
                                <th>Tùy chọn</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($list_room)): ?>
                            <?php foreach($list_room as $room): ?>
                                <?php
                                if($room['status'] == 'Available') {
                                    $bg_for_available = 'bg-gh-apm-card';
                                    $color_for_available = 'text-primary';
                                }
                                else {
                                    $bg_for_available = '';
                                    $color_for_available = '';
                                }
                                ?>
                                <tr class='<?= $bg_for_available ?> font-weight-bold'>
                                    <td><div class="room-data"
                                             data-pk="<?= $room['id'] ?>"
                                             data-value="<?= $room['code'] ?>"
                                             data-name="code"
                                        ><?= $room['code'] ? $room['code'] : 'không có thông tin' ?></div>
                                    </td>
                                    <?php
                                    $list_type_id = json_decode($room['room_type_id'], true);
                                    $js_list_type = "";
                                    $text_type_name = "";
                                    if($list_type_id) {
                                        $js_list_type = implode(",", $list_type_id);
                                        if ($list_type_id && count($list_type_id) > 0) {
                                            foreach ($list_type_id as $type_id) {
                                                $typeModel = $ghBaseRoomType->get(['id' => $type_id]);
                                                $text_type_name .= $typeModel[0]['name'] . ', ';
                                            }
                                        }

                                    }

                                    ?>
                                    <td class="room-type"
                                        data-name="room_type_id"
                                        data-pk="<?= $room['id'] ?>"
                                        data-value="<?= $js_list_type ?>"><?= $text_type_name ? $text_type_name : "-" ?></td>
                                    <td><div class="room-data"
                                             data-pk="<?= $room['id'] ?>"
                                             data-value="<?= $room['type'] ?>"
                                             data-name="type"
                                        ><?= $room['type'] ? $room['type']: '-' ?></div></td>
                                    <td><div class="room-price font-weight-bold"
                                             data-pk="<?= $room['id'] ?>"
                                             data-value="<?= $room['price'] ?>"
                                             data-name="price"><?= $room['price'] ? view_money_format($room['price'],1): '-' ?></div></td>
                                    <td><div class="room-area text-center"
                                             data-pk= "<?= $room['id'] ?>"
                                             data-value= "<?= $room['area'] > 0 ? $room['area']:'' ?>"
                                             data-name="area"><?= $room['area'] > 0 ? $room['area']: '-' ?></div></td>
                                    <td><div class="room-status font-weight-bold text-primary <?= $color_for_available ?>"
                                             data-id="<?= $room['id'] ?>">
                                            <?= $room['status'] ? $label_apartment[$room['status']] : '-' ?></div></td>
                                    <td><div class="room-time_available text-success"
                                             data-pk="<?= $room['id'] ?>"
                                             data-value="<?= date('d-m-Y',$room['time_available']) ?>"
                                             data-name="time_available"><?= $room['time_available'] > 0 ?
                                                date('d-m-Y',$room['time_available']) :'-' ?></div></td>

                                    <?php if($check_option):?>
                                        <td class="">
                                            <div
                                                class="d-flex flex-column flex-md-row justify-content-center">
                                                <button data-room-id="<?= $room['id'] ?>" data-room-code="<?= $room['code'] ?>" type="button" class="btn m-1 room-delete btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                                <?php if($check_contract):?>
                                                    <a href="<?= base_url() ?>admin/create-contract-show?room-id=<?= $room['id'] ?>">
                                                        <button data-room-id="<?= $room['id'] ?>" type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                                            <i class="mdi mdi-file-document"></i>
                                                        </button>
                                                    </a>
                                                <?php endif;?>

                                                <?php if($check_consultant_booking):?>
                                                    <a href="<?= base_url() ?>admin/list-consultant-booking?room-id=<?= $room['id'] ?>&apartment-id=<?= $apartment['id'] ?>&district-code=<?= $apartment['district_code'] ?>&mode=create">
                                                        <button type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                                            <i class="mdi mdi-car-hatchback"></i>
                                                        </button>
                                                    </a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="card-box">
                    <h4 class="header-title m-t-0">Thêm mới</h4>
                    <form role="form" method="post"
                          action="<?= base_url()?>/admin/room/show-create?id=<?= $this->input->get('id') ?>">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-12 col-form-label">Mã Phòng<span class="text-danger">*</span></label>
                            <div class="col-md-8 col-12">
                                <input type="text" required class="form-control"
                                       id="name" name="name" placeholder="Tên quyền (chức vụ)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">Mở</label>
                            <div class="col-8">
                                <div>
                                    <div class=" checkbox checkbox-success">
                                        <input id="active" type="checkbox" value="YES" name="active">
                                        <label for="active">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-custom waves-effect waves-light">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
            $('#table-role').DataTable({
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true
            });

            $('.is-active-role input[type=checkbox]').click(function() {
                var is_active = 'NO';
                var this_id = $(this).attr('id');
                var matches = this_id.match(/(\d+)/);
                var role_id = matches[0];
                if($(this).is(':checked')) {
                    is_active = 'YES';
                }
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>admin/update-role',
                    data: {field_value: is_active, role_id: role_id, field_name : 'active'},
                    async: false,
                    success:function(response){
                        var data = JSON.parse(response);
                        if(data.status == true) {
                            $('.role-alert').html(notify_html_success);
                        } else {
                            $('.role-alert').html(notify_html_fail);
                        }
                    },
                    beforeSend: function(){
                        $('#loader').show();
                    },
                    complete: function(){
                        $('#loader').hide();
                    }
                });
            });

            $('.role-name').editable({
                type: "text",
                url: '<?= base_url() ?>admin/update-role-editable',
                inputclass: '',
                success: function(response) {
                    var data = JSON.parse(response);
                    if(data.status == true) {
                        $('.role-alert').html(notify_html_success);
                    } else {
                        $('.role-alert').html(notify_html_fail);
                    }
                }
            });

            $('.delete-role').click(function(){
                var this_id = $(this).attr('id');
                var this_click = $(this);
                var matches = this_id.match(/(\d+)/);
                var role_id = matches[0];
                if(role_id > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url() ?>admin/delete-role',
                        data: {role_id: role_id},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == true) {
                                $('.role-alert').html(notify_html_success);
                                this_click.parents('tr').remove();
                            } else {
                                $('.role-alert').html(notify_html_fail);
                            }
                        }
                    });
                }
            });
        });
    });
</script>