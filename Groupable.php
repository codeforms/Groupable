<?php
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Group\{Group, Term};
/**
 * @package CodeForms\Repositories\Group\Groupable
 */
trait Groupable
{
	/**
	 * Bir grup verisini alma.
	 * 
	 * $id değişkeni bir grup id'si
	 * 
	 * @param int 		$id
	 * @example $groupable->getGroup($id)
	 * 
	 * @return object
	 */
	public function getGroup($id): object
	{
		return $this->group()->find($id);
	}

	/**
	 * Tüm grupları alma
	 * 
	 * @param bool 		$paginate
	 * @param int 		$eachSide
	 * @example $groupable->getGroups()
	 * @example $groupable->getGroups(10, 3)
	 * 
	 * @return object
	 */
	public function getGroups(bool $paginate = false, int $eachSide = 2): object
	{
		if($paginate)
    		return $this->group()->latest()->paginate($paginate)->onEachSide($eachSide);

    	return $this->group()->latest()->get();
	}

	/**
	 * Yeni grup ekleme işlemi
	 * 
	 * @param string 	$name
	 * @param int 		$parent_id
	 * @example $groupable->newGroup('Genres')
	 * @example $groupable->newGroup('Genres', 1)
	 * 
	 * @return bool
	 */
	public function newGroup(string $name, int $parent_id = null): bool
	{
		$group = new Group;

		return $this->group()->create([
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
			return $this->getGroup($id)->update($pack);
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
		return !is_null(self::getGroup($id));
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
			return $this->group()->find($id)->delete();
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
    public function group()
    {
        return $this->morphMany(Group::class, 'groupable');
    }
}