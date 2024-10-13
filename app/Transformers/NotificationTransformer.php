<?php


namespace App\Transformers;


use App\Models\Retailercategory;
use App\Models\UserNotification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
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
    public function transform(UserNotification $notification)
    {
        return [
            'identifier' => (int) $notification->id,
            'user_id' => 	(int) $notification->user_id,
            'title' => (string) $notification->title,
            'text' => 	(string) $notification->text,
            'seen' => 	(int) $notification->seen,
            'created_at' =>(string) $notification->created_at
        ];
    }
    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'id',
            'user_id' => 	'user_id',
            'title' => 'title',
            'text' => 	'text',
            'seen' => 	'seen',
            'created_at' => 	'created_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
