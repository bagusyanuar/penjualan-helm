@extends('layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", '{{ \Illuminate\Support\Facades\Session::get('failed') }}', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ \Illuminate\Support\Facades\Session::get('success') }}',
                icon: 'success',
                timer: 700
            }).then(() => {
                window.location.reload();
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Shipping Setting</p>
            <p class="content-sub-title">Shipping setting data management</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shipping') }}">Shipping Setting</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <form method="post" id="form-data">
            @csrf
            <div class="w-100 mb-3">
                <label for="city" class="form-label input-label">City <span
                        class="color-danger">*</span></label>
                <input type="text" placeholder="city name" class="text-input" id="city"
                       name="city">
                @if($errors->has('city'))
                    <span id="city-error" class="input-label-error">
                        {{ $errors->first('city') }}
                    </span>
                @endif
            </div>
            <div class="w-100 mb-3">
                <label for="price" class="form-label input-label">Price (Rp) <span
                        class="color-danger">*</span></label>
                <input type="number" placeholder="0" class="text-input" id="price"
                       name="price" value="0">
                @if($errors->has('price'))
                    <span id="name-error" class="input-label-error">
                        {{ $errors->first('price') }}
                    </span>
                @endif
            </div>
            <hr class="custom-divider"/>
            <div class="d-flex align-items-center justify-content-end w-100">
                <a href="#" class="btn-add" id="btn-save">
                    <i class='bx bx-check'></i>
                    <span>Save</span>
                </a>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        function eventSave() {
            $('#btn-save').on('click', function (e) {
                e.preventDefault();
                AlertConfirm('Confirmation!', 'Are you sure?', function () {
                    $('#form-data').submit();
                })
            })
        }

        $(document).ready(function () {
            eventSave();
        })
    </script>
@endsection
