@extends('cashier.header')
@push('css')
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <!-- Add this inside the <head> section of your HTML document -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .pagination {
            height: 36px;
            margin: 0;
            padding: 0;
        }

        .pager, .pagination ul {
            margin-left: 0;
            *zoom: 1
        }

        .pagination ul {
            padding: 0;
            display: inline-block;
            *display: inline;
            margin-bottom: 0;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05)
        }

        .pagination li {
            display: inline
        }

        .pagination a {
            float: left;
            padding: 0 12px;
            line-height: 30px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-left-width: 0
        }

        .pagination .active a, .pagination a:hover {
            background-color: #f5f5f5;
            color: #94999E
        }

        .pagination .active a {
            color: #94999E;
            cursor: default
        }

        .pagination .disabled a, .pagination .disabled a:hover, .pagination .disabled span {
            color: #94999E;
            background-color: transparent;
            cursor: default
        }

        .pagination li:first-child a, .pagination li:first-child span {
            border-left-width: 1px;
            -webkit-border-radius: 3px 0 0 3px;
            -moz-border-radius: 3px 0 0 3px;
            border-radius: 3px 0 0 3px
        }

        .pagination li:last-child a {
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0
        }

        .pagination-centered {
            text-align: center
        }

        .pagination-right {
            text-align: right
        }

        .pager {
            margin-bottom: 18px;
            text-align: center
        }

        .pager:after, .pager:before {
            display: table;
            content: ""
        }

        .pager li {
            display: inline
        }

        .pager a {
            display: inline-block;
            padding: 5px 12px;
            background-color: #fff;
            border: 1px solid #ddd;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            border-radius: 15px
        }

        .pager a:hover {
            text-decoration: none;
            background-color: #f5f5f5
        }

        .pager .next a {
            float: right
        }

        .pager .previous a {
            float: left
        }

        .pager .disabled a, .pager .disabled a:hover {
            color: #999;
            background-color: #fff;
            cursor: default
        }

        .pagination .prev.disabled span {
            float: left;
            padding: 0 12px;
            line-height: 30px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-left-width: 0
        }

        .pagination .next.disabled span {
            float: left;
            padding: 0 12px;
            line-height: 30px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-left-width: 0
        }

        .pagination li.active, .pagination li.disabled {
            float: left;
            padding: 0 12px;
            line-height: 30px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-left-width: 0
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

@section('payments')
    active
@endsection
@section('section')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="col-12 col-xl-12 forma">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title mb-0">To'lovlar ro'yhati</h5>
                            </div>
                            <div class="col-6 text-end">
                                <input class="form-control w-25 d-inline" id="filtr" type="date" name="date">
                                <button class="btn btn-primary add ms-2" id="butt">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-filter align-middle">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                    </svg>
                                    Filrlash
                                </button>
                                <button class="btn btn-danger add ms-2" id="back" style="display: none">Orqaga</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>O'quvchi</th>
                            <th>Summa</th>
                            <th>Sinf</th>
                            <th>Sana</th>
                            <th>O'quv oyi</th>
                            <th>Turi</th>
                            <th>Chek</th>
                        </tr>
                        </thead>
                        <tbody id="old-data">
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <a href="{{ route('cashier.student') }}/{{ $payment->student->id }}">{{ $payment->student->name }}</a>
                                </td>
                                <td><b>{{ number_format($payment->paid, 0, '.', ' ') }}</b> so'm</td>
                                <td>{{ $payment->classes->name }}</td>
                                <td>{{ $payment->date }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->month)->format('F Y') }}</td>
                                @if($payment->type == 'cash')
                                    <td class=""><a href="#" class="badge bg-success me-1 my-1">Naqd</a></td>
                                @elseif($payment->type == 'credit_card')
                                    <td class=""><a href="#" class="badge bg-warning text-dark me-1 my-1">Karta</a></td>
                                @elseif($payment->type == 'click')
                                    <td class=""><a href="#" class="badge bg-info me-1 my-1">Click</a></td>
                                @else
                                    <td class=""><a href="#" class="badge bg-danger me-1 my-1">Bank</a></td>
                                @endif
                                <td>
                                    <button payment_id="{{ $payment->id }}" subject="{{ $payment->classes->name }}"
                                            amount="{{ number_format($payment->paid, 0, '.', ' ') }}"
                                            month="{{ $payment->month }}" name="{{ $payment->student->name }}"
                                            date="{{ $payment->date }}" class="btn btn-outline-primary chek-button ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-printer align-middle me-2">
                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                            <path
                                                d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                            <rect x="6" y="14" width="12" height="8"></rect>
                                        </svg>
                                        Chek
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tbody id="new-data" style="display: none"></tbody>
                    </table>
                </div>
                {{ $payments->links() }}

            </div>
            <div class="col-12 col-xl-4 receip" style="display: none">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Faktura</h5>
                        <h6 class="card-subtitle text-danger">Chekni chiqarishni unutmang.</h6>
                    </div>
                    <div class="card-body border m-1" id="printContent">
                        <div class="h1 text-center">
                            Ideal Study NTM
                        </div>
                        <h2 class="text-center "><b>To'landi</b></h2>
                        <div class="row h5 justify-content-between border-bottom">
                            <b class="col mb-0">Sana:</b>
                            <p class="col mb-0 text-end" id="date">{{ date('d-m-Y') }}</p>
                        </div>
                        <div class="row h5 justify-content-between">
                            <b class="col-3 mb-0">F.I.SH:</b>
                            <p class="col mb-0 text-end" id="name">Samandar Sariboyev</p>
                        </div>
                        <div class="row h5 justify-content-between">
                            <b class="col-3 mb-0">Sinf:</b>
                            <p class="col mb-0 text-end" id="subject">English pre intermediate</p>
                        </div>
                        <div class="row h5 justify-content-between">
                            <b class="col-4 mb-0">O'quv oyi:</b>
                            <p class="col mb-0 text-end" id="month">Sentabr</p>
                        </div>
                        <div class="row h2 text-center border-bottom border-top">
                            <b class="col mb-0" id="amount">300 000 so'm</b>
                        </div>
                        <div id="qrcode" class="text-center d-flex justify-content-center mb-4">

                        </div>
                        <div class="">
                            .
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">

                        {{--                            <button type="button" id="download-button" class="btn btn-info"><i class="align-middle" data-feather="download"></i> Yuklab olish</button>--}}
                        <button type="button" id="printButton" onClick="printdiv('printContent');"
                                class="btn btn-success"><i class="align-middle" data-feather="printer"></i> Chop etish
                        </button>
                        <button type="button" class="btn btn-danger text-white back-button"><i
                                class="align-middle" data-feather="x-circle"></i> Orqaga
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('js')
    <script>
        $(document).on('click', '.chek-button', function () {
            let amount = $(this).attr('amount');
            let payment_id = $(this).attr('payment_id');
            let m1 = $(this).attr('month');
            let month = moment(m1).locale('uz').format('MMMM YYYY');
            let name = $(this).attr('name');
            let date = $(this).attr('date');
            let subject = $(this).attr('subject');
            $('#amount').text(amount+' so\'m')
            $('#month').text(month)
            $('#name').text(name)
            $('#date').text(date)
            $('#subject').text(subject)
            $('#qrcode').empty()
            // generate qr code
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: "https://maktab.ideal-study.uz/receipt/"+payment_id,
                width: 200,
                height: 200,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
            $('.forma').hide();
            $('.receip').show();
        });

        $(document).on('click', '.back-button', function () {
            $('.forma').show();
            $('.receip').hide();
        });

        function printDiv(divId,
                          title) {

            let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

            mywindow.document.write(`<html><head><title>${title}</title>`);
            mywindow.document.write('</head><body >');
            mywindow.document.write(document.getElementById(divId).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        }

        var doc = new jsPDF();

        function saveDiv(divId, title) {
            doc.fromHTML(`<html><head><title>${title}</title></head><body>` + document.getElementById(divId).innerHTML + `</body></html>`);
            doc.save('div.pdf');
            // console.log(doc);
        }

        function printdiv(elem) {
            var header_str = '<html><head><title>' + document.title  + '</title></head><body style="height: 100px">';
            var footer_str = '</body></html>';
            var new_str = document.getElementById(elem).innerHTML;
            var old_str = document.body.innerHTML;
            document.body.innerHTML = header_str + new_str + footer_str;
            window.print();
            document.body.innerHTML = old_str;
            return false;
        }

        //  pdf download
        const button = document.getElementById('download-button');

        function generatePDF() {
            // Choose the element that your content will be rendered to.
            const element = document.getElementById('printContent');
            // Choose the element and save the PDF for your user.
            html2pdf().from(element).save();
        }

        (function (factory) {
            if (typeof define === 'function' && define.amd) {
                define(['moment'], factory); // AMD
            } else if (typeof exports === 'object') {
                module.exports = factory(require('../moment')); // Node
            } else {
                factory(window.moment); // Browser global
            }
        }(function (moment) {
            return moment.defineLocale('uz', {
                months: 'Yanvar_Fevral_Mart_Aprel_May_Iyun_Iyul_Avgust_Sentabr_Oktabr_Noyabr_Dekabr'.split('_'),
                monthsShort: 'янв_фев_мар_апр_май_июн_июл_авг_сен_окт_ноя_дек'.split('_'),
                weekdays: 'Якшанба_Душанба_Сешанба_Чоршанба_Пайшанба_Жума_Шанба'.split('_'),
                weekdaysShort: 'Якш_Душ_Сеш_Чор_Пай_Жум_Шан'.split('_'),
                weekdaysMin: 'Як_Ду_Се_Чо_Па_Жу_Ша'.split('_'),
                longDateFormat: {
                    LT: 'HH:mm',
                    L: 'DD/MM/YYYY',
                    LL: 'D MMMM YYYY',
                    LLL: 'D MMMM YYYY LT',
                    LLLL: 'D MMMM YYYY, dddd LT'
                },
                calendar: {
                    sameDay: '[Бугун соат] LT [да]',
                    nextDay: '[Эртага] LT [да]',
                    nextWeek: 'dddd [куни соат] LT [да]',
                    lastDay: '[Кеча соат] LT [да]',
                    lastWeek: '[Утган] dddd [куни соат] LT [да]',
                    sameElse: 'L'
                },
                relativeTime: {
                    future: 'Якин %s ичида',
                    past: 'Бир неча %s олдин',
                    s: 'фурсат',
                    m: 'бир дакика',
                    mm: '%d дакика',
                    h: 'бир соат',
                    hh: '%d соат',
                    d: 'бир кун',
                    dd: '%d кун',
                    M: 'бир ой',
                    MM: '%d ой',
                    y: 'бир йил',
                    yy: '%d йил'
                },
                week: {
                    dow: 1, // Monday is the first day of the week.
                    doy: 7  // The week that contains Jan 4th is the first week of the year.
                }
            });
        }));

        $(document).on('click', '#back', function () {
            $('#old-data').show();
            $('#new-data').hide();
            $('#back').hide();
        });

        $(document).on('click', '#butt', function () {
            let date = $('#filtr').val();
            let tableBody = $('#new-data');
            $.ajax({
                url: "{{ route('cashier.payment.filtr') }}/" + date,
                method: 'GET',
                success: function (response) {
                    response.forEach(payment => {
                        let formattedMonth = moment(payment.month).locale('uz').format('MMMM YYYY');
                        const formattedAmount = payment.paid.toLocaleString('en-US', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                        let typeMoney = '';
                        console.log(payment.type)
                        if (payment.type === 'cash') {
                            typeMoney = `<td class=""><a href="#" class="badge bg-success me-1 my-1">Naqd</a></td>`;
                        } else if (payment.type === 'credit_card') {
                            typeMoney = `<td class=""><a href="#" class="badge bg-warning text-dark me-1 my-1">Karta</a></td>`;
                        } else if (payment.type === 'click') {
                            typeMoney = `<td class=""><a href="#" class="badge bg-info me-1 my-1">Click</a></td>`;
                        } else {
                            typeMoney = `<td class=""><a href="#" class="badge bg-danger me-1 my-1">Bank</a></td>`;
                        }
                        const newRow = `
                            <tr>
                                <td>${payment.student.name}</td>
                                <td><b>${formattedAmount}</b> so'm</td>
                                <td>${payment.classes.name}</td>
                                <td>${payment.date}</td>
                                <td>${formattedMonth}</td>
                                ${typeMoney}
                            </tr>
                        `;
                        tableBody.append(newRow);
                    });
                    $('#old-data').hide();
                    $('#back').show();
                    $('#new-data').show();
                },
            });
        });
    </script>
@endsection
