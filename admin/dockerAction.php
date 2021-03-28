<?php
$a = 'yo.txt';

if(strpos(file_get_contents($a),'test1')!==false) echo 'found';
?>