<?php
namespace CodeForms\Repositories\Group;

/**
 * @package CodeForms\Repositories\Group\Groupable
 */
trait Groupable
{
	/**
	 * @param string 	$name
	 * @param int 		$parent_id
	 * @param int 		$language_id
	 * 
	 * @example $groupable->newGroup('Genres')
	 * @example $groupable->newGroup('Genres', 1, 2)
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
	 * @example $groupable->hasGroups()
	 * 
	 * @return bool
	 */
	public function hasGroups(): bool
	{
		return !$this->groups()->isEmpty();
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function parentGroups()
	{
		return $this->groups()->whereNull('parent_id');
	}

	/**
	 * @param string|array $group
	 *
	 * @example $groupable->groups
	 * @example $groupable->groups('colors')->get()
	 * @example $groupable->groups(['colors', 'sizes'])->get()
	 * @example $groupable->groups('colors')->with('terms')->get()
	 * @example $groupable->groups(['colors', 'sizes'])->with('terms')->get()
	 * 
	 * @return Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function groups($group = null)
	{
		return $this->morphMany(Group::class, 'groupable')->when(!is_null($group), function($query) use($group) {
			return $query->whereIn('slug', (array)$group);
        });
	}
}