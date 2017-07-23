@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Import CSV</div>

                <div class="panel-body">
                    @if ($message = Session::get('success'))
					<div class="alert alert-success" role="alert">
						{{ Session::get('success') }}
					</div>
					@endif

					@if ($message = Session::get('error'))
						<div class="alert alert-danger" role="alert">
							{{ Session::get('error') }}
						</div>
					@endif

					<h3>Import File Form:</h3>
					<form action="{{ route('words.importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

						<input type="file" name="import_file" />
						{{ csrf_field() }}
						<br/>

						<button class="btn btn-primary">Import CSV or Excel File</button>

					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection