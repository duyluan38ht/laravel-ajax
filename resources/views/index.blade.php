<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
            integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf"
            crossorigin="anonymous"></script>
</head>
<body>

<div class="container mt-3">
    <div class="card">
        <div class="card-header">
            <nav class="navbar navbar-light bg-light">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    Them Khach Hang
                </button>
                <div class="form-inline">
                    <input class="form-control mr-sm-2" type="search" id="searchByName" onkeyup="searchByFirstName()">
                    <button class="btn btn-outline-success my-2 my-sm-0" id="search" onclick="searchByFirstName()">Tim Kiem</button>
                </div>
            </nav>
        </div>

        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Stt</th>
                    <th>Name Customer</th>
                    <th>Email Customer</th>
                    <th>Phone Customer</th>
                    <th>Actions</th>
                </tr>
                <tbody id="result">

                </tbody>
            </table>
        </div>
    </div>
</div>
{{--<div id="result"></div>--}}

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <label>Tên Khách Hàng</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name">
                </div>
                <div class="form-group">
                    <label>Email Khách Hàng</label>
                    <input type="text" class="form-control" id="customer_email" name="customer_email">
                </div>
                <div class="form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                </div>
                <button id="addCustomer" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="customer_id">
                <div class="">
                    <label>Tên Khách Hàng</label>
                    <input type="text" class="form-control" id="edit_customer_name" name="customer_name">
                </div>
                <div class="form-group">
                    <label>Email Khách Hàng</label>
                    <input type="text" class="form-control" id="edit_customer_email" name="customer_email">
                </div>
                <div class="form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" class="form-control" id="edit_customer_phone" name="customer_phone">
                </div>
                <button onclick="updateCustomer()" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#addCustomer').click(function (e) {
            // e.preventDefault();
            addCustomer();
        });

        // $('#editCustomer').click(function (e) {
        //     editCustomer();
        // });

        getAll();

    });
    let getAll = function () {
        $.ajax({
            type: 'GET',
            url: '/api/customers',
            dataType: 'json',
            success: function (response) {
                console.log(response)
                display(response);
            }
        })
    }

    function display(response) {
        let str = '';
        for (let i = response.length - 1; i >= 0; i--) {
            str += `<tr>
                    <td>${response[i].id}</td>
                    <td>${response[i].customer_name}</td>
                    <td>${response[i].customer_email}</td>
                    <td>${response[i].customer_phone}</td>
                    <td><button class="btn btn-danger" onclick="deleteCustomer(${response[i].id})" >delete</button></td>
                    <td>
                    <button type="button" onclick="editCustomer(${response[i].id})" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
                    </td>
                    </tr>`
        }
        $('#result').html(str)
    }

    var addCustomer = function () {
        var customer_name = $('#customer_name').val();
        var customer_email = $('#customer_email').val();
        var customer_phone = $('#customer_phone').val();
        var customer = {customer_name, customer_email, customer_phone};

        $.ajax({
            type: 'POST',
            url: '/api/customers',
            dataType: 'json',
            data: customer,
            success: function () {
                getAll();
                $('#addModal').modal('hide');
                $('#customer_name').val('');
                $('#customer_email').val('');
                $('#customer_phone').val('');
            }
        });
    }
    var editCustomer = function (id) {
        $.ajax({
            type: 'GET',
            url: '/api/customers/' + id,
            dataType: 'json',
            success: function (data) {
                console.log(data)
                $('#edit_customer_name').val(data['customer_name']);
                $('#edit_customer_email').val(data['customer_email']);
                $('#edit_customer_phone').val(data['customer_phone']);
                $('#customer_id').val(data['id']);

            }
        });
    }
    var updateCustomer = function () {
        var customer_name = $('#edit_customer_name').val();
        var customer_email = $('#edit_customer_email').val();
        var customer_phone = $('#edit_customer_phone').val();
        var id = $('#customer_id').val();
        var customer = {customer_name, customer_email, customer_phone};

        $.ajax({
            type:'PUT',
            url: '/api/customers/' + id,
            data: customer,
            success: function () {
                getAll()
                $('#editModal').modal('hide');

                $('#customer_id').val('');
                $('#edit_customer_name').val('');
                $('#edit_customer_email').val('');
                $('#edit_customer_phone').val('');


            }
        })
    }

    function
    deleteCustomer(id) {
        $.ajax({
            type: 'DELETE',
            url: '/api/customers/' + id,
            dataType: 'json',
            success: function () {
                getAll();
            }
        })
    }
    function searchByFirstName() {
        var key = $('#searchByName').val();
        $.ajax({
            type: 'POST',
            url: '/api/customers/' + key,
            dataType: 'json',
            success: function (data) {
                display(data)
            }
        })
    }


</script>


</body>
</html>
