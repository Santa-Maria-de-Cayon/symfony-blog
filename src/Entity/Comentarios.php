<?php

namespace App\Entity;

use App\Repository\ComentariosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentariosRepository::class)
 */
class Comentarios
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Posts", inversedBy="comentarios")
     */
    private $post;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comentarios")
     */
    private $user;


   // public function getPost() :?string
   // {
   //     return $this->post;
   // }
//
//
   // public function setPost($post): self
   // {
   //     $this->post = $post;
   //     return $this;
   // }
//
//
   // public function getUser() :?User
   // {
   //     return $this->user;
   // }
//
//
   // public function setUser($user): self
   // {
   //     $this->user = $user;
   //     return $this;
   // }


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comentario;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_publicacion;


    public function getfecha_publicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setfecha_publicacion(\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }
}
