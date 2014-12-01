<?php
$date = date("d.m.Y");
$file="reporteGeneral-$date.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
e($html);