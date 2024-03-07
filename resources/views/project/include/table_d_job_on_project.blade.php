<table class="table">
    <thead>
        <tr>
            <th scope="col">Kategori</th>
            <th scope="col">Desc</th>
            <th scope="col">AHS</th>
            <th scope="col">Ket</th>
            <th scope="col">Volume</th>
            <th scope="col">Satuan</th>
            <th scope="col">price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_job_on_project as $data)
            <tr id="tr_job_on_project_{{ $data['id'] }}">
                <td>{{ $data['job_category'] }}</td>
                <td>{{ $data['desc'] }}</td>
                <td>{{ $data['job_name'] }}</td>
                <td>{{ $data['job_desc'] }}</td>
                <td>{{ $data['qty'] }}</td>
                <td>{{ $data['unit'] }}</td>
                <td>{{ number_format($data['price'],0,',','.')}}</td>
                <th>
                    @if ($data['status'] == 'unposted')
                        <button onclick="delete_job_on_project('{{ $data['id'] }}')" class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></button>
                        
                    @else
                        
                    @endif
                </th>
            </tr>
        @endforeach
    </tbody>
</table>