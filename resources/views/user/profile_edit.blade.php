@extends('user/layouts.app')

@section('content')

<a href="{{ route('user.show.top') }}">←戻る</a>

<div class="row justify-content-center">
	<div class="col-md-10">
		@if (session('success'))
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif
		
		<div class="row mb-3">
			<div class="col-md-4 col-form-label text-md-end">
				<font size="5">プロフィール変更</font>
			</div>
		</div>

		<form action="{{ route('user.update.profile') }}" method="POST" enctype='multipart/form-data'>
			@csrf

			<div class="row mb-3">				
				<div class="col-md-4 col-form-label text-md-end">
					<img src="{{ asset($profile->profile_image) }}" width="100" height="100">
				</div>
				<div class="col-md-6">
					<label for="profile_image" class="col-md-6">プロフィール画像</label>
					<input type="file" name="profile_image" class="form-control">
				</div>
			</div>

			<div class="row mb-3">
				<label for="name" class="col-md-4 col-form-label text-md-end">ユーザーネーム</label>
				<div class="col-md-6">
					<input type="text" name="name" class="form-control" value="{{ old('name', $profile->name) }}">
				</div>				
			</div>

			<div class="row mb-3">
				<label for="name_kana" class="col-md-4 col-form-label text-md-end">カナ</label>
				<div class="col-md-6">
					<input type="text" name="name_kana" class="form-control" value="{{ old('name_kana', $profile->name_kana) }}">
				</div>
			</div>

			<div class="row mb-3">
				<label for="email" class="col-md-4 col-form-label text-md-end">メールアドレス</label>
				<div class="col-md-6">
					<input type="text" name="email" class="form-control" value="{{ old('email', $profile->email) }}">
				</div>
			</div>

			<div class="row mb-3">
				<label for="password" class="col-md-4 col-form-label text-md-end">パスワード</label>
				<div class="col-md-6">
					<a href="{{ route('user.show.password.edit') }}" class="btn btn-success">パスワード変更</a>
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
