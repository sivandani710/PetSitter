<?php
session_start();
if(isset($_POST['create-review-submit'])) {
    require 'dbh.inc.php';
    
    $reviewer = $_SESSION['user-id'];
    $on_user = $_POST['on_user'];
    $review_type = $_POST['type'];
    $review = $_POST['review'];
    $rank = $_POST['rate'];
    if($rank == null){
        $rank = 0;
    }

    if($stmt = $conn->prepare("INSERT INTO reviews (reviewer, on_user, review_type, review, rank) VALUES (?, ?, ?, ?, ?)")){
        //Bind i -> for int col & s for string col
        $stmt->bind_param("iiisi", $reviewer, $on_user, $review_type, $review, $rank);
        
        if (!$stmt->execute()) {
            echo("Error description: " . mysqli_error($conn));
        } else{
            header('Location: ../volunteer.php');
        }
    } else {
        echo("Error description: " . mysqli_error($conn));
    }
}

?>