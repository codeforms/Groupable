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
	 * $criteria değişkeni bir grup id'si
	 * veya grup adı olabilir.
	 * 
	 * @param $criteria : int | string
	 */
	public function getGroup($criteria) 
	{
		if(is_integer($criteria))
    		return $this->group()->find($criteria);

    	return $this->group()->where('name', 'like', '%'.$criteria.'%')->first();
	}

	/**
	 * Tüm grupları alma
	 * 
	 * @param $paginate
	 * @param $eachSide
	 * 
	 * @return object
	 */
	public function getGroups($paginate = null, $eachSide = 2) 
	{
		if($paginate)
    		return $this->group()->paginate($paginate)->onEachSide($eachSide);

    	return $this->group()->get();
	}

	/**
	 * 
	 */
	public function saveGroup($name) 
	{
		if(!self::hasGroup($name))
			$this->group()->create([
				'name' => $name,
				'slug' => $this->setSlug($this, $name)
			]);

		return $this->getGroup(getGroup($criteria))->update([
					'name' => $name,
					'slug' => $this->setSlug($this, $name)
				]);
	}

	/**
	 * 
	 */
	public function hasGroup($criteria)
	{
		return (bool)self::getGroup($criteria)->count();
	}

	/**
	 * 
	 * TODO
	 * 
	 */
	public function setParentGroup($id)
	{
		if (self::hasGroup($id))
			return $this->group()->update(['parent_id' => $id]);
	}

	/**
	 * 
	 */
	public function deleteGroup($id)
	{
		if (self::hasGroup($id))
			return $this->group()->where('id', $id)->delete();
	}

	/**
     * 
     */
    public function terms()
    {
        return $this->morphToMany(Term::class, 'termable');
    }

	/**
     * morphMany ilişkisi
     *
     * @return object
     */
    public function group()
    {
        return $this->morphMany(Group::class, 'groupable');
    }
}