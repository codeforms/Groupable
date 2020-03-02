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
    protected $table = 'terms';

    /**
     * 
     */
    protected $fillable = ['slug', 'name'];

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
        $collection = new Collection;

        foreach ($this->relations()->get() as $item)
            $collection->push((object)app($item->termable_type)->where('id', $item->termable_id)->first());
 
        return $collection;
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
