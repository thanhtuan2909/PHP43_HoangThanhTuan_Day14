<?php
$error = '';
$result = '';

if (isset($_POST['submit'])) {
    $fileArr = $_FILES['images'];
    $name = $_POST['name'];
    $fileError = $fileArr['error'];
    $fileName = $fileArr['name'];
    if (empty($name)) {
        $error = 'Không được để trống trường name';
    } elseif ($fileError != 0) {
        $error = 'Có lỗi gì đó xảy ra, có thể do server';
    } else {
        $fileSize = $fileArr['size'];
        $sizeMB = round($fileSize / 1024 / 1024, 2);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileExtension = strtolower($fileExtension);

        if (!in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])){
            $error = 'Cần upload file có định dạng ảnh';
        } elseif ($sizeMB > 2) {
            $error = 'File upload không được > 2Mb';
        } else {
            $directoryUploads = __DIR__ . "\uploads";
            if (!file_exists($directoryUploads)){
                mkdir($directoryUploads);
            }

            $tmpName = $fileArr['tmp_name'];
            $destination = $directoryUploads . "\\" . $fileName;
            $isUploaded = move_uploaded_file($tmpName, $destination);

            if ($isUploaded){
                $result = "Tên của bạn: $name<br>";
                $result .= "Avatar của bạn: <img alt='Ảnh lỗi' width='200px' height='200px' src='uploads\\$fileName'><br>";
                $result .= "Tên file: $fileName<br>";
                $result .= "Định dạng file: $fileExtension<br>";
                $result .= "Đường dẫn file trên project của bạn: $destination<br>";
                $result .= "Kích thước file (tính bằng Mb): $sizeMB<br>";
            }
        }
    }
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <label>Name:</label> <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" id="">
    </p>
    <p>
        <label>Avatar:</label> <input type="file" name="images" id="">
    </p>
    <p>
        <input type="submit" name="submit" value="Save">
    </p>
</form>

<h3 style="color: red;">
    <?php echo $error; ?>
</h3>
<h3>
    <?php echo $result; ?>
</h3>
