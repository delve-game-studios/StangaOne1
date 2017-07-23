@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Words</div>

                <div class="panel-body">
                    @if (session('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                    @endif 
                    <p>
                        <a href="{{ route('words.create') }}" class="btn btn-default">Add New Word</a>
                        <a href="{{ route('words.importExport') }}" class="btn btn-default">Import CSV</a>
                    </p>
                    {{ $words->links() }}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkbox_all"></th>
                                <th>Word</th>
                                <th>Meaning</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($words as $word)
                            <tr>
                                <td><input type="checkbox" class="checkbox_delete" name="entries_to_delete[]" value="{{ $word->id }}" /></td>
                                <td>{{ $word->word }}</td>
                                <td>{{ $word->meaning }}</td>
                                <td>{{ $word->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('words.edit', $word->id) }}" class="btn btn-default">Edit</a>
                                    <form action="{{ route('words.destroy', $word->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure?');">
                                      <input type="hidden" name="_method" value="DELETE">
                                      {{ csrf_field() }}
                                      <button class="btn btn-danger">Delete</button>
                                  </form>
                              </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="3">No entries found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <form action="{{ route('words.mass_destroy') }}" method="post" onsubmit="return confirm('Are you sure?');">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="ids" id="ids" value="" />
                    <input type="submit" value="Delete selected" class="btn btn-danger" />
                </form>
                {{ $words->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
    <script>
        function getIDs()
        {
            var ids = [];
            $('.checkbox_delete').each(function () {
                if($(this).is(":checked")) {
                    ids.push($(this).val());
                }
            });
            $('#ids').val(ids.join());
        }

        $(".checkbox_all").click(function(){
            $('input.checkbox_delete').prop('checked', this.checked);
            getIDs();
        });

        $('.checkbox_delete').change(function() {
            getIDs();
        });
    </script>
@endsection