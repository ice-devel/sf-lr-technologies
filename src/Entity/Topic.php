<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TopicRepository::class)
 */
#[ApiResource(
    collectionOperations: ['GET' =>  ['normalization_context' => ['groups' => ['topic:read:collection']]]],
    itemOperations: [
        'GET' => ['normalization_context' => ['groups' => ['topic:read:item']]]
    ],
    denormalizationContext: ['groups' => ["topic:post"]],
    normalizationContext: ['groups' => ["topic:read"]]
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
class Topic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"topic:read","topic:post"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("topic:read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"topic:read","topic:post", "topic:read:collection"})
     * @Assert\NotNull()
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"topic:read","topic:post"})
     * @Assert\NotNull()
     */
    #[Assert\Length(
        min: 10,
        minMessage: 'La description c\'est minimum {{ limit }} caractères',
    )]
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("topic:read")
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="topic",
     *     orphanRemoval=true, fetch="EAGER", cascade={"all"})
     * Lazy loading : les messages ne sont chargés que lorsqu'on en a besoin
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="topics", cascade={"all"})
     */
    private $tags;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->getId(). " - ".$this->getTitle();
    }

    public function __call($fct, $arguments) {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setTopic($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTopic() === $this) {
                $message->setTopic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
