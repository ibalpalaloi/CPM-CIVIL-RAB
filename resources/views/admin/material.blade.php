@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <h5 class="col card-title fw-semibold mb-4">Material </h5>
                        <div class="col">

                            <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                                data-bs-target="#modalAddCategory">Add</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle myTable">
                            <thead class="text-dark fs-4">
                                <tr>
                                    {{-- <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th> --}}
                                    <th class="">
                                        <h6 class="fw-semibold mb-0">Category</h6>
                                    </th>
                                    <th class="">
                                        <h6 class="fw-semibold mb-0">Sub Category</h6>
                                    </th>
                                    <th class="">
                                        <h6 class="fw-semibold mb-0">Material</h6>
                                    </th>
                                    <th class="">
                                        <h6 class="fw-semibold mb-0">Unit</h6>
                                    </th>
                                    <th class="">
                                        <h6 class="fw-semibold mb-0">Price</h6>
                                    </th>
                                    <th class="">
                                        <h6 class="fw-semibold mb-0">Area</h6>
                                    </th>
                                    <th class="">
                                        <h6 class="fw-semibold mb-0">Description</h6>
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_list_category">
                                @foreach ($materials as $data)
                                    <tr id="tr_{{$data->id}}">
                                        <td>{{ $data->material_category->material_category }}</td>
                                        <td>{{ $data->sub_material_category->sub_material }}</td>
                                        <td>{{ $data->material_name }}</td>
                                        <td>{{ $data->unit }}</td>
                                        <td>{{ $data->price }}</td>
                                        <td>{{ $data->area }}</td>
                                        <td>{{ $data->desc }}</td>
                                        <td>
                                            <button onclick="show_modal_edit_material('{{$data->id}}')" class="btn btn-primary btn-sm float-end"
                                                ><i class="ti ti-pencil"></i></button>
                                            {{-- <button onclick="delete_material('{{$data->id}}')" class="btn btn-danger btn-sm float-end"
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_add_material">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Category</label>
                            <select id="material_category" class="form-select" aria-label="Default select example">
                                <option selected>--select--</option>
                                @foreach ($material_category as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['material_category'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Sub Category</label>
                            <select id="sub_material_category" class="form-select sub_material_category" aria-label="Default select example">
                                <option selected>--select--</option>
                                @foreach ($sub_material_category as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['sub_material'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Material</label>
                            <input type="text" class="form-control" id="input_add_material" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="input_add_unit" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Price</label>
                            <input type="number" class="form-control" id="input_add_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Area</label>
                            <input type="text" class="form-control" id="input_add_area" >
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Description</label>
                            <textarea name="" class="form-control" id="input_add_description">    </textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_edit_category">
                    <div class="modal-body">
                        <input type="text" id="input_edit_id_material" hidden>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Category</label>
                            <select id="edit_material_category" class="form-select" aria-label="Default select example">
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Sub Category</label>
                            <select id="edit_sub_material_category" class="form-select sub_material_category" aria-label="Default select example">

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Material</label>
                            <input type="text" class="form-control" id="input_edit_material" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="input_edit_unit" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Price</label>
                            <input type="text" class="form-control" id="input_edit_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Area</label>
                            <input type="text" class="form-control" id="input_edit_area" >
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Description</label>
                            <textarea name="" class="form-control" id="input_edit_description">    </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="edit_material()" class="btn btn-primary">Save</button>
                        <button type="button" onclick="delete_material()" class="btn btn-danger">Delete</button>
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
        var material_category = {!!json_encode($material_category)!!}
        var sub_material_category = {!!json_encode($sub_material_category)!!}
        var materials = {!!json_encode($materials)!!}

        $(document).ready( function () {
            $('.myTable').DataTable();
        } );
        
        $('#form_add_material').on('submit', function(event){
            event.preventDefault();
            add_material();
        })

        // $('#modalEditCategory').on('submit', function(event){
        //     event.preventDefault();
        //     add_material();
        // })

        $('#form_edit_category').on('submit', function(event){
            event.preventDefault();
            edit_material();
        })

        function show_modal_edit_material(id){

            get_material(id);
        }


        function delete_material(){
            var id = $('#input_edit_id_material').val()
            if (confirm("Delete Material ?") == true) {
                $.ajax({
                    url: "{{url('/')}}/material/delete/"+id,
                    method: "GET",
                    success:function(data){
                        if(data.statusCode == 200){
                            $('#tr_'+id).remove();
                            // $('#modalEditCategory').modal('hide');
                            var table = $('.myTable').DataTable();
                            table.row('#tr_'+id).remove()
                        }else{
                            alert(data)
                        }
                    }
                })
            } else {
            }
        }

        function get_material(id){
            $.ajax({
                url: "{{url('/')}}/material/get_material/"+id,
                method: "GET",
                success:function(data){
                    if(data.statusCode == 200){
                        console.log(data);
                        var material = data.material;
                        $('#input_edit_id_material').val(id)
                        $('#input_edit_material').val(material['material_name'])
                        $('#input_edit_unit').val(material['unit'])
                        $('#input_edit_price').val(material['price'])
                        $('#input_edit_area').val(material['area'])
                        $('#input_edit_description').val(material['desc'])

                       
                        var string = '<option selected>--select--</option>';
                        for(let i = 0; i < material_category.length; i++){
                            string = string + `<option value="${material_category[i]['id']}"`
                            if(material_category[i]['id'] == material['material_category_id']){
                                string = string + ' selected'
                            }
                            string = string + ` >`
                            string = string + `${material_category[i]['material_category']} </option>`
                        }

                        var string1 = '<option selected>--select--</option>';
                        for(let i = 0; i < sub_material_category.length; i++){
                            string1 = string1 + `<option value="${sub_material_category[i]['id']}"`
                            if(sub_material_category[i]['id'] == material['sub_material_category_id']){
                                string1 = string1 + ' selected'
                            }
                            string1 = string1 + ` >`
                            string1 = string1 + `${sub_material_category[i]['sub_material']} </option>`
                        }
                        $('#edit_material_category').html(string);
                        $('#edit_sub_material_category').html(string1);
                        $('#modalEditCategory').modal('show');
                    }
                }
            })
        }

        function edit_material(){
            console.log('edit')
            var material_category_id = $('#edit_material_category').val()
            var sub_material_category_id = $('#edit_sub_material_category').val()
            var material = $('#input_edit_material').val()
            var unit = $('#input_edit_unit').val()
            var price = $('#input_edit_price').val()
            var area = $('#input_edit_area').val()
            var description = $('#input_edit_description').val()
            var id = $('#input_edit_id_material').val()

            $.ajax({
                url: "{{url('/')}}/material/post_edit_material/edit/"+id,
                method: "POST",
                data: {
                    'material_category_id': material_category_id,
                    'sub_material_category_id': sub_material_category_id,
                    'material': material,
                    'unit': unit,
                    'price': price,
                    'area': area,
                    'description': description,
                },
                success:function(data){
                    if(data.statusCode == 200){
                        // location.reload();
                        console.log(data)
                        var material = data.material;
                        var string = ``;
                        string = string + `<td>${material.material_category.material_category}</td>
                                        <td>${material.sub_material_category.sub_material}</td>
                                        <td>${material['material_name']}</td>
                                        <td>${material['unit']}</td>
                                        <td>${material['price']}</td>
                                        <td>${material['area']}</td>
                                        <td>${material['desc']}</td>
                                        <td>
                                            <button onclick="show_modal_edit_material('${material['id']}')" class="btn btn-primary btn-sm float-end"
                                                ><i class="ti ti-pencil"></i></button>
                                        </td>`
                        
                        $('#tr_'+material.id).html(string);
                        $('#modalEditCategory').modal('hide')
                    }
                    else{
                        alert(data);
                    }
                    // console.log(data);
                }
            })
        }

        function add_material(){
            var material_category_id = $('#material_category').val()
            var sub_material_category_id = $('#sub_material_category').val()
            var material = $('#input_add_material').val()
            var unit = $('#input_add_unit').val()
            var price = $('#input_add_price').val()
            var area = $('#input_add_area').val()
            var description = $('#input_add_description').val()

            $.ajax({
                url: "{{url('/')}}/material/post_new_material",
                method: "POST",
                data: {
                    'material_category_id': material_category_id,
                    'sub_material_category_id': sub_material_category_id,
                    'material': material,
                    'unit': unit,
                    'price': price,
                    'area': area,
                    'description': description,
                },
                success:function(data){
                    if(data.statusCode == 200){
                        var material = data.material;
                        $('#modalAddCategory').modal('hide');
                        $('#input_add_material').val("")
                        $('#input_add_unit').val("")
                        $('#input_add_price').val("")
                        $('#input_add_area').val("")
                        $('#input_add_description').val("")

                        add_material_on_table(data.material);
                    }
                    console.log(data);
                }
            })
        }

        function add_material_on_table(data){
            var table = $('.myTable').DataTable();
            string = `<button onclick="show_modal_edit_material('${data.id}')" class="btn btn-primary btn-sm float-end"
                                                ><i class="ti ti-pencil"></i></button>`
            var rowNode = table
                .row.add([
                            data['category'], 
                            data['sub_category'], 
                            data['material_name'], 
                            data['unit'], 
                            data['price'], 
                            data['area'], 
                            data['desc'], 
                            string 
                        ])
                .draw()
                .node()
                .id = `tr_${data.id}`;
        }

        function reload_sub_material_category(){
            var category_id = $('#material_category').val();
            for(let i = 0; i < material_category.length; i++){
                if(material_category[i]['id'] == category_id){
                    var string = "";
                    string = string + `<option selected>--select--</option>`;
                    material_category[i]['sub_category'].forEach(element => {
                        string = string + `<option value="${element['id']}">${element['sub_category']}</option>`
                    });

                    $('.sub_material_category').html(string);
                }
            }
        }
    </script>
@endsection
