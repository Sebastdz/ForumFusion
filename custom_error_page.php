<?php
// Retrieve the requested URL from the query string
$requested_url = isset($_GET['url']) ? $_GET['url'] : '';

// Display the custom "not found" message
echo "<div class='notfound'>";
echo "<p> <i class='fa-solid fa-link-slash'></i> </p>";
echo "<p> Invalid URL </p>";
echo "<p class='notfounddesc'>Unfortunately, the link '{$requested_url}' you are trying to access does not exist.</p>";
echo "</div>";
?>
