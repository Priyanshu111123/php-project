<?php
session_start();
require 'vendor/autoload.php'; 

// MongoDB connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->voter_database; 
$collection = $db->voter_services; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $service = htmlspecialchars($_POST['service']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $contact = htmlspecialchars($_POST['contact']);
    $dob = htmlspecialchars($_POST['dob']);
    $address = htmlspecialchars($_POST['address']);
    $complaint = htmlspecialchars($_POST['complaint']);

    $data = [
        'service' => $service,
        'name' => $name,
        'email' => $email,
        'contact' => $contact,
        'dob' => $dob,
        'address' => $address,
        'complaint' => $complaint,
        'timestamp' => new MongoDB\BSON\UTCDateTime()
    ];

    try {
        $insertOneResult = $collection->insertOne($data);
        echo "Data successfully submitted with ID: " . $insertOneResult->getInsertedId();
    } catch (Exception $e) {
        echo "Error storing data: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['candidate'])) {
    $candidate = htmlspecialchars($_POST['candidate']);
    
    $voteData = [
        'user_id' => $_SESSION['user_id'], 
        'candidate' => $candidate,
        'timestamp' => new MongoDB\BSON\UTCDateTime()
    ];
    
    try {
        $voteCollection = $db->votes; 
        $insertVoteResult = $voteCollection->insertOne($voteData);
        echo "Vote successfully submitted for candidate: " . $candidate;
    } catch (Exception $e) {
        echo "Error submitting vote: " . $e->getMessage();
    }
}
?>
