@extends('cashier.header')

@push('css')
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <!-- Add this inside the <head> section of your HTML document -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@section('students')
    active
@endsection
@section('section')
    <main class="content p-4">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-3 col-xl-2">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Profil sozlamalari</h5>
                        </div>

                        <div class="list-group list-group-flush" role="tablist">
                            <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab" aria-selected="true">
                                Account
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#payments" role="tab" aria-selected="false" tabindex="-1">
                                To'lovlar
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#sms" role="tab" aria-selected="false" tabindex="-1">
                                SMS yuborish
                            </a>
                            <a class="list-group-item list-group-item-action text-danger" data-bs-toggle="list" href="#" role="tab" aria-selected="false" tabindex="-1">
                                Delete account
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-xl-10">
                    <div class="tab-content">
                        <div class="tab-pane fade active show " id="account" role="tabpanel">
                            <div class="row">
                                <div class="card col-md-3 col-xl-4 me-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Profil malumotlari</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <h2 class=" text-dark mb-0">{{ $student->name }}</h2>
                                        <div class="text-muted mb-2">O'quvchi</div>

                                    </div>
                                    <hr class="my-0">
                                    <div class="card-body">
                                        <h5 class="h6 card-title">Sinf</h5>
                                        <a href="#" class="badge bg-primary me-1 my-1">{{ $student->class->name }}</a>
                                    </div>
                                    <hr class="my-0">
                                    <div class="card-body">
                                        <h5 class="h6 card-title">About</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="user"></i>F.I.SH: <a href="#">{{ $student->name }}</a>
                                            </li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="briefcase"></i>O'qish joyi: <a href="#">Ideal Study</a></li>
                                            <li class="mb-1"><i class="align-middle me-1" data-feather="phone"></i>Telefon: <a href="#">{{ $student->phone }}</a></li>
                                        </ul>
                                    </div>
                                    <hr class="my-0">
                                </div>
                                <div class="card col-md-6 col-xl-5 d-inline-block">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Malumotlarni yangilash</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('update.student') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="inputFirstName">F.I.SH</label>
                                                <input type="text" name="name" class="form-control" id="inputFirstName" placeholder="Ismi" value="{{ $student->name }}">
                                            </div>
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <div class="mb-3">
                                                <label class="form-label" for="inputLastName">Telefon</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">+998</span>
                                                    <input type="number" required="" name="phone" maxlength="9" value="{{ substr($student->phone, 3, 12) }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Saqlash</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payments" role="tabpanel">
                            <div class="card col-8">
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <h5 class="card-title mb-0 col">To'lovlar malumotlari</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped" >
                                        <thead>
                                            <tr>
                                                <th>O'quv oyi</th>
                                                <th>Summa</th>
                                                <th>Sana</th>
                                                <th>Izox</th>
                                            </tr>
                                        </thead>
                                        <tbody class="old-data">
                                        @foreach($student->monthlyPayments as $payment)
                                            @if($payment->status ==1)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($payment->month)->format('F Y') }}</td>
                                                    <td>{{ number_format($payment->paid, 0, '.', ' ') }}</td>
                                                    <td>{{ $payment->date  }}</td>
                                                    <td>{{ $payment->comment  }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                        <tbody class="new-data" style="display: none">

                                        </tbody>
                                    </table>

                            </div>
                        </div>
                    </div>
                        <div class="tab-pane fade" id="sms" role="tabpanel">
                            <div class="card col-8">
                                <div class="card-header">
                                    <h5 class="card-title mb-0 col"><b class="text-primary">{{ $student->name }}</b> ga sms yuborish</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('cashier.sms.student') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="number" value="{{ $student->phone }}">
                                        <div class="mb-3">
                                            <label class="form-label">SMS matni</label>
                                            <textarea class="form-control" rows="3" required name="message"></textarea>
                                        </div>
                                        <div class=" text-end">
                                            <button type="submit" class="btn btn-success">Xabar yuborish</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

            </div>

            <div class="col-12 col-xl-4 d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Faktura</h5>
                        </div>
                        <div class="card-body border m-1" id="printContent">
                            <div class="row ps-5 pe-5">
                                <img src="{{ asset('logo.png') }}" class="img-fluid">
                            </div>
                            <h1 class="text-center "><b>To'landi</b></h1>
                            <div class="row h4 justify-content-between border-bottom">
                                <b class="col mb-0">Sana:</b>
                                <p class="col mb-0 text-end" id="date"></p>
                            </div>
                            <div class="row h4 justify-content-between">
                                <b class="col-3 mb-0">F.I.SH:</b>
                                <p class="col mb-0 text-end" id="name">{{ $student->name }}</p>
                            </div>
                            <div class="row h4 justify-content-between">
                                <b class="col-3 mb-0">Guruh:</b>
                                <p class="col mb-0 text-end" id="subject"></p>
                            </div>
                            <div class="row h4 justify-content-between">
                                <b class="col-3 mb-0">Oy:</b>
                                <p class="col mb-0 text-end" id="month"></p>
                            </div>
                            <div class="row h2 text-center border-bottom border-top">
                                <b class="col mb-0" id="amount"> so'm</b>
                            </div>
                            <div id="qrcode-2" class="text-center d-flex justify-content-center">

                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button type="button" id="download-button" class="btn btn-info"><i class="align-middle" data-feather="download"></i> Yuklab olish</button>
                            <button type="button" id="printButton" onClick="printdiv('printContent');" class="btn btn-success"><i class="align-middle" data-feather="printer"></i> Chop etish</button>
                        </div>
                    </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>



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

        @if(session('updated') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'O\'quvchi malumotlari yangilandi',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

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
            message: 'Yangi o\'quvchi qo\'shildi!',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('sms_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik. Xabar yuborilmadi',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('sms_send') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Xabar yuborildi',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        function printdiv(elem) {
            var header_str = '<html><head><title>' + document.title  + '</title></head><body>';
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

        button.addEventListener('click', generatePDF);


        // generate qr code
        var qrcode = new QRCode(document.getElementById("qrcode-2"), {
            text: "https://markaz.ideal-study.uz/receip/13213",
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });



    </script>
@endsection
