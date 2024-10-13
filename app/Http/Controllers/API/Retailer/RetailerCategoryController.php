<?php

namespace App\Http\Controllers\API\Retailer;

use App\Http\Controllers\API\ApiController;
use App\Models\AppDomains;

use App\Models\Retailercategory;
use App\Models\Retailer;

use App\Transformers\RetailercategoryTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Doctrine\Common\Cache\Psr6\get;

class RetailerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Retailer $retailer
     * @return \Illuminate\Http\Response
     */
    public function index(Retailer $retailer)
    {
        $categories = $retailer->categories;
        return $this->showAll($categories);
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
     * @param  \App\Models\RetailerCategory  $retailerCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Retailercategory $retailerCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RetailerCategory  $retailerCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Retailercategory $retailerCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RetailerCategory  $retailerCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retailercategory $retailerCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RetailerCategory  $retailerCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retailercategory $retailerCategory)
    {
        //
    }
    public function getFeaturedCategoriesMobile(Retailercategory $retailercategory)
    {
        $categories = $retailercategory->where('featured', Retailercategory::FEATURED_CATEGORIES)->get();

        return $this->showAll($categories);
    }
    public function getparentCategoriesMobile(Retailercategory $retailercategory,Request $request)
    {
        if($request->has('subcategories')){
            $retailercategory = $retailercategory->with('subCategories');
        }
        $categories = $retailercategory->where('parent_id', Retailercategory::PARENT_CATEGORIES)->get();

        return $this->showAll($categories);
    }
    public function getRetailerSubcategories(Retailercategory $retailercategory,Request $request)
    {

        $categories = Retailercategory::with('subCategories')->where('category_id',$request->categoryId)->get();

        return $this->showAll($categories);
    }
    public function getCountriesList() {
        $appDomains = AppDomains::get();
        return $this->showAll($appDomains);
    }
   
    

}
