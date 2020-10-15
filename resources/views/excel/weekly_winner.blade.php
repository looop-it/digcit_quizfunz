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
            <th>得獎人姓名</th>
            <th>學校</th>
            <th>年級</th>
            <th>班別</th>
            <th>負責老師姓名</th>
            <th>聯絡電話</th>
            <th>聯絡電郵</th>
            <th>學校地址</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rankings as $ranking)
        @php
        $participant = $ranking->participant;
        $school = $participant->school;
        $teacher = $school->teachers->first();
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $participant->name }}</td>
            <td>{{ $school->name }}</td>
            <td>{{ $participant->grade }}</td>
            <td>{{ $participant->class }}</td>
            <td>{{ $teacher->name }}</td>
            <td>{{ $teacher->phone }}</td>
            <td>{{ $teacher->email }}</td>
            <td>{{ $teacher->address }}</td>
        </tr>
    @endforeach
    </tbody>
</table>