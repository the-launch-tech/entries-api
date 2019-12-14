<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "Logger.php";
require "Entry.php";

Logger::space();

Logger::entered($_POST);

try {

  $db = new mysqli(
    'localhost',
    '<user>',
    '<pw>',
    '<dbname>'
  );

  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  Logger::established();

  $Entry = new Entry($db);

  if (
    !empty($_POST['to_address']) &&
    !empty($_POST['from_name']) &&
    !empty($_POST['from_address']) &&
    !empty($_POST['html'])
  ) {

    Logger::validData();

    $Entry->to_address = $_POST['to_address'];
    $Entry->from_name = $_POST['from_name'];
    $Entry->from_address = $_POST['from_address'];
    $Entry->replyto_name = array_key_exists('replyto_name', $_POST) ? $_POST['replyto_name'] : '';
    $Entry->replyto_address = array_key_exists('replyto_address', $_POST) ? $_POST['replyto_address'] : '';
    $Entry->cc = array_key_exists('cc', $_POST) ? $_POST['cc'] : '';
    $Entry->bcc = array_key_exists('bcc', $_POST) ? $_POST['bcc'] : '';
    $Entry->subject = array_key_exists('subject', $_POST) ? $_POST['subject'] : '';
    $Entry->html = $_POST['html'];

    Logger::dataSet();

    if ($Entry->create()) {
      Logger::created();
      http_response_code(201);
      echo json_encode(array("message" => "Entry was created.", "Entry" => $Entry));
    } else {
      Logger::unable();
      http_response_code(503);
      echo json_encode(array("message" => "Unable to create Entry.", "Entry" => $Entry));
    }
  } else {
    Logger::incomplete();
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Entry. Data is incomplete.", "Entry" => $Entry));
  }

  $db->close();

  Logger::done();

} catch (Exception $e) {
  Logger::errored('Error running process. Message: ' . $e->getMessage());
  http_response_code(500);
  echo json_encode(array("message" => "Unable To Enter Script.", "Post" => $_POST));
}


?>
