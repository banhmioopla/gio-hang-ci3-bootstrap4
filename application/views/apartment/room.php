<div class="table-responsive">
    <table id="list-room-<?= $apartment['id'] ?>" class="table list-room table-bordered ">
        <thead>
        <tr>
            <th>Mã Phòng</th>
            <th>Loại Phòng</th>
            <th>Giá</th>
            <th>Diện Tích</th>
            <th>Trạng Thái</th>
            <th>Ngày checkout</th>
        </tr>
        </thead>
        <tbody>
            <?php $list_room = $libRoom->getByApartmentIdAndActive($apartment['id'])?>
            <?php if(!empty($list_room)): ?>
                <?php foreach($list_room as $room): ?>
                <tr>
                    <td><div><?= $room['code'] ?></div></td>
                    <td><div><?= $libBaseRoomType->getNameById($room['type_id']) ?></div></td>
                    <td><div><?= money_format($room['price']) ?></div></td>
                    <td><div><?= $room['area'] ?></div></td>
                    <td><div><?= $room['status'] ?></div></td>
                    <td><div><?= date('d-m-Y',$room['time_available']) ?></div></td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>