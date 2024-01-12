$(document).ready(function(){
    $(".add-trash").on("click", function(){
        document.getElementById("admin-trash-modal").innerHTML = `
            <div class="modal fade" id="addtrash" tabindex="-1" aria-labelledby="addtrashLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addtrashLabel">New Trash Type</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <label for="modalcode" class="form-label">Trash Code:</label>
                                <input type="text" class="form-control mb-3" id="modalcode" maxlength="3" onkeyup="this.value = this.value.toUpperCase();">
                                <label for="modaldesc" class="form-label">Description:</label>
                                <textarea class="form-control mb-3" id="modaldesc" rows="3" maxlength="1000"></textarea>
                                <label for="modalprice" class="form-label">Price per kg:</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="modalprice">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-green" onclick="addNew()">Add</button>
                            </div>
                    </div>
                </div>
            </div>`;
        $('#addtrash').modal('show');
    });
    $("#tbl_trash tbody").on("click",".edit-trash", function(){
        var code = $(this).val();
        $.getJSON("backend/admin_trash.backend.php",{code: code,get: true},function(data){
            if(data == -1){
                return alert("ERROR: No Data Found");
            }
            document.getElementById("admin-trash-modal").innerHTML = `
                <div class="modal fade" id="edittrash" tabindex="-1" aria-labelledby="edittrashLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="edittrashLabel">Edit Trash Type: `+code+`</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <label for="modalcode" class="form-label">Trash Code:</label>
                                    <input type="text" class="form-control mb-3" id="modalcode" value=`+code+` maxlength="3" onkeyup="this.value = this.value.toUpperCase();">
                                    <label for="modaldesc" class="form-label">Description:</label>
                                    <textarea class="form-control mb-3" id="modaldesc" rows="3" maxlength="1000">`+data.desc+`</textarea>
                                    <label for="modalprice" class="form-label">Price per kg:</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" value=`+data.price+` id="modalprice">
                                        <span class="input-group-text">€</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-green" onclick="saveEdit('`+code+`')">Save</button>
                                </div>
                        </div>
                    </div>
                </div>`;
            $('#edittrash').modal('show');
        });
    });
    $("#tbl_trash tbody").on("click",".delete-trash", function(){
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
                var code = $(this).val();
                $.getJSON("backend/admin_trash.backend.php",{code: code,delete: true},function(data){
                if(data == -1){
                        return alert("ERROR: No Data Found");
                    }else{
                        Swal.fire({
                            position: "top",
                            title: "Deleted!",
                            text: "Trash Type has been deleted.",
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

function addNew(){
    var code = $("#modalcode").val();
    var desc = $("#modaldesc").val();
    var price = $("#modalprice").val();
    $.getJSON("backend/admin_trash.backend.php",{code: code,new: true,desc: desc,price: price},function(data){
        if(data == -1){
            return alert("ERROR");
        }else{
            Swal.fire({
                position: "top",
                title: "Added!",
                text: "Trash Type has been added.",
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

function saveEdit(code){
    var newcode = $("#modalcode").val();
    var desc = $("#modaldesc").val();
    var price = $("#modalprice").val();
    $.getJSON("backend/admin_trash.backend.php",{code: code,save: true,newcode: newcode,desc: desc,price: price},function(data){
        if(data == -1){
            return alert("ERROR");
        }else{
            Swal.fire({
                position: "top",
                title: "Saved!",
                text: "Changes has been saved.",
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