<?php
    //Check if user logged and has favourite center if not show random
    if(isset($_GET["center"]) && !empty($_GET["center"])){
        showCenter($_GET["center"]);
    }
    else if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true && isset($_SESSION["favcenter"]) && $_SESSION["favcenter"] != null && $_SESSION["favcenter"] != 'null'){
        showCenter($_SESSION["favcenter"]);
    }else{
        showCenter();
    }

    //If user has a not payed bill show a Notification 
    if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true){
        $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
        $query = "SELECT * FROM TBLBILL 
                    INNER JOIN TBLMEASURES ON FIBILLNUM = BILLNUM 
                    WHERE FIUSERNAME = '".$_SESSION["username"]."'
                    AND PAYED = 'NO'";
        $result = mysqli_query($link,$query) OR die(mysqli_error($link));
        if(mysqli_num_rows($result) > 0){
            echo '
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div class="toast btn-green" data-bs-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <a href="index.php?page=myhistory&history=bills" class="text-black link-offset-2 link-underline link-underline-opacity-0">
                                    You have some unpaid bills.
                                </a>
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                <script>
                    var toastElList = [].slice.call(document.querySelectorAll(\'.toast\'))
                    var toastList = toastElList.map(function(toastEl) {
                    // Creates an array of toasts (it only initializes them)
                        return new bootstrap.Toast(toastEl) // No need for options; use the default options
                    });
                    toastList.forEach(toast => toast.show()); // This show them   
                </script>
            ';
        }
        mysqli_close($link);
    }
?>