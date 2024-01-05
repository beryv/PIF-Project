$(document).ready(function(){
    $(".add-center").on("click", function(){
        document.getElementById("admin-center-modal").innerHTML = `
            <div class="modal fade" id="addcenter" tabindex="-1" aria-labelledby="addcenterLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addcenterLabel">New Center</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <label for="modalcode" class="form-label">Center Code:</label>
                                <input type="text" class="form-control mb-3" id="modalcode" maxlength="5" onkeyup="this.value = this.value.toUpperCase();">
                                <label for="modaladdress" class="form-label">Address:</label>
                                <input type="text" class="form-control mb-3" id="modaladdress" maxlength="200">
                                <label for="modalpost" class="form-label">Post Code:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">L-</span>
                                    <input type="text" class="form-control" id="modalpost" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4);">
                                </div>
                                <label for="modalcity" class="form-label">City:</label>
                                <input type="text" class="form-control" id="modalcity" maxlength="100">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-green" onclick="addNew()">Add</button>
                            </div>
                    </div>
                </div>
            </div>`;
        $('#addcenter').modal('show');
    });
    $("#tbl_center tbody").on("click",".edit-center", function(){
        var code = $(this).val();
        $.getJSON("backend/admin_center.backend.php",{code: code,get: true},function(data){
            if(data == -1){
                return alert("ERROR: No Data Found");
            }
            document.getElementById("admin-center-modal").innerHTML = `
                <div class="modal fade" id="editcenter" tabindex="-1" aria-labelledby="editcenterLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editcenterLabel">Edit Center: `+code+`</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <label for="modalcode" class="form-label">Center Code:</label>
                                    <input type="text" class="form-control mb-3" id="modalcode" value="`+code+`" maxlength="5" onkeyup="this.value = this.value.toUpperCase();">
                                    <label for="modaladdress" class="form-label">Address:</label>
                                    <input type="text" class="form-control mb-3" id="modaladdress" value="`+data.adress+`" maxlength="200">
                                    <label for="modalpost" class="form-label">Post Code:</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">L-</span>
                                        <input type="text" class="form-control" id="modalpost" value="`+data.post+`" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4);">
                                    </div>
                                    <label for="modalcity" class="form-label">City:</label>
                                    <input type="text" class="form-control" id="modalcity" value="`+data.city+`" maxlength="100">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-green" onclick="saveEdit('`+code+`')">Save</button>
                                </div>
                        </div>
                    </div>
                </div>`;
            $('#editcenter').modal('show');
        });
    });
    $("#tbl_center tbody").on("click",".delete-center", function(){
        var code = $(this).val();
        $.getJSON("backend/admin_center.backend.php",{code: code,delete: true},function(data){
           if(data == -1){
                return alert("ERROR: No Data Found");
            }else{
                location.reload();
            }
        }); 
    });
});

function addNew(){
    var code = $("#modalcode").val();
    var adress = $("#modaladdress").val();
    var post = $("#modalpost").val();
    var city = $("#modalcity").val();
    $.getJSON("backend/admin_center.backend.php",{code: code,new: true,adress: adress,post: post,city: city},function(data){
        if(data == -1){
            return alert("ERROR");
        }else{
            location.reload();
        }
    });
}

function saveEdit(code){
    var newcode = $("#modalcode").val();
    var adress = $("#modaladdress").val();
    var post = $("#modalpost").val();
    var city = $("#modalcity").val();
    $.getJSON("backend/admin_center.backend.php",{code: code,save: true,newcode: newcode,adress: adress,post: post,city: city},function(data){
        if(data == -1){
            return alert("ERROR");
        }else{
            location.reload();
        }
    });
}