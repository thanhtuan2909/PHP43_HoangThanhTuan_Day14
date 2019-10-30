<?php
$error = '';
$result = '';
if (isset($_POST['submit'])){
    $fileArr = $_FILES['images'];
    $fileError = $fileArr['error'];
    $fileSize = $fileArr['size'];
    $fileName = $fileArr['name'];
    if ($fileError != 0) {
        $error = 'Có lỗi gì đó xảy ra, có thể do server';
    } else {
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileExtension = strtolower($fileExtension);
        if (!in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])){
            $error = 'Cần upload file có định dạng ảnh';
        } elseif ($fileSize > 2097152) {
            $error = 'File upload không được > 1Mb';
        } else {
            $directoryUploads = __DIR__ . "/uploads";
            if (!file_exists($directoryUploads)){
                mkdir($directoryUploads);
            }

            $tmpName = $fileArr['tmp_name'];
            $destination = $directoryUploads . "/" . $fileName;
            $isUploaded = move_uploaded_file($tmpName, $destination);

            if ($isUploaded) {
                $result = "<p>Ảnh vừa upload: " . "<img width='200px' height='200px' src='uploads/$fileName'></p>";
                $result .= "<p>Tên file: $fileName</p>";
                $result .= "<p>Định dạng file: $fileExtension</p>";
            }

        }
    }
}

?>


<style type="text/css">
    input[type="submit"] {
        padding: 15px 20px;
        border-radius: 8px;
        background: #538dc6;
        color: #ffffff;
        font-size: 18px;
        font-weight: bold;
    }
    span {
        color: #636262;
        font-size: 18px;
    }
    strong {
        font-size: 18px;
    }

    form {
        background: #f5f5f5;
    }
    .main-form {
        padding: 15px;
    }
</style>

<form action="" method="post" enctype="multipart/form-data">
    <div class="main-form">
        <p>
            <strong>Select a file to upload</strong><br>
            <input type="file" name="images" id=""><br>
            <span>Only jpg, png and gif file with maximum size of 1 MB is allowed</span>
        </p>
        <p>
            <input type="submit" name="submit" value="Upload">
        </p>
    </div>
</form>
<h3 style="color: red;">
    <?php echo $error; ?>
</h3>
<h3>
    <?php echo $result; ?>
</h3>
