<?php
    $host='localhost';
    $username= 'root';
    $password= '';
    $db= 'latihan';

    mysql_connect($host, $username, $password);
    mysql_select_db($db);
?>
<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$date = new DateTime();
//$date21= $date->format('Y-m-d H:i:sP');
//jika tidak ingin sama tambahkan ID pada awal nama
$nama_baru= $date->format('YmdHis.').$imageFileType;


#01 Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

#02 Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

#03 Check file size
if ($_FILES["fileToUpload"]["size"] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

#04 Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType !='JPG' && $imageFileType !='JPEG' && $imageFileType !='PNG') {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

#05 Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$nama_baru)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        mysql_query("INSERT INTO `upload_gambar`(`foto`) VALUES ('$nama_baru'); ");
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>