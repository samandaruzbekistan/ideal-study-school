@extends('admin.header')

@push('css')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
@endpush
@section('salaries')
    active
@endsection
@section('section')



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
