<?php
 
/*
 * Following code will delete a task from table
 * A task is identified by task id (taskId)
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_GET['taskId'])) {
    $taskId = $_GET['taskId'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 
    // mysql update row with matched taskId
    $result = mysqli_query($db->connect(),"DELETE FROM tasks WHERE taskId = $taskId");
 
    // check if row deleted or not
    if (mysqli_affected_rows() > 0) {
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