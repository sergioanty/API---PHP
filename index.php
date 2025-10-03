<?php
header("Content-Type: application/json"); 
include "db.php"; 

$method = $_SERVER['REQUEST_METHOD']; 
$id = $_SERVER['PATH_INFO'] ? explode('/', trim($_SERVER['PATH_INFO'], '/'))[1] ?? null : null; 
$data = json_decode(file_get_contents("php://input"), true); 

function respond($sql, $single = false) { 
    global $conn;
    $result = $conn->query($sql);
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => $conn->error]);
        return;
    }
    echo json_encode($single ? $result->fetch_assoc() : iterator_to_array($result)); 
}

switch ($method) {
    case 'GET':
        respond("SELECT * FROM tasks" . ($id ? " WHERE id=$id" : ""), $id);
        break;

    case 'POST':
        if (empty($data['title'])) {
            http_response_code(400);
            echo json_encode(["error" => "Title is required"]);
            break;
        }
        $title = $conn->real_escape_string($data['title']);
        $desc  = $conn->real_escape_string($data['description'] ?? '');
        $status = $conn->real_escape_string($data['status'] ?? 'pending');
        $sql = "INSERT INTO tasks (title, description, status) VALUES ('$title','$desc','$status')";
        echo $conn->query($sql)
            ? json_encode(["id" => $conn->insert_id, "message" => "Task created"])
            : json_encode(["error" => $conn->error]);
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "ID is required"]);
            break;
        }
        $title = $conn->real_escape_string($data['title'] ?? '');
        $desc  = $conn->real_escape_string($data['description'] ?? '');
        $status = $conn->real_escape_string($data['status'] ?? 'pending');
        $sql = "UPDATE tasks SET title='$title', description='$desc', status='$status' WHERE id=$id";
        echo $conn->query($sql)
            ? json_encode(["message" => "Task updated"])
            : json_encode(["error" => $conn->error]);
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "ID is required"]);
            break;
        }
        $sql = "DELETE FROM tasks WHERE id=$id";
        echo $conn->query($sql)
            ? json_encode(["message" => "Task deleted"])
            : json_encode(["error" => $conn->error]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
}
