
<?php

$check_consultant_booking = false;
if(isYourPermission('ConsultantBooking', 'show', $this->permission_set)){
    $check_consultant_booking = true;
}

?>
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
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="tag-alert"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="text-center w-100 mb-2">
                    <?php $this->load->view('components/list-navigation'); ?>
                </div>
            </div>
            <div class="col-md-12 border-top"><?php $this->load->view('apartment/search-by-room-price', ['list_price' => $list_price]); ?></div>
            <div class="col-12">
                <div class="card-box table-responsive shadow">
                    <h4 class="text-center text-danger"><?= number_format($number_result) ?> Kết Quả</h4>
                    <div class="row">
                        <div class="col-12">
                            <div role="tablist" aria-multiselectable="true" class="m-b-30">

                                <?php foreach ($arr_apartment_info as $apm_id => $apm_info): ?>
                                    <div class="card">
                                        <div class="card-header row" role="tab" id="headingOne">
                                            <div class="col-md-6 col-12">
                                                <h5 class="mb-0 mt-0">
                                                    <a data-toggle="collapse" href="#apm-<?= $apm_id ?>" class="text-dark"
                                                       aria-expanded="false" aria-controls="apm-<?= $apm_id ?>">
                                                        <?= $apm_info['address'] ?>
                                                    </a>
                                                </h5>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="pull-right">
                                                    <a href="/admin/apartment/show-image?apartment-id=<?= $apm_id ?>" target="_blank">
                                                        <button type="button" class="btn m-1 btn-sm btn-outline-primary btn-rounded waves-light waves-effect">
                                                            <i class="mdi mdi-folder-multiple-image"></i>
                                                        </button>
                                                    </a>
                                                    <a href="<?= base_url() ?>admin/create-new-consultant-booking?apartment-id=<?= $apm_id ?>&district-code=<?= $apm_info['district_code'] ?>&mode=create">
                                                        <button type="button" class="btn m-1 btn-sm btn-outline-success btn-rounded waves-light waves-effect">
                                                            <i class="mdi mdi-car-hatchback"></i>
                                                        </button>
                                                    </a>
                                                </div>

                                            </div>

                                        </div>

                                        <div id="apm-<?= $apm_id ?>" class="collapse" role="tabpanel">
                                            <div class="card-body">
                                                <table class="table table-room">
                                                    <thead>
                                                        <th>Mã Phòng</th>
                                                        <th>Loại</th>
                                                        <th>Giá</th>
                                                        <th>Diện tích</th>
                                                        <th>Trạng Thái</th>
                                                        <th>Sắp Trống</th>
                                                        <th>Tùy Chọn</th>
                                                    </thead>
                                                    <tbody>
                                                    <?php if(isset($arr_apartment_room[$apm_id])):  ?>
                                                        <?php foreach ($arr_apartment_room[$apm_id] as $room):?>
                                                            <tr>
                                                            <td><?= $room['room_code'] ?></td>
                                                            <td><?= $room['room_type'] ?></td>
                                                            <td><?= $room['room_price'] ?></td>
                                                            <td><?= $room['room_area'] ?></td>
                                                            <td><?= $room['room_status'] ?></td>
                                                            <td><?= $room['room_time_available'] ?></td>
                                                            <td>-</td>
                                                            </tr>
                                                        <?php endforeach;?>
                                                    <?php endif;  ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<script type="text/javascript">
    commands.push(function() {
        $(document).ready(function() {
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
            $('.table-room').DataTable({
                columnDefs: [
                    { type: 'sort-numbers-ignore-text', targets : 0 }
                ],
                "pageLength": 10,
                'pagingType': "full_numbers",
                responsive: true,
                "oSearch": {"bSmart": false}
            });


        });
    });
</script>