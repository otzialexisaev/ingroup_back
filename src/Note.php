<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="notes")
 **/
class Note
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    private $id;
    /**
     * @ORM\Column(type="string", columnDefinition="VARCHAR(200) NOT NULL")
     */
    private $title;
    /**
     * @ORM\Column(type="string", columnDefinition="TEXT")
     */
    private $description;
    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP")
     */
    private $created_at;
    /**
     * @ORM\Column(type="boolean", columnDefinition="BOOLEAN NOT NULL DEFAULT FALSE")
     */
    private $is_favourite;

    public function check() {
        var_dump($this);
    }
}