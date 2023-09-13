@extends('admin.header')
@push('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
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
            background: #3b7ddd;
            color: #fff;
        }
        .pagination li:first-child {
            border-left-width: 1px;
        }
    </style>
@endpush

@section('filter')
    active
@endsection
@section('section')
    <main class="content">

        @if(isset($start))
            <div class="container-fluid p-0">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title mb-0">To'lovlar filtri</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <h4 class="d-inline">Excel export: </h4>
                                    <button class="btn btn-success add ms-2" type="button" id="excel">To'lovlar</button>
                                    <button class="btn btn-danger add ms-2" type="button" id="outlay">Xarajatlar</button>
                                    <button class="btn btn-warning text-dark add ms-2" type="button" id="salary">Oyliklar</button>
                                    <form action="{{ route('filter.excel') }}" method="post">
                                        @csrf
                                        <input class="form-control w-25 d-inline" id="filtr" value="{{ $start }}" type="hidden" name="start">
                                        <input class="form-control w-25 d-inline" id="filtr" value="{{ $end }}" type="hidden" name="end">
                                        <button type="submit" class="d-none" id="hidden-b">s</button>
                                    </form>
                                    <form action="{{ route('filter.outlay') }}" method="post">
                                        @csrf
                                        <input class="form-control w-25 d-inline" id="filtr" value="{{ $start }}" type="hidden" name="start">
                                        <input class="form-control w-25 d-inline" id="filtr" value="{{ $end }}" type="hidden" name="end">
                                        <button type="submit" class="d-none" id="hidden-o">s</button>
                                    </form>
                                    <form action="{{ route('filter.salary') }}" method="post">
                                        @csrf
                                        <input class="form-control w-25 d-inline" id="filtr" value="{{ $start }}" type="hidden" name="start">
                                        <input class="form-control w-25 d-inline" id="filtr" value="{{ $end }}" type="hidden" name="end">
                                        <button type="submit" class="d-none" id="hidden-s">s</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Naqd</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{  number_format($payments_cash, 0, '.', ' ') }}</h1>
                            <div class="mb-0">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>Naqd</span>
                                <span class="text-muted"> pulda to'landi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Karta</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{  number_format($payments_card, 0, '.', ' ') }}</h1>
                            <div class="mb-0">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>Karta</span>
                                <span class="text-muted"> orqali to'landi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Перечисление</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="repeat"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{  number_format($payments_bank, 0, '.', ' ') }}</h1>
                            <div class="mb-0">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i>Hisob</span>
                                <span class="text-muted"> raqamga o'tkazma</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Click</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ number_format($payments_click, 0, '.', ' ') }}</h1>
                            <div class="mb-0">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i>Click</span>
                                <span class="text-muted"> o'tkazma</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Xarajat</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ number_format($outlay, 0, '.', ' ') }}</h1>
                            <div class="mb-0">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i>Xarajatlar</span>
                                <span class="text-muted"> summasi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Oldindan oylik</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart align-middle"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ number_format($salary, 0, '.', ' ') }}</h1>
                            <div class="mb-0">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i>Oylik</span>
                                <span class="text-muted"> summasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="container-fluid p-0">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title mb-0">To'lovlar filtri</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <form action="{{ route('filter.view') }}">
                                        <input class="form-control w-25 d-inline" id="filtr" type="date" name="start">
                                        <input class="form-control w-25 d-inline" id="filtr" type="date" name="end">
                                        <button class="btn btn-primary add ms-2" id="butt"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter align-middle"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg> Filrlash</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
@endsection

@section('js')
    <script>
        $(document).on('click', '#excel', function () {
            $('#hidden-b').click();
        });
        $(document).on('click', '#outlay', function () {
            $('#hidden-o').click();
        });
        $(document).on('click', '#salary', function () {
            $('#hidden-s').click();
        });
    </script>
@endsection
