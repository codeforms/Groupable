<?php
namespace CodeForms\Repositories\Group;

use Illuminate\Database\Eloquent\Collection;
use CodeForms\Repositories\Meta\Metable;
use CodeForms\Repositories\Slug\SlugTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
/**
 * @package CodeForms\Repositories\Group\Term
 */
class Term extends Model
{
    /**
     * Terimler için ekstra bilgi
     * kaydetmek istersek şayet hazırda bulunsun.
     * 
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
    protected $collection;

    /**
     * 
     */
    protected $table = 'terms';

    /**
     * 
     */
    protected $fillable = ['slug', 'name'];

    /**
     * 
     */
    public function __construct()
    {
        $this->collection = new Collection;
    }

    /**
     * 
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'termable_id');
    }

    /**
     * Bir terimle ilişkili tüm
     * içerikler / veriler
     * 
     * @example $term->items()
     * 
     * @return object
     */
    public function items(): object
    {
        $items = $this->relations->map(function($relation) {
            return $relation->only(['termable_id', 'termable_type']);
        });

        foreach ($items as $item)
            $this->collection->push((object)app($item['termable_type'])->where('id', $item['termable_id'])->first());

        return $this->collection;
    }

    /**
     * 
     */
    public function relations()
    {
        return $this->hasMany(TermRelation::class, 'term_relation_id', 'id');
    }

    /**
     * 
     */
    public function termable()
    {
        return $this->morphTo();
    }
}
