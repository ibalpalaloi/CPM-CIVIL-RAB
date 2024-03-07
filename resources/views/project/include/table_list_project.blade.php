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
        @foreach ($projects as $project)
            <tr ondblclick="selectProject('{{ $project->id }}')">
                <td>{{ $project->id_project }}</td>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->building_name }}</td>
                <td>{{ $project->project_owner }}</td>
                <td>{{ $project->year }}</td>
            </tr>
        @endforeach
    </tbody>
</table>