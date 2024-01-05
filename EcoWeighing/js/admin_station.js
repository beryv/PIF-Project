$(document).ready(function(){
    $(".add-station").on("click", function(){
        $.getJSON("backend/admin_station.backend.php",{num: 0,getCenter: true},function(data){
            if(data == -1){
                return alert("ERROR: No Data Found");
            }
            centerSelect = '<select class="form-select" id="modalcenter">';
            $.each(data, function(index, value){
                centerSelect = centerSelect+'<option value="'+value+'">'+value+'</option>';
            });
            centerSelect = centerSelect+'</select>';

            document.getElementById("admin-station-modal").innerHTML = `
            <div class="modal fade" id="addstation" tabindex="-1" aria-labelledby="addstationLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addstationLabel">New Station</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <label for="modaldesc" class="form-label">Description:</label>
                                <textarea class="form-control" id="modaldesc" rows="3" maxlength="1000"></textarea>
                                <label for="modalcenter" class="form-label">Center:</label>
                                `+centerSelect+`
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-green" onclick="addNew()">Add</button>
                            </div>
                    </div>
                </div>
            </div>`;
        $('#addstation').modal('show');
        });
    });
    $("#tbl_station tbody").on("click",".edit-station", function(){
        var num = $(this).val();
        $.getJSON("backend/admin_station.backend.php",{num: num,get: true},function(data){
            if(data == -1){
                return alert("ERROR: No Data Found");
            }
            $.getJSON("backend/admin_station.backend.php",{num: 0,getCenter: true},function(selCenter){
                centerSelect = '<select class="form-select" id="modalcenter">';
                $.each(selCenter, function(index, value){
                    if(value == data.center){
                        centerSelect = centerSelect+'<option value="'+value+'" selected>'+value+'</option>';
                    }else{
                        centerSelect = centerSelect+'<option value="'+value+'">'+value+'</option>';
                    }
                });
                centerSelect = centerSelect+'</select>';
    
                document.getElementById("admin-station-modal").innerHTML = `
                    <div class="modal fade" id="editstation" tabindex="-1" aria-labelledby="editstationLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editstationLabel">Edit Station: `+num+`</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body">
                                        <label for="modaldesc" class="form-label">Description:</label>
                                        <textarea class="form-control" id="modaldesc" rows="3" maxlength="1000">`+data.desc+`</textarea>
                                        <label for="modalcenter" class="form-label">Center:</label>
                                        `+centerSelect+`
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-green" onclick="saveEdit(`+num+`)">Add</button>
                                    </div>
                            </div>
                        </div>
                    </div>`;
                $('#editstation').modal('show');
            });
        });
    });
    $("#tbl_station tbody").on("click",".delete-station", function(){
        var num = $(this).val();
        $.getJSON("backend/admin_station.backend.php",{num: num,delete: true},function(data){
           if(data == -1){
                return alert("ERROR: No Data Found");
            }else{
                location.reload();
            }
        }); 
    });
});

function addNew(){
    var desc = $("#modaldesc").val();
    var center = $("#modalcenter").val();
    $.getJSON("backend/admin_station.backend.php",{num: 0,new: true,desc: desc,center: center},function(data){
        if(data == -1){
            return alert("ERROR");
        }else{
            location.reload();
        }
    });
}

function saveEdit(num){
    var desc = $("#modaldesc").val();
    var center = $("#modalcenter").val();
    $.getJSON("backend/admin_station.backend.php",{num: num,save: true,desc: desc,center: center},function(data){
        if(data == -1){
            return alert("ERROR");
        }else{
            location.reload();
        }
    });
}