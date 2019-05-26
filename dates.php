<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	require_once 'include/dbh.inc.php';
	require_once 'include/check-user-registration.php';
    
    if(!isset($_SESSION['user-id'])){
        header('Location: index.php');
    }

    $volunteer_id = $_SESSION['user-id'];
    $sql = "SELECT id, DATE_FORMAT(from_date,'%d/%m/%Y') AS from_date, DATE_FORMAT(from_hour, '%k:%i') AS from_hour, DATE_FORMAT(to_date,'%d/%m/%Y') AS to_date, DATE_FORMAT(to_hour, '%k:%i') AS to_hour FROM volunteers WHERE user_id = $volunteer_id AND DATE(NOW()) < DATE(to_date) ORDER BY from_date";
    $volunteers = $conn->query($sql);
    if ($volunteers->num_rows > 0) {
        $dateArr = array();
        while($row = $volunteers->fetch_assoc()) {
            $date_id = $row['id'];
            $from_date = $row['from_date'];
            $from_hour = $row['from_hour'];
            $to_date = $row['to_date'];
            $to_hour = $row['to_hour'];
            $exsit_date ='
            <div class="row">
                <form action="include/dates.inc.php" method="post">
                    <div id="date{4}-form" class="hidden">
                        <input type="hidden" id="from-date{4}" value="{0}">
                        <input type="hidden" id="from-hour{4}" value="{1}">
                        <input type="hidden" id="to-date{4}" value="{2}">
                        <input type="hidden" id="to-hour{4}" value="{3}">
                        <input type="hidden" name="id" value="{4}">
                        <input type="text" name="datetimes" id="date{4}-input" value="{0} {1} - {2} {3}">
                        <button class="movebtn movebtnsu" type="Submit" name="edit-date-submit">שמור</button>
                        <button type="button" class="movebtn movebtnsu" onclick="cancelExistsDate({4})">ביטול<i
                            class="fa fa-fw fa-remove"></i></button>
                    </div>
            
                    <div id="date{4}-readonly">
                        <span class="dates date{4}">מתאריך {0} בשעה {1} ועד {2} בשעה {3} </span>
                        <div class="form-group date{4}">
                            <div>                                        
                            <button type="Submit" class="movebtn movebtnsu delete" type="Submit" name="remove-date-submit">מחק <i
                                class="fa fa-fw fa-remove"></i></button>
                            <button type="button" class="movebtn movebtnre edit" onclick="editExistsDate({4})">ערוך <i
                                    class="fa fa-fw fa-pencil"></i></button>
                            </div>
                        </div>
                    </div>
            </form>
            </div>';
            $exsit_date = str_replace("{0}", $from_date, $exsit_date);
            $exsit_date = str_replace("{1}", $from_hour, $exsit_date);
            $exsit_date = str_replace("{2}", $to_date, $exsit_date);
            $exsit_date = str_replace("{3}", $to_hour, $exsit_date);
            $exsit_date = str_replace("{4}", $date_id, $exsit_date);
            array_push($dateArr, trim($exsit_date));
        } 
        $exsit_dates = implode("", $dateArr);
    } else {
        echo "0 results";
    }

    $title = 'ניהול תאריכי התנדבות';
    $css_links = '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
                  <link rel="stylesheet" href="css/Dates.css"/>';

	require 'header.php';
?>
    <div class="background">
        <div class="transbox">
            <h1 id="content">ניהול תאריכי התנדבות </h1>
        </div>
    </div>

    <h2>התנדבויות קיימות</h2>
    <div class="container">
        <?php echo $exsit_dates;?>
    </div>

    <h2>הוסף התנדבות חדשה</h2>
    <div class="row">
        <p>
            <label for="email">בחירת תאריכים פנויים
                <a href="#" title="חשוב!" data-toggle="popover" data-trigger="hover"
                    data-content="בשלב זה עליך לבחור את התאריכים הפנויים שלך לשמירה על חיית המחמד">
                    <i class="material-icons">
                        info
                    </i>
                </a>
                <br />
                מתאריך עד תאריך
            </label>
        </p>

        <form action="include/dates.inc.php" method="post">
            <input type="text" name="datetimes" />
            <input type='hidden' value='0' name='add-to-google'>
            <input type="checkbox" class="custom-control-input" id="add-to-google" name="add-to-google" value="1">
            <label class="custom-control-label" for="add-to-google">הוסף התנדבות פנויה ליומן גוגל</label>
            <button  class="movebtn movebtnsu" type="Submit" name="save-date-submit">
                הוסף<i class="fa fa-fw fa-paper-plane"></i>
            </button>
            
        </form>
    </div>

    <?php 
        $js_links = '<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script type="text/javascript" src="js/dates2.js"></script>';
        require 'footer.php'; 
    ?>