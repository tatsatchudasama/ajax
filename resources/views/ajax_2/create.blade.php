<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crate Ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>


    <div class="p-5">

        <!-- ==================== Create a data ==================== -->
        
        <form id="form_add" action="javascript:void(0);">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="mb-3">
                <label for="" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="">
                <div id="nameError" class="form-text text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Email address</label>
                <input type="text" name="email" class="form-control" id="" aria-describedby="emailHelp">
                <div id="emailError" class="form-text text-danger"></div>
            </div>

            <button type="submit" class="btn btn-primary" id="btnSubmit">Submit</button>

        </form>
        <br>
        <hr>

        <!-- ==================== View data ==================== -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="table_data">
                
            </tbody>
        </table>

        <!-- ==================== Edit data ==================== -->
        <!-- Modal for Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing data -->
                    <form id="editForm">

                        <input type="hidden" id="editId">

                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName">
                        </div>

                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- sweet alert cdn -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function(){

            // ==================== Create Data ====================
            $('#form_add').submit(function(event) {
               
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                event.preventDefault();

                var form = $('#form_add')[0];
                var data = new FormData(form);

                $('#btnSubmit').prop("disabled", true);

                $.ajax({
                    type: 'POST',
                    url: '{{ route("stored") }}',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        
                        swal("success", response.success, "success");

                        $('#form_add')[0].reset();

                        $('#btnSubmit').prop("disabled", false);

                        // setTimeout(function(){
                        //     window.location.reload();
                        // }, 3000);

                    },
                    error: function(error){
                        $('#nameError').html(error.responseJSON.errors.name[0]);
                        $('#emailError').html(error.responseJSON.errors.email[0]);
                    }
                });

            });

            // ==================== View Data ====================
            $.ajax({
                type: 'GET',
                url: '{{ route("index") }}',
                success: function(response){
                    $.each(response, function(index, data) {
                        var row = '<tr>' +
                                        '<td>' +data.id+ '</td>'+
                                        '<td >' +data.name+ '</td>'+
                                        '<td>' +data.email+ '</td>' +
                                        '<td>' + 
                                            '<button class="btn btn-primary btn-sm mx-3 edit-btn" data-id="' + data.id + '">Edit</button>' +
                                            '<button class="btn btn-danger btn-sm delete-btn" data-id="' + data.id + '">Delete</button>' +
                                        '</td>'
                                   '<tr>'

                        $('#table_data').append(row);

                    });

                    // ==================== edit Data ====================
                    $('.edit-btn').click(function(){
                        var id = $(this).data('id');

                        var data = $.ajax({
                            type: 'GET',
                            url: '{{ route("data_id_get", ":id") }}'.replace(':id', id),
                            success: function(response){

                                $('#editId').val(response.id);
                                $('#editName').val(response.name);
                                $('#editEmail').val(response.email);
                                
                                $('#editModal').modal('show');

                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });

                    });

                    $('#editForm').submit(function(event) {
                        event.preventDefault();

                        var id = $('#editId').val();
                        var name = $('#editName').val();
                        var email = $('#editEmail').val();

                        $.ajax({
                            type: 'POST',
                            url: '{{ route("data_update", ":id") }}'.replace(':id', id),
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id, // Include the id parameter
                                name: name,
                                email: email
                            },
                            success: function(response) {
                                
                                swal("success", response.success, "success");

                                $('#editModal').modal('hide');
                                
                                location.reload();

                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    });


                    // delete
                    $('.delete-btn').click(function() {
                        var id = $(this).data('id');

                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route("data_delete", ":id") }}'.replace(':id', id),
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                
                                swal("success", response.success, "success");

                                location.reload();

                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    });


                },
                error: function(error){
                    console.log(error);
                }

            });

        });
    </script>


</body>
</html>