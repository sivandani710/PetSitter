<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	require_once 'include/dbh.inc.php';
    require_once 'include/check-user-registration.php';

    if (!isset($_SESSION['user-id'])) {
        header('Location: index.php');
    }

    $id = $_GET['id'];
    $type = $_GET['type'];
    if($id == null || $type == null){
        header('Location: index.php');    
    }

    $sql = "";
    switch ($type) {
        case '1': //owner
            $sql = "SELECT name FROM users WHERE id=$id";
            break;
        case '2': // volunteer
            $sql = "SELECT name FROM users WHERE id=$id";
            break;
        case '3': //Pet
            $sql = "SELECT name FROM pets WHERE id=$id";
            break;
        default:
            header('Location: index.php');    
            break;
    }

    if($stmt = $conn->prepare($sql)){
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row == null){
            header('Location: index.php');    
        }
        $user_name = $row['name'];
    } else {
        header('Location: index.php');    
    }

    $title = 'יצירת חוות דעת';
    $css_links = '<link rel="stylesheet" href="css/ReviewCreate.css">';
    require 'header.php';
?>

<body id="content">
    <div class="background">
        <div class="transbox">
            <p>
                <h1 id="content"> יצירת חוות דעת </h1>
            </p>
        </div>
    </div>

    <p><br> <br>
        הערה: אנא כתבו חוות דעת עניינית וכנה. <br>
        חוות דעת עם שפה לא נאותה ימחקו על ידי מנהלי האתר
    </p> <br><br>
    <p>
        <input type="text" style="text-align: right;" name="firstname" value="<?php echo $user_name;?>" readonly> :שם<br>
    </p>
    <p>
        <br>
        <br> <br>
        <form action="include/review-create.inc.php" method="post">
            <input type="hidden" name="on_user" value="<?php echo htmlspecialchars($id);?>">
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type);?>">
            <p id="reviewbox">
                :אנא מלאו את חוות הדעת שלכם כאן <br><br>
                <textarea style="text-align: right;" name="review" rows="10" cols="50"> </textarea> <br>
            </p><br><br>
            <p>
                אנא דרגו את המשתמש על פי דעתכם <br>
                1= נמוך מאוד <br>
                5= גבוה מאוד <br>
                <div class="rate">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="text">1 star</label>
                </div>
                <input type="submit" value="שלח" id="create-review" name="create-review-submit">
        </form>
    <?php 
		$js_links = '';
		require 'footer.php'; 
	?>