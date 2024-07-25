@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Product</p>
            <p class="content-sub-title">Product data management</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Data Product</p>
            <a href="{{ route('product.create') }}" class="btn-add">
                <i class='bx bx-plus'></i>
                <span>Create Product</span>
            </a>
        </div>
        <hr class="custom-divider"/>
        <table id="table-data" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center"></th>
                <th width="12%" class="text-center middle-header">Image</th>
                <th width="10%" class="text-center middle-header">Category</th>
                <th>Name</th>
                <th width="12%" class="text-center">Qty</th>
                <th width="12%" class="text-end">Price (Rp)</th>
                <th width="10%" class="text-center">Action</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table;

        function generateTable() {
            table = $('#table-data').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    // 'data': data
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventDelete();
                },
                columns: [
                    {
                        className: 'dt-control middle-header',
                        orderable: false,
                        data: null,
                        render: function () {
                            return '<i class="bx bx-plus-circle"></i>';
                        }
                    },
                    {
                        data: 'image',
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
                        data: 'category.name',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'name',
                        className: 'middle-header',
                    },
                    {
                        data: 'qty',
                        className: 'text-center middle-header',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'price',
                        className: 'text-right middle-header',
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
                            let urlEdit = path + '/' + id + '/edit';
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a href="#" class="btn-table-action-delete" data-id="' + id + '"><i class="bx bx-trash"></i></a>' +
                                '<a href="' + urlEdit + '" class="btn-table-action-edit"><i class="bx bx-edit-alt"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });
        }

        function eventDelete() {
            $('.btn-table-action-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Confirmation!', 'Are you sure?', function () {
                    let url = path + '/' + id + '/delete';
                    BaseDeleteHandler(url, id);
                })
            })
        }

        function expandRow() {
            $('#table-data tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var i = $(this).children();
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    i.removeClass('bx-minus-circle');
                    i.addClass('bx-plus-circle');
                } else {
                    // Open this row
                    row.child(descriptionElement(row.data())).show();
                    tr.addClass('shown');
                    i.removeClass('bx-plus-circle');
                    i.addClass('bx-minus-circle');
                }
            });
        }

        function descriptionElement(data) {
            let description = data['description'];
            if (description !== null) {
                let content = data['description'].toString();
                let contentString = $.parseHTML(content);
                return (
                    '<div>' + contentString[0].nodeValue + '</div>'
                );
            }
            return  (
                '<div class="w-100 d-flex justify-content-center align-items-center">' +
                '<p>no description</p>' +
                '</div>'
            )
        }

        $(document).ready(function () {
            generateTable();
            expandRow();
        })
    </script>
@endsection
