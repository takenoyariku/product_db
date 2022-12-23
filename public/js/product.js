function checkDelete(){
  if(window.confirm('削除してよろしいですか？')){
      return true;
  } else {
      return false;
  }
}

//検索機能非同期処理.searchbuttonをクリックしたらこの関数に飛ぶ
$(document).on('click', '#searchbutton', function () {
//   ～～ここで値を取得～～
  var search_data = {
    keyword_product: $("#keyword_product").val(),
    company: $("#company").val()
  }

  console.log(search_data);
// 　　～～下記からajax処理～～
  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });
  // →構文で覚えておｋ
  $.ajax({
      url: '/search',
// →次に遷移させるurl
      type: 'GET',
// →postかgetで送るか記述
      data:JSON.stringify(search_data),
// →送る内容を中に記述
      datatype:"json",
// →送る型を記述、textだったりjsonだったり、今回はtextで送っておｋ
      contentType: "application/json",
// →jsonの場所記述、大体構文
      processData: false,
      //ajax成功
  }).done(function(data){
// →成功した場合の処理を記述
      console.log('done');
      // →成功したかログを出している
      $("td").remove(".dbconect");
      $("tr").remove(".dbconect");
// →もともと書いてあった物を削除している
      console.log("delete");
      
      //ループ
      $.each(data,function(index,val){
          console.log(index);
          $("#product").append('<tr class="dbconect" id = "'+val.product_id+'"></tr>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.product_id+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect"><img src="'+'/image/'+val.img_path+'" height="300" width="300"></td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.product_name+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.price+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.stock+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.company_name+'</td>');
          $('#'+val.product_id).append('<td class="dbconect" id="'+val.product_id+'">'+'<button class="btn btn-primary" onclick="location.href='+'/product/'+val.product_id+'">詳細</button>');
          $('#'+val.product_id).append(
              '<td class="dbconect" id="'+val.product_id+'">'
                  +'<input class="deletebutton" type="button" value="削除"></td>');
      });
// →ループで取得した配列をhtmlに表記
  })
  //ajax失敗
  .fail(function(data){
      console.log("fail")
      console.log("error:"+e);
      return;
  })
});