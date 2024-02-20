<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testCannotBeCreatedFromEmptyTitle()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('', 'content', 'slug');
    }

    public function testCannotBeCreatedFromEmptySlug()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('title', 'content', '');
    }

    public function testCannotBeCreatedFromInvalidSlug()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('title', 'content', 'invalid@slug');
    }

    public function testCannotBeCreatedFromEmptyContent()
    {
        $this->expectException(InvalidArgumentException::class);
        new Post('title', '', 'slug');
    }

    public function testCanBeCreatedWithValidArguments()
    {
        $title = 'Superbe';
        $content = 'Awesome content';
        $slug = 'superbe-slug';

        $post = new Post($title, $content, $slug);

        $this->assertSame($title, $post->getTitle());
        $this->assertSame($content, $post->getContent());
        $this->assertSame($slug, $post->getSlug());
    }
    
    public function testSetAndGetPrivate()
    {
        $post = new Post('title', 'content', 'slug');

        $this->assertFalse($post->getPrivate());

        $post->setPrivate(true);

        $this->assertTrue($post->getPrivate());
    }
}