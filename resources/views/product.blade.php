@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div>
                    <form id="search">
                        <div>
                            <label for="keyword_product">キーワード</label>
                            <input type="text" id="keyword_product" name="keyword_product" value="@if (isset($keyword_product)) {{ $keyword_product }} @endif">
                            <select id="company" name="company">
                                <option value="">全て</option>
                                @foreach ($company_list as $company_item)
                                    <option value="{{ $company_item -> company_name }}">{{ $company_item -> company_name }}</option>
                                @endforeach
                            </select>
                            @csrf
                        </div>
                        <div>
                            <label for="">下限価格</label>
                            <input type="text" id="min_price" name="min_price">
                            <label for="">〜上限価格</label>
                            <input type="text" id="max_price" name="max_price">
                        </div>
                        <input type="button" value="検索" id="search_button">
                    </form>
                </div>
                <div class="card-header">商品一覧</div>

                <div class="card-body">
                    @if (session('err_msg'))
                    <p class="text-danger">
                        {{ session('err_msg') }}
                    </p>
                    @endif

                    @if($products -> count())
                    <table class="table table-striped" id="product">
                        <tr>
                            <th>@sortablelink('id', 'ID')</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>@sortablelink('price', '価格')</th>
                            <th>@sortablelink('stock', '在庫数')</th>
                            <th>メーカー名</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($products as $product)
                        <tr class="dbconect">
                            <td class="dbconect">{{ $product -> product_id }}</td>
                            <td class="dbconect"><img src="{{asset(\Storage::url($product -> img_path))}}"alt="" class="products-image"></td>
                            <td class="dbconect">{{ $product -> product_name }}</td>
                            <td class="dbconect">{{ $product -> price }}</td>
                            <td class="dbconect">{{ $product -> stock }}</td>
                            <td class="dbconect">{{ $product -> company_name }}</td>
                            <td class="dbconect">                        
                                <button class="btn btn-primary" onclick="location.href='/product/{{ $product -> product_id }}'">詳細</button>
                            </td>
                            <td class="dbconect" id="{{ $product -> product_id }}">
                                <input data-product_id = "{{ $product->product_id }}" type="button" class="btn btn-primary" value="削除" id="delete_button">
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div>
                        {{ $products -> links() }}
                    </div>


                    @else
                    <p>見つかりませんでした。</p>
                    @endif

                    <div class="product-register">
                        <button class="btn btn-primary" onclick="location.href='{{ route('create') }}'">新規登録</button>
                    </div>
                </div>
            </div>
         
        </div>
    </div>
</div>
@endsection
