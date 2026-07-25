<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once "../../config/db.php";
require_once "../auth.php";

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js"></script>

</head>
<body>
    <div class="calendar-container">

        <h2>Lịch hoạt động của tôi</h2>

        <div id="calendar"></div>

    </div>

</body>
</html>