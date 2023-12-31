$(document).ready(function(){
    $(".show-bill").on("click", function(){
        var billNum = $(this).val();
        $.getJSON("backend/myhistory_bill.backend.php",{num: billNum},function(data){
            if(data == -1){
                return alert("ERROR: No Data Found");
            }
            var table = "";
            var total = 0;
            $.each(data.measures, function(index, value){
                table += "<tr><td>"+value.date+"</td><td>"+value.weight+"kg</td><td>"+value.typ+"</td><td>"+value.price+"€</td></tr>";
                total = total+parseFloat(value.price);
            });
            if(data.bill.payed == "YES"){
                var payed = "<i class=\"bi bi-check-circle-fill mainColor\"></i> Payed";
                var paymeth = "";
            }else{
                var payed = "<i class=\"bi bi-x-lg text-danger\"></i> Not Payed";
                var paymeth = `<br><h5>Payment Methode</h5><br>
                <div class="text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                    <i class="bi bi-credit-card-fill"></i> Credit Card
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                    <label class="form-check-label" for="flexRadioDefault2">
                    <i class="bi bi-paypal"></i> PayPal
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                    <label class="form-check-label" for="flexRadioDefault3">
                    <i class="bi bi-apple"></i> Apple Pay
                    </label>
                </div>
                <br>
                <br>
                <button id="payBtn" type="button" class="btn customBtn btn-green" value="`+billNum+`">Pay `+total+`€</button>
                </div>`;
            }
            document.getElementById("myhistory-modal").innerHTML = `
            <div class="modal fade" id="myhistorybill" tabindex="-1" aria-labelledby="myhistorybillLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="myhistorybillLabel">Bill Number: `+billNum+`</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <h5>Details</h5>
                                    <table class="table"><tr><td>Date: `+data.bill.date+`</td><td class="text-end">Status: `+payed+`</td></tr></table>
                                <h5>Measures</h5>
                                <table class="table">`+table+`</table>
                                <h6 class="text-center">Total Price: `+total+`€</h6>
                                `+paymeth+`
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                    </div>
                </div>
            </div>`;
        $('#myhistorybill').modal('show');
        $("#payBtn").on("click", function(){
            var billNum = $(this).val();
            $.getJSON("backend/myhistory_bill.backend.php",{num: billNum,pay: true},function(data){
                if(data == -1){
                    return alert("ERROR: No Data Found");
                }
                if(data == "ok"){
                    location.reload();
                };
            });
        });
        });
    });
});
