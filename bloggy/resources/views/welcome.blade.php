<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('style.css') }}" rel="stylesheet" />
        <link href="{{ asset('datatable.css') }}" rel="stylesheet" />
        <!-- Styles -->
        <style>


            body {
                padding-top: 20px;
                padding-bottom: 100px;
            }

            .navbar {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>

      <div class="container">
        <div class="content">
            <h3>Data Barang</h3>

            <table id="comments" class="display table table-responsive table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>nama barang</th>
                        <th>jumlah</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td>nama_barang </td>
                        <td>jumlah</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
      </div>

      <script src="{{ asset('script.js') }}"></script>
        <script src="{{ asset('datatables.js') }}"></script>
        <script>
            var apiUrl = "http://127.0.0.1:8080/api/databarang";
            var DataTable_Comments = $('#comments').DataTable({
                "processing": true,
                "ajax": {
                    "url": apiUrl,
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "nama_barang" },
                    { "data": "jumlah" },
                    { "data": "id",
                        "render": function(data, type, row, meta) {
                        return '<button type="button" class="btn btn-link btn-sm" onclick="editForm('+data+')" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>' + '&emsp;' +
                        '<button type="button" data-id="'+data+'" class="btn btn-link btn-sm" onclick="destroy('+data+', this)" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>'
                    } }
                ],
                "pagingType": "simple_numbers"
            });

            $('#comments tfoot tr td').each(function() {
                $(this).html( '<input type="text" class="form-control input-sm" style="width: 100%" placeholder="Search '+$(this).text()+'" />' );
            });

            DataTable_Comments.columns().every(function() {
                var th = this;
                $('input', this.footer()).on('keyup change', function() {
                    if(th.search() !== this.value) {
                        th.search(this.value).draw();
                    }
                });
            });

            function editForm(id) {
                var _this = this;
                $.getJSON({
                    url: apiUrl + '/' + id,
                    success: function(d) {
                        bootbox.dialog({
                            title: 'Edit Data #' + d.id,
                            message: _this.form(d),
                            buttons: {
                                main: {
                                    label: 'Save',
                                    className: 'btn-info btn-sm',
                                    callback: function() {
                                        _this.putForm(d.id, $('form.editForm').serialize());
                                    }
                                }
                            }
                        });
                    }
                });
            }

            function putForm(id, serializeData) {
                $.ajax({
                    url: apiUrl + '/' + id,
                    type: 'PUT',
                    data: serializeData,
                    success: function(res) {
                        bootbox.alert('Success Edit Data #' + res.id);
                        console.log('[EDIT] Message From Server: ' + JSON.stringify(res));
                        DataTable_Comments.draw();
                    }
                });
            }

            function form(d) {
                var _form = $('<form></form>').addClass('editForm').addClass('form').attr('role', 'form');

                var inputName = _form.append($('<div></div>').addClass('form-group'));
                inputName.append($('<label></label>').addClass('label-control').text('nama barang'));
                inputName.append($('<input></input>').addClass('form-control').attr('name', 'nama_barang').attr('type', 'text').val(d.nama_barang));

                var inputJumlah = _form.append($('<div></div>').addClass('form-group'));
                inputJumlah.append($('<label></label>').addClass('label-control').text('jumlah'));
                inputJumlah.append($('<input></input>').addClass('form-control').attr('name', 'jumlah').attr('type', 'text').val(d.jumlah));


                return _form;
            }

            function destroy(id, comp) {
                var target = $(comp).closest('tr').get(0);
                bootbox.confirm('Are You Sure', function(res) {
                    if(res == true) {
                        $.ajax({
                            url: apiUrl + '/' + id,
                            type: 'DELETE',
                            success: function(r) {
                                // bootbox.alert('[DELETE] Message From Server: ' + JSON.stringify(r));
                                target.remove();
                                console.log('[DELETE] Message From Server: ' + JSON.stringify(r));
                            }
                        });
                    }
                });

                return true;
            }
        </script>

    </body>
</html>
