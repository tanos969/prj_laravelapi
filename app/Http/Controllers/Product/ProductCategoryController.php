<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $oCollection = $product->categories;
        return $this->showAll($oCollection);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        //se elimina la relación en la tabla pivote
        if(!$product->categories()->find($category->id))
        {
            return $this->errorResponse("The specified category is not a category of this product",404);
        }

        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }//destroy

}//ProductCategoryController
