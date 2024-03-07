<table>
    <tr>
        <td></td>
        <td width="35">NAMA PROJECT</td>
        <td align="left" width="35"><b>{{ $project_summary->project_name }}</b></td>
    </tr>
    <tr>
        <td></td>
        <td width="35">NAMA BANGUNAN</td>
        <td align="left"><b>{{ $project_summary->building_name }}</b></td>
    </tr>
    <tr>
        <td></td>
        <td width="35">PEMILIK PROYEK</td>
        <td align="left"><b>{{ $project_summary->project_owner }}</b></td>
    </tr>
    <tr>
        <td></td>
        <td width="35">TAHUN</td>
        <td align="left"><b>{{ $project_summary->year }}</b></td>
    </tr>
</table>

<table>
    <thead>
        <tr style="font-weight: bold; color: red">
            <th style="background-color: yellow;"><b>No</b></th>
            <th style="background-color: yellow;"><b>Kategori</b></th>
            <th style="background-color: yellow;"><b>Deskripsi</b></th>
            <th style="background-color: yellow;"><b>AHS</b></th>
            <th style="background-color: yellow;"><b>Keterangan</b></th>
            <th style="background-color: yellow;"><b>Volume</b></th>
            <th style="background-color: yellow;"><b>Unit</b></th>
            <th style="background-color: yellow;"><b>Harga Satuan Upah</b></th>
            <th style="background-color: yellow;"><b>Harga Satuan Material</b></th>
            <th style="background-color: yellow;"><b>Harga Satuan Alat</b></th>
            <th style="background-color: yellow;"><b>Harga Satuan</b></th>
            <th style="background-color: yellow;"><b>Total</b></th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_price = 0;
            $no=1;
        @endphp
        @foreach ($data_job_on_project as $data)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data['job_category'] }}</td>
                <td>{{ $data['desc_job_project'] }}</td>
                <td>{{ $data['job'] }}</td>
                <td>{{ $data['desc_job'] }}</td>
                <td>{{ $data['qty'] }}</td>
                <td>{{ $data['unit'] }}</td>
                <td>{{ number_format($data['Upah'],0,',',',') }}</td>
                <td>{{ number_format($data['Material'],0,',',',') }}</td>
                <td>{{ number_format($data['Alat'],0,',',',') }}</td>
                <td>{{ number_format($data['Alat']+$data['Material']+$data['Upah'],0,',',',') }}</td>
                <td>{{ number_format(($data['Alat']+$data['Material']+$data['Upah']) * $data['qty'],0,',',',') }}</td>
            </tr>
            @php
                $total_price += ($data['Alat']+$data['Material']+$data['Upah']) * $data['qty'];
            @endphp
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ number_format($total_price,0,',',',') }}</td>
        </tr>
    </tbody>
</table>
