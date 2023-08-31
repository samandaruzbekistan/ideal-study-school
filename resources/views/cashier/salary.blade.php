@extends('cashier.header')

@push('css')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
@endpush
@section('salaries')
    active
@endsection
@section('section')


    <main class="content add-outlay" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi oylik qoshish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('cashier.salary.new') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label class="form-label">O'qituvchi</label>
                                        <select class="form-select mb-3" required name="teacher_id">
                                            <option hidden disabled selected>Tanlang...</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">O'quv oyi</label>
                                        <select class="form-select mb-3" required name="month">
                                            <option hidden selected disabled>Tanglang...</option>
                                            <option>Yanvar</option>
                                            <option>Fevral</option>
                                            <option>Mart</option>
                                            <option>Aprel</option>
                                            <option>May</option>
                                            <option>Iyun</option>
                                            <option>Iyul</option>
                                            <option>Avgust</option>
                                            <option>Sentabr</option>
                                            <option>Oktabr</option>
                                            <option>Noyabr</option>
                                            <option>Dekabr</option>
                                        </select>
                                    </div>
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
                                <h5 class="card-title mb-0">Oyliklar ro'yhati</h5>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-success text-white ms-2" onclick="ExportToExcel('xlsx')">Excel</button>
                                <button class="btn btn-danger text-white new ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-circle align-middle"><circle cx="12" cy="12" r="10"></circle><polyline points="16 12 12 8 8 12"></polyline><line x1="12" y1="16" x2="12" y2="8"></line></svg> Oylik berish</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover" id="tbl_exporttable_to_xls">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>O'qituvchi</th>
                            <th>Summa</th>
                            <th>O'quv oyi</th>
                            <th>Sana</th>
                            <th>Izox</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach($salaries as $id => $salary)
                            <tr>
                                <td>{{ $id+1 }}</td>
                                <td>
                                    {{ $salary->teacher->name }}
                                </td>
                                <td>{{ $salary->amount }}</td>
                                <td>{{ $salary->month }}</td>
                                <td>{{ $salary->date }}</td>
                                <td>{{ $salary->description }}</td>
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

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || ('oylik.' + (type || 'xlsx')));
        }

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
