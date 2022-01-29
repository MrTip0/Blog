<?php
if (isset($_COOKIE["jwt"])) {
    setcookie("jwt", null, -1, "/");
}
?>