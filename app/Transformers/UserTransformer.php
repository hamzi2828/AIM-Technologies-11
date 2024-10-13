<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
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
        'transactions'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int) $user->user_id,
            'full-name' => (string) $user->fname .' '.$user->lname,
            'fname' => (string) $user->fname,
            'lname' => (string) $user->lname,
            'user-name' => (string) $user->username,
            'contact-email' => (string) ($user->email =='' ? $user->username : $user->email),
            'phone-number' => (string) $user->phone,
            'country' => (string) $user->country,
            'isVerified' => (int) $user->validated,
            'createdOnDate' => (string) $user->created,
            'reg-source' => (string) $user->reg_source,
            'lastModifiedOnDate' => (string) $user->updated_at,
        //    'deletedOnDate' => (string) $user->deleted_at,
            'deletedDate' => isset($user->deleted_at)?(string) $user->deleted_at : null
        ];
    }

      public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'user_id',
            'full-name' => 'fname' . 'lname',
            'fname' => 'fname',
            'lname' => 'fname',
            'user-name' => 'username',
            'contact-email' => 'email',
            'phone-number' => 'phone',
            'country' => 'country',
            'isVerified' => 'validated',
            'createdOnDate' => 'created',
            'reg-soruce' => 'reg_source',
            'lastModifiedOnDate' => 'updated_at',
            'deletedOnDate' =>  'deleted_at',

            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public function includeTransactions(User $user)
    {
        $transactions = $user->transactions;
        return $this->collection($transactions, new TransactionTransformer);
    }
}
