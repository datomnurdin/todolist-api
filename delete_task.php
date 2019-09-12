<?php
 header("Access-Control-Allow-Origin: *");
 header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
 header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
 header('Content-Type: application/json');
/*
 * Following code will delete a task from table
 * A task is identified by task id (taskId)
 */
 
// array for JSON response
$response = array();

$postdata = json_decode(file_get_contents("php://input"), true);
$taskId = $postdata['taskId'];
 
// check for required fields
if (isset($taskId)) {
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 
    // mysql update row with matched taskId
    $result = mysqli_query($db->connect(),"DELETE FROM tasks WHERE taskId = $taskId");
 
    // check if row deleted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Task successfully deleted";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // no task found
        $response["success"] = 0;
        $response["message"] = "No task found";
 
        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>
