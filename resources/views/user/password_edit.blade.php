@extends('user/layouts.app')

@section('content')

<a href="{{ route('user.show.profile') }}">←戻る</a>

<div class="row justify-content-center">
	<div class="col-md-10">
				
		<div class="row mb-3">
			<div class="col-md-4 col-form-label text-md-end">
				<font size="5">パスワード変更</font>
			</div>
		</div>

		<form action="{{ route('user.update.password') }}" method="POST" enctype='multipart/form-data'>
			@csrf

			<div class="row mb-3">
				<label for="old_password" class="col-md-4 col-form-label text-md-end">旧パスワード</label>
				<div class="col-md-6">
					<input type="text" name="old_password" class="form-control" value="{{ old('old_password') }}">
				</div>				
			</div>

			<div class="row mb-3">
				<label for="new_password" class="col-md-4 col-form-label text-md-end">新パスワード</label>
				<div class="col-md-6">
					<input type="text" name="new_password" class="form-control" value="{{ old('new_password') }}">
				</div>
			</div>

			<div class="row mb-3">
				<label for="new_password_confirmation" class="col-md-4 col-form-label text-md-end">新パスワード確認</label>
				<div class="col-md-6">
					<input type="text" name="new_password_confirmation" class="form-control" value="{{ old('new_password_confirmation') }}">
				</div>
			</div>

			<div class="offset-md-5">
				<input type="submit" class="btn btn-primary" value="登録" />				
			</div>
		</form>
		
	</div>
</div>

@if ($errors->any())
    <script>
        var errors = @json($errors->all());
        window.onload = function() {
            alert(errors.join("\n"));
        };
    </script>
@endif

@endsection
