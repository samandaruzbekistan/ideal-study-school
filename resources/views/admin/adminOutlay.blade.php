@extends('admin.header')
@push('css')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
@endpush
@section('adminOutlay')
    active
@endsection
@section('section')

    <main class="content forma" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi xarajat qo'shish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('admin.new.outlay') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Summa <span class="text-danger">*</span></label>
                                    <input name="amount" required type="number" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Izox <span class="text-danger">*</span></label>
                                    <input name="description" required type="text" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sana <span class="text-danger">*</span></label>
                                    <input name="date" required type="date" value="{{ date('Y-m-d') }}" class="form-control" placeholder="">
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
                        <h5 class="card-title">Xarajatlar ro'yhati</h5>
                        <div>
                            <button class="btn btn-primary add"><i class="align-middle" data-feather="user-plus"></i> Qo'shish</button>
                            <button class="btn btn-success text-white ms-2" onclick="ExportToExcel('xlsx')">Excel</button>
                        </div>
                    </div>
                    <table class="table table-striped table-hover" id="tbl_exporttable_to_xls">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Summa</th>
                            <th>Izox</th>
                            <th>Sana</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($outlays as $id => $item)
                            <tr>
                                <td>{{ $id+1 }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->date }}</td>
                                <td><a href="{{ route('admin.delete.outlay', ['id' => $item->id]) }}" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 align-middle me-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></td>
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
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tbl_exporttable_to_xls');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || ('oylik.' + (type || 'xlsx')));
        }


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
            message: 'Xarajat qo\'shildi!',
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
            message: 'Xarajat o\'chirildi!',
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
