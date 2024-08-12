@extends('laporan.cetak')

@section('content')
    <div class="text-center f-bold report-title">Laporan Penjualan</div>
    <div class="text-center f-small">Periode Laporan {{ $start }} - {{ $end }}</div>
    <hr/>
    <table id="my-table" class="table display f-small">
        <thead>
        <tr>
            <th width="5%" class="text-center f-small f-semi-bold">#</th>
            <th width="15%" class="text-center f-semi-bold">Tanggal</th>
            <th class="f-semi-bold">No. Penjualan</th>
            <th width="12%" class="text-right f-semi-bold">Sub Total</th>
            <th width="12%" class="text-right f-semi-bold">Ongkir</th>
            <th width="12%" class="text-right f-semi-bold">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td class="text-center f-small middle-header">{{ $loop->index + 1 }}</td>
                <td class="f-small middle-header text-center">{{ $v->date }}</td>
                <td class="f-small middle-header">{{ $v->reference_number }}</td>
                <td class="f-small middle-header text-right">
                    {{ number_format($v->sub_total, 0, ',', '.') }}
                </td>
                <td class="f-small middle-header text-right">
                    {{ number_format($v->shipping, 0, ',', '.') }}
                </td>
                <td class="f-small middle-header text-right">
                    {{ number_format($v->total, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr />
    <div class="row">
        <div class="col-xs-7"></div>
        <div class="col-xs-4">
            <div class="text-right">
                <p class="text-right f-bold">Total Pendapatan : {{ number_format($data->sum('total'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endsection
