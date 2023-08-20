@extends('admin.header')

@section('cashiers')
    active
@endsection
@section('section')

    <main class="content edit-forma" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><span id="name" class="text-danger"></span> ning parolni yangilash</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('admin.update.cashier') }}" method="post">
                                @csrf
                                <input type="hidden" name="username" id="username">
                                <div class="mb-3">
                                    <label class="form-label">Yangi parol</label>
                                    <input required name="password1" type="password" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Yangi parolni takrorlang</label>
                                    <input required name="password2" type="password" class="form-control" placeholder="">
                                </div>
                                <div class=" text-end">
                                    <button type="button" class="btn btn-danger cancel1">Bekor qilish</button>
                                    <button type="submit" class="btn btn-success">Yangilash</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <main class="content forma" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi kassir qo'shish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('admin.new.cashier') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Ism familya <span class="text-danger">*</span></label>
                                    <input name="name" required type="text" class="form-control" placeholder="">
                                </div>
                                <label class="form-label">Telefon <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">+998</span>
                                    <input type="number" required name="phone" maxlength="9" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rasm</label>
                                    <input class="form-control" type="file" name="photo" accept="image/*">
                                    <small class="text-danger">Rasm hajmi 2 mb dan oshmasligi kerak</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Login <span class="text-danger">*</span></label>
                                    <input name="username" required type="text" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Parol <span class="text-danger">*</span></label>
                                    <input name="password" required type="password" class="form-control" placeholder="">
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
                        <h5 class="card-title">Kassirlar ro'yhati</h5>
                        <button class="btn btn-primary add"><i class="align-middle" data-feather="user-plus"></i> Qo'shish</button>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Ism</th>
                            <th>Telefon</th>
                            <th>Login</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cashiers as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset('img/avatars') }}/{{ $item->photo }}" width="35" height="35" class="rounded-circle me-2" alt="Avatar"> {{ $item->name }}
                                </td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->username }}</td>
                                <td id="{{ $item->username }}" data="{{ $item->name }}" class="edit-btn" style="cursor: pointer"><i class="align-middle" data-feather="edit-2"></i></td>
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
            $('.edit-forma').hide();
            $('.teachers').show();
        });

        $(".edit-btn").on("click", function() {
            let username = $(this).attr('id');
            let name = $(this).attr('data');
            $('#username').val(username);
            $('#name').text(name);
            $('.edit-forma').show();
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

        @if(session('password_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Parollar bir xil emas!',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('size_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Rasmi hajmi 2 mb dan katta    !',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Kassir muvaffaqiyatli qo\'shildi!',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('change') == 2)
        const notyf = new Notyf();

        notyf.success({
            message: 'Parol muvaffaqiyatli o\'zgartirildi',
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
            message: 'Xatolik! Bunday login mavjud',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif
    </script>
@endsection
