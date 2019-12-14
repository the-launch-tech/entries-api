<?php

class Logger {

  public static function log($message) {
    $logDir = "logs";

    if (!file_exists($logDir)) {
      mkdir($logDir, 0775, true);
    }

    file_put_contents(
      $logDir . '/log_' . date("j.n.Y") . '.txt',
      $message,
      FILE_APPEND
    );
  }

  public static function space() {
    self::log(PHP_EOL.PHP_EOL);
  }

  public static function entered($post) {
    self::log("Index.php Line: 12 | Time: ".date("y-m-d H:i:s.")." | Entered File! Contents: ".json_encode($post)." ".PHP_EOL);
  }

  public static function errored() {
    self::log("Index.php Line: 54 | Time: ".date("y-m-d H:i:s.")." | errored ".$message.".".PHP_EOL);
  }

  public static function established() {
    self::log("Index.php Line: 30 | Time: ".date("y-m-d H:i:s.")." | Established connection and initialized Entry class!".PHP_EOL);
  }

  public static function validData() {
    self::log("Index.php Line: 39 | Time: ".date("y-m-d H:i:s.")." | We have valid data!".PHP_EOL);
  }

  public static function dataSet() {
    self::log("Index.php Line: 57 | Time: ".date("y-m-d H:i:s.")." | Data is set.".PHP_EOL);
  }

  public static function created() {
    self::log("Index.php Line: 54 | Time: ".date("y-m-d H:i:s.")." | Created In Creation.".PHP_EOL);
  }

  public static function unable() {
    self::log("Index.php Line: 58 | Time: ".date("y-m-d H:i:s.")." | Failed In Creation.".PHP_EOL);
  }

  public static function incomplete() {
    self::log("Index.php Line: 63 | Time: ".date("y-m-d H:i:s.")." | Invalid Data In Creation.".PHP_EOL);
  }

  public static function done() {
    self::log("Index.php Line: 68 | Time: ".date("y-m-d H:i:s.")." | Done.".PHP_EOL);
  }

}
