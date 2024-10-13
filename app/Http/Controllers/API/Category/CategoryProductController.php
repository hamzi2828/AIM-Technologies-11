<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\API\ApiController;
use App\Models\Productcategory;
use App\Models\Product;

use Illuminate\Http\Request;

class CategoryProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Retailercategory $category
     * @return \Illuminate\Http\Response
     */
    public function products(Productcategory $category)
    {
        //check for null and return products of the descendant categories
   //     if(is_null($category->alternates) || (empty($category->alternates))) {
           $ids = $category->descendants->pluck('id');
          //  return collect(); //return an empty collection
          $products = Product::whereIn('categoryid', $ids)->get();

           return $this->showAll($products);
     //   }
     /*   
        $alternates = explode(PHP_EOL,trim($category->alternates));
      
           $alternate = $alternates[0];
            $alternate = rtrim($alternate, '/');   //REMOVE RIGHT SLASH /
            
            
            if($alternate[0] === '='){              //EXACT MATCH
                $alternate = ltrim($alternate, '=/');
                $products = Product::where('category','=',$alternate);

            }
            elseif($alternate[0] === '?'){       //REGULARE EXPR
                $alternate = ltrim($alternate, '?/');
                $products = Product::where('category','regexp',$alternate);

            }

            
            if (sizeof($alternates) > 1) {    //MORE THAN ONE ALTERNATES
                     unset($alternates[0]);   // REMOVE THE FIRST ONE
                     if (($key = array_search('\r', $alternates)) !== false) {
                        unset($alternates[$key]);
                     }     
                   //  return $alternates;
                     foreach($alternates as $alternate){
                        $alternate = rtrim($alternate, '/');

                         if($alternate[0] === '='){
                             $alternate = ltrim($alternate, '=/');
                            $products = $products->orWhere('category','=',$alternate);

                        }
                         elseif($alternate[0] === '?'){
                             $alternate = ltrim($alternate, '?/');
                            $products = $products->orWhere('category','regexp',$alternate);

                        }
                    }

            }
        
        return $this->showAll($products->get());
        
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
     * @param  \App\Models\Retailercategory  $retailercategory
     * @return \Illuminate\Http\Response
     */
    public function show(Retailercategory $retailercategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Retailercategory  $retailercategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Retailercategory $retailercategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Retailercategory  $retailercategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retailercategory $retailercategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Retailercategory  $retailercategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retailercategory $retailercategory)
    {
        //
    }
}
