<table>
    <thead>
        <tr>
            <th colspan="5">{{ $title }}</th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>排名</th>
            <th>姓名</th>
            <th>學校</th>
            <th>年級</th>
            <th>班別</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rankings as $ranking)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ranking['participant_name'] }}</td>
            <td>{{ $ranking['school_name'] }}</td>
            <td>{{ $ranking['grade'] }}</td>
            <td>{{ $ranking['class'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>