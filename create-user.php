<?php
	session_start();
	require 'include/dbh.inc.php';

    //If user not sign in browse to login.php
	if (!isset($_SESSION['access_token'])) {
		header('Location: login.php');
		exit();
	}
    
	//User is sign in -> get user data
	$sql = "SELECT * FROM users WHERE email='".$_SESSION['email']."'";
	$result = mysqli_query($conn, $sql);

	//If user not exists -> stay in the page
	if(!empty($result->fetch_assoc())){
		header('Location: index.php');
	}	
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create New User Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://serve.fontsproject.com/css?family=Simple+CLM:400' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/owner.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="js/index.js"></script>
    <script>
    $(document).ready(function() {
        $("#thanks").hide();
        $('[data-toggle="popover"]').popover();
    });

    $(function() {
        var $privacy = $('#privacy-terms'),
            $privacyWrapper = $('#privacy-wrapper'),
            $agree = $('#agree'),
            height = $privacy.height(),
            top = $privacy.offset().top,
            privacyWrapperHeight = $privacyWrapper.outerHeight();

        $privacy.on('scroll', function() {
            if (Math.ceil(height - $privacyWrapper.offset().top + top) >= privacyWrapperHeight) {
                $agree.show();
            }
        });

        $("#location-input").autocomplete({
            source: "include/search-location.inc.php",
            select: function(event, ui) {
                event.preventDefault();
                $("#location").val(ui.item.value);
                $("#location-id").val(ui.item.id);
                $("#location-input").val(ui.item.value);
            },
            change: function(event, ui) {
                if (ui.item == null || ui.item == undefined) {
                    $("#location").val("");
                    $("#location-id").val("");
                    $("#location-input").val("");
                    $("#location-input").attr("disabled", false);
                } else {
                    $("#location-input").attr("disabled", true);
                }
            }
        });

        $('#remove-location').click(function(e) {
            e.preventDefault();
            $("#location").val("");
            $("#location-id").val("");
            $("#location-input").val("");
            $("#location-input").attr("disabled", false);
        });

        $('input[type=file]').change(function(event) {
            $('#pic').val(event.target.files[0].name);
        });

    });

    $('form').submit(function() {
        $("#thanks").show();
    });
    </script>

</head>
<!--required=""-->

<body id="content" dir="rtl">
    <div class="background">
        <div class="transbox">
            <h1 id="content">יצירת פרופיל חדש </h1>
        </div>
    </div>
    <form class="form" action="include/create-user.inc.php" enctype="multipart/form-data" method="post">
        <div class="form-group">
            <label for="name">שם מלא</label>
            <div class="relative">
                <input class="form-control" id="name" name="name" type="text" autofocus="" required="" autocomplete=""
                    placeholder="הקלד את שמך המלא...">
                <i class="fa fa-user"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="email">טלפון נייד</label>
            <div class="relative">
                <input class="form-control" type="text" name="mobile" maxlength="10"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="הקלד טלפון נייד...">
                <i class="fa fa-phone"> </i>
            </div>
        </div>
        <div class="form-group">
            <label for="birth_date">תאריך לידה</label>
            <div class="relative">
                <input class="form-control" type="date" id="birth_date" name="birth_date"
                    data-date-inline-picker="true" />
                <i class="fa fa-calendar"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="designation">כתובת</label>
            <div class="relative">
                <i class="fa fa-address-card-o"></i>
                <input class="form-control" type="text" name="location-input" id="location-input"
                    placeholder="הקלד את כתובת המגורים שלך..." />
                <p id="remove-location" class="glyphicon glyphicon-trash"
                    style="text-decoration: underline; float: left; margin-top:2px; cursor:pointer">מחק כתובת</p>
                <input type="hidden" id="location-id" name="location-id" />
                <input type="hidden" id="location" name="location" />
            </div>
        </div>

        </div>
        </div>
        <div class="form-group">
            <label for="pic">העלאת תמונת פרופיל</label>
            <div class="relative">
                <div class="input-group">
                    <input type="text" class="form-control" name="pic" id="pic" placeholder="בחר קובץ להעלאה..."
                        readonly>
                    <i class="fa fa-camera-retro fa-lg"></i>
                    <label class="input-group-btn">
                        <span class="btn btn-default">
                            ...
                            <input type="file" style="display: none;" name="fileToUpload" id="fileToUpload">
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <p><label>פרטים נוספים שכדאי לדעת:
            </label>
            <a href="#" title="חשוב!" data-toggle="popover" data-trigger="hover" data-content="פרטים נוספים כגון רמת זמינות בעת המשמורת עשויים לעזור למתנדב להכיר אותך קצת יותר ולהבין מול מי ההתקשרות.

">
                <i class="material-icons">
                    info
                </i>
            </a>
            <textarea cols="60" rows="3" name="more-info" id="more-info"></textarea>

        </p>

        <div id="privacy-terms">
            <div id="privacy-wrapper">
                <p> 1.כלב שאינו תוקפני כלפי בני אדם או כלבים אחרים.</p>
                <p> 2.לא יתקבלו כלבים אם חוסנו כנגד שעלת וטרם עברו 14 יום מרגע נטילת החיסון</p>
                <p> 3. טיפולים וטרינריים להם יזדקק הכלב במהלך השהות יהיו על חשבון הבעלים אלא עם כן נגרמו באשמת המתנדב
                </p>
                <p> 4.טיפול המשך יהיה באחריותו של הבעלים בכל מקרה הכלב יקבל את הטיפול במהירות האפשרית ללא צורך בקבלת
                    היתר מהבעלים.</p>
                <p> 5.הלקוח יספק הוראות ומידע על רגישויות בנושא  טיפוח וניקיון של כלבו רגישות לחומרי טיפוח שונים , צורכי
                    הברשה או מריטה מיוחדים וכו.</p>
            </div>
        </div>
        <br>

        <p id="agree">
            <label for="i-agree">
                <input  type="checkbox" required id="i-agree" name="i-agree" />הנני מאשר/ת כי קראתי את תקנון האתר והנני
                מסכים/מה לתנאיו.</label>
        </p>

        <div class="tright">
            <a href=""><button class="movebtn movebtnre" type="Reset"><i class="fa fa-fw fa-refresh"></i> אפס
                </button></a>
            <!--<button id="sub" class="movebtn movebtnsu" type="Submit">צור<i class="fa fa-fw fa-paper-plane"></i></button>-->
            <button id="sub" class="movebtn movebtnsu" type="Submit" name="create-user-submit">צור<i
                    class="fa fa-fw fa-paper-plane"></i></button>

        </div>
        <div class="thanks" id="thanks">
            <h4>תודה!</h4>
            <p><small>הפרופיל נוצר בהצלחה!!</small></p>
        </div>
    </form>





</body>

</html>