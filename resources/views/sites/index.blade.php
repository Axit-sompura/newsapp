@extends('layouts.main')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">{{ __('Site Management') }}</h1>

    </div>
    <!-- /.container-fluid -->
    <div class="container">
        <div class="pull-right mb-4" style="float: right">
            <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Add Domain</a>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card-body">
            <table class="table table-bordered" id="ajax-crud-datatable">
                <thead class="text-center">
                <tr>
                    <th>Id</th>
                    <th>Site Name</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- boostrap company model -->
    <div class="modal fade" id="domain-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="DomainModal"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="DomainForm" name="DomainForm" class="form-horizontal"
                          method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label" style="    display: inline;">Domian
                                Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="domain" name="domain"
                                       placeholder="Enter Domain Name" maxlength="250" required="">
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#ajax-crud-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('domain-list') }}",
                columns: [
                    {title: "Domain Name", data: 'domain', name: 'domain',  className: "text-left"},
                    {title: "Created", data: 'created_at', name: 'created_at',  className: "text-center"},
                    {title: "Valid", data: 'status', name: 'status', className: "text-center"},
                    {title: "Action", data: 'action', name: 'action',  className: "text-center", sortable:false, searchable:false},
                ],
                order: [[0, 'desc']]
            });
        });

        function add() {
            $('#DomainForm').trigger("reset");
            $('#DomainModal').html("Add Domain");
            $('#domain-modal').modal('show');
            $('#id').val('');
        }

        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;
                $.ajax({
                    type: "POST",
                    url: "{{ url('delete') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        var oTable = $('#ajax-crud-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }

        $('#DomainForm').submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ url('store')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#domain-modal").modal('hide');
                    var oTable = $('#ajax-crud-datatable').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>

<style>

</style>
@endsection
