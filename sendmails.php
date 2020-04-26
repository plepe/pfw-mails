<?php
require 'conf.php';

$template = file_get_contents($template_file);

$csvfile = fopen($data_file, 'r');
$fields = fgetcsv($csvfile);

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

  $body = strtr($template, $tr);
}

