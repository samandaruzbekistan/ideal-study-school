@extends('cashier.header')


@section('classes')
    active
@endsection
@section('section')



    <main class="content forma" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi sinf ochish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('cashier.new.class') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nomi <span class="text-danger">*</span></label>
                                    <input name="name" required type="text" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bosqichi <span class="text-danger">*</span></label>
                                    <input name="level" required type="number" class="form-control" placeholder="">
                                </div>
                                <label class="form-label">O'qituvchi <span class="text-danger">*</span></label>
                                <select class="form-select mb-3" name="teacher_id">
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
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
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title mb-0">Sinflar ro'yhati</h5>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-primary add ms-2">+ Yangi sinf</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Nomi</th>
                            <th>Bosqich</th>
                            <th>O'qituvchi</th>
                            <th>O'quvchi soni</th>
                            <th>Tavsilotlar</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach($classes as $subject)
                            <tr>
                                <td>
                                    <a href="{{ route('cashier.class.students', ['class_id' => $subject->id]) }}">{{ $subject->name }}</a>
                                </td>
                                <td>{{ $subject->level }}</td>
                                <td>{{ $subject->teacher->name }}</td>
                                <td>{{ $subject->students_count }}</td>
                                <td>{{ $subject->id }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection


@section('js')
    <script>




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
            message: 'Yangi sinf ochildi!',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif



        @if(session('name_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik! Bunday nomli sinf mavjud',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('teacher_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik! O\'qtuvchi boshqa sinfga biriktirilgan',
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
