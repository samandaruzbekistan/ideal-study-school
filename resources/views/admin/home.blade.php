@extends('admin.header')
@push('css')
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
@endpush
@section('home')
    active
@endsection
@section('section')
    <main class="content">
        <div class="container-fluid p-0">

            {{-- Statistika --}}
            <div class="row">
                <div class="col d-flex">
                    <div class="w-100">
                        <h3 class="mb-3">Bugungi statistika</h3>
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
                                        <h1 class="mt-1 mb-3">{{  number_format($cash, 0, '.', ' ') }}</h1>
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
                                    <h1 class="mt-1 mb-3">{{  number_format($credit_card, 0, '.', ' ') }}</h1>
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
                                    <h1 class="mt-1 mb-3">{{  number_format($transfer, 0, '.', ' ') }}</h1>
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
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
                    <div class="card flex-fill w-100">
                        <div class="card-header">

                            <h5 class="card-title mb-0">To'lov turlari</h5>
                        </div>
                        <div class="card-body d-flex">
                            <div class="align-self-center w-100">
                                <div class="py-3">
                                    <div class="chart chart-xs"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                        <canvas id="chartjs-dashboard-pie" width="291" height="250" style="display: block; height: 200px; width: 233px;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>

                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <td>Naqd</td>
                                        <td class="text-end">{{ $cash }}</td>
                                    </tr>
                                    <tr>
                                        <td>Karta</td>
                                        <td class="text-end">{{ $credit_card }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bank</td>
                                        <td class="text-end">{{ $transfer }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">

                            <h5 class="card-title mb-0">To'lov qilganlar</h5>
                        </div>
                        <table class="table table-hover my-0">
                            <thead>
                            <tr>
                                <th>F.I.SH</th>
                                <th class="d-none d-xl-table-cell">Vaqti</th>
                                <th class="d-none d-xl-table-cell">Summa</th>
                                <th>To'lov turi</th>
                                <th class="d-none d-md-table-cell">O'qituchi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->student->name }}</td>
                                        <td class="d-none d-xl-table-cell">{{ $payment->date }}</td>
                                        <td class="d-none d-xl-table-cell">{{ $payment->amount_paid }}</td>
                                        @if($payment->type == 'cash')
                                            <td class=""><a href="#" class="badge bg-success me-1 my-1">Naqd</a></td>
                                        @elseif($payment->type == 'credit_card')
                                            <td class=""><a href="#" class="badge bg-warning text-dark me-1 my-1">Karta</a></td>
                                        @else
                                            <td class=""><a href="#" class="badge bg-danger me-1 my-1">Bank</a></td>
                                        @endif
                                        <td class="d-none d-md-table-cell">{{ $payment->teacher->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="m-2">{{ $payments->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Pie chart
            new Chart(document.getElementById("chartjs-dashboard-pie"), {
                type: "pie",
                data: {
                    labels: ["Naqd", "Karta", "Bank"],
                    datasets: [{
                        data: [{{ $cash }}, {{ $credit_card }}, {{ $transfer }}],
                        backgroundColor: [
                            window.theme.primary,
                            window.theme.warning,
                            window.theme.danger
                        ],
                        borderWidth: 5
                    }]
                },
                options: {
                    responsive: !window.MSInputMethodContext,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 75
                }
            });
        });
    </script>
@endsection
