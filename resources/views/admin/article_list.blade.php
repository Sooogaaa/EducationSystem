@extends('admin/layouts.app')

@section('content')

<a href="{{ route('user.show.top') }}">←戻る</a>

<div class="row justify-content-center">
	<div class="col-md-10">
		<div class="row mb-3">			
			<font size="5">お知らせ一覧</font>			
		</div>

		<a href="{{ route('admin.show.article.create') }}" class="btn btn-success">新規登録</a>

		<table class="table">
			<thead>
				<tr>			
					<th>投稿日時</th>
					<th>タイトル</th>
					<th></th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach ($items as $item)
				<tr>
					<td>{{ $item->posted_date }}</td>
					<td>{{ $item->title }}</td>
					<td><a href="{{ route('admin.show.article.edit', $item->id) }}" class="btn btn-success">変更する</a></td>
					<td>
						<form action="{{ route('admin.article.destroy', $item->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger">削除</button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection
