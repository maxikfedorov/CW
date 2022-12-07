<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
header('Content-Type: application/json');
$con = new mysqli("MYSQL", "root", "", "MusicStore");
$answer = array();
switch ($requestMethod) {
    case 'GET':
        if (empty(isset($_GET['department_id']))) {
            $result = $con->query("SELECT * FROM department;");
            while ($row = $result->fetch_assoc()) {
                $answer[] = $row;
            }
        } else {
            $query_result = $con->query("SELECT * FROM department WHERE department_id = " . $_GET['department_id'] . ";");
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
        if (!empty($client->{'dep_name'}) && !empty($client->{'dep_address'}) ) {
            $dep_name = $client->{'dep_name'};
            $dep_address = $client->{'dep_address'};
            $query_result = $con->query("SELECT * FROM department WHERE dep_name = '" . $dep_name . "'");
            if (!empty($result)) {
                http_response_code(409);
            } else {
                $stmt = $con->prepare("INSERT INTO department (dep_name, dep_address) VALUES (?, ?)");
                $stmt->bind_param('ss', $dep_name, $dep_address);
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

        #break if no id
        if (empty(isset($_GET['department_id']))){
            $answer["status"] = "Error. Need ID Param";
            http_response_code(422);
        }
        else
        {
            $query_result = $con->query("SELECT * FROM department WHERE department_id='".$_GET['department_id']."'");
            $result = $query_result->fetch_row();

            if (!empty($result)){

                if(!empty($obj->{'dep_name'}))
                    $con->query("UPDATE department SET dep_name='".$obj->{'dep_name'}."'
                         WHERE department_id ='".$_GET['department_id']."'");

                if(!empty($obj->{'dep_address'}))
                    $con->query("UPDATE department SET dep_address ='".$obj->{'dep_address'}."'
                         WHERE department_id='".$_GET['department_id']."'");


                $answer["status"] = "Success. User updated.";
                http_response_code(200);

            } else {
                $answer["status"] = "Error. User not found.";
                http_response_code(404);
            }
        }
        echo json_encode($answer);
        break;

    /*
    case 'PUT':
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        if (!empty($obj->{'dep_name'}) && !empty($obj->{'dep_address'})){
            if (empty(isset($_GET['department_id']))){
                $answer["status"] = "Error. Need ID Param";
                http_response_code(422);
            } else {
                $query_result = $con->query("SELECT * FROM department WHERE department_id='".$_GET['department_id']."'");
                $result = $query_result->fetch_row();
                if (!empty($result)){
                    $query_result = $con->query("SELECT * FROM department WHERE dep_name='".$obj->{'dep_name'}."' AND department_id!='".$_GET['department_id']."'");
                    $result = $query_result->fetch_row();
                    if (!empty($result)){
                        $answer["status"] = "Error. User with this username already exists.";
                        http_response_code(409);
                    } else {
                        $con->query("UPDATE department SET dep_name='".$obj->{'dep_name'}."', dep_address='".$obj->{'dep_address'}."' WHERE department_id='".$_GET['department_id']."'");
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
    case 'DELETE':
        if (empty(isset($_GET['department_id']))) {
            http_response_code(422);
        } else {
            $query_result = $con->query("SELECT * FROM department WHERE department_id='" . $_GET['department_id'] . "'");
            $result = $query_result->fetch_row();
            if (!empty($result)) {
                $query_result = $con->query("DELETE FROM department WHERE department_id='" . $_GET['department_id'] . "'");
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
