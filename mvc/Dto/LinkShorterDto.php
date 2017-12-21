<?php

namespace Dto;

class LinkShorterDto
{
    /**
     * @var null
     */
    private $id;
    /**
     * @var string
     */
    private $link;
    /**
     * @var string
     */
    private $hash;

    /**
     * LinkShorterDto constructor.
     * @param null $id
     * @param string $link
     * @param string $hash
     */
    public function __construct(
        $id = null,
        $link,
        $hash
    ) {

        $this->id = $id;
        $this->link = $link;
        $this->hash = $hash;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}