<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $reference
 * @property Collection $links
 */
abstract class ReferencedModel extends Model
{
    const FIELD_REFERENCE = 'reference';

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @return string
     */
    public function getReferenceName() : string {
        return self::FIELD_REFERENCE;
    }

    /**
     * Set the reference
     *
     * @param $value
     */
    public function setReferenceAttribute(string $value) {
        $this->attributes[self::FIELD_REFERENCE] = strtoupper($value);
    }

    /**
     * @param string $reference
     * @return mixed
     */
    public function findByReference(string $reference) {
        return $this->where($this->getReferenceName(), $reference)->first();
    }

    /**
     * Find a model by reference or fail
     *
     * @param string $reference
     * @throws ModelNotFoundException
     * @return ReferencedModel
     */
    public function findByReferenceOrFail(string $reference) : ReferencedModel {
        $model = $this->findByReference($reference);

        if(!$model) {
            throw new ModelNotFoundException('Could not find requested data', Response::HTTP_NOT_FOUND);
        }

        return $model;
    }

    /**
     * Get a model reference by id or fail
     *
     * @param int $id
     * @throws ModelNotFoundException if company could not be found
     * @return string
     */
    public function getReferenceByIdOrFail(int $id) : string {

        return $this->findOrFail($id)->getAttribute($this->getReferenceName());
    }
}