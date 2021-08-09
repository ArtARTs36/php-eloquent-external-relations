<?php

namespace ArtARTs36\EloquentExternalRelations\Tests;

use ArtARTs36\EloquentExternalRelations\ExternalRelationNotFound;
use ArtARTs36\EloquentExternalRelations\HasExternalRelations;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

class HasExternalRelationsTest extends TestCase
{
    public function testSetExternalRelationClassOnIncorrectClass(): void
    {
        self::expectException(ExternalRelationNotFound::class);

        Author::setExternalRelationClass('posts', 'random-string');
    }

    public function testSetExternalRelationClassGood(): void
    {
        Author::setExternalRelationClass('posts', Post::class);

        $author = new Author();

        self::assertInstanceOf(Post::class, $author->posts()->getModel());
    }
}

class Author extends Model
{
    use HasExternalRelations;

    public function posts()
    {
        return $this->hasMany($this->getExternalRelationClass('posts'));
    }
}

class Post extends Model
{
    public static function resolveConnection($connection = null)
    {
        return (new \ReflectionClass(Connection::class))->newInstanceWithoutConstructor();
    }
}