<?php
namespace CodeForms\Repositories\Group;

/**
 * @package CodeForms\Repositories\Group\Termable
 */
trait Termable
{
    /**
     * @param array $terms : term ids
     * @example $post->addTerms() (revoke all terms)
     * @example $post->addTerms([1, 2, 3])
     * 
     * @return bool
     */
    public function addTerms(array $terms = [])
    {
        return $this->terms()->sync($terms);
    }

    /**
     * @return MorphToMany
     */
    public function terms()
    {
        return $this->morphToMany(TermRelation::class, 'termable');
    }
}