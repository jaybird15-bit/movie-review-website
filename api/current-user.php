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
    SELECT *
    FROM
        users
    WHERE
        email = ?
";

$statement = $mysql->prepare($query);
$statement->execute([$_SESSION["email"]]);
$rows = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

// Is the user is logged in?
if (count($rows) > 0) {
    http_response_code(200);
    echo json_encode(
        $rows[0]
    );
} else {
    http_response_code(200);
    echo json_encode(
        null
    );
}
