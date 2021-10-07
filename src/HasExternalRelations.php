<?php

namespace ArtARTs36\EloquentExternalRelations;

use Illuminate\Database\Eloquent\Model;

trait HasExternalRelations
{
    /** @var array<string, class-string<Model>> */
    protected static $externalRelationMap = [];

    /**
     * @param class-string<Model> $relationClass
     * @throws ExternalRelationNotFound
     */
    public static function setExternalRelationClass(string $relationName, string $relationClass): void
    {
        if (! is_subclass_of($relationClass, Model::class)) {
            throw new ExternalRelationNotFound($relationName);
        }

        static::$externalRelationMap[static::class][$relationName] = $relationClass;
    }

    /**
     * @throws ExternalRelationNotFound
     * @return class-string<Model>
     */
    protected function getExternalRelationClass(string $relationName): string
    {
        if (! array_key_exists($relationName, static::$externalRelationMap[static::class] ?? [])) {
            throw new ExternalRelationNotFound($relationName);
        }

        return static::$externalRelationMap[static::class][$relationName];
    }

    /**
     * @throws ExternalRelationNotFound
     * @return object
     */
    protected function newExternalRelationInstance(string $relationName)
    {
        $class = $this->getExternalRelationClass($relationName);

        return new $class();
    }
}
