@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <h5 class="col card-title fw-semibold mb-4">Job Category</h5>
                        <div class="col">

                            <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                                data-bs-target="#modalAddCategory">Add</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    {{-- <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th> --}}
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Job</h6>
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_list_category">
                                @foreach ($job_category as $item)
                                    <tr id="tr_{{$item->id}}">
                                        <td>{{$item->job_category}}</td>
                                        <td>
                                            <button onclick="show_modal_edit_job_category('{{$item->id}}', '{{$item->job_category}}')" class="btn btn-primary btn-sm float-end"
                                                ><i class="ti ti-pencil"></i></button>
                                            {{-- <button onclick="delete_job_category('{{$item->id}}')" class="btn btn-danger btn-sm float-end"
                                                ><i class="ti ti-trash"></i></button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="modalAddCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_add_job">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Job</label>
                            <input type="text" class="form-control" id="job_category" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_edit_category">
                    <div class="modal-body">
                        <input type="text" id="editIdInput" hidden>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Category</label>
                            <input type="text" class="form-control" id="editCategoryInput" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" onclick="delete_category()" class="btn btn-danger">Delete</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form_add_job').on('submit', function(event) {
            event.preventDefault();
            add_job();
        })

        $('#form_edit_category').on('submit', function(event) {
            event.preventDefault();

            edit_job_category();
        })

        function delete_category(){
            if (confirm("delete Job?") == true) {
                var id = $('#editIdInput').val();
                $.ajax({
                    url: "{{url('/')}}/job_category/delete/"+id,
                    method: "GET",
                    success:function(data){
                        if(data.statusCode == 200){
                            $('#tr_'+id).remove();
                            $('#modalEditCategory').modal('hide');
                        }
                    }
                })
            } else {
            }
            
        }

        function edit_job_category(){
            console.log('dda')
            var id = $('#editIdInput').val();
            var job_category = $('#editCategoryInput').val();
            $.ajax({
                url: "{{url('/')}}/post_edit_job_category/"+id,
                method: "POST",
                data: {
                    'job_category': job_category
                },
                success:function(data){
                    if(data.statusCode== 200){
                        console.log(data.job_category);
                        change_tr_table_job_category(data.job_category);
                        $('#modalEditCategory').modal('hide');
                    }
                }
            })


            function change_tr_table_job_category(data){
                var string = ``;
                string = string + `<td>${data['category']}</td>
                                        <td>
                                            <button onclick="show_modal_edit_job_category('`+data['id']+`', '`+data['category']+`')" class="btn btn-primary btn-sm float-end"
                                                ><i class="ti ti-pencil"></i></button>
                                        </td>`
                $('#tr_'+data['id']).html(string);
            }
        }

        function show_modal_edit_job_category(id, category){
            $('#modalEditCategory').modal('show')
            $('#editIdInput').val(id);
            $('#editCategoryInput').val(category)
        }

        function add_job(){
            var job_category = $('#job_category').val()

            $.ajax({
                url: "{{url('/')}}/post_new_job_category",
                method: "POST",
                data: {
                    'job_category': job_category
                },
                success:function(data){
                    if(data.statusCode== 200){
                        console.log(data.job_category);
                        add_tr_table_job_category(data.job_category);


                    }else{
                        alert(data)
                    }
                }
            })
        }

        function add_tr_table_job_category(data){
            var string = ``;
            string = string + `<tr id="tr_${data['id']}">
                                        <td>${data['job_category']}</td>
                                        <td>
                                            <button onclick="show_modal_edit_job_category('`+data['id']+`', '`+data['job_category']+`')" class="btn btn-primary btn-sm float-end"
                                                ><i class="ti ti-pencil"></i></button>
                                        </td>
                                    </tr>`
            $('#tbody_list_category').append(string)
            $('#modalAddCategory').modal('hide');
            $('#job_category').val();
        }
    </script>
@endsection
