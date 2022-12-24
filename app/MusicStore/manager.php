<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
header('Content-Type: application/json');
$con = new mysqli("MYSQL", "root", "", "MusicStore");
$answer = array();
switch ($requestMethod) {
    case 'GET':
        if (empty(isset($_GET['employee_id']))) {
            $result = $con->query("SELECT * FROM manager;");

            while ($row = $result->fetch_assoc()) {
                $answer[] = $row;
            }
        } else {
            $query_result = $con->query("SELECT * FROM manager WHERE employee_id = " . $_GET['employee_id'] . ";");
            $result = $query_result->fetch_assoc();
            $answer = $result;
        }
        if (!empty($result)) {

            http_response_code(200);

        } else {
            $answer["status"] = "Wrong ID !";
            http_response_code(404);
        }
        echo json_encode($answer);
        break;
    case 'POST':
        $json = file_get_contents('php://input');
        $client = json_decode($json);
        if (!empty($client->{'employee_id'}) && !empty($client->{'department_id'})) {
            $employee_id = $client->{'employee_id'};
            $department_id = $client->{'department_id'};

            #$query_result = $con->query("SELECT * FROM clients WHERE client_surname = '" . $client_surname . "'");

            $stmt = $con->prepare("INSERT INTO manager (employee_id, department_id) VALUES (?, ?)");
            $stmt->bind_param('ii', $employee_id, $department_id);
            $stmt->execute();
            $answer["status"] = "Successfully created !";
            http_response_code(201);

        } else {
            $answer["status"] = "Wrong number of param !";

            http_response_code(422);
        }
        echo json_encode($answer);
        break;

    /*
case 'PUT':
    $json = file_get_contents('php://input');
    $obj = json_decode($json);
    if (!empty($obj->{'client_address'}) && !empty($obj->{'client_phone'})){
        if (empty(isset($_GET['client_id']))){
            $answer["status"] = "Error. Need ID Param";
            http_response_code(422);
        } else {
            $query_result = $con->query("SELECT * FROM clients WHERE client_id='".$_GET['client_id']."'");
            $result = $query_result->fetch_row();
            if (!empty($result)){
                $query_result = $con->query("SELECT * FROM clients WHERE client_address='".$obj->{'client_address'}."' AND client_id!='".$_GET['client_id']."'");
                $result = $query_result->fetch_row();
                if (!empty($result)){
                    $answer["status"] = "Error. User with this username already exists.";
                    http_response_code(409);
                } else {
                    $con->query("UPDATE clients SET client_address='".$obj->{'client_address'}."', client_phone='".$obj->{'client_phone'}."' WHERE client_id='".$_GET['client_id']."'");
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
*/

    case 'PATCH':
        $json = file_get_contents('php://input');
        $obj = json_decode($json);

        #break if no id
        if (empty(isset($_GET['employee_id']))){
            $answer["status"] = "Error. Need ID Param";
            http_response_code(422);
        }
        else
        {
            $query_result = $con->query("SELECT * FROM manager WHERE employee_id='".$_GET['employee_id']."'");
            $result = $query_result->fetch_row();

            if (!empty($result)){

                if(!empty($obj->{'class_descr'}))
                    $con->query("UPDATE manager SET department_id='".$obj->{'department_id'}."'
                         WHERE employee_id ='".$_GET['employee_id']."'");

                $answer["status"] = "Success. User updated.";
                http_response_code(200);

            } else {
                $answer["status"] = "Error. User not found.";
                http_response_code(404);
            }
        }

        echo json_encode($answer);
        break;

    case 'DELETE':
        if (empty(isset($_GET['employee_id']))) {
            $answer["status"] = "Empty ID param !";
            http_response_code(422);
        } else {
            $query_result = $con->query("SELECT * FROM manager WHERE employee_id='" . $_GET['employee_id'] . "'");
            $result = $query_result->fetch_row();
            if (!empty($result)) {
                $query_result = $con->query("DELETE FROM manager WHERE employee_id ='" . $_GET['employee_id'] . "'");
                $answer["status"] = "Successfully deleted !";
                http_response_code(200);
            } else {
                $answer["status"] = "Error. Client not found !";
                http_response_code(404);
            }
        }
        echo json_encode($answer);
        break;
    default:
        http_response_code(405);
        break;
}
?>
