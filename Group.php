<?php 
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Meta\Metable;
use Illuminate\Database\Eloquent\{Model};
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
	protected $fillable = ['name', 'slug', 'parent_id', 'language_id'];

	/**
	 * Gruplar için yeni terimler ekleme.
     * 
     * @param array $terms : array içinde bir veya birden fazla string
     * 
     * @return bool
	 */
	public function createTerms(array $terms)
	{
        $data  = [];
        $model = new Term;
        
        foreach ($terms as $term)
            $data[] = new Term([
                'name' => $term,
                'slug' => $model->setSlug($term)
            ]);

        return $this->terms()->saveMany($data);
	}

	/**
	 * Bir alt grubun ait olduğu
	 * üst grup verisi
	 *
	 */
	public function parentGroup()
	{
		return $this->belongsTo(self::class, 'parent_id');
	}

	/**
	 * Alt gruplar
	 * 
	 */
	public function childGroups()
	{
		return $this->hasMany(self::class, 'groupable_id', 'id')->whereNotNull('parent_id');
	}

	/**
	 * Bir gruba ait tüm terimler
	 */
	public function terms()
	{
		return $this->morphMany(Term::class, 'termable');
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