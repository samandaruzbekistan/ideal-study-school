@extends('cashier.header')

@push('css')
    <style>
        .pagination{height:36px;margin:0;padding: 0;}
        .pager,.pagination ul{margin-left:0;*zoom:1}
        .pagination ul{padding:0;display:inline-block;*display:inline;margin-bottom:0;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);-moz-box-shadow:0 1px 2px rgba(0,0,0,.05);box-shadow:0 1px 2px rgba(0,0,0,.05)}
        .pagination li{display:inline}
        .pagination a{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .active a,.pagination a:hover{background-color:#f5f5f5;color:#94999E}
        .pagination .active a{color:#94999E;cursor:default}
        .pagination .disabled a,.pagination .disabled a:hover,.pagination .disabled span{color:#94999E;background-color:transparent;cursor:default}
        .pagination li:first-child a,.pagination li:first-child span{border-left-width:1px;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;border-radius:3px 0 0 3px}
        .pagination li:last-child a{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0}
        .pagination-centered{text-align:center}
        .pagination-right{text-align:right}
        .pager{margin-bottom:18px;text-align:center}
        .pager:after,.pager:before{display:table;content:""}
        .pager li{display:inline}
        .pager a{display:inline-block;padding:5px 12px;background-color:#fff;border:1px solid #ddd;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px}
        .pager a:hover{text-decoration:none;background-color:#f5f5f5}
        .pager .next a{float:right}
        .pager .previous a{float:left}
        .pager .disabled a,.pager .disabled a:hover{color:#999;background-color:#fff;cursor:default}
        .pagination .prev.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .next.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination li.active, .pagination li.disabled {
            float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0
        }
        .pagination li.active {
            background: #364E63;
            color: #fff;
        }
        .pagination li:first-child {
            border-left-width: 1px;
        }
    </style>
@endpush

@section('students')
    active
@endsection
@section('section')



    <main class="content forma" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi o'quvchi qo'shish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('cashier.new.student') }}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-label">F.I.Sh <span class="text-danger">*</span></label>
                                        <input name="name" required type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label">Kelgan sana <span class="text-danger">*</span></label>
                                        <input name="date" required type="date" value="{{ date('Y-m-d') }}"  class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="district" class="form-label">Sinf</label> <sup class="text-danger">*</sup>
                                        <select  name="class_id" required class="form-select">
                                            <option disabled="" selected="" hidden>Tanlang</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">Oylik to'lov<span class="text-danger">*</span></label>
                                        <input type="number" required name="amount" class="form-control">
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">Ota-ona telefoni<span class="text-danger">*</span></label>
                                        <div class="input-group mb-3 col-6">
                                            <span class="input-group-text">+998</span>
                                            <input type="number" required name="phone" maxlength="9" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-sm-4 col-4">
                                        <label for="region" class="form-label">Viloyat</label> <sup class="text-danger">*</sup>
                                        <select id="region" required="" class="form-select" name="region_id">
                                            <option disabled="" selected="" hidden>Tanlang</option>
                                            <option value="2">Andijon viloyati</option>
                                            <option value="3">Buxoro viloyati</option>
                                            <option value="12">Farg‘ona viloyati</option>
                                            <option value="4">Jizzax viloyati</option>
                                            <option value="7">Namangan viloyati</option>
                                            <option value="6">Navoiy viloyati</option>
                                            <option value="5">Qashqadaryo viloyati</option>
                                            <option value="1">Qoraqalpog‘iston Respublikasi</option>
                                            <option value="8">Samarqand viloyati</option>
                                            <option value="10">Sirdaryo viloyati</option>
                                            <option value="9">Surxandaryo viloyati</option>
                                            <option value="14">Toshkent shahri</option>
                                            <option value="11">Toshkent viloyati</option>
                                            <option value="13">Xorazm viloyati</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-4 col-4">
                                        <label for="district" class="form-label">Tuman</label> <sup class="text-danger">*</sup>
                                        <select id="district" name="district_id" required class="form-select">
                                            <option disabled="" selected="" hidden>Tanlang</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-4 col-4">
                                        <label for="quarter" class="form-label">Mahalla</label> <sup class="text-danger">*</sup>
                                        <select id="quarter" name="quarter_id" required class="form-select">
                                            <option disabled="" selected="" hidden>Tanlang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" text-end">
                                    <button type="button" class="btn btn-danger cancel">Bekor qilish</button>
                                    <button type="submit" class="btn btn-success">Qo'shish</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <main class="content teachers">
        <div class="container-fluid p-0">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">O'quvchilar ro'yhati</h5>
                        <button class="btn btn-primary add ms-2">+ Yangi o'quvchi</button>
                    </div>
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>F.I.Sh</th>
                            <th class="d-none d-sm-table-cell">Telefon</th>
                            <th>Sinf</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach($students as $id => $student)
                            <tr>
                                <td>
                                    {{ $id+1 }}
                                </td>
                                <td><a href="{{ route('cashier.student') }}/{{ $student->id }}">{{ $student->name }}</a></td>
                                <td class="d-none d-sm-table-cell">{{ $student->phone }}</td>
                                <td class="d-none d-sm-table-cell">{{ $student->class->name }}</td>
{{--                                <td style="cursor: pointer"><a href="{{ route('cashier.add_to_subject') }}/{{ $student->id }}" class="btn btn-success add-student"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus align-middle"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></a></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $students->links() }}
        </div>
    </main>
@endsection


@section('js')
    <script>
        $(document).on('change', '#region', function() {
            let selectedId = $(this).val();
            let firstOption = $('#district option:first');

            $("#district").empty();
            $('#district').append('<option value="" disabled selected hidden>Tanlash...</option>');
            $.ajax({
                url: '{{ route('cashier.district.regionID') }}/' + selectedId,
                method: 'GET',
                success: function(data) {
                    $("#district").empty();
                    $('#district').append('<option value="" disabled selected hidden>Tanlash...</option>');
                    $.each(data, function(key, value){
                        $('#district').append('<option value="' + value.id+ '">' + value.name + '</option>');
                    });
                }
            });
        });

        $(document).on('change', '#district', function() {
            let selectedId = $(this).val();
            let firstOption = $('#quarter option:first');

            $("#quarter").empty();
            $('#quarter').append('<option value="" disabled selected hidden>Tanlash...</option>');
            $.ajax({
                url: '{{ route('cashier.quarter.districtID') }}/' + selectedId,
                method: 'GET',
                success: function(data) {
                    $("#quarter").empty();
                    $('#quarter').append('<option value="" disabled selected hidden>Tanlash...</option>');
                    $.each(data, function(key, value){
                        $('#quarter').append('<option value="' + value.id+ '">' + value.name + '</option>');
                    });
                }
            });
        });


        $(document).on('click', '.new-student', function () {
            $('.add-student').show();
            $('.teachers').hide();
        });


        @if($errors->any())
        const notyf = new Notyf();

        @foreach ($errors->all() as $error)
        notyf.error({
            message: '{{ $error }}',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endforeach

        @endif


        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Yangi o\'quvchi qo\'shildi!',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('username_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik! Bunday ism mavjud',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        $(".add").on("click", function() {
            $('.forma').show();
            $('.teachers').hide();
        });

        $(".cancel").on("click", function() {
            event.stopPropagation();
            $('.forma').hide();
            $('.teachers').show();
        });

        $(".cancel1").on("click", function() {
            event.stopPropagation();
            $('.add-student').hide();
            $('.teachers').show();
        });

    </script>
@endsection
