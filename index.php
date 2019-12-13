<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "./Entry.php";

if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
  $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
  if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {

    $db = new mysqli(
      '127.0.0.1',
      '<username>',
      '<password>',
      '<dbname>'
    );

    if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
    }

    $Entry = new Entry($db);

    $data = json_decode(file_get_contents("php://input"));

    if (
      !empty($data->to_address) &&
      !empty($data->from_name) &&
      !empty($data->from_address) &&
      !empty($data->html)
    ) {

      $Entry->to_address = property_exists($data, 'to_address') ? $data->to_address : '';
      $Entry->from_name = property_exists($data, 'from_name') ? $data->from_name : '';
      $Entry->from_address = property_exists($data, 'from_address') ? $data->from_address : '';
      $Entry->replyto_name = property_exists($data, 'replyto_name') ? $data->replyto_name : '';
      $Entry->replyto_address = property_exists($data, 'replyto_address') ? $data->replyto_address : '';
      $Entry->cc = property_exists($data, 'cc') ? $data->cc : '';
      $Entry->bcc = property_exists($data, 'bcc') ? $data->bcc : '';
      $Entry->subject = property_exists($data, 'subject') ? $data->subject : '';
      $Entry->html = property_exists($data, 'html') ? $data->html : '';

      if ($Entry->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Entry was created."));
      } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create Entry."));
      }
    } else {
      http_response_code(400);
      echo json_encode(array("message" => "Unable to create Entry. Data is incomplete."));
    }

    $db->close();
  }
} catch (Exception $e) {
  echo json_encode(array('error' => $e->getMessage()));
}

?>
