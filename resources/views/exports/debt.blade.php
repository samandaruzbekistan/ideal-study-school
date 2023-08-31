<table>
    <thead>
    <tr>
        <th>O'quvchi</th>
        <th>Sinf</th>
        <th>Bosqich</th>
        <th>O'quv oyi</th>
        <th>Qarzdorlik</th>
        <!-- Add more columns as needed -->
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->student->name }}</td>
            <td>{{ $payment->classes->name }}</td>
            <td>{{ $payment->classes->level }}</td>
            <td>{{ \Carbon\Carbon::parse($payment->month)->format('F Y') }}</td>
            <td>{{ $payment->indebtedness }}</td>
            <!-- Add more columns as needed -->
        </tr>
    @endforeach
    </tbody>
</table>
