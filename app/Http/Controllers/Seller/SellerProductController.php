<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerProductController extends ApiController
{
    /**
     * Get all the products a specific seller is selling
     * @param Seller $seller
     * @return JsonResponse
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }


    /**
     * Storing a new product by an existing seller
     * @param Request $request
     * @param User $seller A user who has any product associated,
     *                      so if somebody trying to publish for first time so, he/she is currently not a seller
     *                      so instead of a seller we need to receive a User
     * @return JsonResponse
     */
    public function store(Request $request, User $seller)
    {
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
            'quantity'      => 'required|integer|min:1',
            'image'         => 'required|image',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $data['status']     = Product::UNAVAILABLE_PRODUCT;
        $data['image']      = '1.jpg';
        $data['seller_id']  = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product);
    }


    /**
     * Update a product belongs to a specified seller
     * Rules: 1. We cannot update a product if the owner is different
     *        2. Cannot turn status to available if these product do not have at least one category associated
     * @param Request $request
     * @param Seller $seller
     * @param Product $product
     * @return JsonResponse
     * @throws HttpException
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity'  =>  'integer|min:1',
            'status'    =>  'in:'.Product::AVAILABLE_PRODUCT.','.Product::UNAVAILABLE_PRODUCT,
            'image'     =>  'image'
        ];
        $this->validate($request, $rules);
        // verify if the seller is the owner of the product
        $this->checkSeller($seller, $product);

        // using intersect method to avoid null or empty values
        $product->fill($request->intersect([
            'name', 'description', 'quantity'
        ]));

        if($request->has('status')){
            $product->status = $request->status;
            // if the product does not have categories, we will return an error
            if($product->isAvailable() && $product->categories->count() == 0)
            {
                return $this->errorResponse('An active product must have at least one category', 409);
            }
        }
        if($product->isClean())
        {
            return $this->errorResponse('Specify a different value to update', 409);
        }
        $product->save();
        return $this->showOne($product);
    }


    /**
     * Deleting a specified product of a specific owner
     * @param Seller $seller
     * @param Product $product
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Seller $seller, Product $product)
    {
        // check if the seller is the product owner
        $this->checkSeller($seller, $product);
        $product->delete();
        return $this->showOne($product);
    }

    //--------------------------------------- Internal helper Function -------------------------------------------//
    protected function checkSeller(Seller $seller, Product $product)
    {
        if($seller->id != $product->seller_id)
        {
            throw new HttpException(422,'The specified seller is not the owner of the product');
        }
    }
}
