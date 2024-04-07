@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <h5 class="col card-title fw-semibold mb-4">Job Input</h5>
                        <div class="col">

                            <button onclick="showModalAddCategory()" class="btn btn-primary btn-sm float-end"
                                data-bs-toggle="modal" data-bs-target="#modalAddCategory">Add</button>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Pekerjaan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="jobName">
                            </div>
                            <div class="col-sm-5">
                                <button onclick="show_modal_search_job()" type="button"
                                    class="btn btn-secondary btn-sm">search</button>
                                <button onclick="save_job()" type="button" class="btn btn-secondary btn-sm">Save</button>
                                <button onclick="clear_job()" type="button" class="btn btn-secondary btn-sm">Clear</button>
                                <button onclick="delete_job()" type="button" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Kategori AHS</label>
                            <div class="col-sm-5">
                                <select class="form-select" id="categoryAHS" aria-label="Default select example" required>
                                    <option selected></option>
                                    @foreach ($job_category as $data)
                                        <option value="{{ $data->id }}">{{ $data->job_category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Satuan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="jobUnit">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" id="descriptionJob" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Total Harga</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="TotalPriceInput" disabled>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <button onclick="showModalAddItemOfJob()" class="btn btn-primary btn-sm float-end"
                        data-bs-toggle="modal" data-bs-target="#modalAddItemOfJob">Add</button>

                    <div id="tableAHS">
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
                            <label for="exampleInputEmail1" class="form-label">Job Category</label>
                            <select class="form-select" id="job_category" aria-label="Default select example" required>
                                <option value="first" selected>--select--</option>
                                @foreach ($job_category as $data)
                                    <option value="{{ $data->id }}">{{ $data->job_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Job Name</label>
                            <input type="text" class="form-control" id="job_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="job_unit" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Desc</label>
                            <textarea name="" id="description" class="form-control" id="" cols="30" rows="2"></textarea>
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

    <div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    {{-- modal search job --}}
    <div class="modal fade" id="modal_search_job" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SEARCH AHS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_edit_category">
                    <div class="modal-body modal-lg">
                        <div class="mb-3 row">

                            <label for="exampleInputEmail1" class="col-sm-2 col-form-label">Kategori AHS</label>
                            <div class="col-sm-7">
                                <select name="" id="inputSearchJobCategory" class="form-control form-control-sm">
                                    <option value=""></option>
                                    @foreach ($job_category as $data)
                                        <option value="{{ $data->id }}">{{ $data->job_category }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="exampleInputEmail1" class="col-sm-2 col-form-label">AHS</label>
                            <div class="col-sm-7">

                                <input type="text" class="form-control form-control-sm" id="inputSearchJob">

                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    onclick="getTableSearchJob()">seach</button>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div id="tableModalSearchJob" class="overflow-auto" style="height: 500px">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Job</th>
                                    <th scope="col">Category</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
            </div>
            </form>

        </div>
    </div>
    </div>

    {{-- add item of job --}}
    <div class="modal fade" id="modalAddItemOfJob" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_add_itemOfJob">
                    <div class="modal-body">
                        <input type="text" id="inputIdMaterial" hidden>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Material Kategori</label>
                            <select onchange="getMaterialOfMaterialCategory()" class="form-select select2bs4modal"
                                id="materialCategory" aria-label="Default select example" required>
                                <option value="first" selected>--select--</option>
                                @foreach ($materialCategories as $data)
                                    <option value="{{ $data->id }}">{{ $data->material_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Material</label>
                            <select onchange="" class="form-select select2bs4modal" id="inputAddMaterial"
                                aria-label="Default select example" required>
                                <option value="first" selected>--select--</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Index</label>
                            <input type="text" class="form-control" id="inputAddIndex" required>
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

    {{-- modal edit item of job --}}
    <div class="modal fade" id="modalEditItemOfJob" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_Edit_itemOfJob">
                    <div class="modal-body">
                        <input type="text" id="inputEditIdMaterial" hidden>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Material Kategori</label>
                            <input type="text" class="form-control" id="inputEditMaterialCategory" required disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Material</label>
                            <input type="text" class="form-control" id="inputEditMaterial" required disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Index</label>
                            <input type="text" class="form-control" id="inputEditIndex" required>
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
@endsection

@section('script')
    <script>
        var job = '';
        var job_category = {!! json_encode($job_category) !!}
        var materialCategories = {!! json_encode($materialCategories) !!}

        $(function() {

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $('.select2bs4modal').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalAddItemOfJob')
            })
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form_add_job').on('submit', function(event) {
            event.preventDefault();
            add_job();
        })

        $('#modalEditItemOfJob').on('submit', function(event) {
            var id = $('#inputEditIdMaterial').val()
            event.preventDefault();
            edit_material_of_job(id);
        })

        $('#form_add_itemOfJob').on('submit', function(event) {
            event.preventDefault();
            add_item_of_job();
        })

        function delete_job() {
            if (confirm("delete?") == true) {
                $.ajax({
                    url: "{{ url('/') }}/job/delete_job/" + job.id,
                    method: "GET",
                    success: function(data) {
                        if (data.statusCode == 200) {
                            clear_job();
                        } else {
                            alert(data);
                        }
                    },
                })
            } else {}
        }

        function getTotalPrice(id) {
            $.ajax({
                url: "{{ url('/') }}/job/get_total_price/" + id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#TotalPriceInput').val(format_number_rupiah(data.total_price));
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function clear_job() {
            var job = '';
            $('#jobName').val('')
            $('#jobUnit').val('')
            $('#categoryAHS').html('')
            $('#descriptionJob').val('')
            $('#tableAHS').html('')
        }

        function editItemOfJob(id) {
            $.ajax({
                url: "{{ url('/') }}/job/get_material_of_job/" + id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#inputEditMaterialCategory').val(data.material['material_category'])
                        $('#inputEditMaterial').val(data.material['material'])
                        $('#inputEditIndex').val(data.material['qty'])
                        $('#inputEditIdMaterial').val(data.material['id'])
                        $('#modalEditItemOfJob').modal('show')
                        console.log(data)
                    } else {
                        alert(data);
                    }
                },
            })
        }

        function edit_material_of_job(id) {
            $.ajax({
                url: "{{ url('/') }}/job/post_edit_material_of_job/" + id,
                method: "POST",
                data: {
                    'index': $('#inputEditIndex').val()
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        getJob(job['id'])
                        $('#modalEditItemOfJob').modal('hide')
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function add_item_of_job() {
            var job_id = job.id
            var id = $('#inputIdMaterial').val();
            var material_id = $('#inputAddMaterial').val();
            var quantity = $('#inputAddIndex').val();
            $.ajax({
                url: "{{ url('/') }}/job/post_new_item_of_job",
                method: "POST",
                data: {
                    'job_id': job_id,
                    'material_id': material_id,
                    'quantity': quantity
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        getMaterialOfJob(job_id)
                        $('#modalAddItemOfJob').modal('hide')
                    } else {
                        alert(data);
                    }
                }
            })

        }

        function post_edit_item_of_job() {
            console.log('post_edit_item_of_job')
            var job_id = job.id
            var id = $('#inputIdMaterial').val();
            var material_id = $('#inputAddMaterial').val();
            var quantity = $('#inputAddIndex').val();
            $.ajax({
                url: "{{ url('/') }}/job/postEditOfJob/" + id,
                method: "POST",
                data: {
                    'job_id': job_id,
                    'material_id': material_id,
                    'quantity': quantity
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        getMaterialOfJob(job_id)
                        $('#modalAddItemOfJob').modal('hide')
                    } else {
                        alert(data);
                    }
                }
            })
        }

        function showModalAddCategory() {
            $('#job_category').val('first')
            $('#job_name').val('')
            $('#description').val('')
        }

        function showModalAddItemOfJob() {
            $('#inputAddIndex').val();
            $('#materialCategory').val('first');
            $('#inputAddMaterial').val('first');
        }

        function save_job() {
            if (job !== '') {
                var jobName = $('#jobName').val()
                var CategoryAHS = $('#categoryAHS').val()
                var descriptionJob = $('#descriptionJob').val()
                var unit = $('#jobUnit').val()
                $.ajax({
                    url: "{{ url('/') }}/job/update_job/" + job.id,
                    method: "POST",
                    data: {
                        'job_category': CategoryAHS,
                        'job_name': jobName,
                        'desc': descriptionJob,
                        'unit': unit
                    },
                    success: function(data) {
                        if (data.statusCode == 200) {
                            console.log(data)
                        } else {
                            alert(data)
                        }
                    }
                })
            } else {
                alert('Job is empty')
            }
        }

        function show_modal_search_job() {
            // console.log('sea')
            $('#tableModalSearchJob').html('')
            $('#inputSearchJob').val('');
            $('#modal_search_job').modal('show');
        }

        function add_job() {
            var job_category = $('#job_category').val()
            var job_name = $('#job_name').val()
            var desc = $('#description').val()
            var unit = $('#job_unit').val()

            $.ajax({
                url: "{{ url('/') }}/job/post_new_job",
                method: "POST",
                data: {
                    'job_category': job_category,
                    'job_name': job_name,
                    'desc': desc,
                    'unit': unit,
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        // console.log(data.job);
                        getJob(data.job['id'])
                        $('#modalAddCategory').modal('hide')
                        // add_tr_table_job(data.job);

                    }
                }
            })
        }

        function add_tr_table_job(data) {
            var string = ``;
            string = string + `<tr id="tr_${data['id']}">
                                        <td>${data['job_category']}</td>
                                        <td>${data['job_name']}</td>
                                        <td>${data['description']}</td>
                                        <td></td>
                                    </tr>`
            $('#tbody_list_category').append(string)
            $('#modalAddCategory').modal('hide');
        }

        function getTableSearchJob() {
            var input = $('#inputSearchJob').val();
            var job_category_id = $('#inputSearchJobCategory').val()
            $.ajax({
                url: "{{ url('/') }}/job/get_table_search_job?input=" + input + "&job_category_id=" +
                    job_category_id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#tableModalSearchJob').html(data.view)
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function getJob(id) {
            $.ajax({
                url: "{{ url('/') }}/job/getJob/" + id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        job = data.job;
                        // console.log(job);
                        $('#jobName').val(job['job_name'])
                        // $('#categoryAHS').val(job['jobCategory'])
                        $('#descriptionJob').val(job['desc'])
                        $('#jobUnit').val(job['unit'])
                        $('#modal_search_job').modal('hide')
                        var string = ``;
                        job_category.forEach(data => {
                            string = string + `<option value="${data.id}"`
                            if (data.job_category == job['jobCategory']) {
                                string = string + 'selected'
                            }
                            string = string + `>${data.job_category}</option>`
                        })
                        $('#categoryAHS').html(string);
                        getMaterialOfJob(job.id)
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function getMaterialOfMaterialCategory() {
            var categoryID = $('#materialCategory').val();
            $.ajax({
                url: "{{ url('/') }}/job/getMaterialOfMaterialCategory/" + categoryID,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        var string = ``;
                        string = string + `<option selected>--select--</option>`
                        data.materials.forEach(material => {
                            string = string +
                                `<option value=${material.id}>${material.material_name}</option>`
                        });
                        // console.log(string);
                        $('#inputAddMaterial').html(string);
                    } else {
                        alert(data)
                    }
                }
            })

        }

        function getMaterialOfJob(id) {
            $.ajax({
                url: "{{ url('/') }}/job/getMaterialOfJob/" + id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#tableAHS').html(data.view)
                        getTotalPrice(job['id'])
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function deleteItemOfJob(id) {
            if (confirm("Delete material ?") == true) {
                $.ajax({
                    url: "{{ url('/') }}/job/deleteItemOfJob/" + id,
                    method: "GET",
                    success: function(data) {
                        if (data.statusCode == 200) {
                            getMaterialOfJob(job.id);
                        } else {
                            alert(data)
                        }
                    }
                })
            } else {

            }

        }
    </script>
@endsection
