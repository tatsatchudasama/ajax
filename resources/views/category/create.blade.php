<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>


    <!-- Modal -->
    <!-- ajax-model class is close model -->
    <div class="modal fade ajax-model" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="ajaxForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="model-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <input type="hidden" name="category_id" id="category_id">

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <span id="nameError" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option selected disabled>chose category</option>
                                <option value="electronics">Electronics</option>
                            </select>
                            <span id="typeError" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBTN"></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-6 offset-3" style="margin-top: 100px;">
            <a href="" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal" id="add_category">Add Category</a>
        
            <table id="category-table" class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.25/js/jquery.dataTables.min.js"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <!-- DataTables JavaScript -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {

           

            // csrf token pass
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // all tabla data show
            // table variable is refresh table
            var table = $('#category-table').dataTable({
                processing: true,
                serverSide: true,

                ajax: "{{ route('category.index') }}",
                columns:[
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'type' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]

            });


            // title & save model btn ajax id create
            $('#model-title').html('Create Category');
            $('#saveBTN').html('Save Category');

            var form = $('#ajaxForm')[0];

            $("#saveBTN").click(function() {

                $('#saveBTN').html('Saving.....');
                // button disabled create
                $('#saveBTN').attr('disabled', true);


                $('.error-messages').html('');

                // form all data get using object
                var formData = new FormData(form);

                $.ajax({
                    url: "{{ route('category.store') }}",
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {

                        // table data reload
                        table.api().ajax.reload();

                        // button disabled create
                        $('#saveBTN').attr('disabled', false);
                        $('#saveBTN').html('save category');

                        $('#name').val('');
                        $('#type').val('');
                        $('#category_id').val('');


                        $('.ajax-model').modal('hide');

                        if (response) {
                            swal("success!", response.success, "success");
                        }
                    },
                    error: function(error) {
                        // button disabled create
                        $('#saveBTN').attr('disabled', false);
                        $('#saveBTN').html('save category');
                        
                        if (error) {
                            // error message
                            $("#nameError").html(error.responseJSON.errors.name);
                            $("#typeError").html(error.responseJSON.errors.type);
                        }
                    }
                });

            });


            // edit code
            $("body").on('click', '.editButton', function(){
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ url("category", "") }}/' + id + '/edit',
                    method: "GET",
                    success: function(response){
                        $('.ajax-model').modal('show');
                        $('#model-title').html('edit category');
                        $('#saveBTN').html('Update category');

                        // hidden input text id pass
                        $('#category_id').val(response.id);
                        // name & type data edit time already selected
                        $('#name').val(response.name);
                        $('#type').empty().append('<option selected value="'+ response.type +'">'+ response.type.charAt(0).toUpperCase() + response.type.slice(1) +'</option>');

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
                
            });

            // $("body").on('click', '.delButton', function(){
            //     var id = $(this).data('id');
            //     $.ajax({
            //         url: '{{ url("category/destroy", "") }}/' + id ,
            //         method: "DELETE",
            //         success: function(response){
            //             table.draw();
            //             swal("success!", response.success, "success");
            //         },
            //         error: function(error){
            //             console.log(error);
            //         }
            //     });
            // });

            $("body").on('click', '.delButton', function(){
                
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ url("category/destroy", "") }}/' + id ,
                    method: "DELETE",
                    success: function(response){
                        // table data reload
                        table.api().ajax.reload();

                        swal("success!", response.success, "success");
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });



            $('#add_category').click(function(){
                $('#model-title').html('Create Category');
                $('#saveBTN').html('Save Category');
            });

        });
    </script>

</body>

</html>