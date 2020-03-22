<?php
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Meta\Metable;
use CodeForms\Repositories\Slug\SlugTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
/**
 * @package CodeForms\Repositories\Group\Term
 */
class Term extends Model
{
    /**
     * @link https://github.com/codeforms/Metable
     */
    use Metable;

    /**
     * 
     */
    use SlugTrait;

    /**
     * 
     */
    use SoftDeletes;

    /**
     * 
     */
    protected $table = 'terms';

    /**
     * 
     */
    protected $fillable = ['slug', 'name'];

    /**
     * @example $term->items()
     * 
     * @return object
     */
    public function items(): object
    {
        $collection = new Collection;

        foreach ($this->relations()->get() as $item)
            $collection->push(app($item->termable_type)->find($item->termable_id));
 
        return $collection;
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relations()
    {
        return $this->hasMany(TermRelation::class, 'term_relation_id', 'id');
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function termable()
    {
        return $this->morphTo();
    }
}
