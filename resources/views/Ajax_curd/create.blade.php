<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Boostrep</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    <div class="container mt-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Data
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="model-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form id="ajaxForm">

                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <span id="nameError" class="text-danger error-messages"></span>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price">
                            <span id="priceError" class="text-danger error-messages"></span>
                        </div>

                        <div class="mb-3">
                            <label for="price_percentage" class="form-label">Price Percentage</label>
                            <input type="text" class="form-control" id="price_percentage" name="price_percentage">
                            <span id="price_percentageError" class="text-danger error-messages"></span>
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Price Calculation</label>
                            <input type="text" id="priceCalcError" class="bg-secondary form-control" name="total" readonly>
                            <span id="totalError" class="text-danger error-messages"></span>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                            <span id="dateError" class="text-danger error-messages"></span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveBTN"></button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ajax js -->

    <!-- ajax js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#model-title').html('Create Data');
            $('#saveBTN').html('Add Data');

            var form = $('#ajaxForm')[0];

            $('#saveBTN').click(function(){

                var formData = new FormData(form);

                

            });



            // $('#nameError').html(error.responseJSON.errors.name);
            // $('#priceError').html(error.responseJSON.errors.price)
            // $('#priceRangeError').html(error.responseJSON.errors.price)
            // $('#totalError').html(error.responseJSON.errors.price)
            // $('#dateError').html(error.responseJSON.errors.price)

            // $.each(error.responseJSON.errors, function(key, errors) {
            //     $('#' + key + 'Error').html(errors[0]);
            // });

        });
    </script>

    


</body>
</html>
