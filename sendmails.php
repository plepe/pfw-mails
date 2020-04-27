<?php
require 'conf.php';
require 'vendor/autoload.php';

$template = file_get_contents($template_file);

$csvfile = fopen($data_file, 'r');
$fields = fgetcsv($csvfile);

$sendgrid = new \SendGrid($SENDGRID_API_KEY);

while ($row = fgetcsv($csvfile)) {
  $entry = array();
  $tr = array();
  foreach ($fields as $i => $k) {
    $entry[$k] = $row[$i];
    $tr["[{$k}]"] = $row[$i];
  }

  if ($entry['last_accessed']) {
    continue; // skip
  }

  $email = new \SendGrid\Mail\Mail();

  $email->setFrom($from_email, $from_name);
  $email->setSubject(strtr($subject_template, $tr));
  $email->addTo(
    strtr($to_email_template, $tr),
    strtr($to_name_template, $tr)
  );

  $email->addContent("text/plain", strtr($template, $tr));

  try {
    $response = $sendgrid->send($email);
    print "{$entry['private_id']}:" . $response->statusCode() . "\n";
  } catch (Exception $e) {
    print "{$entry['private_id']}: Caught exception: " . $e->getMessage() . "\n";
  }
}

