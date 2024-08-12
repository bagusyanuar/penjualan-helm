@extends('laporan.cetak')

@section('content')
    <div class="text-center f-bold report-title">Laporan Data Stok</div>
    <hr/>
    <table id="my-table" class="table display f-small">
        <thead>
        <tr>
            <th width="5%" class="text-center f-small f-semi-bold">#</th>
            <th width="15%" class="text-center f-semi-bold">Kategori</th>
            <th class="f-semi-bold">Nama</th>
            <th width="12%" class="text-center f-semi-bold">Qty</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td class="text-center f-small middle-header">{{ $loop->index + 1 }}</td>
                <td class="f-small middle-header text-center">{{ $v->category->name }}</td>
                <td class="f-small middle-header">{{ $v->name }}</td>
                <td class="f-small middle-header text-center">{{ $v->qty }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
