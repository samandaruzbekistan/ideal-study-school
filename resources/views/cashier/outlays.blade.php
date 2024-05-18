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
                                        <input required name="amount" type="text"  oninput="formatPaymentAmount(this)" class="form-control" placeholder="">
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
            {{ $outlays->links() }}
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

        function formatPaymentAmount(input) {
            // Remove existing non-numeric characters
            const numericValue = input.value.replace(/\D/g, '');

            // Add thousand separators
            const formattedValue = numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

            // Update the input field with the formatted value
            input.value = formattedValue;
        }

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
