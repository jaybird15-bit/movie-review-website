<?php
session_start();
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

mysqli_report((MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX) | MYSQLI_REPORT_STRICT);
try {
    $mysql = new mysqli("studentdb-maria.gl.umbc.edu", "j247", "j247", "j247");
} catch (Exception $e) {
    error_log($e);
}

$body = json_decode(file_get_contents("php://input"));

// Is the title length out of range?
if (strlen($body->title) < 1 || strlen($body->title) > 256) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Title must be 1-256 characters."]
    );
    exit();
}

// Is the year valid?
if (strlen($body->year) != 4 || !is_numeric($body->year)) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Year must be a 4-digit number (YYYY)."]
    );
    exit();
}

// Is the poster URL length out of range?
if (strlen($body->posterUrl) < 1 || strlen($body->posterUrl) > 256) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Poster URL must be 1-256 characters."]
    );
    exit();
}

// Is the synopsis too long?
if (strlen($body->synopsis) > 512) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Synopsis must be less than 512 characters."]
    );
    exit();
}

// Is it too long?
if (strlen($body->behindTheScenesVideoUrl) > 256) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Behind the scenes video URL must be less than 256 characters."]
    );
    exit();
}

// Is it too long?
if (strlen($body->castInterviewVideoUrl) > 256) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Cast interview video URL must be less than 256 characters."]
    );
    exit();
}

// Insert the movie...
$query = "
    INSERT INTO
        movies( title, year, posterUrl, synopsis, behind_the_scenes_video_url, cast_interview_video_url )
    VALUES( ?, ?, ?, ?, ?, ? )
";
$statement = $mysql->prepare($query);
$statement->bind_param(
    "sissss",
    $body->title,
    $body->year,
    $body->posterUrl,
    $body->synopsis,
    $body->behindTheScenesVideoUrl,
    $body->castInterviewVideoUrl
);

if (!$statement->execute()) {
    http_response_code(500);
    echo json_encode(
        ["message" => "Something went wrong. Please try again."]
    );
    exit();
} else {
    http_response_code(200);
    echo json_encode(
        ["message" => "Movie added successfully."]
    );
    exit();
}
