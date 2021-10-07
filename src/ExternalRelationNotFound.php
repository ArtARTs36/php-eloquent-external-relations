<?php

namespace ArtARTs36\EloquentExternalRelations;

class ExternalRelationNotFound extends \Exception
{
    public $failedRelationName;

    public function __construct(string $relationName)
    {
        $this->failedRelationName = $relationName;

        parent::__construct("External Relation $relationName not found!");
    }
}
