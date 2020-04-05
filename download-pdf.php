<?php
$filename = 'AQUAHOUND-BASIC-INSTALL-MANUAL.PDF';
$filepath = 'resources/'.$filename;
header('Content-Type: application/pdf');
header('Content-Disposition: attachment;filename='.$filename);
readfile($filepath);
?>
