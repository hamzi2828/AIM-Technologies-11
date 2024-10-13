<?php  
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RetailerScope implements Scope{

	public function apply(Builder $eloq_builder, Model $model){
			$eloq_builder->where('status','=','active');
		//	$eloq_builder->addselect('retailer_id','title','image','cashback','visits','featured','deal_of_week','website');
			//$eloq_builder->exclude(['user_id','description','status']);
			//$eloq_builder->has('coupons');
			
			//$eloq_builder->with(['coupons']);
	}

}