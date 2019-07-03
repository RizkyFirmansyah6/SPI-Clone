<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename="'.$nama_file.'.csv"');

echo $content;