@extends('admin.header')


@section('subjects')
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
                                <h5 class="card-title mb-0">Guruhlar ro'yhati</h5>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Nomi</th>
                            <th>Narxi</th>
                            <th>O'qituvchi</th>
                            <th>Darslar soni</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach($classes as $subject)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.subject.students', ['subject_id' => $subject->id]) }}">{{ $subject->name }}</a>
                                </td>
                                <td><b>{{ number_format($subject->price, 0, '.', ' ') }}</b> so'm</td>
                                <td>{{ $subject->teacher->name }}</td>
                                <td>{{ $subject->lessons_count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection

