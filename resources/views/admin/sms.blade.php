@extends('admin.header')
@push('css')

@endpush
@section('sms')
    active
@endsection
@section('section')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">SMS xabarnoma xizmati</h5>
                        <div class="card-actions float-end" role="tablist"  >
                            <a class="btn btn-sm btn-light active" data-bs-toggle="list" href="#teachers" role="tab" aria-selected="true">
                                Ustozlarga
                            </a>

                            <a class="btn btn-sm btn-light" data-bs-toggle="list" href="#parents" role="tab" aria-selected="true">
                                Ota onalarga
                            </a>

                            <a class="btn btn-sm btn-light" data-bs-toggle="list" href="#group" role="tab" aria-selected="true">
                                Sinf bo'yicha
                            </a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show " id="teachers" role="tabpanel">
                            <div class="m-3 col-6">
                                <h6 class="card-title"><span class="text-danger">Ustozlarga</span> sms jo'natish</h6>
                                <form action="{{ route('admin.sms.teachers') }}" method="post">
                                    @csrf
                                    <textarea required name="message" class="form-control" rows="3" placeholder="Xabar matni"></textarea>
                                    <input type="submit" class="btn btn-success mt-3" value="Yuborish">
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="parents" role="tabpanel">
                            <div class="m-3 col-6">
                                <h6 class="card-title"><span class="text-danger">Ota-onalarga</span> sms jo'natish</h6>
                                <form action="{{ route('sms.parents') }}" method="post">
                                    @csrf
                                    <textarea required name="message" class="form-control" rows="3" placeholder="Xabar matni"></textarea>
                                    <input type="submit" class="btn btn-success mt-3" value="Yuborish">
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="group" role="tabpanel">
                            <div class="m-3 col-6">
                                <h6 class="card-title"><span class="text-danger">Guruh</span> bo'yicha jo'natish</h6>
                                <form action="{{ route('smsBySubject') }}" method="post">
                                    @csrf
                                    <select class="form-select mb-3" required name="subject_id" id="monthInput">
                                        <option selected disabled hidden value="">Guruhni tanlang</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                    <textarea required name="message" class="form-control" rows="3" placeholder="Xabar matni"></textarea>
                                    <input type="submit" class="btn btn-success mt-3" value="Yuborish">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script>
        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'SMS xabar yuborildi',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik! Balansni tekshiring',
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


