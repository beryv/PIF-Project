$(document).ready(function(){
    $("#tbl_measures tbody").on("click",".edit-measure", function(){
        var id = $(this).val();
        $.getJSON("backend/admin_measure.backend.php",{id: id,get: true},function(data){
            if(data == -1){
                return alert("ERROR: No Data Found");
            }
            $.getJSON("backend/admin_measure.backend.php",{id: id,getSel: true},function(sel){
                if(data == -1){
                    return alert("ERROR: No Data Found");
                }
                trashSelect = '<select class="form-select mb-3" id="modaltrash">';
                $.each(sel.trashtype, function(index, value){
                    if(value == data.trash){
                        trashSelect = trashSelect+'<option value="'+value+'" selected>'+value+'</option>';
                    }else{
                        trashSelect = trashSelect+'<option value="'+value+'">'+value+'</option>';
                    }
                });
                trashSelect = trashSelect+'</select>';

                stationSelect = '<select class="form-select mb-3" id="modalstation">';
                $.each(sel.station, function(index, value){
                    if(value == data.station){
                        stationSelect = stationSelect+'<option value="'+value+'" selected>'+value+'</option>';
                    }else{
                        stationSelect = stationSelect+'<option value="'+value+'">'+value+'</option>';
                    }
                });
                stationSelect = stationSelect+'</select>';

                billSelect = '<select class="form-select" id="modalbill">';
                if(data.bill == null){
                    billSelect = billSelect+'<option value=null selected>None</option>';
                }else{
                    billSelect = billSelect+'<option value=null>None</option>';
                }
                $.each(sel.bill, function(index, value){
                    if(value == data.bill){
                        billSelect = billSelect+'<option value="'+value+'" selected>'+value+'</option>';
                    }else{
                        billSelect = billSelect+'<option value="'+value+'">'+value+'</option>';
                    }
                });
                billSelect = billSelect+'</select>';

                document.getElementById("admin-measure-modal").innerHTML = `
                <div class="modal fade" id="editmeasure" tabindex="-1" aria-labelledby="editmeasureLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editmeasureLabel">Edit Measure Id: `+id+`</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <label for="modaldate" class="form-label">Date:</label>
                                    <input type="date" class="form-control mb-3" id="modaldate" value="`+data.date+`">
                                    <label for="modalprice" class="form-label">Price:</label>
                                    <input type="number" class="form-control mb-3" id="modalprice" value="`+data.price+`">
                                    <label for="modalweight" class="form-label">Weight:</label>
                                    <input type="number" class="form-control mb-3" id="modalweight" value="`+data.weight+`">
                                    <label for="modaltrash" class="form-label">Trash Type:</label>
                                    `+trashSelect+`
                                    <label for="modalstation" class="form-label">Station:</label>
                                    `+stationSelect+`
                                    <label for="modaluser" class="form-label">User:</label>
                                    <input type="text" class="form-control mb-3" id="modaluser" value="`+data.user+`">
                                    <label for="modalbill" class="form-label">Bill:</label>
                                    `+billSelect+`
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-green" onclick="saveEdit(`+id+`)">Save</button>
                                </div>
                        </div>
                    </div>
                </div>`;
            $('#editmeasure').modal('show');
            });
        });
    });
    $("#tbl_measures tbody").on("click",".delete-measure", function(){
        Swal.fire({
            position: "top",
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#94dd26",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).val();
                $.getJSON("backend/admin_measure.backend.php",{id: id,delete: true},function(data){
                if(data == -1){
                        return alert("ERROR: No Data Found");
                    }else{
                        Swal.fire({
                            position: "top",
                            title: "Deleted!",
                            text: "Measure has been deleted.",
                            icon: "success",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }
                });
            }
        });
    });
});

function saveEdit(id){
    var date = $("#modaldate").val();
    var price = $("#modalprice").val();
    var weight = $("#modalweight").val();
    var trash = $("#modaltrash").val();
    var station = $("#modalstation").val();
    var user = $("#modaluser").val();
    var bill = $("#modalbill").val();
    $.getJSON("backend/admin_measure.backend.php",{id: id,save: true,date: date,price: price,weight: weight,trash: trash,station: station,user: user,bill: bill},function(data){
        if(data == -1){
            return alert("ERROR: No Data Found");
        }else{
            location.reload();
        }
    });
}