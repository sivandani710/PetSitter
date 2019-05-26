<?php
    //On edit date
    if(isset($_POST['edit-date-submit'])) {
        require 'dbh.inc.php';
    
        $volunteer_id = $_POST['id'];
        $date_input = $_POST['datetimes'];
        $dates = preg_split ("/ /", $date_input);
        $from_date = date("Y-m-d", strtotime(str_replace('/', '-', $dates[0])));
        $from_hour = date("H:i:s", strtotime($dates[1]));
        $to_date = date("Y-m-d", strtotime(str_replace('/', '-', $dates[3])));
        $to_hour = date("H:i:s", strtotime($dates[4]));
        
        if($stmt = $conn->prepare("UPDATE volunteers
                                   SET  from_date = ?,
                                        from_hour = ?,
                                        to_date = ?,
                                        to_hour = ?
                                   WHERE id = ?")) {
        
            //Bind i -> for int col & s for string col
            $stmt->bind_param("ssssi", $from_date, $from_hour, $to_date, $to_hour, $volunteer_id);
            
            if (!$stmt->execute()) {
                echo("Error description: " . mysqli_error($conn));
            } else{
                header('Location: ../dates.php');
            }
        } else {
            echo("Error description: " . mysqli_error($conn));
        }
    }

    //On remove date
    if(isset($_POST['remove-date-submit'])) {
        require 'dbh.inc.php';
    
        $volunteer_id = $_POST['id'];
        
        if($stmt = $conn->prepare("DELETE FROM volunteers WHERE id = ?")) {
        
            //Bind i -> for int col & s for string col
            $stmt->bind_param("i", $volunteer_id);
            
            if (!$stmt->execute()) {
                echo("Error description: " . mysqli_error($conn));
            } else{
                header('Location: ../dates.php');
            }
        } else {
            echo("Error description: " . mysqli_error($conn));
        }
    }

    //On add new date
    if(isset($_POST['save-date-submit'])) {
        require_once "../config.php";
        $gClient->setAccessToken($_SESSION['access_token']);
        $service = new Google_Service_Calendar($gClient);

        require 'dbh.inc.php';
    
        $user_id = $_SESSION['user-id'];
        $date_input = $_POST['datetimes'];
        $dates = preg_split ("/ /", $date_input);
        $from_date = date("Y-m-d", strtotime(str_replace('/', '-', $dates[0])));
        $from_hour = date("H:i:s", strtotime($dates[1]));
        $to_date = date("Y-m-d", strtotime(str_replace('/', '-', $dates[3])));
        $to_hour = date("H:i:s", strtotime($dates[4]));
        
        if($stmt = $conn->prepare("INSERT INTO volunteers (user_id, from_date, from_hour, to_date, to_hour) 
                                   VALUES (?, ?, ?, ?, ?)")) {
            //Bind i -> for int col & s for string col
            $stmt->bind_param("issss", $user_id, $from_date, $from_hour, $to_date, $to_hour);
            
            if (!$stmt->execute()) {
                echo("Error description: " . mysqli_error($conn));
            } else{
                header('Location: ../dates.php');
            }
        } else {
            echo("Error description: " . mysqli_error($conn));
        }

        if($_POST['add-to-google'] == '1'){
            $from_hour_isr = date("H:i:s", strtotime('-3 hours', strtotime($from_hour)));
            $to_hour_isr = date("H:i:s", strtotime('-3 hours', strtotime($to_hour)));
            $eventStart = $from_date.'T'.$from_hour_isr.'-00:00';
            $eventEnd = $to_date.'T'.$to_hour_isr.'-00:00';
            $event = new Google_Service_Calendar_Event(array(
                'summary' => 'פנוי להתנדבות',
                'description' => 'הוסף על ידי Petsiter',
                'start' => array(
                    'dateTime' => $eventStart,
                    'timeZone' => 'Asia/Jerusalem',
                ),
                'end' => array(
                    'dateTime' => $eventEnd,
                    'timeZone' => 'Asia/Jerusalem',
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                        array('method' => 'email', 'minutes' => 24 * 60),
                        array('method' => 'popup', 'minutes' => 10),
                    ),
                ),
            ));
          
          $calendarId = 'primary';
          $event = $service->events->insert($calendarId, $event);
        }
    }
?>