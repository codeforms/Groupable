<?php
namespace CodeForms\Repositories\Group;

use CodeForms\Repositories\Group\{Term};
/**
 * @package CodeForms\Repositories\Group\Termable
 */
trait Termable
{
	/**
	 * Gruplar için yeni terimler ekleme.
     * 
     * not: Sadece Groupable trait dosyasını
     * kullanan veri türleri için
     * 
     * @param array $terms : array içinde bir veya birden fazla string
     * @example $group->createTerms(['Ambient', 'Electronic'])
     * 
     * @return bool
	 */
	public function createTerms(array $terms)
	{
        $data  = [];
        $model = new Term;
        
        foreach ($terms as $term)
            $data[] = new Term([
                'name' => $term,
                'slug' => $model->setSlug($term)
            ]);

        return $this->terms()->saveMany($data);
	}

    /**
     * Bir nesneye terimler ekleme
     * 
     * Termable'ı kullanan bir nesne ile
     * seçilen terimler arasında bağlantı oluşturma
     * 
     * @param array $terms : terim id'leri
     * @example $post->syncTerms([1, 2, 3])
     * 
     * @return bool
     */
    public function syncTerms(array $terms)
    {
        return $this->termable()->sync($terms);
    }

    /**
     * @return MorphMany
     */
    public function terms()
    {
        return $this->morphMany(Term::class, 'termable');
    }

    /**
     * @return MorphToMany
     */
    public function termable()
    {
        return $this->morphToMany(TermRelation::class, 'termable');
    }
}