<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\API\ApiController;
use App\Models\Retailercategory;
use Illuminate\Http\Request;

class CategoryRetailerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Retailercategory $category
     * @return \Illuminate\Http\Response
     */
    public function index(Retailercategory $category)
    {
        $retailers = $category->retailers;
        return $this->showAll($retailers);
    }
    public function subcategories( Retailercategory $category)
    {
        $subcategories = $category->subCategories;
        return $this->showAll($subcategories);
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
