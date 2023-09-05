@extends('teacher.header')


@section('attendance')
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
                                <h5 class="card-title mb-0">Sinflar ro'yhati</h5>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped text-center table-hover">
                        <thead>
                        <tr>
                            <th>Nomi</th>
                            <th>Davomat</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach($classes as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                </td>
                                <td><a class="btn btn-success" href="{{ route('teacher.home',['id' => $subject->id]) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check align-middle me-2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection

