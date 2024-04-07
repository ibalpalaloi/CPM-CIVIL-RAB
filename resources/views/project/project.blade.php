@extends('layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row">
                        <h5 class="col card-title fw-semibold mb-4">Project</h5>
                        <div class="col float-end" id="div_btn_project_status">
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">ID Project</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="projectID" disabled>
                            </div>
                            <div class="col-sm-5">
                                <button onclick="show_modal_search_job()" type="button" class="btn btn-secondary btn-sm"><i
                                        class="ti ti-search"></i>search</button>
                                <button onclick="save_job()" type="button"
                                    class="btn btn-secondary btn-sm">save</i></button>
                                <button onclick="clear_job()" type="button" class="btn btn-secondary btn-sm"><i
                                        class="ti ti-reload"></i>clear</button>
                                <button onclick="show_modal_add_project()" type="button"
                                    class="btn btn-secondary btn-sm">New</button>
                                <button onclick="delete_job()" type="button" class="btn btn-danger btn-sm"><i
                                        class="ti ti-trash"></i></button>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Nama Project</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="inputProjectName">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Nama Bangunan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="inputBuildingName">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Pemilik Proyek</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="inputProjectOwner">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Tahun</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" id="inputProjectYear">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Kontraktor</label>
                            <div class="col-sm-5">
                                <select class="form-select" id="inputContractorProject" aria-label="Default select example"
                                    required>
                                    <option value="first" selected>--select--</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <button onclick="showModalSearchJob()" class="btn btn-primary btn-sm float-end ms-2">Add</button>
                    <div class="dropdown float-end">
                        <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Print
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#" onclick="print_recap_rab()">Rekap RAB</a></li>
                            <li><a class="dropdown-item" href="#" onclick="print_material_and_price()">Material &
                                    Price</a></li>
                            <li><a class="dropdown-item" href="#" onclick="print_recap_material()">Rekap Material</a>
                            </li>
                        </ul>
                    </div>

                    <div id="tableAHS">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- modal add project --}}
    <div class="modal fade" id="modalAddProject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="form_add_project">
                    <div class="modal-body">
                        {{-- <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-4 col-form-label">ID Project</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="inputAddProjectID">
                        </div>
                    </div> --}}
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Nama Project</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputAddProjectName">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Nama Bangunan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputAddBuildingName">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Pemilik Proyek</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputAddProjectOwner">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Tahun</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputAddProjectYear">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Kontraktor</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="inputAddContractor" aria-label="Default select example"
                                    required>
                                    <option value="first" selected>--select--</option>
                                    @foreach ($contractors as $contractor)
                                        <option value="{{ $contractor->id }}">{{ $contractor->contractor_name }}</option>
                                    @endforeach
                                </select>
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

    <div class="modal fade" id="modalSearchJob" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <div class="input-group mb-3">
                        <input type="text" class="form-control" id="inputSearchJob">
                        <span class="input-group-text" id="basic-addon2" onclick="searchListJob()">Search</span>
                    </div> --}}
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
                                <button type="button"
                                    class="btn btn-secondary btn-sm"onclick="searchListJob()">seach</button>
                            </div>
                        </div>

                    </div>
                    <div>
                        <div class="overflow-auto" style="height: 600px" id="tableListSearchJob">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Handle</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div> --}}

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSearchProject" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="inputSearchProject">
                        <span class="input-group-text" id="basic-addon2" onclick="searchListProject()">Search</span>
                    </div>
                    <div>
                        <div class="overflow-auto" style="height: 600px" id="tableListSearchProject">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Project Name</th>
                                        <th scope="col">Building Name</th>
                                        <th scope="col">Owner</th>
                                        <th scope="col">Year</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> --}}

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalJobQuantity" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="form_add_job">
                        <input type="text" id="inputModalJobId" hidden>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Pekerjaan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputModalJobName"
                                    disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Volume</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputModalJobQty">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Desc</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputModalJobDesc">
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>


                </div>
                {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> --}}

            </div>
        </div>
    </div>

    {{-- edit job --}}
    <div class="modal fade" id="modalEditJobQuantity" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="form_edit_job">
                        <input type="text" id="inputEditModalJobId" hidden>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Pekerjaan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputEdiModalJobName"
                                    disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Volume</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputEditModalJobQty">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Desc</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="inputEditModalJobDesc">
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>


                </div>
                {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> --}}

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

        var contractors = {!! json_encode($contractors) !!}
        var project = ''

        $(document).ready(function() {
            clear_job()
        });

        $('#form_add_job').on('submit', function(event) {
            event.preventDefault();
            post_new_job();
        })

        $('#form_edit_job').on('submit', function(event) {
            event.preventDefault();
            post_edit_job();
        })

        function post_edit_job(){
            var id = $('#inputEditModalJobId').val()
            var qty = $('#inputEditModalJobQty').val()
            var desc = $('#inputEditModalJobDesc').val();
            $.ajax({
                url: "{{ url('/') }}/project/post_edit_job/" + id,
                method: "POST",
                data: {
                    'qty': qty,
                    'desc': desc

                },
                success:function(data){
                    if(data.statusCode == 200){
                        $('#modalEditJobQuantity').modal('hide');
                        get_table_job_on_project(project['id'])
                    }
                }
            })
        }

        function print_material_and_price() {
            if (project != '') {
                window.open("{{ url('/') }}/project/export/material_and_price/" + project['id'], '_blank');
            }
        }

        function print_recap_rab() {
            if (project != '') {
                window.open("{{ url('/') }}/project/export/recap_rab/" + project['id'], '_blank');
            }
        }

        function print_recap_material() {
            if (project != '') {
                window.open("{{ url('/') }}/project/export/list_materials/" + project['id'], '_blank');
            }
        }

        function delete_job() {
            if (confirm("delete?") == true) {
                if (project != '') {
                    if (project.status != 'posted') {
                        $.ajax({
                            url: "{{ url('/') }}/project/project_summary/delete/" + project['id'],
                            method: "DELETE",
                            success: function(data) {
                                if (data.statusCode == 200) {
                                    clear_job();
                                }
                            }
                        })
                    } else {
                        alert('Project is Posted')
                    }

                }
            } else {}

            
        }

        function edit_job_on_project(id){
            $.ajax({
                url: "{{ url('/') }}/project/get_d_job_on_project/" + id,
                method: "GET",
                success:function(data){
                    if(data.statusCode == 200){
                        $('#inputEditModalJobId').val(data.d_job_on_project['id'])
                        $('#inputEdiModalJobName').val(data.d_job_on_project['job_name'])
                        $('#inputEditModalJobQty').val(data.d_job_on_project['qty'])
                        $('#inputEditModalJobDesc').val(data.d_job_on_project['desc'])

                        $('#modalEditJobQuantity').modal('show')
                    }
                }
            })
        }

        function clear_job() {
            project = ''
            $('#tableAHS').html('');
            $('#projectID').val('')
            $('#inputProjectName').val('')
            $('#inputBuildingName').val('')
            $('#inputProjectOwner').val('')
            $('#inputProjectYear').val('')
            $('#inputContractorProject').html('')
            $('#div_btn_project_status').html(' ')
            $('#inputProjectName').attr('disabled', 'disabled')
            $('#inputBuildingName').attr('disabled', 'disabled')
            $('#inputProjectOwner').attr('disabled', 'disabled')
            $('#inputProjectYear').attr('disabled', 'disabled')
        }

        function delete_job_on_project(id) {
            if (confirm("delete ?") == true) {
                $.ajax({
                    url: "{{ url('/') }}/project/delete_d_job_on_project/" + id,
                    method: "GET",
                    success: function(data) {
                        if (data.statusCode == 200) {
                            $('#tr_job_on_project_' + id).remove();
                        } else {
                            alert(data)
                        }
                    }
                })
            } else {}

        }

        function post_new_job() {
            var job_id = $('#inputModalJobId').val()
            var qty = $('#inputModalJobQty').val()
            var desc = $('#inputModalJobDesc').val()

            $.ajax({
                url: "{{ url('/') }}/project/post_new_job/" + project['id'] + '/' + job_id,
                method: "POST",
                data: {
                    'qty': qty,
                    'desc': desc
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        get_table_job_on_project(project['id'])
                        $('#modalJobQuantity').modal('hide')
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function selectJob(id) {
            $.ajax({
                url: "{{ url('/') }}/project/get_job/" + id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        console.log(data)
                        var job = data.job
                        $('#inputModalJobName').val(job['job_name'])
                        $('#inputModalJobQty').val('1')
                        $('#inputModalJobId').val(job['id'])
                        $('#modalSearchJob').modal('hide')
                        $('#inputModalJobDesc').val('')
                        $('#modalJobQuantity').modal('show')
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function show_modal_add_project() {
            $('#modalAddProject').modal('show')
        }

        function searchListJob() {
            var key = $('#inputSearchJob').val();
            var job_category_id = $('#inputSearchJobCategory').val()
            $.ajax({
                url: "{{ url('/') }}/project/get_table_list_job?key=" + key + "&jobcategoryid=" +
                    job_category_id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#tableListSearchJob').html(data.table)
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function showModalSearchJob() {
            // console.log('ddd')
            if (project != '') {
                $('#modalSearchJob').modal('show')

            } else {
                alert('project is empty')
            }
        }

        function searchListProject() {
            var key = $('#inputSearchProject').val();
            $.ajax({
                url: "{{ url('/') }}/project/get_table_list_project?key=" + key,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#tableListSearchProject').html(data.table)
                    } else {
                        alert(data)
                    }
                }
            })
        }

        $('#form_add_project').on('submit', function(event) {
            event.preventDefault();
            post_new_project();
        })

        function show_modal_search_job() {
            $('#inputSearchProject').val('')
            $('#tableListSearchProject').html('')
            $('#modalSearchProject').modal('show')
        }

        function selectProject(id) {
            $.ajax({
                url: "{{ url('/') }}/project/get_project/" + id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        project = data.project
                        get_table_job_on_project(project['id'])
                        $('#projectID').val(project['id_project'])
                        $('#inputProjectName').val(project['project_name'])
                        $('#inputBuildingName').val(project['building_name'])
                        $('#inputProjectOwner').val(project['project_owner'])
                        $('#inputProjectYear').val(project['year'])
                        var string = ``;
                        console.log(data)
                        if (project.status == 'posted') {
                            string = `<option value="" >${data.contractor.contractor_name}</option>`
                        } else {
                            contractors.forEach(element => {
                                string = string + ` <option value="${element.id}"`
                                if (element.contractor_name == data.contractor.contractor_name) {
                                    string = string + ` selected`
                                }
                                string = string + `>${element.contractor_name}</option>`
                            });
                        }

                        if (project.status == 'posted') {
                            var btn = `<div class="btn-group float-end">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Posted
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li onclick="posting_project()" ><a class="dropdown-item" href="#">Cancel Posted</a></li>
                                    </ul>
                                    </div>`

                            console.log(project.status)
                        } else {
                            var btn = `<div class="btn-group float-end">
                                        <button class="btn btn-outline-danger btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Unposted
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li onclick="posting_project()"><a class="dropdown-item" href="#">Post</a></li>
                                    </ul></div>`
                        }
                        $('#div_btn_project_status').html(btn)
                        $('#inputContractorProject').html(string);
                        $('#modalSearchProject').modal('hide')
                    } else {
                        alert(data)
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            })

        }

        function posting_project() {
            if (project != "") {
                $.ajax({
                    url: "{{ url('/') }}/project/posting_project/" + project.id,
                    method: "GET",
                    success: function(data) {
                        if (data.statusCode == 200) {
                            if (data.statusCode == 200) {
                                selectProject(project['id'])
                            }
                        }
                    }
                })
            }
        }

        function get_table_job_on_project(project_id) {
            $.ajax({
                url: "{{ url('/') }}/project/get_table_job_on_project/" + project_id,
                method: "GET",
                success: function(data) {
                    if (data.statusCode == 200) {
                        $('#tableAHS').html(data.table)
                        $('#modalSearchProject').modal('hide')
                    } else {
                        alert(data)
                    }
                }
            })
        }

        function post_new_project() {
            $.ajax({
                url: "{{ url('/') }}/project/post_new_project",
                method: "POST",
                data: {
                    'project_name': $('#inputAddProjectName').val(),
                    'building_name': $('#inputAddBuildingName').val(),
                    'project_owner': $('#inputAddProjectOwner').val(),
                    'year': $('#inputAddProjectYear').val(),
                    'contractor_id': $('#inputAddContractor').val()
                },
                success: function(data) {
                    if (data.statusCode == 200) {
                        var response = data.project;
                        project = response
                        get_table_job_on_project(project.id)
                        $('#projectID').val(response.id_project)
                        $('#inputProjectName').val(response.project_name)
                        $('#inputBuildingName').val(response.building_name)
                        $('#inputProjectOwner').val(response.project_owner)
                        $('#inputProjectYear').val(response.year)
                        var string = ``;
                        contractors.forEach(element => {
                            string = string + `<option value="${element['id']}"`
                            if (contractors['id'] == data.contractor.id) {
                                string = string + ' selected'
                            }
                            string = string + `>${element['contractor_name']}</option>`
                        });
                        $('#inputContractorProject').html(string)
                        $('#modalAddProject').modal('hide')
                        selectProject(project.id)
                    } else {
                        alert(data)
                    }
                },
                error: function(request, error) {
                    alert(error);
                }
            })
        }

        function save_job() {
            if (project != '') {
                if (project.status != 'posted') {
                    $.ajax({
                        url: "{{ url('/') }}/project/post_update_project/" + project['id'],
                        method: "POST",
                        data: {
                            'project_name': $('#inputProjectName').val(),
                            'building_name': $('#inputBuildingName').val(),
                            'project_owner': $('#inputProjectOwner').val(),
                            'year': $('#inputProjectYear').val(),
                            'contractor_id': $('#inputContractorProject').val()
                        },
                        success: function(data) {
                            if (data.statusCode == 200) {

                            } else {
                                alert(data)
                            }
                        },
                        error: function(request, error) {
                            alert(error);
                        }
                    })
                } else {
                    alert('Project is Posted')
                }

            }
        }
    </script>
@endsection
