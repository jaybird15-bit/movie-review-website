<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Reviews viewer</title>
	<link rel="stylesheet" type="text/css" href="reviewtheme.css" />
</head>

<?php

$movie_name = $_POST["movie_name"];

if (preg_match("/[^ \r\t\n\f]+$/", $movie_name)) {
	echo "valid name <br />";
} else {
	echo "invalid name <br />";
}

$review = $_POST["review"];

if (preg_match("/[^ \r\t\n\f]+$/", $review)) {
	echo "review <br />";
} else {
	echo "invalid review <br />";
}

$rating = $_POST["rating"];
if (preg_match("/[^ \r\t\n\f]+$/", $rating)) {
	echo "valid rating thank you <br />";
} else {
	echo "invalid rating <br />";
}


?>
<?php
#connect to mysql database
$db = mysqli_connect("studentdb-maria.gl.umbc.edu", "j247", "j247", "j247");

if (mysqli_connect_errno())
	exit("Error - could not connect to MySQL");
if (preg_match("/[^ \r\t\n\f]+$/", $movie_name) && preg_match("/[^ \r\t\n\f]+$/", $review) && preg_match("/[^ \r\t\n\f]+$/", $rating)) {
	#get the parameter from the HTML form that this PHP program is connected to
	#since data from the form is sent by the HTTP POST action, use the $_POST array here
	$movie_name = $_POST["movie_name"];
	$review = $_POST["review"];
	$rating = $_POST["rating"];
	$movie_name = mysqli_real_escape_string($db, $movie_name);
	$review = mysqli_real_escape_string($db, $review);

	$constructed_query = "INSERT INTO reviews (review, rating, moviename) VALUES ('$review', '$rating', '$movie_name')";
	if ($db->query($constructed_query) === TRUE) {
		echo "review added to database <br> Here is the full list of reviews <br />";
		$sql = "SELECT  review, rating, moviename FROM reviews";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				echo '<div class = "review">';
				echo "  -Movie Name: " . $row["moviename"] . "   -Review: " . $row["review"] . " -Rating: " . $row["rating"] .  "<br>";
				echo '</div>';
			}
		} else {
			echo "0 results";
		}
	} else {
		echo "Error: " . $constructed_query . "<br />" . $db->error;
	}
} else {
	echo "Review not added to Database";
}


?>

<?php
$search = $_POST["Search_name"];
$sql = "SELECT review, rating, moviename FROM reviews WHERE reviews.moviename = '$search'";
$result = mysqli_query($db, $sql);

if (mysqli_connect_errno())
	exit("Error - could not connect to MySQL");
$constructed_query = "Select * from reviews where moviename = '$search'";
if ($db->query($constructed_query) === TRUE) {
	echo "Here are the results of your search <br />";
}
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	echo " <br /> Here is the Results of your search <br /> ";
	while ($row = mysqli_fetch_assoc($result)) {

		echo "  -Movie Name: " . $row["moviename"] . "   -Review: " . $row["review"] . " -Rating: " . $row["rating"] .  "<br>";
	}
} else {
	echo "0 results";
}
?>

<a href="homepage.html">Return to Homepage</a>