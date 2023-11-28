<?php
session_start();
$errors = array();
$response = array();

if (isset($_POST['submitL'])) {
    $nameL = mysqli_real_escape_string($conn, $_POST['nameL']);
    $passL = md5($_POST['passwordL']);
    $selectL = "SELECT * FROM users WHERE username = '$nameL' && password = '$passL'";
    $resultL = mysqli_query($conn, $selectL);

    if (mysqli_num_rows($resultL) > 0) {
        $row = mysqli_fetch_array($resultL);
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['username'];
            $response['success'] = true;
            $response['redirect'] = 'admin_page.php';
        } elseif ($row['user_type'] == 'default') {
            $_SESSION['user_name'] = $row['username'];
            $response['success'] = true;
            $response['redirect'] = 'user_page.php';
        }
    } else {
        $response['success'] = false;
        $response['error'] = "Incorrect username or password";
    }
}
session_destroy();

header('Content-Type: application/json');
echo json_encode($response);
?>
