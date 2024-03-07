<table>
    <thead>
        <tr style="font-weight: bold; color: red">
            <th style="background-color: yellow;"><b>Ketagori AHS</b></th>
            <th style="background-color: yellow;"><b>Pekerjaan</b></th>
            <th style="background-color: yellow;"><b>Keterangan</b></th>
            <th style="background-color: yellow;"><b>Volume</b></th>
            <th style="background-color: yellow;"><b>Satuan</b></th>
            <th style="background-color: yellow;"><b>Material Kategory</b></th>
            <th style="background-color: yellow;"><b>Material</b></th>
            <th style="background-color: yellow;"><b>Jumlah Material</b></th>
            <th style="background-color: yellow;"><b>Satuan</b></th>
            <th style="background-color: yellow;"><b>Harga satuan</b></th>
            <th style="background-color: yellow;"><b>Total</b></th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($data_job_on_project as $job_on_project)
            @php
                $first_line_1 = true;
                $grand_total = 0;
            @endphp
            @foreach ($job_on_project['material'] as $material)
                @php
                    $price_per_category = 0;
                    $first_line = true;
                @endphp
                @foreach ($material['list'] as $list)
                    <tr>
                        @if ($first_line_1 == true)
                            <td>{{ $job_on_project['job_category'] }}</td>
                            <td>{{ $job_on_project['job'] }}</td>
                            <td>{{ $job_on_project['desc'] }}</td>
                            <td>{{ $job_on_project['qty'] }}</td>
                            <td>{{ $job_on_project['unit'] }}</td>
                            @php
                                $first_line_1 = false;
                            @endphp
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                        
                        
                        @if ($first_line == true)
                            <td rowspan="{{ count($material['list']) }}">{{ $material['material_category'] }}</td>
                            @php
                                $first_line = false;
                            @endphp
                        @endif
                        <td>{{ $list->material_name }}</td>
                        <td>{{ $list->qty * $job_on_project['qty'] }}</td>
                        <td>{{ $list->unit }}</td>
                        <td align="right">{{ number_format($list->price,0,',',',') }}</td>
                        <td align="right">{{ number_format($list->qty * $job_on_project['qty'] * $list->price,0,',',',') }}</td>
                    </tr>
                    @php
                        $price_per_category += $list->qty * $job_on_project['qty'] * $list->price;
                    @endphp
                @endforeach
                @if ($price_per_category != 0)
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th> </th>
                        <th></th>
                        <th></th>
                        <th colspan="2"><b>Total</b></th>
                        <th align="right"><b>{{ number_format($price_per_category,0,',',',') }}</b></th>
                        
                    </tr>
                        @php
                            $grand_total += $price_per_category;
                        @endphp
                @endif
            @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th> </th>
                <th></th>
                <th></th>
                <th colspan="2"><b>Grand Total</b></th>
                <th align="right"><b>{{ number_format($grand_total,0,',',',') }}</b></th>
                
            </tr>
            @php
                $total += $grand_total;
            @endphp
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th> </th>
            <th></th>
            <th></th>
            <th colspan="2"><b>TOTAL</b></th>
            <th align="right"><b>{{ number_format($total,0,',',',') }}</b></th>
            
        </tr>
    </tbody>
</table>
