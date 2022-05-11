<?php
session_start();
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

mysqli_report((MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX) | MYSQLI_REPORT_STRICT);
try {
    $mysql = new mysqli("studentdb-maria.gl.umbc.edu", "j247", "j247", "j247");
} catch (Exception $e) {
    error_log($e);
}

$query = "
    SELECT 
        id,
        title,
        year,
        posterUrl,
        synopsis,
        behind_the_scenes_video_url,
        cast_interview_video_url
    FROM
        movies
    WHERE
        id = ?
";

$statement = $mysql->prepare($query);
$statement->bind_param(
    "i",
    $_GET["id"]
);

if (!$statement->execute()) {
    http_response_code(500);
    echo json_encode(
        ["message" => "Something went wrong. Please try again."]
    );
    exit();
}

$statement->bind_result($id, $title, $year, $posterUrl, $synopsis, $behind_the_scenes_video_url, $cast_interview_video_url);
$statement->fetch();

http_response_code(200);
echo json_encode(
    [
        "id" => $id,
        "title" => $title,
        "year" => $year,
        "posterUrl" => $posterUrl,
        "synopsis" => $synopsis,
        "behind_the_scenes_video_url" => $behind_the_scenes_video_url,
        "cast_interview_video_url" => $cast_interview_video_url
    ]
);
exit();
