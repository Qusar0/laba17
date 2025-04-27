<?php
require_once 'db.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'all':
        $result = pg_query($conn, "SELECT c.id AS country_id, c.name AS country_name, ci.name AS city_name
                                   FROM countries c
                                   LEFT JOIN cities ci ON c.id = ci.country_id");
        $countries = [];
        while ($row = pg_fetch_assoc($result)) {
            $countries[$row['country_id']]['name'] = $row['country_name'];
            $countries[$row['country_id']]['cities'][] = $row['city_name'];
        }
        echo json_encode($countries);
        break;
    case 'get':
        $id = $_GET['id'] ?? 0;
        $result = pg_query_params($conn, "SELECT c.name AS country_name, ci.name AS city_name
                                          FROM countries c
                                          LEFT JOIN cities ci ON c.id = ci.country_id
                                          WHERE c.id = $1", array($id));
        $country = [];
        while ($row = pg_fetch_assoc($result)) {
            $country['name'] = $row['country_name'];
            $country['cities'][] = $row['city_name'];
        }
        echo json_encode($country);
        break;
    case 'del':
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $result = pg_query_params($conn, "DELETE FROM countries WHERE id = $1", array($id));
            if ($result) {
                echo json_encode(["message" => "Country deleted successfully"]);
            } else {
                echo json_encode(["message" => "Error deleting country"]);
            }
        }
        break;
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? 0;
            $country_name = $_POST['country_name'] ?? '';
            if ($id && $country_name) {
                $result = pg_query_params($conn, "UPDATE countries SET name = $1 WHERE id = $2", array($country_name, $id));
                if ($result) {
                    echo json_encode(["message" => "Country updated successfully"]);
                } else {
                    echo json_encode(["message" => "Error updating country"]);
                }
            }
        }
        break;
    case 'cities':
        $country_name = $_GET['country'] ?? '';
        $result = pg_query_params($conn, "SELECT ci.name AS city_name
                                          FROM cities ci
                                          JOIN countries c ON ci.country_id = c.id
                                          WHERE c.name = $1", array($country_name));
        $cities = [];
        while ($row = pg_fetch_assoc($result)) {
            $cities[] = $row['city_name'];
        }
        echo json_encode($cities);
        break;
    default:
        echo json_encode(["message" => "Invalid action"]);
        break;
}

pg_close($conn);
?>
