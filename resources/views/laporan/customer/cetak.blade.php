@extends('laporan.cetak')

@section('content')
    <div class="text-center f-bold report-title">Laporan Data Customer</div>
    <hr/>
    <table id="my-table" class="table display f-small">
        <thead>
        <tr>
            <th width="5%" class="text-center f-small f-semi-bold">#</th>
            <th width="15%" class="text-center f-semi-bold">Username</th>
            <th class="f-semi-bold">Nama</th>
            <th width="12%" class="text-center f-semi-bold">No. HP</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td class="text-center f-small middle-header">{{ $loop->index + 1 }}</td>
                <td class="f-small middle-header text-center">{{ $v->user->username }}</td>
                <td class="f-small middle-header">{{ $v->name }}</td>
                <td class="f-small middle-header text-center">{{ $v->phone }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
