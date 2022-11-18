<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ProductController;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'product_name' => 'required | max:255',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'required',
            'img_path' => 'required' | str_replace('public/', 'storage/', $product->image_path),
        ];
    }
}
