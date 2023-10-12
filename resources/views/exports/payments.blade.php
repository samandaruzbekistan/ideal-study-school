<table>
    <thead>
    <tr>
        <th>O'quvchi</th>
        <th>Sinf</th>
        <th>Bosqich</th>
        <th>O'quv oyi</th>
        <th>Summa</th>
        <th>To'lov turi</th>
        <th>To'lov oyi</th>
        <th>To'lov sanasi</th>
        <th>Izox</th>
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
            <td>{{ $payment->type }}</td>
            <td>{{ $payment->paid }}</td>
            <td>{{ \Carbon\Carbon::parse($payment->date)->format('F Y') }}</td>
            <td>{{ $payment->date }}</td>
            <td>{{ $payment->comment }}</td>
            <!-- Add more columns as needed -->
        </tr>
    @endforeach
    </tbody>
</table>
