@extends('layouts.app')

@section('content')

<a href="{{ route('show.article.list') }}">←戻る</a>

<div class="row justify-content-center">
	<div class="col-md-10">
		<div class="row mb-3">
			<div class="col-md-4 col-form-label text-md-end">
				<font size="5">
					{{ isset($article) ? 'お知らせ変更' : 'お知らせ新規登録' }}
				</font>
			</div>
		</div>

		<form action="{{ isset($article) ? route('article.update', $article->id) : route('article.store') }}" method="POST" enctype='multipart/form-data'>
			@csrf
			@if(isset($article))
			    @method('PUT')
            @endif

			<div class="row mb-3">
				<label for="posted_date" class="col-md-4 col-form-label text-md-end">投稿日時</label>
				<div class="col-md-6">
					<input type="date" name="posted_date" class="form-control" value="{{ old('posted_date', $article->posted_date ?? '') }}">
				</div>				
			</div>

			<div class="row mb-3">
				<label for="title" class="col-md-4 col-form-label text-md-end">タイトル</label>
				<div class="col-md-6">
					<input type="text" name="title" class="form-control" value="{{ old('title', $article->title ?? '') }}">
				</div>
			</div>
			
			<div class="row mb-5">
				<label for="article_contents" class="col-md-4 col-form-label text-md-end">本文</label>
				<div class="col-md-6">
					<textarea type="text" name="article_contents" class="form-control">{{ old('article_contents', $article->article_contents ?? '') }}</textarea>
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
