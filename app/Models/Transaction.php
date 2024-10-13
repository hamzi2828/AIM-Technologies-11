<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Transformers\TransactionTransformer;

class Transaction extends Model
{
    use Notifiable;

    //https://stackoverflow.com/questions/32917944/laravel-where-to-store-statuses-flags-model-class-or-config-folder
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_DECLINED = 'declined';
    const STATUS_UNKNOWN = 'unknown';
    const STATUS_ALL = 'all';
    const STATUS_PAID = 'paid';
    const STATUS_REQUEST = 'request';

    const LABEL_STATUS_PENDING = 'Σε εκκρεμότητα';
    const LABEL_STATUS_CONFIRMED = 'Επιβεβαιωμένο';
    const LABEL_STATUS_DECLINED = 'Ακυρώθηκε';
    const LABEL_STATUS_PAID = 'Πληρώθηκε';
    const LABEL_STATUS_REQUEST = 'Ζητήθηκε';


    const TYPE_FRIEND_BONUS = 'friend_bonus';
    const TYPE_CASHBACK = 'Cashback';
	const TYPE_WITHDRAWAL = 'Withdrawal';
	const TYPE_REVIEW = 'review';
	const TYPE_CLAIM = 	'claim';
	const TYPE_REVERSAL = 'reversal';
	const TYPE_SPECIAL = 'friend_special_bonus';
	const TYPE_MAINT_FEE = 'account_maintenance_fee';
	const TYPE_WELCOME_BONUS = 'Welcome_bonus';


    const LABEL_TYPE_FRIEND_BONUS = 'Bonus Φίλου';
    const LABEL_TYPE_CASHBACK = 'Cashback';
	const LABEL_TYPE_WITHDRAWAL = 'Withdrawal';
	const LABEL_TYPE_REVIEW = 'Review';
	const LABEL_TYPE_CLAIM = 	'Claim';
	const LABEL_TYPE_REVERSAL = 'Reversal';
	const LABEL_TYPE_SPECIAL = 'Friend Special Bonus';
	const LABEL_TYPE_MAINT_FEE = 'Account Maintenance Fee';
	const LABEL_TYPE_WELCOME_BONUS = 'Welcome Bonus';

    const PAYMENT_METHOD_PAYPAL = 1;
    const PAYMENT_METHOD_BANK   = 3;
    const MIN_PAYOUT   = 'min_payout';

    protected $table = 'cashbackengine_transactions';
   // protected $dateFormat = 'Y-m-d H:m:s';   // examples 2018-09-30 18:36:35, 2012-08-28 10:38:07 , 2018-10-02 12:09:27
    protected $primaryKey = 'transaction_id';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

   // public $timestamps = false;


    protected $fillable = [
        'reference_id',
        'network_id',
        'retailer_id',
        'retailer',
        'program_id',
        'user_id',
        'transaction_commision',
        'payment_method',
        'payment_type',
        'payment_details',
        'amount',
        'status',
        'reason',
        "transaction_amount",
    ];

    public $transformer = TransactionTransformer::class;

    public function retailer()
    {
        return $this->belongsTo('App\Models\Retailer','retailer_id');
    }

    public function pmethod()
    {
        return $this->belongsTo('App\Models\method','payment_method');
    }

    public function affnetwork()
    {
        return $this->belongsTo('App\Models\Affnetwork','network_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function isDeclined()
    {
        return $this->status == Transaction::STATUS_DECLINED;
    }

    public function isPending()
    {
        return $this->status == Transaction::STATUS_PENDING;
    }

    public function isConfirmed()
    {
        return $this->status == Transaction::STATUS_CONFIRMED;
    }

    public function isUnknown()
    {
        return $this->status == Transaction::STATUS_UNKNOWN;
    }


      public function getTypelabelAttribute(){

           switch($this->payment_type){
            case Transaction::TYPE_FRIEND_BONUS     : return Transaction::LABEL_TYPE_FRIEND_BONUS;
            case Transaction::TYPE_CASHBACK         : return Transaction::LABEL_TYPE_CASHBACK;
            case Transaction::TYPE_WITHDRAWAL       : return Transaction::LABEL_TYPE_WITHDRAWAL;
	        case Transaction::TYPE_REVIEW           : return Transaction::LABEL_TYPE_REVIEW;
	        case Transaction::TYPE_CLAIM            : return Transaction::LABEL_TYPE_CLAIM;
	        case Transaction::TYPE_REVERSAL         : return Transaction::LABEL_TYPE_REVERSAL;
	        case Transaction::TYPE_SPECIAL          : return Transaction::LABEL_TYPE_SPECIAL;
        	case Transaction::TYPE_MAINT_FEE        : return Transaction::LABEL_TYPE_MAINT_FEE;
	        case Transaction::TYPE_WELCOME_BONUS    : return Transaction::LABEL_TYPE_WELCOME_BONUS;
            default                                 : return Transaction::STATUS_UNKNOWN;
          }

      }

       public function getStatuslabelAttribute(){
          switch($this->status){
            case Transaction::STATUS_PENDING     : return Transaction::LABEL_STATUS_PENDING;
            case Transaction::STATUS_CONFIRMED   : return Transaction::LABEL_STATUS_CONFIRMED;
            case Transaction::STATUS_DECLINED    : return Transaction::LABEL_STATUS_DECLINED;
            case Transaction::STATUS_PAID        : return Transaction::LABEL_STATUS_PAID;
            case Transaction::STATUS_REQUEST        : return Transaction::LABEL_STATUS_REQUEST;
            default                 : return Transaction::STATUS_UNKNOWN;
          }
      }
}
