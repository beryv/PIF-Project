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
                $.getJSON("backend/admin_center.backend.php",{code: code,delete: true},function(data){
                if(data == -1){
                        return alert("ERROR: No Data Found");
                    }else{
                        Swal.fire({
                            position: "top",
                            title: "Deleted!",
                            text: "Center has been deleted.",
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
    $("#tbl_center tbody").on("click",".schedules-center", function(){
        var code = $(this).val();
        showtbl(code);
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

function showtbl(code){
        var days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
        var promises = [];
        var dayData = {};

        $.each(days, function (index, day) {
            var promise = $.getJSON("backend/admin_center.backend.php", { code: code, getSchedules: true, day: day }, function (data) {
                dayData[day] = data;
            });
            promises.push(promise);
        });

        $.when.apply($, promises).done(function () {
            var schedulesTbl = `<table class="table">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
            var id = 0;
            $.each(days, function(index, day){
                if(dayData[day] == -1){
                    schedulesTbl = schedulesTbl+"<tr><td>"+day+"</td><td class=\"bg-danger text-white text-center\" colspan=\"3\">Closed</td></tr>";
                }else{
                    $.each(dayData[day], function(index, time){
                        schedulesTbl = schedulesTbl+"<tr>";
                        schedulesTbl = schedulesTbl+"<td id=\"day"+id+"\">"+day+"</td><td id=\"start"+id+"\">"+time.start.substr(0,5)+"</td><td id=\"end"+id+"\">"+time.end.substr(0,5)+"</td><td><button type=\"button\" onclick=\"deltime("+id+",'"+code+"')\" class=\"btn btn-danger\"><i class=\"bi bi-trash-fill\"></i></button></td>";
                        schedulesTbl = schedulesTbl+"</tr>";
                    });
                }
                id++;
            });
            
            schedulesTbl = schedulesTbl+"</tbody></table>";
            document.getElementById("admin-center-modal").innerHTML = `
                    <div class="modal fade" id="timecenter" tabindex="-1" aria-labelledby="timecenterLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="timecenterLabel">Schedules Center: `+code+`</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <select class="form-select" id="selDay">
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                            </select>
                                            <input type="time" class="form-control" id="startTime">
                                            <input type="time" class="form-control" id="endTime">
                                            <button type="button" class="btn btn-green" onclick="newtime('`+code+`')"><i class=\"bi bi-plus-lg\"></i></button>
                                        </div>
                                        `+schedulesTbl+`
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                            </div>
                        </div>
                    </div>`;
            $('#timecenter').modal('show');
        });
}

function deltime(id,code){
    var day = $("#day"+id).text();
    var start = $("#start"+id).text();
    var end = $("#end"+id).text();
    $.getJSON("backend/admin_center.backend.php", { code: code, delSchedules: true, day: day,start: start,end: end}, function (data) {
        if(data == -1){
            return alert("ERROR");
        }
    });

    $('#timecenter').modal('hide');
    $('#timecenter').on('hidden.bs.modal', function () {
        showtbl(code);
    });
}

function newtime(code){
    var day = $("#selDay").val();
    var start = $("#startTime").val();
    var end = $("#endTime").val();
    $.getJSON("backend/admin_center.backend.php", { code: code, newSchedules: true, day: day,start: start,end: end}, function (data) {
        if(data == -1){
            return alert("ERROR");
        }
    });

    $('#timecenter').modal('hide');
    $('#timecenter').on('hidden.bs.modal', function () {
        showtbl(code);
    });
}