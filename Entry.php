<?php
class Entry {

  private $db;
  private $table_name = "entries";

  public $to_address;
  public $from_name;
  public $from_address;
  public $replyto_name;
  public $replyto_address;
  public $cc;
  public $bcc;
  public $subject;
  public $html;

  public function __construct($db){
    $this->db = $db;
  }

  function create() {
    $status = false;

    $query = "
      INSERT INTO " . $this->table_name . " (
        to_address,
        from_name,
        from_address,
        replyto_name,
        replyto_address,
        cc,
        bcc,
        subject,
        html
      )
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt = $this->db->prepare($query);

    $this->to_address = strip_tags($this->to_address);
    $this->from_name = strip_tags($this->from_name);
    $this->from_address = strip_tags($this->from_address);
    $this->replyto_name = strip_tags($this->replyto_name);
    $this->replyto_address = strip_tags($this->replyto_address);
    $this->cc = strip_tags($this->cc);
    $this->bcc = strip_tags($this->bcc);
    $this->subject = strip_tags($this->subject);
    $this->html = strip_tags($this->html, '<div><span><strong><b><i><p><a><br><li><ul><small>');

    $stmt->bind_param("sssssssss",
      $this->to_address,
      $this->from_name,
      $this->from_address,
      $this->replyto_name,
      $this->replyto_address,
      $this->cc,
      $this->bcc,
      $this->subject,
      $this->html,
    );

    if ($stmt->execute()) {
      $status = true;
    }

    $stmt->close();

    return $status;
  }

}
