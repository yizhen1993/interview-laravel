@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5">
        <form id="search-form">
            <div class="row">
                <div class="col-12">
                    <div class="card collapsed-card">
                        <div class="card-header" data-card-widget="collapse">
                            <h3 class="card-title mb-0">Search Filter</h3>
                            <div class="card-tools">
                                <!-- Collapse Button -->
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" id="btn_search_filter" class="btn btn-success ">Search</button>
                        </div>
                    </div>
                </div>
            </div> <!-- header and filter -->
        </form>

        <table id="resultTable" class="table table-bordered table-hover dataTable dt-custom"
            style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Courses</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </tfoot>
        </table>
    </div>
@endsection
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
<script>

    $(function() {
        let table = defaultTable( $('#resultTable'));
        async function defaultTable(el,email='')
        {
            console.log('run', email);
            var data = {};
            if(email != ''){
                data = {
                    email
                }
            }
            var dataSet = [];
            await $.ajax({
                url: "{{ route('student.list')}}",
                type: "get",
                data: data,
                success: function(response) {
                    dataSet = response;
                },
                error: function(xhr) {
                console.log('Error', xhr);
                }
            });

            return  el.DataTable({
                searching: true,
                data: dataSet.content,
                "bDestroy": true,
                language: {
                    paginate: { 'next': "next", 'previous': "previous" },
                    "emptyTable": "emptyTable",
                    "info": "showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "showing 0 entries",
                    "infoFiltered": "<span class='quickApproveTable_info_filtered_span'>(filtered from _MAX_ total entries)</span>",
                    "processing": "processing",
                    "lengthMenu": 'show <select class="custom-select custom-select-sm form-control form-control-sm">'+
                        '<option value="5">5</option>'+
                        '<optn value="10">10</option>'+
                        '<option value="25">25</option>'+
                        '<option value="50">50</option>'+
                        '<option value="100">100</option>'+
                        '</select> entries',
                },
                columns: [
                    {data:'id', name: 'id', searchable: false},
                    {data:'name', name:'name', searchable: true ,orderable: false},
                    {data:'email', name: 'email', searchable: true},
                    {data:'courses', name: 'courses', "render": function(data, type, row) {
                        var html = '<ul>';
                        data.forEach(function (item, index, arr){
                            html += '<li>' + item.name + '</li>';
                        });
                        html += '</ul>';

                        return html;
                    }},
                    {data:'created_at', name: 'created_at'},
                    {data:'updated_at', name: 'updated_at'},
                ]
            });
        }

        $('#search-form').on('submit' , function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var email = $('#search-form [name=email]').val();
            table = defaultTable( $('#resultTable') , email);
        });
    });


</script>
