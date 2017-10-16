<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get All Customers
$app->get('/api/customers', function (Request $request, Response $response){
    $sql = "SELECT * FROM customers";
    try {
        // Get DB Objects
        $db = new db();
        // Connect
        $db = $db->connect();
        // Execute Query
        $stmt = $db->query($sql);
        // Fetch Result
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        // Dissconnect DB
        $db = null;
        // Encode Result to JSON
        echo json_encode($customers);
    } catch(PDOEception $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single Customer
$app->get('/api/customers/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id = $id";
    try {
        // Get DB Objects
        $db = new db();
        // Connect
        $db = $db->connect();
        // Execute Query
        $stmt = $db->query($sql);
        // Fetch Result
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        // Dissconnect DB
        $db = null;
        // Encode Result to JSON
        echo json_encode($customer);
    } catch(PDOEception $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';

    }
});

// Add Customer
$app->post('/api/customers/add', function (Request $request, Response $response){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    $sql = "INSERT INTO customers (first_name, last_name, phone, email, address, city, state) VALUES
    (:first_name, :last_name, :phone, :email, :address, :city, :state)";
    try {
        // Get DB Objects
        $db = new db();
        // Connect
        $db = $db->connect();
        // Execute Query
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->execute();
        echo '{"notice": {"text": "Customer Added"}';
    } catch(PDOEception $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update Customer
$app->put('/api/customers/update/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    $sql = "UPDATE customers SET
     first_name = :first_name,
     last_name = :last_nam,
     phone = :phone,
     email = :email,
     address = :address,
     city = :city, 
     state = :state
     WHERE id = $id";
    try {
        // Get DB Objects
        $db = new db();
        // Connect
        $db = $db->connect();
        // Execute Query
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();
        echo '{"notice": {"text": "Customer Updated"}';
    } catch(PDOEception $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete Customer
$app->get('/api/customers/delete/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM customers WHERE id = $id";
    try {
        // Get DB Objects
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        // Execute Query
        $stmt->execute();
        // Dissconnect DB
        $db = null;
        echo '{"notice": {"text": "Customer Deleted"}';
    } catch(PDOEception $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';

    }
});