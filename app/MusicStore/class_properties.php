<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
header('Content-Type: application/json');
$con = new mysqli("MYSQL", "root", "", "MusicStore");
$answer = array();
switch ($requestMethod) {
    case 'GET':
        if (empty(isset($_GET['class_id']))) {
            $result = $con->query("SELECT * FROM class_properties;");

            while ($row = $result->fetch_assoc()) {
                $answer[] = $row;
            }
        } else {
            $query_result = $con->query("SELECT * FROM class_properties WHERE class_id = " . $_GET['class_id'] . ";");
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
        if (!empty($client->{'class_id'}) && !empty($client->{'property_id'}) ) {
            $class_id = $client->{'class_id'};
            $property_id = $client->{'property_id'};

            #$query_result = $con->query("SELECT * FROM clients WHERE client_surname = '" . $client_surname . "'");

            $stmt = $con->prepare("INSERT INTO class_properties (class_id, property_id) VALUES (?, ?)");
            $stmt->bind_param('ii', $class_id, $property_id);
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
        if (empty(isset($_GET['class_id']))){
            $answer["status"] = "Error. Need ID Param";
            http_response_code(422);
        }
        else
        {
            $query_result = $con->query("SELECT * FROM class_properties WHERE client_id='".$_GET['client_id']."'");
            $result = $query_result->fetch_row();

            if (!empty($result)){

                if(!empty($obj->{'property_id'}))
                    $con->query("UPDATE class_properties SET property_id='".$obj->{'property_id'}."'
                         WHERE class_id ='".$_GET['class_id']."'");

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
        if (empty(isset($_GET['class_id']))) {
            $answer["status"] = "Empty ID param !";
            http_response_code(422);
        } else {
            $query_result = $con->query("SELECT * FROM class_properties WHERE class_id='" . $_GET['class_id'] . "'");
            $result = $query_result->fetch_row();
            if (!empty($result)) {
                $query_result = $con->query("DELETE FROM class_properties WHERE class_id='" . $_GET['class_id'] . "'");
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
