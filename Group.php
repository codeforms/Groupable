<?php 
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Meta\Metable;
use Illuminate\Database\Eloquent\{Model};
use CodeForms\Repositories\Group\{Termable, Groupable};
use CodeForms\Repositories\Slug\SlugTrait;
/**
 * @package CodeForms\Repositories\Group\Group
 */
class Group extends Model
{
	/**
	 * Veri grupları için ekstra bilgi
	 * kaydetmek istersek şayet hazırda bulunsun.
	 * 
     * @link https://github.com/codeforms/Metable
	 */
	use Metable;

	/**
	 * @link https://github.com/codeforms/SlugTrait
	 */
	use SlugTrait;

	/**
	 * 
	 */
	use Termable;

	/**
     * 
     */
	protected $table = 'group';

	/**
	 * 
	 */
	protected $fillable = ['name', 'slug', 'parent_id'];

	/**
	 * Üst grup için belongsTo
	 *
	 */
	public function parentGroup()
	{
		return $this->belongsTo(Group::class, 'parent_id');
	}

	/**
	 * Alt gruplar için hasMany
	 * 
	 */
	public function childGroup()
	{
		return $this->hasMany(Group::class, 'parent_id');
	}

    /**
     * morphTo
     * 
     */
    public function groupable()
    {
        return $this->morphTo();
    }
}