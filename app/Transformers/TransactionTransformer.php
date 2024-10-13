<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Transaction;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int) $transaction->transaction_id,
            'userID' => (int) $transaction->user_id,
            'retailerID' => 	(int) $transaction->retailer_id,
            'referenceID' => 	(string) $transaction->reference_id,
            'networkID' => 	(int) $transaction->network_id,
            'programID' => 	(int) $transaction->program_id,
            'referralID' => 	(int) $transaction->ref_id,
            
            'retailer' => 	(string) $transaction->retailer,
            'payment_type' => 	(string) $transaction->payment_type,
            'payment_method' => 	(string) $transaction->payment_method,
            'payment_details' => 	(string) $transaction->payment_details,
            'transaction_amount' => 	(double) $transaction->transaction_amount,
            'transaction_commision' => 	(double) $transaction->transaction_commision,
            'amount' => 	(double) $transaction->amount,
            'reason' => 	(string) $transaction->reason,
            'notification_sent' => 	(string) $transaction->notification_sent,
            
            'status' => 	(string) $transaction->status,
            'createdOnDate' => 	(string) $transaction->created,
            'updatedOnDate' => 	(string) $transaction->updated,
            'processedOnDate' => 	(string) $transaction->process_date,
            'typelabeled' => (string) $transaction->typelabel,
            'statuslabeled' => (string) $transaction->statuslabel,
        ];
    }
    
    public static function originalAttributes($index) {
        $attributes = [
             'identifier' => 'transaction_id',
            'userID' => 'user_id',
            'retailerID'=>	'retailer_id',
            'referenceID' => 	'reference_id',
            'networkID' => 	'network_id',
            'programID' => 	'program_id',
            'refferalID' => 	'refID',
            
            'retailer' => 	'retailer',
            'payment_type' => 	'payment_type',
            'payment_method' => 	'payment_method',
            'payment_details' => 	'payment_details',
            'transaction_amount' => 	'transaction_amount',
            'transaction_commision' => 	'transaction_commision',
            'amount' => 	'amount',
            'reason' => 	'reason',
            'notification_sent' => 	'notification_sent',
            
            'status' => 	'status',
            'createdOnDate' => 	'created',
            'updatedOnDate' => 	'updated',
            'processedOnDate' => 	'process_date',
            'typelabeled' => 'typelabel',
            'statuslabeled' => 'statuslabel',
            
            ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    

}
