$(document).ready(function(){
    $(".show-bill").on("click", function(){
        var billNum = $(this).val();
        //(à faire) Ajouter la requete AJAX (Backend) !
        document.getElementById("myhistory-modal").innerHTML = `
            <div class="modal fade" id="myhistorybill" tabindex="-1" aria-labelledby="myhistorybillLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="myhistorybillLabel">Bill Number: `+billNum+`</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                    </div>
                </div>
            </div>`;
        $('#myhistorybill').modal('show');
    })
})
