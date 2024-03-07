@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <h5 class="col card-title fw-semibold mb-4">Contractor Input</h5>
                        <div class="col">

                            <button onclick="showModalAddContractor()" class="btn btn-primary btn-sm float-end"
                                data-bs-toggle="modal" data-bs-target="#modalAddCategory">Add</button>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Contractor</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="contractorName">
                            </div>
                            <div class="col-sm-5">
                                <button onclick="show_modal_search_contractor()" type="button"
                                    class="btn btn-secondary btn-sm">search</button>
                                <button onclick="save_form()" type="button" class="btn btn-secondary btn-sm">Save</button>
                                <button onclick="clear_form ()" type="button"
                                    class="btn btn-secondary btn-sm">Clear</button>
                                <button onclick="delete_contractor()" type="button"
                                    class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="contractorContact">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" id="descriptionContractor" rows="3"></textarea>
                            </div>
                        </div>

                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="modalAddContractor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formAddContractor">
                    <div class="modal-body">
                        <div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Contractor</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="InputContractorName"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="inputContractorContact"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="inputDescriptionContractor" required rows="3"></textarea>
                                </div>
                            </div>

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

    {{-- modal search contactor --}}
    <div class="modal fade" id="modal_search_contractor" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SEARCH CONTRACTOR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_edit_category">
                    <div class="modal-body modal-lg">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Contractor</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="inputSearchContractor">
                                <span class="input-group-text" id=""
                                    onclick="getTableSearchContractor()">Cari</span>
                            </div>
                        </div>
                        <hr>
                        <div id="tableModalSearchContractor">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">contractor</th>
                                        <th scope="col">contact</th>
                                        <th scope="col">desc</th>
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
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var contractor = ''

        function showModalAddContractor() {
            $('#InputContractorName').val('')
            $('#inputContractorContact').val('')
            $('#inputDescriptionContractor').val('')
            $('#modalAddContractor').modal('show')
        }

        $('#formAddContractor').on('submit', function(event) {
            event.preventDefault();
            add_contractor();
        })

        function add_contractor() {
            $.ajax({
                url: "{{ url('/') }}/contractor/post_new_contractor",
                method: "POST",
                data: {
                    'contractor_name': $('#InputContractorName').val(),
                    'contact': $('#inputContractorContact').val(),
                    'desc': $('#inputDescriptionContractor').val(),
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        console.log(data)
                        $('#modalAddContractor').modal('hide')
                    } else {
                        alert(data);
                    }
                }
            })
        }

        function show_modal_search_contractor() {
            $('#inputSearchContractor').val('');
            $('#tableModalSearchContractor').html('')
            $('#modal_search_contractor').modal('show');
        }

        function getTableSearchContractor() {
            var key = $('#inputSearchContractor').val()
            $.ajax({
                url: "{{ url('/') }}/contractor/getTableSearchContractor",
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#tableModalSearchContractor').html(data.table)
                    } else {
                        alert(data);
                    }
                }
            })
        }

        function selectContractor(contractorID) {
            $.ajax({
                url: "{{ url('/') }}/contractor/getContractor/" + contractorID,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        contractor = data.contractor;
                        $('#contractorName').val(contractor['contractor_name'])
                        $('#contractorContact').val(contractor['contact'])
                        $('#descriptionContractor').val(contractor['desc'])
                        $('#modal_search_contractor').modal('hide')
                    } else {
                        alert(data);
                    }
                }
            })
        }

        function clear_form() {
            contractor = '';
            $('#contractorName').val('')
            $('#contractorContact').val('')
            $('#descriptionContractor').val('')
        }

        function save_form() {
            if (contractor != '') {
                $.ajax({
                    url: "{{ url('/') }}/contractor/post_update_contractor/" + contractor['id'],
                    method: "POST",
                    data: {
                        'contractor_name': $('#contractorName').val(),
                        'contact': $('#contractorContact').val(),
                        'desc': $('#descriptionContractor').val(),
                    },
                    success: function(data) {
                        if (data.statusCode == 200) {
                            console.log(data)
                        } else {
                            alert(data);
                        }
                    }
                })
            }
        }

        function delete_contractor() {
            if (contractor != '') {
                if (confirm("delete contractor??") == true) {
                    $.ajax({
                        url: "{{ url('/') }}/contractor/delete/" + contractor['id'],
                        method: "DELETE",
                        success: function(data) {
                            if (data.statusCode == 200) {
                                clear_form();
                            } else {
                                alert(data)
                            }
                        }
                    })
                }
            }else{
                alert('contractor is empty')
            }


        }
    </script>
@endsection
