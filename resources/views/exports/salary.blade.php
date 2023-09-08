<table>
    <thead>
    <tr>
        <th>O'quvchi</th>
        <th>Summa</th>
        <th>Oy uchun</th>
        <th>Sana</th>
        <th>Izox</th>
    </tr>
    </thead>
    <tbody>
    @foreach($salaries as $salary)
        <tr>
            <td>{{ $salary->teacher->name }}</td>
            <td>{{ $salary->amount }}</td>
            <td>{{ $salary->month }}</td>
            <td>{{ $salary->date }}</td>
            <td>{{ $salary->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
