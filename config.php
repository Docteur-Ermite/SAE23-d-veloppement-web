<?php

/**
 * Configuration for database connection
 *
 */

$host       = "192.168.50.89";
$username   = "server";
$password   = "azerty";
$dbname     = "SAE23";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );