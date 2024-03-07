@foreach ($dataMaterials as $dataMaterial)
    <table class="table table-bordered">
        <thead>
            <tr>
                <td style="background-color: #90B9F7" colspan="6"><b>{{ $dataMaterial['materialCategory'] }}</b></td>
            </tr>
            <tr style="font-weight: bold">
                <th style=""></th>
                <th></th>
                <th>index</th>
                <th>Satun</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>

        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($dataMaterial['listMaterial'] as $list)

                <tr style="font-size: 12px;">
                    <td style="width: 10%">
                        <button onclick="editItemOfJob('{{$list->id}}')" class="btn btn-sm btn-warning">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button onclick="deleteItemOfJob('{{$list->id}}')" class="btn btn-sm btn-danger">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                    <td>{{$list->material_name}}</td>
                    <td>{{$list->qty}}</td>
                    <td>{{$list->unit}}</td>
                    <td>{{number_format($list->price,0,',','.')}}</td>
                    <td>{{ number_format($list->qty* $list->price,0,',','.')}}</td>
                </tr>
                @php
                    $total += $list->qty * $list->price;
                @endphp

            @endforeach
            <tr style="font-size: 12px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Rp. {{ number_format($total,0,',','.')}}</td>
            </tr>
        </tbody>
    </table>
@endforeach
