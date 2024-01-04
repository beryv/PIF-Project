$(document).ready(function(){
    $(".show-bill").on("click", function(){
        var billNum = $(this).val();
        $.getJSON("backend/admin_bill.backend.php",{num: billNum,show: true},function(data){
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
            }else{
                var payed = "<i class=\"bi bi-x-lg text-danger\"></i> Not Payed";
            }
            document.getElementById("admin-bill-modal").innerHTML = `
            <div class="modal fade" id="showbill" tabindex="-1" aria-labelledby="showbillLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="showbillLabel">Bill Number: `+billNum+`</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <h5>Details</h5>
                                    <table class="table"><tr><td>Date: `+data.bill.date+`</td><td class="text-end">Status: `+payed+`</td></tr></table>
                                <h5>Measures</h5>
                                <table class="table">`+table+`</table>
                                <h6 class="text-center">Total Price: `+total+`€</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                    </div>
                </div>
            </div>`;
        $('#showbill').modal('show');
        });
    });
    $(".edit-bill").on("click", function(){
        var billNum = $(this).val();
        $.getJSON("backend/admin_bill.backend.php",{num: billNum,show: true},function(data){
            if(data == -1){
                return alert("ERROR: No Data Found");
            }
            if(data.bill.payed == "YES"){
                var payed = `<input type="radio" class="btn-check" name="options-payed" id="option1" autocomplete="off" value="NO">
                            <label class="btn" for="option1"><i class=\"bi bi-x-lg text-danger\"></i> No</label>
                            <input type="radio" class="btn-check" name="options-payed" id="option2" autocomplete="off" value="YES" checked>
                            <label class="btn" for="option2"><i class=\"bi bi-check-circle-fill mainColor\"></i> Yes</label>`;
            }else{
                var payed = `<input type="radio" class="btn-check" name="options-payed" id="option1" autocomplete="off" value="NO" checked>
                            <label class="btn" for="option1"><i class=\"bi bi-x-lg text-danger\"></i> No</label>
                            <input type="radio" class="btn-check" name="options-payed" id="option2" autocomplete="off" value="YES">
                            <label class="btn" for="option2"><i class=\"bi bi-check-circle-fill mainColor\"></i> Yes</label>`;
            }

            const dateString = data.bill.date;
            const dateParts = dateString.split('/');
            const dateObject = new Date(`${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`);
            const formattedDate = dateObject.toISOString().split('T')[0];

            document.getElementById("admin-bill-modal").innerHTML = `
            <div class="modal fade" id="editbill" tabindex="-1" aria-labelledby="editbillLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editbillLabel">Editing Bill Number: `+billNum+`</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <label for="modaldate" class="form-label">Date:</label>
                                <input type="date" class="form-control" id="modaldate" value="`+formattedDate+`">
                                <br>
                                Payed: `+payed+`
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-green" onclick="saveEdit(`+billNum+`)">Save</button>
                            </div>
                    </div>
                </div>
            </div>`;
        $('#editbill').modal('show');
        });
    });
    $(".delete-bill").on("click", function(){
        var billNum = $(this).val();
        $.getJSON("backend/admin_bill.backend.php",{num: billNum,delete: true},function(data){
           if(data == -1){
                return alert("ERROR: No Data Found");
            }else{
                location.reload();
            }
        }); 
    });
});

function saveEdit(billNum){
    if (document.getElementById('option1').checked) {
        payed = document.getElementById('option1').value;
    } else if (document.getElementById('option2').checked) {
        payed = document.getElementById('option2').value;
    }
    var date = $("#modaldate").val();
    $.getJSON("backend/admin_bill.backend.php",{num: billNum,edit: true,date: date,payed: payed},function(data){
        if(data == -1){
            return alert("ERROR: No Data Found");
        }else{
            location.reload();
        }
    });
};