@extends('admin.layouts.admin')

@section('title','CSV Import')

@section('content')

<form class="form-horizontal" method="POST" action="{{ route('admin.import_process') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
                                @if (isset($csv_header_fields))
                            <tr>
                                @foreach ($csv_header_fields as $value)
                                    <th>{{ $value }}</th>
                                @endforeach
                            </tr>
                            @endif
        </thead>
        <tbody>
       
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
                                                    @if ($key === $db_field) selected @endif>{{ $db_field }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
      
            
        </tbody>
        
    </table>
    
                         <button type="submit" class="btn btn-primary">
                            Import Data
                         </button>
                         <td><a class="btn btn-danger" href = "{{ route('admin.delete_process', $csv_data_file->csv_filename) }}">Cancel</a></td>
    </form>

    <script>
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>
@endsection

@section('scripts')
@parent
{{ Html::script('https://code.jquery.com/jquery-3.5.1.js') }}
{{ Html::script('https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js') }}
{{ Html::script('https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js') }}

@endsection
