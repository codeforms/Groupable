<?php
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Group\{Group, Term};
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
	 * @example $groupable->newGroup('Genres')
	 * @example $groupable->newGroup('Genres', 1)
	 * 
	 * @return object
	 */
	public function newGroup(string $name, int $parent_id = null): object
	{
		$group = new Group;

		return $this->groups()->create([
			'name'      => $name,
			'parent_id' => $parent_id,
			'slug'      => $group->setSlug($name)
		]);
	}

	/**
	 * Grup güncelleme işlemi
	 * 
	 * @param int 		$id
	 * @param array 	$pack : name, parent_id, slug
	 * @example $groupable->updateGroup(1, ['name' => 'Genres'])
	 * 
	 * @return bool
	 */
	public function updateGroup($id, array $pack): bool
	{
		if(self::hasGroup($id))
			return $this->groups()->find($id)->update($pack);
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
	 * Mevcut bir grubu silme
	 * 
	 * @param int $id
	 * @example $groupable->deleteGroup(1)
	 * 
	 * @return bool
	 */
	public function deleteGroup($id): bool
	{
		if (self::hasGroup($id))
			return $this->groups()->find($id)->delete();
	}

	/**
     * morphToMany ilişkisi
     */
    public function terms()
    {
        return $this->morphToMany(Term::class, 'termable');
    }

	/**
     * morphMany ilişkisi
     */
    public function groups()
    {
        return $this->morphMany(Group::class, 'groupable');
    }
}