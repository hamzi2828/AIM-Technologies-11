<?php 
namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use League\Fractal;

trait ApiResponser{

	private function successResponse($data, $code){
		return response()->json($data,$code);
	}

	protected function errorResponse($message, $code){
		return response()->json(['error' => $message,'code'=> $code],$code);
	}

	protected function showAll(Collection $collection, $code = 200){
		if($collection->isEmpty()){
			return $this->successResponse(['data' => $collection] ,$code );
		}
		$transformer = $collection->first()->transformer;
	
	
	    $collection = $this->filterData($collection, $transformer);
		$collection = $this->sortData($collection, $transformer);
		
		$collection = $this->paginate($collection);
		$collection = $this->transformData($collection,$transformer);
		if(!config('app.debug')){
			$collection = $this->cacheResponse($collection);
		}
		return $this->successResponse($collection ,$code );
	}

	protected function showOne(Model $model, $code = 200){
		
		$transformer = $model->transformer;
		$model = $this->transformData($model,$transformer);
		
		return $this->successResponse( $model ,$code );
	}
/*	
	protected function showWith(Model $model,$with_model_name, $code = 200){
	
        $transformer = $model->transformer;
        		$model = $this->transformData($model,$transformer);

        return $this->successResponse( $model ,$code );

	}
*/
	protected function paginate(Collection $collection){
		$rules = [
			'per_page' => 'integer|min:2|max:50'
		];

		Validator::validate(request()->all(),$rules);

		$page = LengthAwarePaginator::resolveCurrentPage();
		$perPage = 16;  //Default value
		if(request()->has('per_page')){
			$perPage = (int) request()->per_page;
		}
		$results = $collection->slice(($page - 1)* $perPage, $perPage)->values();
		$paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
			'path' => LengthAwarePaginator::resolveCurrentPath()
		] );
		$paginated->appends(request()->all());
		return $paginated;
	}
	
	protected function filterData(Collection $collection,$transformer){
	    foreach( request()->query() as $query => $value) {
	        
	        $valuelist = explode(',',$value);
	        $attribute = $transformer::originalAttributes($query);
            if (sizeof($valuelist) > 1) {
                    if(isset($attribute, $valuelist)) {
	                    $collection = $collection->whereIn($attribute,$valuelist);
	                }
            } else {
                if(isset($attribute, $value)) {
	                $collection = $collection->where($attribute,$value);
	            }
            }
	        
	       
	    }
	    
	    return $collection;
	}

	protected function sortData(Collection $collection,$transformer){
		if(request()->has('sort_by')){
			$attribute = $transformer::originalAttributes(request()->sort_by);
		//	$attribute = request()->sort_by;
			$collection = $collection->sortByDesc->{$attribute};
		}
		return $collection;
	}


		protected function cacheResponse($data){
			$url = request()->url();
			$queryParams = request()->query();
			ksort($queryParams);
			$queryString = http_build_query($queryParams);
			$fullUrl = "{$url}?{$queryString}";
			return Cache::remember($fullUrl, 30, function() use ($data){
				return $data;
			});
			
		}
		
		protected function transformData($data, $transformer) {
		    $transformation = fractal($data, new $transformer);
		    return $transformation->toArray();
		    
		}
		
}