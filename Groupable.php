<?php
namespace CodeForms\Repositories\Group;

/**
 * @package CodeForms\Repositories\Group\Groupable
 */
trait Groupable
{
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
	 */
	public function parentGroups()
	{
		return self::groups()->whereNull('parent_id');
	}

	/**
	 * Tüm gruplar (parent & child)
	 */
	public function groups()
	{
		return $this->morphMany(Group::class, 'groupable');
	}
}