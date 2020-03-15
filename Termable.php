<?php
namespace CodeForms\Repositories\Group;

/**
 * @package CodeForms\Repositories\Group\Termable
 */
trait Termable
{
    /**
     * Bir nesneye terimler ekleme
     * 
     * Termable'ı kullanan bir nesne ile
     * seçilen terimler arasında bağlantı oluşturma
     * 
     * @param array $terms : terim id'leri
     * @example $post->addTerms()
     * @example $post->addTerms([1, 2, 3])
     * 
     * @return bool
     */
    public function addTerms(array $terms = [])
    {
        return $this->termable()->sync($terms);
    }

    /**
     * @return MorphToMany
     */
    public function termable()
    {
        return $this->morphToMany(TermRelation::class, 'termable');
    }
}