<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理バナー</title>
  <link rel="stylesheet" href="{{ asset('/css/admin/banner_edit.css') }}">
</head>

<body>
    @extends('admin.layouts.app')

    @section('title', '管理トップ')

    @section('content')

  <a href="{{ route('show.top') }}" class="back">←戻る</a>

  <h1>バナー管理</h1>
  <form action="{{ route('show.banner.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <table id="bannerTable">
      <tbody>
        @foreach($banners as $banner)
        <tr>
          <td><img src="{{ asset('storage/' . $banner->image) }}" class="banner_image" id="banner-{{ $banner->id }}"></td>
          <td><input type="button" name="banner_images[]" class="file-input" onchange="previewImage(event, 1)" multiple></td>
          <td>
            <button type="button" class="delete_button" onclick="deleteExistingRow({{ $banner->id }}, '{{ route('show.banner.delete', $banner->id) }}')">-</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    @if ($errors->any())
    <script>
      let errorMessage = "";
      @foreach($errors -> all() as $error)
        errorMessage += "{{ $error }}\n";
      @endforeach
      alert(errorMessage);
    </script>
    @endif
  </form>
  @endsection
</body>
</html>