
<?php
    session_start();
    //On edit exsits date
    if(isset($_POST['create-user-submit'])) {
        require 'dbh.inc.php';
    
        $name = $_POST['name'];
        $oauth_uid = $_SESSION['id'];
        $email = $_SESSION['email'];
        $mobile = $_POST['mobile'];
        $birth_date = date ("Y-m-d H:i:s", strtotime($_POST['birth_date']));

        $location_id = $_POST['location-id'];
        $location = $_POST['location'];
        $maps_url = 'http://geocoder.api.here.com/6.2/geocode.json?locationid={0}&jsonattributes=1&gen=9&app_id=bzonpeNIWqYBXzfcQhLK&app_code=i4NaaZIjpiCRyvDWg4BNPQ';
        $maps_url = str_replace("{0}",$location_id, $maps_url);
        $maps_json = file_get_contents($maps_url);
        $maps_array = json_decode($maps_json, true);
        $latitude = $maps_array['response']['view'][0]['result'][0]['location']['mapView']['topLeft']['latitude'];
        $longitude = $maps_array['response']['view'][0]['result'][0]['location']['mapView']['topLeft']['longitude'];
        
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
            'google',
            '$oauth_uid',
            '$email',
            '$mobile',
            '$birth_date',
            '$profile_picture',
            '$location',
            '$latitude',
            '$longitude',
            '$more_details')";
    
        if($result = mysqli_query($conn, $sql)){
            $row = $result->fetch_assoc()['LAST_INSERT_ID()'];
            $target_file = str_replace("{0}",$row, $target_file);
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
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


