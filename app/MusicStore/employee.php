<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
header('Content-Type: application/json');
$con = new mysqli("MYSQL", "root", "", "MusicStore");
$answer = array();
switch ($requestMethod) {
    case 'GET':
        if (empty(isset($_GET['employee_id']))) {
            $result = $con->query("SELECT * FROM employee;");
            while ($row = $result->fetch_assoc()) {
                $answer[] = $row;
            }
        } else {
            $query_result = $con->query("SELECT * FROM employee WHERE employee_id = " . $_GET['employee_id'] . ";");
            $result = $query_result->fetch_assoc();
            $answer = $result;
        }
        if (!empty($result)) {
            http_response_code(200);
            echo json_encode($answer);
        } else {
            http_response_code(204);
        }
        break;
    case 'POST':
        $json = file_get_contents('php://input');
        $client = json_decode($json);
        if (!empty($client->{'emp_surname'}) && !empty($client->{'emp_name'}) && !empty($client->{'emp_patronymic'})) {
            $emp_surname = $client->{'emp_surname'};
            $emp_name = $client->{'emp_name'};
            $emp_patronymic = $client->{'emp_patronymic'};
            $query_result = $con->query("SELECT * FROM employee WHERE emp_patronymic = '" . $emp_patronymic . "'");
            if (!empty($result)) {
                http_response_code(409);
            } else {
                $stmt = $con->prepare("INSERT INTO employee (emp_surname, emp_name, emp_patronymic) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $emp_surname, $emp_name, $emp_patronymic);
                $stmt->execute();
                http_response_code(201);
            }
        } else {
            http_response_code(422);
        }

        break;

    case 'PATCH':
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        if (!empty($obj->{'emp_name'}) && !empty($obj->{'emp_surname'})){
            if (empty(isset($_GET['employee_id']))){
                $answer["status"] = "Error. Need ID Param";
                http_response_code(422);
            } else {
                $query_result = $con->query("SELECT * FROM employee WHERE employee_id='".$_GET['employee_id']."'");
                $result = $query_result->fetch_row();
                if (!empty($result)){
                    $query_result = $con->query("SELECT * FROM employee 
                                                       WHERE emp_name ='".$obj->{'emp_name'}."' 
                                                       AND employee_id!='".$_GET['employee_id']."'");
                    $result = $query_result->fetch_row();
                    if (!empty($result)){
                        $answer["status"] = "Error. User with this username already exists.";
                        http_response_code(409);
                    } else {
                        $con->query("UPDATE employee SET emp_surname ='".$obj->{'emp_surname'}."', emp_name ='".$obj->{'emp_name'}."'
                                           WHERE employee_id ='".$_GET['employee_id']."'");
                        $answer["status"] = "Success. User updated.";
                        http_response_code(200);
                    }
                } else {
                    $answer["status"] = "Error. User not found.";
                    http_response_code(404);
                }
            }
        } else {
            $answer["status"] = "Error. Need username and email in JSON BODY.";
            http_response_code(422);
        }
        echo json_encode($answer);
        break;

    case 'DELETE':
        if (empty(isset($_GET['employee_id']))) {
            http_response_code(422);
        } else {
            $query_result = $con->query("SELECT * FROM employee WHERE employee_id='" . $_GET['employee_id'] . "'");
            $result = $query_result->fetch_row();
            if (!empty($result)) {
                $query_result = $con->query("DELETE FROM employee WHERE employee_id='" . $_GET['employee_id'] . "'");
                http_response_code(200);
            } else {
                http_response_code(204);
            }
        }
        break;
    default:
        http_response_code(405);
        break;
}
?>
