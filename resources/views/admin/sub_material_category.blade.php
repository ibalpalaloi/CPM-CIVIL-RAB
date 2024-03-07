@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <h5 class="col card-title fw-semibold mb-4">Sub Material Category</h5>
                        <div class="col">

                            <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                                data-bs-target="#modalAddCategory">Add</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Sub Category</h6>
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_list_sub_category">

                                {{-- <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">1</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1">Sunil Joshi</h6>
                                        <span class="fw-normal">Web Designer</span>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">Elite Admin</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary rounded-3 fw-semibold">Low</span>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 fs-4">$3.9</h6>
                                    </td>
                                </tr> --}}
                                @php
                                    $no = 1
                                @endphp
                                @foreach ($sub_categories as $data)
                                    <tr id="tr_{{$data->id}}">
                                        <td class="border-bottom-0">
                                            <h6 class="">{{ $data->sub_material }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button onclick="show_modal_edit_category('{{$data->id}}', '{{$data->sub_material}}')" class="btn btn-primary btn-sm float-end"
                                            ><i class="ti ti-pencil"></i></button>
                                            
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_add_category">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Category</label>
                            <input type="text" class="form-control" id="sub_material_category" required>
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
                        {{-- <button type="button" onclick="delete_category()" class="btn btn-danger">Delete</button> --}}
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    var material_category = {!!json_encode($categories)!!};

    $('#form_add_category').on('submit', function(event){
        event.preventDefault();
        add_category();
    })

    $('#form_edit_category').on('submit', function(event){
        event.preventDefault();
        edit_category();
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function edit_category(){
        var id = $('#editIdInput').val()
        var category_id = $('#edit_material_category').val()
        var category = $('#editCategoryInput').val();
        $.ajax({
            method: "POST",
            url: "{{url('/')}}/sub_material_category/post_edit_material_category/"+id,
            data: {
                'category': category,
                'category_id': category_id,
            },
            success:function(data){
                if(data.statusCode != 200){
                    alert(data.message);
                }else{
                    console.log(data);
                    var string = `<td class="border-bottom-0">
                                            <h6 class="">${data.category['sub_material']}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button onclick="show_modal_edit_category('${data.category['id']}', '${data.category['sub_material']}')" class="btn btn-primary btn-sm float-end"
                                            ><i class="ti ti-pencil"></i></button>
                                        </td>`
                    $('#tr_'+id).html(string);
                    $('#modalEditCategory').modal('hide');
                }
            },
            error:function(e){
                console.log(e)
            }
        })
    }

    function add_category(){
        var material_category = $('#material_category').val();
        var sub_material_category = $('#sub_material_category').val();
        $.ajax({
            method: "POST",
            url: "{{url('/')}}/sub_material_category/post_new_sub_material_category",
            data: {
                'sub_material_category': sub_material_category,
            },
            success:function(data){
                if(data.statusCode != 200){
                    alert(data.message);
                }else{
                    var string = `<tr><td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">${data.category['sub_material']}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button onclick="show_modal_edit_category('${data.category['id']}', '${data.category['sub_material']}'" class="btn btn-primary btn-sm float-end"
                                            ><i class="ti ti-pencil"></i></button>
                                        </td>
                                        <button onclick="show_modal_edit_category('${data.category['id']}'" class="btn btn-primary btn-sm float-end"
                                            ><i class="ti ti-pencil"></i></button>
                                    </tr>`
                    $('#tbody_list_sub_category').append(string);
                }
            },
            error:function(e){
                console.log(e)
            }
        })
    }

    function show_modal_edit_category(id, sub_category){
        $('#editCategoryInput').val(sub_category);
        $('#editIdInput').val(id);
        $('#modalEditCategory').modal('show');

    }

    function delete_category(){
        var id = $('#editIdInput').val();
        if(id != ""){
            $.ajax({
                method: "GET",
                url: "{{url('/')}}/sub_material_category/delete/"+id,
                success:function(data){
                    if(data.statusCode == 200){
                        $('#tr_'+id).remove();
                        // alert('deleted');
                        $('#modalEditCategory').modal('hide');
                    }
                    
                },
                error:function(e){
                    console.log(e);
                }
            })
        }
    }
</script>
@endsection
