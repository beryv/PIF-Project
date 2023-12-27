<?php
setcookie(session_name(),session_id(),time()-3600); //delete cookie
session_unset();
session_destroy();
session_set_cookie_params(0); //reset cookie session timeout on server side
echo "<script>window.location.href = 'index.php?page=center'</script>";
?>