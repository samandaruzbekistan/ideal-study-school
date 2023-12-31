@extends('cashier.header')

@push('css')
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <!-- Add this inside the <head> section of your HTML document -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endpush

@section('payment')
    active
@endsection
@section('section')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row">
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
                            <button type="button" onclick="saveDiv('printContent','Titsle')" class="btn btn-info"><i class="align-middle" data-feather="download"></i> Yuklab olish</button>
{{--                            <button type="button" id="download-button" class="btn btn-info"><i class="align-middle" data-feather="download"></i> Yuklab olish</button>--}}
                            <button type="button" id="printButton" onClick="printdiv('printContent');" class="btn btn-success"><i class="align-middle" data-feather="printer"></i> Chop etish</button>
                        </div>
                    </div>
                </div>
                <div class="forma col-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">To'lov</h5>
                            <h6 class="card-subtitle text-danger text-danger">Malumotlarni to'gri to'ldiring. Xatolikka yo'l qo'ymang.</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cashier.paid') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">O'quvchi</label>
                                    <input type="text" class="form-control" id="search-user">
                                    <select multiple="" class="form-control" id="selectUsers" style="display: none;"></select>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col">
                                        <label class="form-label">Oy</label>
                                        <select class="form-select flex-grow-1" required id="monthly_payments_select" name="id">
                                            <option value="all">Tanlang...</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col">
                                        <label class="form-label">Summa</label>
                                        <input type="text"  oninput="formatPaymentAmount(this)" class="form-control" name="amount" id="summa" max="300000" min="0">
                                    </div>
                                </div>
                                <div class="mb-3 col">
                                    <label class="form-label">Izox</label>
                                    <input type="text" class="form-control" required name="comment"  value="_">
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-check m-0">
                                            <input type="checkbox" name="status" value="1" class="form-check-input">
                                            <span class="form-check-label">To'liq to'landi</span>
                                        </label>
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label class="form-label d-block">To'lov turi</label>
                                        <label class="d-inline-block form-check me-4">
                                            <input name="type" type="radio" value="cash" class="form-check-input" checked>
                                            <span class="form-check-label">Naqd</span>
                                        </label>
                                        <label class="d-inline-block form-check me-4">
                                            <input name="type" type="radio" value="click" class="form-check-input">
                                            <span class="form-check-label">Click</span>
                                        </label>
                                        <label class="d-inline-block form-check me-4">
                                            <input name="type" type="radio" value="credit_card" class="form-check-input">
                                            <span class="form-check-label">Karta</span>
                                        </label>
                                        <label class="d-inline-block form-check me-4">
                                            <input name="type" type="radio" value="transfer" class="form-check-input">
                                            <span class="form-check-label">Bank orqali</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="button" id="fake-btn" class="btn btn-primary">Qabul qilish</button>
                                <button type="submit" id="submit-btn" class="d-none">Qabul qilish</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6" style="max-height: 550px; overflow-y: auto;">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Bugungi to'lovlar</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" >
                                <thead>
                                <tr>
                                    <th>Ismi</th>
                                    <th>Sinf</th>
                                    <th>Summa</th>
                                    <th>Turi</th>
                                    <th>Chek</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->student->name }}</td>
                                        <td>{{ $payment->classes->name }}</td>
                                        <td>{{ number_format($payment->paid, 0, '.', ' ') }}</td>
                                        @if($payment->type == 'cash')
                                            <td class=""><a href="#" class="badge bg-success me-1 my-1">Naqd</a></td>
                                        @elseif($payment->type == 'credit_card')
                                            <td class=""><a href="#" class="badge bg-warning text-dark me-1 my-1">Karta</a></td>
                                        @elseif($payment->type == 'click')
                                            <td class=""><a href="#" class="badge bg-info me-1 my-1">Click</a></td>
                                        @else
                                            <td class=""><a href="#" class="badge bg-danger me-1 my-1">Bank</a></td>
                                        @endif
                                        <td><button payment_id="{{ $payment->id }}" subject="{{ $payment->classes->name }}" amount="{{ number_format($payment->paid, 0, '.', ' ') }}" month="{{ $payment->month }}" name="{{ $payment->student->name }}" date="{{ $payment->date }}" class="btn btn-warning chek-button text-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer align-middle me-2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>Chek</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>
        function formatPaymentAmount(input) {
            // Remove existing non-numeric characters
            const numericValue = input.value.replace(/\D/g, '');

            // Add thousand separators
            const formattedValue = numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

            // Update the input field with the formatted value
            input.value = formattedValue;
        }


        var doc = new jsPDF();

        function saveDiv(divId, title) {
            doc.fromHTML(`<html><head><title>${title}</title></head><body>` + document.getElementById(divId).innerHTML + `</body></html>`);
            doc.save('div.pdf');
            // console.log(doc);
        }

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


        $(document).ready(function() {
            // Event listener for the input field
            $('#search-user').on('keyup', function() {
                var searchTerm = $(this).val();
                $('#group').empty();
                $('#days').val(0);
                $('#summa').val(0);
                $('#paid').val(0);
                $('#group').append($('<option></option>').attr('value', 'all').text('Tanlang...'));
                $('#monthly_payments_select').empty();
                $('#monthly_payments_select').append($('<option></option>').attr('value', 'all').text('Tanlang...'));
                if(searchTerm.length > 2) {
                    // Perform an AJAX request to fetch users based on the search term
                    $.ajax({
                        url: '{{ route('cashier.search') }}', // Replace with your actual API endpoint
                        method: 'GET',
                        data: {name: searchTerm},
                        success: function (data) {
                            // Clear the previous options in the select
                            $('#selectUsers').empty();


                            for (var i = 0; i < data.length; i++) {
                                $('#selectUsers').append($('<option></option>').attr('value', data[i].id).text(`${data[i].name} ${data[i].class.name}`));
                            }


                            // Show the select if there are matching users, hide it otherwise
                            $('#selectUsers').toggle(data.length > 0);
                        },
                        error: function () {
                            // Handle error here
                        }
                    });
                }
                else{
                    $('#selectUsers').empty();
                    $('#selectUsers').hide();
                }
            });

            // Event listener for the select options
            $('#selectUsers').on('change', function() {
                let selectedName = $(this).find('option:selected').text();
                let selectedValue = $(this).val();
                $('#search-user').val(selectedName);
                // Remove the selected option from the select
                $('#selectUsers').hide();
                let month = $('#monthly_payments_select');
                $.ajax({
                    url: '{{ route('cashier.getPayments') }}/'+selectedValue, // Replace with your actual API endpoint
                    method: 'GET',
                    success: function(monthly_payments) {
                        month.empty();
                        month.append($(`<option disabled selected hidden>Tanlang</option>`));
                        for (var i = 0; i < monthly_payments.length; i++) {
                            if (monthly_payments[i].status === 0){
                                // Format the date using moment.js to display month names in Uzbek
                                var formattedMonth = moment(monthly_payments[i].month).locale('uz').format('MMMM YYYY');
                                month.append($('<option></option>').attr('value', monthly_payments[i].id).text(formattedMonth));
                            }
                        }
                    }
                });

            });
        });



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


        $(document).on('change', '#monthly_payments_select', function() {
            let selectedPaymentId = $(this).val();

            // Make another AJAX call to retrieve the payment data based on the selected payment ID
            $.ajax({
                url: '{{ route('cashier.getPayment') }}/' + selectedPaymentId, // Replace with your route to get payment data by ID
                method: 'GET',
                success: function(data) {
                    if (data.indebtedness !== null) {
                        let paymentAmount = data.indebtedness.toString(); // Convert to string
                        let paidAmount = data.paid.toString(); // Convert to string

                        // Format the paymentAmount with thousand separators
                        const formattedValue = paymentAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

                        // Update the #summa input with the amount
                        $('#summa').val(formattedValue);
                        $('#summa').prop('max', paymentAmount);


                    }
                }
            });
        });

        $(document).on('click', '#fake-btn', function() {
            let group = $('#group').val();
            let payment = $('#monthly_payments_select').val();
            const notyf = new Notyf();
            if (group === 'all'){
                notyf.error({
                    message: 'Guruh tanlanmagan',
                    duration: 5000,
                    dismissible : true,
                    position: {
                        x : 'center',
                        y : 'top'
                    },
                });
            }
            else if(payment === 'all'){
                notyf.error({
                    message: 'Oy tanlanmagan',
                    duration: 5000,
                    dismissible : true,
                    position: {
                        x : 'center',
                        y : 'top'
                    },
                });
            }
            else {
                $('#submit-btn').click();
            }

        });

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

        button.addEventListener('click', generatePDF);

        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'To\'lov qabul qilindi!',
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


