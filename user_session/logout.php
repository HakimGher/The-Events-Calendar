<?php

session_start();
session_unset();
session_destroy();

//go back to front page
header("location: ../index.php");