<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理バナー</title>
  <link rel="stylesheet" href="{{ asset('/css/admin/banner_edit.css') }}">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
  @extends('admin.layouts.app')

  @section('title', '管理トップ')

  @section('content')

  <a href="{{ route('show.top') }}" class="back">←戻る</a>

  <h1>バナー管理</h1>
  <form action="{{ route('show.banner.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <table id="bannerTable" class="bannerTable">
      <tbody>
        @foreach($banners as $banner)
        <tr>
          <td><img src="{{ asset('storage/' . $banner->image) }}" id="banner-{{ $banner->id }}" class="banner_image"></td>
          <td><input type="file" name="banner_images[]" class="file-input" onchange="previewImage(event, 1)" multiple></td>
          <td>
          <button class="delete_button" type="button" onclick="deleteExistingRow({{ $banner->id }}, '{{route('show.banner.delete', $banner->id }}')">ー</button>
          </td>
          @if ($errors->any())
            <script>
              let errorMessage = "";
              @foreach($errors -> all() as $error)
                errorMessage += "{{ $error }}\n";
              @endforeach
              alert(errorMessage);
            </script>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
    <button type="button" class="addition_button">+</button>
    <input type="submit" class="register" value="登録">
  </form>

  @if (session('success'))
  <script>
    alert("{{ session('success') }}");
  </script>
  @endif
</body>
<script src="{{ asset('js/admin/banner_edit.js') }}"></script>
@endsection
</html>