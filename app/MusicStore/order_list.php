<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
header('Content-Type: application/json');
$con = new mysqli("MYSQL", "root", "", "MusicStore");
$answer = array();
switch ($requestMethod) {
    case 'GET':
        if (empty(isset($_GET['order_id']))) {
            $result = $con->query("SELECT * FROM order_list;");

            while ($row = $result->fetch_assoc()) {
                $answer[] = $row;
            }
        } else {
            $query_result = $con->query("SELECT * FROM order_list WHERE order_id = " . $_GET['order_id'] . ";");
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
        if (!empty($client->{'item_id_ord'}) &&
            !empty($client->{'quantity'}) &&
            !empty($client->{'price'})) {

            $item_id_ord = $client->{'item_id_ord'};
            $quantity = $client->{'quantity'};
            $price = $client->{'price'};
            #$query_result = $con->query("SELECT * FROM order_list WHERE client_surname = '" . $client_surname . "'");

            $stmt = $con->prepare("INSERT INTO order_list (item_id_ord, quantity, price) VALUES (?, ?, ?)");

            $stmt->bind_param('iii', $item_id_ord, $quantity, $price);

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
        if (empty(isset($_GET['order_id']))){
            $answer["status"] = "Error. Need ID Param";
            http_response_code(422);
        } else {
            $query_result = $con->query("SELECT * FROM order_list WHERE order_id='".$_GET['order_id']."'");
            $result = $query_result->fetch_row();
            if (!empty($result)){
                $query_result = $con->query("SELECT * FROM order_list WHERE client_address='".$obj->{'client_address'}."' AND order_id!='".$_GET['order_id']."'");
                $result = $query_result->fetch_row();
                if (!empty($result)){
                    $answer["status"] = "Error. User with this username already exists.";
                    http_response_code(409);
                } else {
                    $con->query("UPDATE order_list SET client_address='".$obj->{'client_address'}."', client_phone='".$obj->{'client_phone'}."' WHERE order_id='".$_GET['order_id']."'");
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
        if (empty(isset($_GET['order_id']))){
            $answer["status"] = "Error. Need ID Param";
            http_response_code(422);
        }
        else
        {
            $query_result = $con->query("SELECT * FROM order_list WHERE order_id='".$_GET['order_id']."'");
            $result = $query_result->fetch_row();

            if (!empty($result)){

                if(!empty($obj->{'item_id_ord'}))
                    $con->query("UPDATE order_list SET item_id_ord='".$obj->{'item_id_ord'}."'
                         WHERE order_id ='".$_GET['order_id']."'");

                if(!empty($obj->{'quantity'}))
                    $con->query("UPDATE order_list SET quantity ='".$obj->{'quantity'}."'
                         WHERE order_id='".$_GET['order_id']."'");

                if(!empty($obj->{'price'}))
                    $con->query("UPDATE order_list SET price='".$obj->{'price'}."'
                         WHERE order_id='".$_GET['order_id']."'");

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
        if (empty(isset($_GET['order_id']))) {
            $answer["status"] = "Empty ID param !";
            http_response_code(422);
        } else {
            $query_result = $con->query("SELECT * FROM order_list WHERE order_id='" . $_GET['order_id'] . "'");
            $result = $query_result->fetch_row();
            if (!empty($result)) {
                $query_result = $con->query("DELETE FROM order_list WHERE order_id='" . $_GET['order_id'] . "'");
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
