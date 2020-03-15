<?php 
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Meta\Metable;
use Illuminate\Database\Eloquent\{Model};
use CodeForms\Repositories\Slug\SlugTrait;
use Illuminate\Database\Eloquent\Collection;
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
     * @example $electronic->createTerms(['Bilgisayar', 'Beyaz Eşya'])
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
     * Bir gruba ait tüm verileri veya bir gruba ait
     * spesifik bir terimle bağlantılı tüm verileri dönderir.
     * 
     * @param string|array $slug : terim slug
     * 
     * @example $electronic->items()
     * @example $electronic->items('bilgisayar')
     * @example $electronic->items(['bilgisayar', 'beyaz-esya'])
     * 
     * @return mixed
     */
    public function items($slug = null)
    {
		$collection = new Collection;
		$terms = $this->terms()->when(!is_null($slug), function($query) use($slug) {
		            return $query->whereIn('slug', is_array($slug) ? $slug : [$slug]);
		        })->get();
		
		if(count($terms) > 0)
			foreach($terms as $term)
        		$collection->push($term->items());

        	return $collection->collapse()->unique('id');
    }

	/**
	 * Bir alt grubun ait olduğu
	 * üst grup verisi
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function parentGroup()
	{
		return $this->belongsTo(self::class, 'parent_id');
	}

	/**
	 * Alt gruplar
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function childGroups()
	{
		return $this->hasMany(self::class, 'parent_id', 'id');
	}

	/**
	 * Bir gruba ait tüm terimler
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function terms()
	{
		return $this->morphMany(Term::class, 'termable');
	}

    /**
     * morphTo
     * 
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     * 
     */
    public function groupable()
    {
        return $this->morphTo();
    }
}