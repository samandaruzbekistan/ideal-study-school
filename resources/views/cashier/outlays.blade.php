@extends('cashier.header')


@section('outlays')
    active
@endsection
@section('section')

    <main class="content add-student" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi xarajat turi qo'shish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('cashier.outlay.new.type') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nomi</label>
                                    <input required name="name" type="text" maxlength="255" class="form-control" placeholder="">
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

    <main class="content add-outlay" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi xarajat</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('cashier.outlay.new') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Turi</label>
                                    <select class="form-select mb-3" name="type_id">
                                        @foreach($types as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Summa</label>
                                        <input required name="amount" min="0" type="number"class="form-control" placeholder="">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Sana</label>
                                        <input required name="date" type="date" max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Izox</label>
                                    <textarea class="form-control" rows="3" name="description">.</textarea>
                                </div>
                                <div class=" text-end">
                                    <button type="button" class="btn btn-danger cancel">Bekor qilish</button>
                                    <button type="submit" class="btn btn-success">Saqlash</button>
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
                                <h5 class="card-title mb-0">Guruhlar ro'yhati</h5>
                            </div>
                            <div class="col-6 text-end">
                                <i class="align-middle" data-feather="filter"></i>
                                <select class="form-select mb-3" style="width: auto; display: inline-block" id="teacher">
                                    <option value="all">Barchasi</option>
                                    @foreach($types as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-info add ms-2">+ Xarajat turi</button>
                                <button class="btn btn-danger text-white new ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-circle align-middle"><circle cx="12" cy="12" r="10"></circle><polyline points="16 12 12 8 8 12"></polyline><line x1="12" y1="16" x2="12" y2="8"></line></svg> Xarajat</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Turi</th>
                            <th>Summa</th>
                            <th>Sana</th>
                            <th>Izox</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach($outlays as $id => $outlay)
                            <tr>
                                <td>{{ $id+1 }}</td>
                                <td>
                                    {{ $outlay->types->name }}
                                </td>
                                <td>{{ $outlay->amount }}</td>
                                <td>{{ $outlay->date }}</td>
                                <td>{{ $outlay->description }}</td>
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

        $(document).on('change', '#teacher', function() {
            let selectedId = $(this).val();
            if(selectedId === 'all'){
                window.location = "{{ route('cashier.outlays') }}";
            }
            $("#tbody").empty();

            $.ajax({
                url: '{{ route('cashier.outlays.get') }}/' + selectedId,
                method: 'GET',
                success: function(data) {
                    const tableBody = $("#tbody");
                    let countdown = 0;
                    data.forEach(outlay => {
                        console.log(data)
                        countdown++;
                        const newRow = `
                            <tr>
                                <td>${countdown}</td>
                                <td><b>${outlay.types.name}</b></td>
                                <td>${outlay.amount}</td>
                                <td>${outlay.date}</td>
                                <td>${outlay.description}</td>
                            </tr>
                        `;
                        tableBody.append(newRow);
                    });

                }
            });
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


        @if(session('add') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Yangi xarajat turi qo\'shildi',
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
            message: 'Yangi xarajat qo\'shildi',
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
            message: 'Xatolik! Bunday xarajat turi mavjud',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        $(".add").on("click", function() {
            $('.add-student').show();
            $('.teachers').hide();
        });

        $(".new").on("click", function() {
            $('.add-outlay').show();
            $('.teachers').hide();
        });

        $(".cancel").on("click", function() {
            event.stopPropagation();
            $('.add-student').hide();
            $('.add-outlay').hide();
            $('.teachers').show();
        });



    </script>
@endsection
