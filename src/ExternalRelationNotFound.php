<?php

namespace ArtARTs36\EloquentExternalRelations;

class ExternalRelationNotFound extends \Exception
{
    public function __construct(string $relationName)
    {
        parent::__construct("External Relation $relationName not found!");
    }
}
