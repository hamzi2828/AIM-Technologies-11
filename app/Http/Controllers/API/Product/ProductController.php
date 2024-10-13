<?php
namespace App\Http\Controllers\API\Product;



use App\Http\Controllers\API\ApiController;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Transformers\ProductTransformer;
use Carbon\Carbon;

class ProductController extends ApiController

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $products = Product::
            //all();
orderBy('merchant','desc') ->limit(20000)->
        //select('retailer_id','title','url','image','cashback','visits','featured','deal_of_week')->
    //   limit(10)
        get();
        return $this->showAll($products);

        // Eager Load Coupons
/*
        $includes = explode(',', \Request::get('include'));

        if (in_array('coupons', $includes)) $retailers->load('coupons');

        return $this->showAll($retailers);
*/

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }



    /**

     * Display the specified resource.

     *

     * @param  Retailer  $retailer

     * @return \Illuminate\Http\Response

     */

    public function show(Product $product)
    {
        return $this->showOne($product);
    }



   

    /**

     * Show the form for editing the specified resource.

     *

     * @param  Retailer $retailer

     * @return \Illuminate\Http\Response

     */

    public function edit(Retailer $retailer)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }
    

}