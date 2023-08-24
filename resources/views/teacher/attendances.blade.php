@extends('teacher.header')


@section('attendance')
    active
@endsection
@section('section')

    <main class="content teachers">
        <div class="container-fluid p-0">
            <a href="#" class="btn btn-primary float-end mt-n1" id="new">+ Qo'shish</a>
            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">{{ $class_name }} sinf yo'qlama</h1>
            </div>
            <div class="col-12 col-xl-12">
                <div class="card old">
                    <div class="card-header">
                        <div class="card-actions float-end" role="tablist"  >
                            <a class="btn btn-sm btn-light active" data-bs-toggle="list"  onclick="getData({{ $class_id }},9)" role="tab" aria-selected="true">
                                Sentabr
                            </a>
                            <a class="btn btn-sm btn-light " data-bs-toggle="list"  onclick="getData({{ $class_id }},10)" role="tab" aria-selected="true">
                                Oktabr
                            </a>
                            <a class="btn btn-sm btn-light " data-bs-toggle="list" onclick="getData({{ $class_id }},11)" role="tab" aria-selected="true">
                                Noyabr
                            </a>
                            <a class="btn btn-sm btn-light " data-bs-toggle="list"  onclick="getData({{ $class_id }},12)" role="tab" aria-selected="true">
                                Dekabr
                            </a>
                            <a class="btn btn-sm btn-light " data-bs-toggle="list" onclick="getData({{ $class_id }},'01')" role="tab" aria-selected="true">
                                Yanvar
                            </a>
                            <a class="btn btn-sm btn-light " data-bs-toggle="list" onclick="getData({{ $class_id }},'02')" role="tab" aria-selected="true">
                                Fevral
                            </a>
                            <a class="btn btn-sm btn-light " data-bs-toggle="list" onclick="getData({{ $class_id }},'03')" role="tab" aria-selected="true">
                                Mart
                            </a>
                            <a class="btn btn-sm btn-light " data-bs-toggle="list" onclick="getData({{ $class_id }},'04')" role="tab" aria-selected="true">
                                Aprel
                            </a>
                            <a class="btn btn-sm btn-light" data-bs-toggle="list" onclick="getData({{ $class_id }},'05')" role="tab" aria-selected="true">
                                May
                            </a>
                            <a class="btn btn-sm btn-light" data-bs-toggle="list" onclick="getData({{ $class_id }},'06')" role="tab" aria-selected="true">
                                Iyun
                            </a>
                            <a class="btn btn-sm btn-light" data-bs-toggle="list" onclick="getData({{ $class_id }},'07')" role="tab" aria-selected="true">
                                Iyul
                            </a>
                            <a class="btn btn-sm btn-light" data-bs-toggle="list" onclick="getData({{ $class_id }},'08')" role="tab" aria-selected="true">
                                Avgust
                            </a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show "  role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <h4 class="card-title ps-3">O'quvchilar davomatlari</h4>
                                    <table class="table table-striped text-center table-hover border-bottom mb-3">
                                        <thead>
                                        <tr>
                                            <th>F.I.Sh</th>
                                            <th>Kelmagan kunlar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table1">
                                        @foreach($absentDay as $abset)
                                            <tr>
                                                <td>
                                                    {{ $abset->student->name }}
                                                </td>
                                                <td>
                                                    {{ $abset->total_absent_days }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <h4 class="card-title ps-3">Yo'qlama kunlari</h4>
                                    <table class="table table-striped text-center table-hover">
                                        <thead>
                                        <tr>
                                            <th>Sana</th>
                                            <th>Tafsilotlar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="table2">
                                        @foreach($attendances as $attendance)
                                            <tr>
                                                <td>
                                                    {{ $attendance->date }}
                                                </td>
                                                <td><button date="{{ $attendance->date }}" class="btn btn-primary showAttedance" id="{{ $attendance->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye align-middle"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card forma" style="display: none">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-4">
                                <h5 class="card-title mb-0">Yo'qlama</h5>
                            </div>
                            <div class="col-8 text-end">
                                <h5 class="card-title mb-0">Sana: <span class="text-danger">{{ date('d.m.Y') }} yil</span></h5>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('teacher.attendances.check') }}" method="post">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class_id }}">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Kelamagan</th>
                                <th>Telefon</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <label class="form-check">
                                            <input class="form-check-input" name="student_ids[]" type="checkbox" value="{{ $student->id }}">
                                            <span class="form-check-label">
                                          {{ $student->name }}
                                        </span>
                                        </label>
                                    </td>
                                    <td>{{ $student->phone }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-end p-3">
                            <button type="button" class="btn btn-danger cancel">Bekor qilish</button>
                            <button type="submit" class="btn btn-success">Saqlash</button>
                        </div>
                    </form>
                </div>
                <div class="card details col-6" style="display: none">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><span class="text-danger" id="sana"></span> da kelmaganlar</h5>
                    </div>
                    <table class="table table-striped text-center table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>F.I.Sh</th>
                        </tr>
                        </thead>
                        <tbody id="kelmaganlar">

                        </tbody>
                    </table>
                    <div class="card-footer text-end p-3">
                        <button type="button" class="btn btn-danger cancel2">Orqaga</button>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection


@section('js')
    <script src="{{ asset('js/ajax-functions.js') }}"></script>
    <script>
        let absentDays = $('#table1');
        let attendances = $('#table2');
        function getData(id, month){
            $.ajax({
                url: '{{ route('teacher.attendance.detail') }}/'+id+'/'+month,
                method: 'GET',
                success: function(data) {
                    absentDays.empty();
                    data[0].forEach(absent => {
                        const newRow = `
                            <tr>
                                <td>${absent.student.name}</td>
                                <td>${absent.total_absent_days}</td>
                            </tr>
                        `;
                        absentDays.append(newRow);
                    });
                    attendances.empty();
                    data[1].forEach(attendance => {
                        const newRow = `
                            <tr>
                                <td>${attendance.date}</td>
                                <td><button date="${attendance.date}" class="btn btn-primary showAttedance" id="${attendance.id}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye align-middle"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button></td>
                            </tr>
                        `;
                        attendances.append(newRow);
                    });
                }
            });
        }


        $(document).on('click', '.showAttedance', function () {
            let id = $(this).attr('id');
            let date = $(this).attr('date');
            let students = $('#kelmaganlar');
            let countdown = 0;
            $('#sana').text(date);
            $.ajax({
                url: '{{ route('teacher.attendance.day') }}/'+id,
                method: 'GET',
                success: function(data) {
                    students.empty();
                    data.forEach(day => {
                        countdown++;
                        const newRow = `
                            <tr>
                                <td>${countdown}</td>
                                <td>${day.student.name}</td>
                            </tr>
                        `;
                        students.append(newRow);
                    });
                    $('.old').hide();
                    $('.details').show();
                },
            });
        });

        $(document).on('click', '#new', function () {
            $('.old').hide();
            $('.forma').show();
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
            message: 'Malumotlar saqlandi',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif


        @if(session('error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Bugungi sanaga yo\'qlama qilingan',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif


        $(".cancel").on("click", function() {
            event.stopPropagation();
            $('.forma').hide();
            $('.old').show();
        });

        $(".cancel2").on("click", function() {
            event.stopPropagation();
            $('.details').hide();
            $('.old').show();
        });


    </script>
@endsection
