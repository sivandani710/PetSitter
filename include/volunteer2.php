<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	require_once 'include/dbh.inc.php';
	require_once 'include/check-user-registration.php';
	require_once 'gocoder.php';

	//Get volunteers
	if($stmt = $conn->prepare("SELECT * FROM volunteer_view")){
		$stmt->execute();
		$figuresArr = array();
		$result = $stmt->get_result();

		$figures = 'לא קיימים מתנדבים פנויים במאגר';
		if($result->num_rows != 0) {
			//Now you can fetch the results into an array
			while ($userData = $result->fetch_assoc()) {
				$figure = "<li>
				<figure class='snip0045 red'>
					<figcaption>
						<h2><span>{0}</span>{10}</h2>
						<p>{1}</p>
						<p>{2}</p>
						<p id='more-details'>{3}</p>
						<p>
							:תאריכים פנויים קרובים<br/>
							{8}
						</p>
					</figcaption>
					<img src='{4}'/>	
					<div class='position'> 
						<div class='icons'>
							חוות דעת עליי&nbsp;<a href='reviews.php?type=2&id={9}'><i class='ion-ios-heart'></i></a> 
							&nbsp;&nbsp;&nbsp;
							{7}
						</div>
					</div>
					{5}
				</figure></li>";
				$volunteer_id = $userData['id'];

				$figure = str_replace("{0}", $userData['name'], $figure);
				$figure = str_replace("{1}", $userData['address'], $figure);
				$figure = str_replace("{3}", $userData['more_details'], $figure);
				$figure = str_replace("{4}", $userData['profile_picture'], $figure);
				$figure = str_replace("{9}", $volunteer_id, $figure);

				//If user has no account
				if (!isset($_SESSION['user-id'])) {
					$figure = str_replace("{2}", "", $figure);
					$figure = str_replace("{5}", "", $figure);
					$figure = str_replace("{7}", "", $figure);
					$figure = str_replace("{10}", "", $figure);
				} else {
					
					$figure = str_replace("{2}", $userData['email'], $figure);
					$figure = str_replace("{5}", "<p><a class='back-to-profile' href='contract.php?id=$volunteer_id'> לחץ כאן כדי להשאיר לי בקשה להתנדבות</a></p>", $figure);
					$figure = str_replace("{7}", "הוספת חוות דעת&nbsp;<a href='review-create.php?id=$volunteer_id&type=2'><i class='ion-ios-email'></i></a>", $figure);
					$distance = getDistance($_SESSION['user-latitude'], $_SESSION['user-longitude'], $userData['latitude'], $userData['longitude']);
					$figure = str_replace("{10}", $distance, $figure);
				}
				$volunteer_id = $userData['id'];
				$sql = "SELECT DATE_FORMAT(from_date,'%d/%m/%Y') AS from_date, DATE_FORMAT(from_hour, '%k:%i') AS from_hour, DATE_FORMAT(to_date,'%d/%m/%Y') AS to_date, DATE_FORMAT(to_hour, '%k:%i') AS to_hour 
						FROM volunteers
						WHERE user_id = $volunteer_id 
						AND DATE(NOW()) < DATE(to_date) 
						AND is_request = 0
						ORDER BY from_date ASC LIMIT 2";
				$volunteers = $conn->query($sql);
				if ($volunteers->num_rows > 0) {
					$dateArr = array();
				while($row = $volunteers->fetch_assoc()) {
						$from_date = $row['from_date'];
						$from_hour = $row['from_hour'];
						$to_date = $row['to_date'];
						$to_hour = $row['to_hour'];
						$date = "$from_date - $to_date $from_hour - $to_hour";
						array_push($dateArr, $date);
					}		
					$figure = str_replace("{8}", implode("<br/>", $dateArr), $figure);
				} else {
						echo "0 results";
				}

				array_push($figuresArr, $figure);
			}

			//Join all figuresArr strings
			$figures = implode("", $figuresArr);
		}
	} else {
		printf("Error message: %s\n", $conn->error);
	}
	$title = 'מתנדבים';
	$css_links = '<link rel="stylesheet" href="css/repository2.css">';
	require 'header.php';
?>

    <div class="background">
        <div class="transbox">
            <p>
                <h1 id="content">מאגר מתנדבים </h1>
            </p>
        </div>
	</div>
	<div class="manage-repo">
    	<a <?php if(!isset($_SESSION['user-id'])) echo 'class="hidden"' ?> href="dates.php">ההתנדבויות
		שלי</a>
	</div>
	
	<ul class="flex-container">
		<?php echo $figures;?>
	</ul>

    <?php require 'footer.php'; ?>