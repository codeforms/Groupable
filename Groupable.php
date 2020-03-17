<?php
namespace CodeForms\Repositories\Group;

/**
 * @package CodeForms\Repositories\Group\Groupable
 */
trait Groupable
{
	/**
	 * Yeni grup ekleme işlemi
	 * 
	 * @param string 	$name
	 * @param int 		$parent_id
	 * @param int 		$language_id
	 * 
	 * @example $groupable->newGroup('Elektronik')
	 * @example $groupable->newGroup('Elektronik', 1, 2)
	 * 
	 * @return object
	 */
	public function newGroup(string $name, int $parent_id = null, int $language_id = null): object
	{
		$group = new Group;

		return $this->groups()->create([
			'name'        => $name,
			'parent_id'   => $parent_id,
			'language_id' => $language_id,
			'slug'        => $group->setSlug($name)
		]);
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
	 * Sadece ana gruplar
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function parentGroups()
	{
		return self::groups()->whereNull('parent_id');
	}

	/**
	 * Tüm gruplar (parent & child)
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function groups()
	{
		return $this->morphMany(Group::class, 'groupable');
	}
}