<?php
session_unset();
session_destroy();
echo "<script>window.location.href = 'index.php?page=center'</script>";
?>