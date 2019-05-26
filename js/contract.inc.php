<?php
    //On ask for volunteer
    if(isset($_POST['save-contract-submit'])) {
        session_start();
        require 'dbh.inc.php';
    
        $request_user_id = $_SESSION['user-id'];
        $date_id = $_POST['date-id'];
        if($stmt = $conn->prepare("UPDATE volunteers SET is_request = 1, request_user_id = ? WHERE id = ?")){
            //Bind i -> for int col & s for string col
            $stmt->bind_param("ii", $request_user_id, $date_id);
            
            if (!$stmt->execute()) {
                echo("Error description: " . mysqli_error($conn));
            } else{
                /*
                $sql = "SELECT  u.email AS email,
                                DATE_FORMAT(from_date,'%d/%m/%Y') AS from_date,
                                DATE_FORMAT(from_hour, '%k:%i') AS from_hour, 
                                DATE_FORMAT(to_date,'%d/%m/%Y') AS to_date, 
                                DATE_FORMAT(to_hour, '%k:%i') AS to_hour
                        FROM    volunteers AS v 
                        INNER JOIN users AS u ON v.user_id = u.id  
                        WHERE v.id = $date_id";
                $result = $conn->query($sql);
				if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $from_date = $row['from_date'];
                    $from_hour = $row['from_hour'];
                    $to_date = $row['to_date'];
                    $to_hour = $row['to_hour'];
                    $email ='danielts86@gmail.com';// $row['email'];
                    $msg = "שלום\nיש לך בקשה חדשה להתנדבות,מתאריך {0} בשעה {1} ועד {2} בשעה {3}";
                    $msg = str_replace("{0}", $from_date, $msg);
                    $msg = str_replace("{1}", $from_hour, $msg);
                    $msg = str_replace("{2}", $to_date, $msg);
                    $msg = str_replace("{3}", $to_hour, $msg);
                    // use wordwrap() if lines are longer than 70 characters
                    $msg = wordwrap($msg,70);
                    // send email
                    mail($email,"בקשה חדשה להתנדבות",$msg);*/
                    header('Location: ../volunteer.php');
                }
            }
        } else {
            echo("Error description: " . mysqli_error($conn));
        }
    }
?>