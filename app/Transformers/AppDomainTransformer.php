<?php


namespace App\Transformers;


use App\Models\AppDomains;
use League\Fractal\TransformerAbstract;

class AppDomainTransformer extends TransformerAbstract
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
    public function transform(AppDomains $appDomain)
    {
        return [
            'identifier' => (int) $appDomain->id,
            'counryId' => (int) $appDomain->cid,
            'apidomain' => 	(string) $appDomain->apidomain,
            'title' => (string) $appDomain->label,
            'country_code2' => 	(string) $appDomain->country_code2,
            'country_code3' => 	(string) $appDomain->country_code3,
            'langcode' => 	(string) $appDomain->langcode,
            'icon' =>(string) $appDomain->iconpath
        ];
    }
    public static function originalAttributes($index) {
        $attributes = [
            'identifier' => 'id',
            'counryId' => 'cid',
            'apidomain' => 	'apidomain',
            'title' => 'label',
            'country_code2' => 	'country_code2',
            'country_code3' => 	'country_code3',
            'langcode' => 	'langcode',
            'icon' => 	'iconpath',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
