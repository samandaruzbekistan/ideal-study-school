<table>
    <thead>
    <tr>
        <th>Izox</th>
        <th>Turi</th>
        <th>Summa</th>
        <th>Sana</th>
    </tr>
    </thead>
    <tbody>
    @foreach($outlays as $outlay)
        <tr>
            <td>{{ $outlay->description }}</td>
            <td>{{ $outlay->types->name }}</td>
            <td>{{ $outlay->amount }}</td>
            <td>{{ $outlay->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
