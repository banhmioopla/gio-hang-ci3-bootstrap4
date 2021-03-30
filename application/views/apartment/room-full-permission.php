<div class="table-responsive">
    <div class="d-flex justify-content-center">
        <button type="button" 
            data-apartment-id = "<?= $apartment['id'] ?>"
            class="btn m-1 btn-sm room-add btn-outline-success btn-rounded waves-light waves-effect">
            <i class="mdi mdi-credit-card-plus"></i>
        </button>
        <a href="/admin/room/show-create?apartment-id=<?= $apartment['id'] ?>" target="_blank"
           class="btn m-1 btn-sm btn-outline-danger btn-rounded waves-light waves-effect">
            <i class="mdi mdi-credit-card-plus"></i></a>
    </div>
    <table id="list-room-<?= $apartment['id'] ?>" class="table list-room table-bordered ">
        <thead>
        <tr>
            <th>Mã Phòng</th>
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
            <?php $list_room = $libRoom->getByApartmentIdAndActive($apartment['id'])?>
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