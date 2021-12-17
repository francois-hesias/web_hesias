<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post', 'get',
        'get_oui' => [
            'method' => 'GET',
            'path' => '/books/oui',
            'status' => 200,
        ],
    "create" => [
        "method" => "POST",
        "input" => creatbook::class,
        "output" => dtobook::class
    ],
    ],
    itemOperations: [
        'get', 'delete', 'put'
    ],
    normalizationContext : ['groups' => ['books:read']]

)]
#[ApiFilter(SearchFilter::class, properties: ['titre' => 'ipartial'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
#[ApiFilter(BooleanFilter::class, properties: ['Dispo'])]
#[ApiFilter(OrderFilter::class, properties: ['titre'])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['books:read'])]
    private $titre;


    #[ORM\Column(type: 'boolean')]
    #[Groups(['books:read'])]
    private $dispo;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getDispo()
    {
        return $this->dispo;
    }

    /**
     * @param mixed $dispo
     */
    public function setDispo($dispo): void
    {
        $this->dispo = $dispo;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
