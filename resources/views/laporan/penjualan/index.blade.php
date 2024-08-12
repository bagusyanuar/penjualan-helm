@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Order Report</p>
            <p class="content-sub-title">Manajemen data report order</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Report</li>
            </ol>
        </nav>
    </div>

    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Data Pesanan</p>
        </div>
        <hr class="custom-divider"/>
        <div class="w-100">
            <label for="filter" class="form-label input-label">Filter Tanggal</label>
            <div class="d-flex align-items-center justify-content-center gap-1">
                <input type="date" class="text-input" id="start" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       name="start">
                <span style="font-weight: 600; color: var(--dark); font-size: 0.8em;">s/d</span>
                <input type="date" class="text-input" id="end" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       name="end">
                <a href="#" class="btn-add" id="btn-search">
                    <i class='bx bx-search'></i>
                    <span>Cari</span>
                </a>
                <a href="#" class="btn-print" id="btn-print">
                    <i class='bx bx-printer'></i>
                    <span>Print</span>
                </a>
            </div>
        </div>
        <hr class="custom-divider"/>
        <table id="table-data" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th>No. Penjualan</th>
                <th width="10%" class="text-end">Sub Total</th>
                <th width="10%" class="text-end">Ongkir</th>
                <th width="10%" class="text-end">Total</th>
            </tr>
            </thead>
        </table>
        <hr class="custom-divider" />
        <div class="text-right mt-3">
            <span class="mr-2 font-weight-bold">Total Pendapatan : </span>
            <span class="font-weight-bold" id="lbl-total">Rp. 0</span>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table, tablePacking, tableSent, tableFinish;

        function generateTable() {
            table = $('#table-data').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.status = 1;
                        d.start = $('#start').val();
                        d.end = $('#end').val();
                    }
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
                    let data = this.fnGetData();
                    let total = data.map(item => item['total']).reduce((prev, next) => prev + next, 0);
                    $('#lbl-total').html('Rp. ' + total.toLocaleString('id-ID'));
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'reference_number',
                        className: 'middle-header',
                    },
                    {
                        data: 'sub_total',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'shipping',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'total',
                        className: 'middle-header text-end',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                ],
            });
        }

        $(document).ready(function () {
            generateTable();

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-print').on('click', function (e) {
                e.preventDefault();
                let start = $('#start').val();
                let end = $('#end').val();
                window.open('/report-order/print?start=' + start + '&end=' + end, '_blank');
            })
        })
    </script>
@endsection
