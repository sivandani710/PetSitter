<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	require_once 'include/dbh.inc.php';
    require_once 'include/check-user-registration.php';

    if (!array_key_exists('user-id', $_SESSION) || $_SESSION['user-id'] == null) {
        header('Location: index.php');
    }
    
    $title = 'יצירת חיית מחמד חדשה';
	$css_links = '<link rel="stylesheet" href="css/animal.css">';
    require 'header.php';	
?>
    <div class="background">
        <div class="transbox">
            <h1 id="content">יצירת פרופיל חיית מחמד חדשה </h1>
        </div>
    </div>
    <form class="form" action="include/create-pet.inc.php" enctype="multipart/form-data" method="post">
        <div class="form-group">
            <label for="name">שם</label>
            <div class="relative">
                <input class="form-control" id="name" name="name" type="text" autofocus="" required="" autocomplete=""
                    placeholder="הקלד את שם החיית מחמד שלך...">
                <i class="fa fa-paw"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="type">סוג</label>
            <div class="relative">
                <input class="form-control" id="type" name="type" type="text" autofocus="" required=""
                    autocomplete="" placeholder="הקלד את סוג חיית המחמד שלך...">
                <i class="fa fa-paw"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="race">גזע</label>
            <div class="relative">
                <input class="form-control" id="race" name="race" type="text" autofocus="" required=""
                    autocomplete="" placeholder="הקלד את גזע חיית המחמד שלך...">
                <i class="fa fa-paw"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="age">גיל</label>
            <div class="relative">
                <input class="form-control" type="text" id="age" name="age" maxlength="3"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    placeholder="הקלד את גיל חיית המחמד שלך...">
                <i class="fa fa-paw"> </i>
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
            <a href="#" title="חשוב!" data-toggle="popover" data-trigger="hover"
                data-content="פרטים נוספים כגון יחס חיית המחמד לאנשים לא מוכרים, סביבת ביתית בשוטף או הרגלי אכילה עשויים למתנדב להכיר את חיית המחמד שלך קצת יותר ולהבין האם ישנה התאמה.">
                <i class="material-icons">
                    info
                </i>
            </a>
            <textarea id="more-info" name="more-info" cols="60" rows="3"></textarea>

        </p>

        <div id="privacy-terms">
            <div id="privacy-wrapper">
                <p> 1.כלב שאינו תוקפני כלפי בני אדם או כלבים אחרים.</p>
                <p> 2.לא יתקבלו כלבים אם חוסנו כנגד שעלת וטרם עברו 14 יום מרגע נטילת החיסון</p>
                <p> 3. טיפולים וטרינריים להם יזדקק הכלב במהלך השהות יהיו על חשבון הבעלים אלא עם כן נגרמו באשמת
                    המתנדב </p>
                <p> 4.טיפול המשך יהיה באחריותו של הבעלים בכל מקרה הכלב יקבל את הטיפול במהירות האפשרית ללא צורך
                    בקבלת היתר מהבעלים.</p>
                <p> 5.הלקוח יספק הוראות ומידע על רגישויות בנושא  טיפוח וניקיון של כלבו רגישות לחומרי טיפוח שונים
                    , צורכי הברשה או מריטה מיוחדים וכו.</p>
            </div>
        </div>
        <br>

        <p id="agree">
            <label for="i-agree">
                <input type='hidden' value='0' name='i-agree'>
                <input type="checkbox" required value="1" id="i-agree" name="i-agree" />הנני מאשר/ת כי קראתי את תקנון האתר
                והנני מסכים/מה לתנאיו.</label>
        </p>

        <div class="tright">
            <a href=""><button class="movebtn movebtnre" type="Reset"><i class="fa fa-fw fa-refresh"></i> אפס
                </button></a>
            <button id="sub" class="movebtn movebtnsu" type="Submit" name="create-pet-submit">צור<i
                    class="fa fa-fw fa-paper-plane"></i></button>

        </div>
    </form>
    <?php 
        $js_links = '<script src="js/showfilename.js"></script>';
        require 'footer.php';
    ?>