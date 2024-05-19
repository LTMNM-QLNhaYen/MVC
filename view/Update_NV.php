

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin nhân viên</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Cập nhật thông tin nhân viên</h2>
        <form method="POST" action="Update_NV.php">
            <!-- Mã nhân viên (ẩn) -->
            <input type="hidden" name="MaNV" value="<?php echo $employeeId; ?>">
            <!-- Các trường nhập liệu -->
            <div class="form-group">
                <label for="ten">Họ và tên</label>
                <input type="text" class="form-control" id="ten" name="ten" value="<?php echo $ten; ?>">
            </div>
            <div class="form-group">
                <label for="sdt">Số điện thoại</label>
                <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo $sdt; ?>">
            </div>
            <div class="form-group">
                <label for="gt">Giới tính</label>
                <select id="gt" class="form-control" name="gt">
                    <option value="Nam" <?php if($gt == 'Nam') echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if($gt == 'Nữ') echo 'selected'; ?>>Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ns">Ngày sinh</label>
                <input type="date" class="form-control" id="ns" name="ns" value="<?php echo $ns; ?>">
            </div>
            <div class="form-group">
                <label for="dc">Địa chỉ</label>
                <input type="text" class="form-control" id="dc" name="dc" value="<?php echo $dc; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="btn_capnhat">Cập nhật thông tin</button>
        </form>
    </div>
</body>
</html>
