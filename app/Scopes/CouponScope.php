<?php  
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CouponScope implements Scope{

	public function apply(Builder $eloq_builder, Model $model){
			$eloq_builder->where('status','=','active');
			//$eloq_builder->exclude(['user_id','description','status','retailer']);
		//	$eloq_builder->addselect('added','code','coupon_id','coupon_type','end_date','exclusive','last_visit','likes','retailer_id','sort_order','start_date','title','viewed','visits','visits_today');
	}

}


