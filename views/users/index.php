<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--  <link rel="stylesheet" href="../css/styles.css">-->
  <title>user index</title>
</head>
<body>
<h1>user index</h1>
<ul id="user-list"></ul>
<?php
if (!empty($data)) {
  print_r($data['users']);
}
?>
<!--<script src="script.js"></script>-->
</body>
</html>