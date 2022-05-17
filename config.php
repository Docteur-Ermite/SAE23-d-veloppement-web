<?php

/**
 * Configuration for database connection
 *
 */

$host       = "83.198.227.125";
$username   = "server";
$password   = "azerty";
$dbname     = "SAE23";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );