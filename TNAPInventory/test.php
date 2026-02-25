<?php
$file = fopen("contacts.csv","r");
print_r(fgetcsv($file));
fclose($file);
?>