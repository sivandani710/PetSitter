<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	require_once 'include/dbh.inc.php';
	require_once 'include/check-user-registration.php';
	require_once 'gocoder.php';

	//Get pets for ads
	//Get pets for ads
	if($stmt = $conn->prepare("SELECT   p.id AS id, 
										p.owner AS owner, 
										p.name AS name, 
										p.type AS type, 
										p.race AS race, 
										p.age AS age, 
										CONCAT('uploads/pets/', p.id, p.profile_picture) AS profile_picture, 
										p.ads_details AS ads_details,
										u.latitude AS latitude,
										u.longitude AS longitude
									FROM pets AS p
									INNER JOIN users AS u ON p.owner = u.id
									WHERE is_ads = 1")){
		$stmt->execute();
		$figuresArr = array();
		$result = $stmt->get_result();

		$figures = 'לא קיימות חיות מחמד לאימוץ במאגר';
		if($result->num_rows != 0) {
			//Now you can fetch the results into an array
			while ($petData = $result->fetch_assoc()) {
				$figure = 
				"<figure class='snip0045 red'>
					<figcaption>
						<h2><span>{0}</span>{10}</h2>
						<p>{1}</p>
						<p>{2}</p>
						<p>{3}</p>
						<p>{4}</p>
					</figcaption>
					<img src='{5}'/>	
					<div class='position'> 
					</div>
					{6}
				</figure>";
				
				$figure = str_replace("{0}", $petData['name'], $figure);
				$figure = str_replace("{1}", $petData['type'], $figure);
				$figure = str_replace("{2}", $petData['race'], $figure);
				$figure = str_replace("{3}", $petData['age'], $figure);
				$figure = str_replace("{4}", $petData['ads_details'], $figure);
				$figure = str_replace("{5}", $petData['profile_picture'], $figure);
				//If user has no account
				if (!isset($_SESSION['user-id'])) {
					$figure = str_replace("{6}", "", $figure);
					$figure = str_replace("{10}", "", $figure);
				} else {
					$figure = str_replace("{6}", '<p><a class="back-to-profile" href="user-profile.php?id='.$petData['owner'].'">לפרופיל של הבעלים שלי</a></p>', $figure);
					$distance = getDistance($_SESSION['user-latitude'], $_SESSION['user-longitude'], $petData['latitude'], $petData['longitude']);
					if($distance != null) {
						$figure = str_replace("{10}","<span class='distance'>$distance קמ ממך</span>", $figure);
					} else {
						$figure = str_replace("{10}", "", $figure);
					}
				}
				
				array_push($figuresArr, $figure);
			}
		
			//Join all figuresArr strings
			$figures = implode("", $figuresArr);
		}
	} else {
		printf("Errormessage: %s\n", $conn->error);
	}
   
	$title = 'מאגר חיות מחמד לאימוץ';
	$css_links = '<link rel="stylesheet" href="css/repository.css">';
	require 'header.php';
?>

<div class="background">
    <div class="transbox">
        <p>
            <h1 id="content"> מאגר חיות מחמד לאימוץ </h1>
        </p>
    </div>
</div>
<div class="manage-repo">
    <a <?php if(!isset($_SESSION['user-id'])) echo 'class="hidden"' ?> href="create-ads.php">הוסף
        בעל
        חיים לאימוץ</a>
</div>
<ul class="flex-container">
	<?php echo $figures;?>
</ul>

<?php 
		$js_links = '';
		require 'footer.php'; 
?>