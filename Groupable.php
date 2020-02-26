<?php
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Group\{Group, Term};
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
	 * Bir gruba ait tüm terimler
	 */
	public function terms()
	{
		return $this->morphToMany(Term::class, 'termable');
	}

	/**
	 * Sadece ana gruplar
	 */
	public function parentGroups()
	{
		return $this->morphMany(Group::class, 'groupable')->whereNull('parent_id');
	}

	/**
	 * Tüm gruplar (parent & child)
	 */
	public function groups()
	{
		return $this->morphMany(Group::class, 'groupable');
	}
}