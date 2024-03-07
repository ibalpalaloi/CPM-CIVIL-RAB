<table class="table">
    <thead>
      <tr>
        <th scope="col">Job</th>
        <th scope="col">Category</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($jobs as $job)
            <tr ondblclick="getJob('{{$job->id}}')">
                <td>{{$job->job_name}}</td>
                <td>{{$job->job_category->job_category}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
