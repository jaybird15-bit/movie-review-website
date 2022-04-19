<?php
session_start();
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

mysqli_report((MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX) | MYSQLI_REPORT_STRICT);
try {
    $mysql = new mysqli("studentdb-maria.gl.umbc.edu", "j247", "j247", "j247");
} catch (Exception $e) {
    error_log($e);
}

// email, password
$body = json_decode(file_get_contents("php://input"));

// Is the email invalid? (i.e. does it have no '@' character, etc...)
if (filter_var($body->email, FILTER_VALIDATE_EMAIL) == false) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Email is invalid."]
    );
    exit();
}

$query = "
    SELECT *
    FROM
        users
    WHERE
        email = ?
";
$statement = $mysql->prepare($query);
$statement->execute([$body->email]);
$rows = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

// Does that user exist?
if (count($rows) > 0) {
    $user = $rows[0];

    // Does the password hash match the given password?
    if (password_verify($body->password, $user["password_hash"])) {
        http_response_code(200);
        echo json_encode(
            ["message" => "Login successful."]
        );
        exit();
    }
}

http_response_code(400);
echo json_encode(
    ["message" => "Incorrect email/password."]
);
exit();
