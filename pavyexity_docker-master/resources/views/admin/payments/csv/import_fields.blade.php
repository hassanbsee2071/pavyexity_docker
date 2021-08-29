@extends('admin.layouts.admin')

@section('title','CSV Import')

@section('content')
    <div class="container">
    <form class="form-horizontal" method="POST" action="{{ route('admin.payments.import_process') }}">
    {{ csrf_field() }}
    <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />
    <table class="table">
    @if (isset($csv_header_fields))
        <tr>
            @foreach ($csv_header_fields as $csv_header_field)
                <th>{{ $csv_header_field }}</th>
            @endforeach
        </tr>
        @endif
        @foreach ($csv_data as $row)
            <tr>
            @foreach ($row as $key => $value)
                <td>{{ $value }}</td>
            @endforeach
            </tr>
        @endforeach
        <tr>
            @foreach ($csv_data[0] as $key => $value)
                <td>
                <select name="fields[{{ $key }}]">
                        @foreach (config('app.db_fields') as $db_field)
                            <option value="{{ (\Request::has('header')) ? $db_field : $loop->index }}"
                            @if ($db_field == 'ignore this column' && $key != 'email' && $key != 'amount' && $key != 'description' ) selected @endif @if ($key === $db_field) selected @endif >{{ $db_field }}</option>
                     
                                <!-- @if ($key === $db_field) selected @endif >{{ $db_field }}</option> -->
                        @endforeach 
                    </select>
                </td> 
            @endforeach
        </tr>
    </table>

    <button type="submit" class="btn btn-primary">
        Import Data
    </button>
    <td><a class="btn btn-danger" href = "{{ route('admin.delete_process', $csv_data_file->csv_filename) }}">Cancel</a></td>
</form>
    </div>
@endsection
