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
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function termable() 
    {
        return $this->morphTo();
    }
}