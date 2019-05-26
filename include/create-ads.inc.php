
<?php
    //On create new ads
    if(isset($_POST['create-ads-submit'])) {
        require 'dbh.inc.php';
        session_start();
    
        $owner = $_SESSION['user-id'];
        $name = $_POST['name'];        
        $type = $_POST['type'];
        $race = $_POST['race'];
        $age = $_POST['age'];
        $more_details = '';
        $is_ads = 1;
        $ads_details = $_POST['ads-details'];
        
    
        $profile_picture = $_FILES["fileToUpload"]["name"];
        $dirpath = realpath(dirname(getcwd()));
        $target_dir = "uploads/pets/{0}";
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

        $sql = "CALL CreateNewPet(
            '$owner',
            '$name',
            '$type',
            '$race',
            '$age',
            '$profile_picture',
            '$more_details',
            '$is_ads',
            '$ads_details')";
    
        if($result = mysqli_query($conn, $sql)){
            $row = $result->fetch_assoc()['LAST_INSERT_ID()'];
            $target_file = str_replace("{0}",$row, $target_file);
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                header('Location: ../index.php');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        else {
            echo("Error description: " . mysqli_error($conn));
        }
    }
?>


