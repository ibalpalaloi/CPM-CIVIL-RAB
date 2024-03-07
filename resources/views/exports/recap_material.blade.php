<table>
    <tr>
        <td width="35">Nama Proyek</td>
        <td align="left" ><b>{{ $project->project_name }}</b></td>
    </tr>
    <tr>
        <td>Nama Bangunan</td>
        <td align="left"><b>{{ $project->building_name }}</b></td>
    </tr>
    <tr>
        <td>Pemilik Proyek</td>
        <td align="left"><b>{{ $project->project_owner }}</b></td>
    </tr>
    <tr>
        <td>Tahun</td>
        <td align="left"><b>{{ $project->year }}</b></td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th style="background-color: yellow;">Material</th>
            <th style="background-color: yellow;">Jumlah Material</th>
            <th style="background-color: yellow;">Satuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_materials as $data)
            <tr>
                <td>{{ $data['material_name'] }}</td>
                <td>{{ $data['qty'] }}</td>
                <td>{{ $data['unit'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>