function checkDelete(){
  if(window.confirm('削除してよろしいですか？')){
      return true;
  } else {
      return false;
  }
}


$(document).on('click', '#search_button', function () {

    var param = {
        "keyword_product": $('#keyword_product').val(),
        "company": $('#company').val(),
        "min_price":$('#min_price').val(),
        "max_price":$('#max_price').val(),
    };

    console.log(param);

  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });

  $.ajax({
      url: 'search',

      type: 'POST',

      data:JSON.stringify(param),

      datatype:"text",

      contentType: "application/json",

      processData: false,

  }).done(function(data){

      $("td").remove(".dbconect");
      $("tr").remove(".dbconect");

      console.dir(data.products.data);
      
      //ループ
      $.each(data.products.data,function(index,val){
          $("#product").append('<tr class="dbconect" id = "'+val.product_id+'"></tr>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.product_id+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect"><img src="{{asset(\Storage::url('+val.img_path+'))}}" class="products-image"></td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.product_name+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.price+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.stock+'</td>');
          $('#'+val.product_id).append(
              '<td class="dbconect">'+val.company_name+'</td>');
          $('#'+val.product_id).append( '<td class="dbconect"><a href="/product/'+val.product_id+
          '"><input type="button" value="詳細表示" id="detailbutton" class="btn btn-primary"></a><td>');
          $('#'+val.product_id).append(
              '<td class="dbconect" id="'+val.product_id+'">'+'<input data-product_id = "'+val.product_id+'" id="delete_button" class="btn btn-primary" type="button" value="削除"></td>');
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

$(document).on('click', '#delete_button', function()
{

    var deleteConfirm = confirm('削除してよろしいでしょうか？');
    if(deleteConfirm == true) {
        var clickEle = $(this)
        var productID = clickEle.attr('data-product_id');

        console.log(productID);

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        })

        $.ajax({
            url: '/delete/' + productID,

            type: 'POST',

            data:JSON.stringify({
                'id': productID,
            }),
            

            datatype:"text",

            contentType: "application/json",

            processData: false,

        }).done(function(){
            clickEle.parents('tr').remove();
        })
        //ajax失敗
        .fail(function(){
            alert('エラー');
        });
    } else {
        (function(e) {
        e.preventDefault()
        });
    };
});