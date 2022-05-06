<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Student Info Submitted</title>
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
	echo "valid last name thank you <br />";
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

#get the parameter from the HTML form that this PHP program is connected to
#since data from the form is sent by the HTTP POST action, use the $_POST array here
$movie_name = $_POST["movie_name"];
$review = $_POST["review"];
$rating = $_POST["rating"];
$movie_name = mysqli_real_escape_string($db, $movie_name);
$review = mysqli_real_escape_string($db, $review);

$constructed_query = "INSERT INTO reviews (review, rating, moviename) VALUES ('$review', $rating, '$movie_name')";
if ($db->query($constructed_query) === TRUE) {
	echo "review added to database <br />";
} else {
	echo "Error: " . $constructed_query . "<br />" . $db->error;
}
?>

<a href="https://swe.umbc.edu/~kaio1/is448/Deliverable5/homepage.html">Return to Homepage</a>