<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('isi') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
<div class="container">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-12">
            <div class="col-md-12">
                <h1>Product
                    <small>List</small>
                    <div class="float-right"><a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Add New</a></div>
                </h1>
            </div>

            <table class="table table-striped" id="mydata">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="show_data">

                </tbody>
            </table>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        show_product(); //call function show all product

        $('#mydata').dataTable();

        //function show all product
        function show_product() {
            $.ajax({
                type: 'get',
                url: '<?php echo site_url('dosen/get_detail_bimbingan') ?>',
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data1.length; i++) {
                        html += '<tr>' +
                            '<td>' + data1[i].id_judul + '</td>' +
                            '<td>' + data1[i].id_judul + '</td>' +
                            '<td>' + data1[i].id_judul + '</td>' +
                            '<td style="text-align:right;">' +
                            '<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-product_code="' + data[i].product_code + '" data-product_name="' + data[i].product_name + '" data-price="' + data[i].product_price + '">Edit</a>' + ' ' +
                            '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="' + data[i].product_code + '">Delete</a>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }

            });
        }

        //Save product
        $('#btn_save').on('click', function() {
            var product_code = $('#product_code').val();
            var product_name = $('#product_name').val();
            var price = $('#price').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('product/save') ?>",
                dataType: "JSON",
                data: {
                    product_code: product_code,
                    product_name: product_name,
                    price: price
                },
                success: function(data) {
                    $('[name="product_code"]').val("");
                    $('[name="product_name"]').val("");
                    $('[name="price"]').val("");
                    $('#Modal_Add').modal('hide');
                    show_product();
                }
            });
            return false;
        });

        //get data for update record
        $('#show_data').on('click', '.item_edit', function() {
            var product_code = $(this).data('product_code');
            var product_name = $(this).data('product_name');
            var price = $(this).data('price');

            $('#Modal_Edit').modal('show');
            $('[name="product_code_edit"]').val(product_code);
            $('[name="product_name_edit"]').val(product_name);
            $('[name="price_edit"]').val(price);
        });

        //update record to database
        $('#btn_update').on('click', function() {
            var product_code = $('#product_code_edit').val();
            var product_name = $('#product_name_edit').val();
            var price = $('#price_edit').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('product/update') ?>",
                dataType: "JSON",
                data: {
                    product_code: product_code,
                    product_name: product_name,
                    price: price
                },
                success: function(data) {
                    $('[name="product_code_edit"]').val("");
                    $('[name="product_name_edit"]').val("");
                    $('[name="price_edit"]').val("");
                    $('#Modal_Edit').modal('hide');
                    show_product();
                }
            });
            return false;
        });

        //get data for delete record
        $('#show_data').on('click', '.item_delete', function() {
            var product_code = $(this).data('product_code');

            $('#Modal_Delete').modal('show');
            $('[name="product_code_delete"]').val(product_code);
        });

        //delete record to database
        $('#btn_delete').on('click', function() {
            var product_code = $('#product_code_delete').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('product/delete') ?>",
                dataType: "JSON",
                data: {
                    product_code: product_code
                },
                success: function(data) {
                    $('[name="product_code_delete"]').val("");
                    $('#Modal_Delete').modal('hide');
                    show_product();
                }
            });
            return false;
        });

    });
</script>

<?= $this->endsection('') ?>