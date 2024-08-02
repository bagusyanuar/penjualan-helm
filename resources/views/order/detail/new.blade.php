@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Pesanan Baru</p>
            <p class="content-sub-title">Manajemen data pesanan baru</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order') }}">Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->reference_number }}</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title" style="font-size: 0.8em">Data Pesanan</p>
        </div>
        <hr class="custom-divider"/>
        <div class="row w-100">
            <div class="col-8">
                <div class="w-100 d-flex align-items-center mb-1"
                     style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">No. Pesanan :</p>
                    <p style="margin-bottom: 0">{{ $data->reference_number }}</p>
                </div>
                <div class="w-100 d-flex align-items-center mb-1"
                     style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">Tanggal Pesanan :</p>
                    <p style="margin-bottom: 0">{{ \Carbon\Carbon::parse($data->date)->format('d F Y') }}</p>
                </div>

                <div class="w-100 d-flex align-items-center"
                     style="font-size: 0.8em; font-weight: 600; color: var(--dark);">
                    <p style="margin-bottom: 0; font-weight: 500;" class="me-2">Alamat Pengiriman :</p>
                    <p style="margin-bottom: 0">{{ $data->shipping_address }} ({{ $data->shipping_city }})</p>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
        <hr class="custom-divider"/>
        <div class="row">
            <div class="col-12">
                <table id="table-data-cart" class="display table w-100">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="12%" class="text-center middle-header">Gambar</th>
                        <th>Nama Product</th>
                        <th width="10%" class="text-center">Qty</th>
                        <th width="10%" class="text-end">Harga</th>
                        <th width="10%" class="text-end">Total</th>
                    </tr>
                    </thead>
                </table>
                <hr class="custom-divider"/>
                <div class="w-100 d-flex justify-content-end mb-1"
                     style="font-size: 0.8em; font-weight: bold; color: var(--dark);">
                    <div class="me-2 w-100 text-end" style="width: 80%">Sub Total :</div>
                    <div class="text-end" style="width: 20%">Rp.{{ number_format($data->sub_total, 0, ',', '.') }}</div>
                </div>
                <div class="w-100 d-flex justify-content-end mb-1"
                     style="font-size: 0.8em; font-weight: bold; color: var(--dark);">
                    <div class="me-2 w-100 text-end" style="width: 80%">Ongkir :</div>
                    <div class="text-end" style="width: 20%">Rp.{{ number_format($data->shipping, 0, ',', '.') }}</div>
                </div>
                <div class="w-100 d-flex justify-content-end"
                     style="font-size: 0.8em; font-weight: bold; color: var(--dark);">
                    <div class="me-2 w-100 text-end" style="width: 80%">Total :</div>
                    <div class="text-end" style="width: 20%">Rp.{{ number_format($data->total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <hr class="custom-divider"/>
        <p style="font-size: 0.8em; font-weight: 600; color: var(--dark);">Konfirmasi Pesanan</p>
        <hr class="custom-divider"/>
        <div class="w-100 justify-content-end d-flex">
            <a href="#" class="btn-add" id="btn-confirm">
                <span>Packing</span>
            </a>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table;

        function generateTableKeranjang() {
            table = $('#table-data-cart').DataTable({
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
                        data: 'product.image',
                        orderable: false,
                        className: 'middle-header text-center',
                        render: function (data) {
                            if (data !== null) {
                                return '<div class="w-100 d-flex justify-content-center">' +
                                    '<a href="' + data + '" target="_blank" class="box-product-image">' +
                                    '<img src="' + data + '" alt="product-image" />' +
                                    '</a>' +
                                    '</div>';
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'product.name',
                        className: 'middle-header',
                    },
                    {
                        data: 'qty',
                        className: 'middle-header text-center',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },

                    {
                        data: 'price',
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

        function eventChangeConfirmation() {
            $('.payment-status').on('change', function () {
                changeConfirmationHandler();
            })
        }

        function changeConfirmationHandler() {
            let val = $('input[name=payment-status]:checked').val();
            let elPanelReason = $('#panel-reason');
            if (val === '0') {
                elPanelReason.removeClass('d-none');
            } else {
                elPanelReason.addClass('d-none');
            }
        }

        function eventSaveConfirmation() {
            $('#btn-confirm').on('click', function (e) {
                e.preventDefault();
                AlertConfirm('Konfirmasi', 'Apakah anda yakin ingin melakukan konfirmasi?', function () {
                    saveConfirmationHandler();
                })
            })
        }

        async function saveConfirmationHandler() {
            try {
                await $.post(path);
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil melakukan konfirmasi data...',
                    icon: 'success',
                    timer: 700
                }).then(() => {
                    window.location.href = '/order';
                })
            } catch (e) {
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            }
        }

        $(document).ready(function () {
            generateTableKeranjang();
            eventChangeConfirmation();
            eventSaveConfirmation();
        })
    </script>
@endsection
