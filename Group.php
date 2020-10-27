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
     * @var string
     */
	protected $table = 'group';

	/**
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'parent_id', 'language_id'];

	/**
     * @param array $terms
     * 
     * @example $genres->createTerms(['Ambient', 'House'])
     * 
     * @return bool
	 */
	public function createTerms(array $terms = [])
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
     * @param string|array $slug
     * 
     * @example $genres->items()
     * @example $genres->items('ambient')
     * @example $genres->items(['ambient', 'house'])
     * 
     * @return mixed
     */
    public function items($slug = null)
    {
		$collection = new Collection;
		$terms      = $this->terms()->when(!is_null($slug), function($query) use($slug) {
			return $query->whereIn('slug', (array)$slug);
        })->get();
		
		if(count($terms) > 0)
			foreach($terms as $term)
				$collection->push($term->items());

			return $collection->collapse()->unique('id');
    }

	/**
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function parentGroup()
	{
		return $this->belongsTo(self::class, 'parent_id');
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function childGroups()
	{
		return $this->hasMany(self::class, 'parent_id', 'id');
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function terms()
	{
		return $this->morphMany(Term::class, 'termable');
	}

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function groupable()
    {
        return $this->morphTo();
	}
	
	/**
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param $language_id
	 * 
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByLanguage($query, $language_id)
	{
		return $query->where('language_id', $language_id);
	}
}