<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Category</th>
            <th scope="col">Job</th>
            <th scope="col">Unit</th>
            <th scope="col">Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_jobs as $job)
            <tr ondblclick="selectJob('{{$job['job_id']}}')">
                <th scope="row"></th>
                <td>{{$job['job_name']}}</td>
                <td>{{$job['job_category']}}</td>
                <td>{{$job['unit']}}</td>
                <td>{{number_format($job['total_price'],0,',','.')}}</td>
            </tr>
        @endforeach
        

    </tbody>
</table>