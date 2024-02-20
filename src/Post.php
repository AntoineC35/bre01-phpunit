<?php
class Post {
    private bool $private = false;

    public function __construct(private string $title, private string $content, private string $slug)
    {
        $this->ensureTitleIsNotEmpty($title);
        $this->title = $title;
        $this->ensureSlugIsNotEmptyAndSafe($slug);
        $this->slug = $slug;
        $this->ensureContentIsNotEmpty($content);
        $this->content = $content;
    }

    private function ensureTitleIsNotEmpty(string $title): void
    {
        if (empty($title)) {
            throw new InvalidArgumentException("Le titre ne peut pas être vide.");
        }
    }
    private function ensureSlugIsNotEmptyAndSafe(string $slug) : void
    {
        if (empty($slug)) {
            throw new InvalidArgumentException("Slug ne peut pas être vide");
        } else if (!preg_match('/^[A-Za-z0-9\-_]+$/', $slug)) {
            throw new InvalidArgumentException("Slug ne peut contenir que des caractères alphanumériques, des tirets et des underscores.");
        }
    }
    private function ensureContentIsNotEmpty(string $content) : void
    {
        if (empty($content)) {
            throw new InvalidArgumentException("Le content ne peut pas être vide.");
        } 
    }
    

 
    public function getTitle()
    {
        return $this->title;
    }
 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    public function getPrivate()
    {
        return $this->private;
    }

   
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }
 
    public function getContent()
    {
        return $this->content;
    }

 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }


    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}