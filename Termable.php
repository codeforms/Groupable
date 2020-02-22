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
     * @param array $terms
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
     * Termable'ı kullanan bir nesne ile
     * seçilen terimler arasında bağlantı oluşturma
     * 
     * @param array $terms
     * 
     * @return bool
     */
    public function syncTerm(array $terms)
    {
        $data  = [];
        $model = new Term;
        foreach ($terms as $term)
            $data[] = $term;

        return $this->termable()->sync($data);
    }

    /**
     * @return HasMany
     */
    public function terms()
    {
        return $this->morphMany(Term::class, 'termable');
    }

    /*
     * 
     *
     * @return HasMany
     */
    public function termable()
    {
        return $this->morphToMany(TermRelation::class, 'termable');
    }
}