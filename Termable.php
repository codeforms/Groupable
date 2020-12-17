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
        return $this->termRelation()->sync($terms);
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function terms()
    {
        return $this->morphMany(TermRelation::class, 'termable')->join('terms', function($join) {
            $join->on('terms.id','=','termables.term_relation_id');
        });
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function termRelation()
    {
        return $this->morphToMany(TermRelation::class, 'termable');
    }
}