<?php
 header("Access-Control-Allow-Origin: *");
 header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
 header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
 header('Content-Type: application/json');
/*
 * Following code will get single task details
 * A task is identified by task id (taskId)
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();

$postdata = json_decode(file_get_contents("php://input"), true);
$userId = $postdata['userId'];
$q = $postdata['q'];
 
// check for post data
if (isset($userId) & isset($q)) {
 
    // get a task from task table
    $result = mysqli_query($db->connect(),"SELECT * FROM tasks WHERE userId = '$userId' AND name LIKE '%$q%' ");
 
    if (!empty($result)) {
        // check for empty result
        if (mysqli_num_rows($result) > 0) {
 
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