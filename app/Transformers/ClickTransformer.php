<?php


namespace App\Transformers;


use App\Models\Click;
use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class ClickTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
//
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Click $click)
    {
        return [
            'identifier' => (int) $click->click_id,
            'userID' => (int) $click->user_id,
            'clickRef' => (string) $click->click_ref,
            'retailerID' => 	(int) $click->retailer_id,
            'retailor' => 	(string) $click->retailer,
            'clickIp' => 	(string) $click->click_ip,
            'dateAdded' => 	(string) $click->added,

        ];
    }

    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'click_id',
            'userID' => 'user_id',
            'clickRef'=>	'click_ref',
            'retailerID' => 	'retailer_id',
            'retailor' => 	'retailer',
            'clickIp' => 	'click_ip',
            'dateAdded' => 	'added',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
