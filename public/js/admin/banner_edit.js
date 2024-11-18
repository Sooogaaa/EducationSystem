$(function () {
  // 削除ボタンが押された際の処理
  function deleteRow(button) {
    let row = button.closest('tr');
    row.remove();
  }

  function deleteExistingRow(bannerId, deleteUrl) {
    if (confirm('削除しますか？')) {
      $.ajax({
        url: deleteUrl,
        type: 'DELETE',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            alert('削除されました');
            $(`#banner-${bannerId}`).closest('tr').remove(); // 行を削除
        },
        error: function (xhr) {
          if (xhr.responseJSON && xhr.responseJSON.error) {
              alert(xhr.responseJSON.error);
          } else {
              alert("予期しないエラーが発生しました。");
          }
        }
      });
    }
  }
}


    // 登録ボタンが押された際の処理
    $(".register").on("click", function (e) {
        e.preventDefault();

        let formData = new FormData();
        let updateUrl = "/admin/banner/ + bannerId"; // ここにバックエンドのURLを指定

        // CSRFトークンの追加
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        // 各画像ファイルのデータをフォームデータに追加
        $("#bannerTable .file-input").each(function (index, input) {
            let file = input.files[0];
            if (file) {
                formData.append(`banner_images[${index}]`, file);
            }
        });

        $.ajax({
            url: updateUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert("登録が完了しました");
                window.location.reload(); // 画面をリロードして、登録した画像を表示
            },
            error: function (xhr) {
                alert("エラーが発生しました。もう一度お試しください。");
            },
        });
    });

// イメージプレビューの処理
function previewImage(event, rowId) {
    let reader = new FileReader();
    reader.onload = function () {
        let preview = document.getElementById(`preview${rowId}`);
        preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

let rowCount = 1;
function addRow() {
  rowCount++;

  let table = document.getElementById('bannerTable').getElementsByTagName('tbody')[0];
  let newRow = table.insertRow();
  let cell1 = new.insertRow(0);
  let cell2 = new.insertRow(1);
  let cell3 = new.insertRow(2);

  let img =document.createElement('img');
  img.id = `preview${rowCount}`;
  img.className = 'banner_images';
  cell1.appendChild(img);
}

