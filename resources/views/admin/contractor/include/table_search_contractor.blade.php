<table class="table">
    <thead>
        <tr>
            <th scope="col">contractor</th>
            <th scope="col">contact</th>
            <th scope="col">desc</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contractors as $contractor)
        <tr ondblclick="selectContractor('{{ $contractor->id }}')">
            <td>{{ $contractor->contractor_name }}</td>
            <td>{{ $contractor->contact }}</td>
            <td>{{ $contractor->desc }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
