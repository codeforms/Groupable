<?php
namespace CodeForms\Repositories\Group;

/**
 * @package CodeForms\Repositories\Group\Groupable
 */
trait Groupable
{
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
	 * Mevcut bir grubu sorgulama
	 * 
	 * @param int $id
	 * @example $groupable->hasGroup(1)
	 * 
	 * @return bool
	 */
	public function hasGroup($id): bool
	{
		return !is_null($this->groups()->find($id));
	}

	/**
	 * Bir gruba ait tüm terimler
	 */
	public function terms()
	{
		return $this->morphMany(Term::class, 'termable');
	}

	/**
	 * Üst grup
	 *
	 */
	public function parentGroup()
	{
		return $this->morphOne(Group::class, 'groupable');
	}

	/**
	 * Sadece ana gruplar
	 */
	public function parentGroups()
	{
		return $this->morphMany(Group::class, 'groupable')->whereNull('parent_id');
	}

	/**
	 * Alt gruplar
	 * 
	 */
	public function childGroups()
	{
		return $this->morphMany(Group::class, 'groupable')->whereNotNull('parent_id');
	}

	/**
	 * Tüm gruplar (parent & child)
	 */
	public function groups()
	{
		return $this->morphMany(Group::class, 'groupable');
	}
}