@extends('layouts.app')

@section('content')

<a href="{{ route('show.top') }}">←戻る</a>

<div class="row justify-content-center">
	<div class="col-md-10">
		<div>{{$article->posted_date}}</div>

		<div class="row mb-3">
			<font size="5">{{$article->title}}</font>
		</div>

		<div>{{$article->article_contents}}</div>
	</div>
</div>

@endsection
