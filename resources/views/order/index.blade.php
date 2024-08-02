@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Order</p>
            <p class="content-sub-title">Manajemen data order</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">ORder</li>
            </ol>
        </nav>
    </div>
    <ul class="nav nav-pills mb-3 custom-tab-pills" id="transaction-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link custom-tab-link active" id="pills-new-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-new"
                    type="button" role="tab" aria-controls="pills-new" aria-selected="true">
                Pesanan Baru
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link custom-tab-link" id="pills-packing-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-packing"
                    type="button" role="tab" aria-controls="pills-packing" aria-selected="false">
                Pesanan Di Packing
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link custom-tab-link" id="pills-sent-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-sent"
                    type="button" role="tab" aria-controls="pills-sent" aria-selected="false">
                Pesanan Di Kirim
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link custom-tab-link" id="pills-finish-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-finish"
                    type="button" role="tab" aria-controls="pills-finish" aria-selected="false">
                Selesai
            </button>
        </li>
    </ul>
    <div class="tab-content" id="transaction-content">
        <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
            <div class="card-content">
                <div class="content-header mb-3">
                    <p class="header-title">Data Pesanan Baru</p>
                </div>
                <hr class="custom-divider"/>
                <table id="table-data-new-order" class="display table w-100">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>No. Penjualan</th>
                        <th width="10%" class="text-end">Sub Total</th>
                        <th width="10%" class="text-end">Ongkir</th>
                        <th width="10%" class="text-end">Total</th>
                        <th width="8%" class="text-center"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-packing" role="tabpanel" aria-labelledby="pills-packing-tab">
            <div class="card-content">
                <div class="content-header mb-3">
                    <p class="header-title">Data Pesanan Di Packing</p>
                </div>
                <hr class="custom-divider"/>
                <table id="table-data-packing-order" class="display table w-100">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>No. Penjualan</th>
                        <th width="10%" class="text-end">Sub Total</th>
                        <th width="10%" class="text-end">Ongkir</th>
                        <th width="10%" class="text-end">Total</th>
                        <th width="8%" class="text-center"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-sent" role="tabpanel" aria-labelledby="pills-sent-tab">
            <div class="card-content">
                <div class="content-header mb-3">
                    <p class="header-title">Data Pesanan Di Packing</p>
                </div>
                <hr class="custom-divider"/>
                <table id="table-data-sent-order" class="display table w-100">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>No. Penjualan</th>
                        <th width="10%" class="text-end">Sub Total</th>
                        <th width="10%" class="text-end">Ongkir</th>
                        <th width="10%" class="text-end">Total</th>
                        <th width="8%" class="text-center"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-finish" role="tabpanel" aria-labelledby="pills-finish-tab">
            <div class="card-content">
                <div class="content-header mb-3">
                    <p class="header-title">Data Pesanan Selesai</p>
                </div>
                <hr class="custom-divider"/>
                <table id="table-data-finish-order" class="display table w-100">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>No. Penjualan</th>
                        <th width="10%" class="text-end">Sub Total</th>
                        <th width="10%" class="text-end">Ongkir</th>
                        <th width="10%" class="text-end">Total</th>
                        <th width="8%" class="text-center"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table, tablePacking, tableSent, tableFinish;

        function generateTableNewOrder() {
            table = $('#table-data-new-order').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.status = 1
                    }
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
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
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            let urlDetail = path + '/' + id + '/pesanan-baru';
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a style="color: var(--dark-tint)" href="' + urlDetail + '" class="btn-table-action" data-id="' + id + '"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });
        }

        function generateTablePackingOrder() {
            tablePacking = $('#table-data-packing-order').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.status = 2
                    }
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
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
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            let urlDetail = path + '/' + id + '/pesanan-packing';
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a style="color: var(--dark-tint)" href="' + urlDetail + '" class="btn-table-action" data-id="' + id + '"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });

        }

        function generateTableSentOrder() {
            tableSent = $('#table-data-sent-order').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.status = 3
                    }
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
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
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            let urlDetail = path + '/' + id + '/pesanan-di-kirim';
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a style="color: var(--dark-tint)" href="' + urlDetail + '" class="btn-table-action" data-id="' + id + '"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });

        }

        function generateTableFinishOrder() {
            tableFinish = $('#table-data-finish-order').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.status = 4
                    }
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
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
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            let urlDetail = path + '/' + id + '/pesanan-selesai';
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a style="color: var(--dark-tint)" href="' + urlDetail + '" class="btn-table-action" data-id="' + id + '"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });

        }

        function eventChangeTab() {
            $('#transaction-tab').on('shown.bs.tab', function (e) {
                if (e.target.id === 'pills-packing-tab') {
                    tablePacking.columns.adjust();
                }

                if (e.target.id === 'pills-sent-tab') {
                    tableSent.columns.adjust();
                }

                if (e.target.id === 'pills-finish-tab') {
                    tableFinish.columns.adjust();
                }
            })
        }

        $(document).ready(function () {
            generateTableNewOrder();
            generateTablePackingOrder();
            generateTableSentOrder();
            generateTableFinishOrder();
            eventChangeTab();
        })
    </script>
@endsection
