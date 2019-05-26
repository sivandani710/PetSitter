<?php
if(isset($_POST['create-owner-submit'])) {
    require 'dbh.inc.php';
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $date_old = '23-5-2016 23:15:23'; 
    $birth_date = date ("Y-m-d H:i:s", strtotime($_POST['birth_date']));
    $address = $_POST['designation'];
    $more_details = $_POST['more-info'];

    $profile_picture = $_FILES["fileToUpload"]["name"];
    $dirpath = realpath(dirname(getcwd()));
    $target_dir = "uploads/{0}";
    $target_file = $dirpath. "/" .$target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    //Check file type
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    }

    $sql = "CALL CreateNewUser(
        '$name',
        '$email',
        '$mobile',
        '$birth_date',
        '$profile_picture',
        '$address',
        '$more_details')";

        
    if($result = mysqli_query($conn, $sql)){
        $row = $result->fetch_assoc()['LAST_INSERT_ID()'];
        $target_file = str_replace("{0}",$row, $target_file);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    else {
        echo("Error description: " . mysqli_error($conn));
    }
}

?>