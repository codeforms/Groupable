<?php 
namespace CodeForms\Repositories\Group;

use Illuminate\Database\Eloquent\{Model};
use CodeForms\Repositories\Group\{Term};
/**
 * @package CodeForms\Repositories\Group\TermRelation
 */
class TermRelation extends Model 
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 
     */
	protected $table = 'termables';

    /**
     * morphTo
     */
    public function termable() 
    {
        return $this->morphTo();
    }
}