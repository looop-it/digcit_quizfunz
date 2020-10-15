<table {!! $attributes !!}>
    <thead>
    <tr>
        @foreach($headers as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
    <tr>
        @foreach($row as $item)
        <td>{!! $item !!}</td>
        @endforeach
    </tr>
    @endforeach
    <tr>
        <td colspan="{{ count($headers)}}" align="center">
            <a href="{{ $exportLink }}" class="btn btn-success" target="_blank">導出名單</a>
        </td>
    </tr>
    </tbody>
</table>