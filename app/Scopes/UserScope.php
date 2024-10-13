<?php  
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserScope implements Scope{

	public function apply(Builder $eloq_builder, Model $model){
			$eloq_builder->where('status','=','active');
	}

}


