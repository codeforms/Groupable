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
        $terms = Term::find($terms);

        if($terms) {
            foreach ($terms as $term)
                $pivot[$term->id] = ['group_id' => $term->termable_id];
            return $this->termRelation()->sync($pivot);
        }
        
        return;
    }

    /**
     * @param string|array $group_slug
     * 
     * @example $content->terms (all terms)
     * @example $content->terms('colors')->get()
     * @example $content->terms(['colors', 'sizes'])->get()
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function terms($group_slug = null)
    {
        return $this->morphMany(TermRelation::class, 'termable')->join('terms', 'terms.id','=','term_relation_id')
            ->when(!is_null($group_slug), function($query) use($group_slug) {
                $groups = Group::whereIn('slug', (array)$group_slug)->pluck('id');
                return $query->whereIn('group_id', $groups);
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