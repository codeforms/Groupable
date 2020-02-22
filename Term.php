<?php
namespace CodeForms\Repositories\Group;

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
    protected $table = 'terms';

    /**
     * 
     */
    protected $fillable = ['slug', 'name'];

    /**
     * 
     */
    public function group()
    {
        return $this->morphOne(Group::class, 'groupable');
    }

    /**
     * 
     */
    public function termable()
    {
        return $this->morphTo();
    }
}
