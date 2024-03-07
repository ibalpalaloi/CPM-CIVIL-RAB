@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <h5 class="col card-title fw-semibold mb-4">Material Category</h5>
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
                                        <h6 class="fw-semibold mb-0">Category</h6>
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_list_category">

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
                                @foreach ($categories as $data)
                                    <tr id="tr_{{$data->id}}">
                                        {{-- <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{$no++}}</h6>
                                        </td> --}}
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $data->material_category }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button onclick="show_modal_edit_category('{{$data->id}}', '{{$data->material_category}}')" class="btn btn-primary btn-sm float-end"
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
                            <input type="text" class="form-control" id="category" required>
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
    var categories = {!!json_encode($categories)!!}
    var no = {!!json_encode($no)!!}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#form_add_category').on('submit', function(event){
        event.preventDefault();
        add_category();
    })

    $('#form_edit_category').on('submit', function(event){
        event.preventDefault();
        edit_category();
    })

    function edit_category(){
        console.log('dada');
        var id = $('#editIdInput').val()
        var category = $('#editCategoryInput').val();
        $.ajax({
            method: "POST",
            url: "{{url('/')}}/material_category/post_edit_material_category/"+id,
            data: {
                'category': category,
            },
            success:function(data){
                if(data.statusCode != 200){
                    alert(data.message);
                }else{
                    var string = ""
                    string = string +'<td class="border-bottom-0">'+`<h6 class="fw-semibold mb-1">${data['material_category']['category']}</h6>`+'</td>'
                    string = string + `<td class="border-bottom-0"><button onclick="show_modal_edit_category('${data['material_category']['id']}', '${data['material_category']['category']}')" class="btn btn-primary btn-sm float-end"><i class="ti ti-pencil"></i></button></td>`


                    console.log(string);

                    $('#tr_'+id).html(string);
                    $('#editIdInput').val("");
                    $('#modalEditCategory').modal('hide');
                }
            },
            error:function(e){
                console.log(e)
            }
        })
    }

    function delete_category(){
        var id = $('#editIdInput').val();
        if(id != ""){
            $.ajax({
                method: "GET",
                url: "{{url('/')}}/material_category/delete/"+id,
                success:function(data){
                    $('#tr_'+id).remove();
                    // alert('deleted');
                    $('#modalEditCategory').modal('hide');
                },
                error:function(e){
                    console.log(e);
                }
            })
        }
    }

    function show_modal_edit_category(id, category){
        $('#editIdInput').val(id);
        $('#editCategoryInput').val(category);
        $('#modalEditCategory').modal('show');
    }

    function add_category(){
        var category = $('#category').val();
        $.ajax({
            method: "POST",
            url: "{{url('/')}}/material_category/post_new_material_category",
            data: {
                'material_category': category,
            },
            success:function(data){
                if(data.statusCode != 200){
                    alert(data.message);
                }else{
                    var string = `<tr id='tr_`+data['material_category']['id']+`''>`
                    string = string +'<td class="border-bottom-0">'+`<h6 class="fw-semibold mb-1">${data['material_category']['material_category']}</h6>`+'</td>'
                    string = string + `<td class="border-bottom-0"><button onclick="show_modal_edit_category('${data['material_category']['id']}', '${data['material_category']['category']}')" class="btn btn-primary btn-sm float-end"><i class="ti ti-pencil"></i></button></td>`
                    string = string + '</tr>'

                    console.log(string);

                    $('#tbody_list_category').append(string);
                    no = no+1;
                    $('#category').val("");
                    $('#modalAddCategory').modal('hide');
                }
            },
            error:function(e){
                console.log(e)
            }
        })
    }
</script>
@endsection
