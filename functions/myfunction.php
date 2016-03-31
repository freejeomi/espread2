<?php

$_NAIRA= "&#8358;";
$_DOLLAR= "&#36;";
$_POUNDS= "&#163;";
$_EUROS= "&#8364;";

function refined_number($raw_num)
{
    return number_format($raw_num, 2, '.', ',');
}

function quantity_number($qty_num)
{
    return number_format($qty_num, 0, '.', ',');
}
?>