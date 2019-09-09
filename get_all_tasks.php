<?php
 header("Access-Control-Allow-Origin: *");
 header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
 header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
 header('Content-Type: application/json');
/*
 * Following code will list all the tasks
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all tasks from task table
$result = mysqli_query($db->connect(), "SELECT *FROM tasks");
 
// check for empty result
if (mysqli_num_rows($result) > 0) {
    // looping through all results
    // tasks node
    $response["tasks"] = array();
 
    while ($row = mysqli_fetch_array($result)) {
        // temp tasks array
        $tasks = array();
        $task["taskId"] = $row["taskId"];
        $task["name"] = $row["name"];
        $task["description"] = $row["description"];
        $task["dateCreated"] = $row["dateCreated"];
        $task["dateUpdated"] = $row["dateUpdated"];
 
        // push single task into final response array
        array_push($response["tasks"], $task);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no tasks found
    $response["success"] = 0;
    $response["message"] = "No tasks found";
 
    // echo no tasks JSON
    echo json_encode($response);
}
?>