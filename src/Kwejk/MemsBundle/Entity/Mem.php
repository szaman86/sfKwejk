<?php

namespace Kwejk\MemsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mems
 * @Vich\Uploadable
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="mem")
 * @ORM\Entity(repositoryClass="Kwejk\MemsBundle\Entity\MemRepository")
 */
class Mem {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Kwejk\UserBundle\Entity\User", inversedBy="mems")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * @var Kwejk\userBundle\Entity\User
     */
    private $createdBy;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="mem")
     * @var ArrayCollection
     * 
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="mem")
     * @var ArrayCollection
     * 
     */
    private $ratings;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var string
     * @Assert\NotBlank(message="Brak ImageTitle")
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=255)
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="mems_image", fileNameProperty="imageName")
     * @Assert\NotBlank(message="Brak ImageFile")
     * @var File $imageFile
     */
    private $imageFile;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", length=255, unique=true, nullable=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_accepted", type="boolean")
     */
    private $isAccepted;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Mems
     */
    public function setCreateAt($createAt) {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime 
     */
    public function getCreateAt() {
        return $this->createAt;
    }

    /**
     * Set title
     * 
     * @param string $title
     * @return Mems
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set slug
     * @param string $slug
     * @return Mems
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Mems
     */
    public function setImageName($imageName) {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName() {
        return $this->imageName;
    }

    /**
     * Set isAccepted
     *
     * @param boolean $isAccepted
     * @return Mems
     */
    public function setIsAccepted($isAccepted) {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    /**
     * Get isAccepted
     *
     * @return boolean 
     */
    public function getIsAccepted() {
        return $this->isAccepted;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->createAt = new \DateTime('now');
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdBy
     *
     * @param \Kwejk\UserBundle\Entity\User $createdBy
     * @return Mem
     */
    public function setCreatedBy(\Kwejk\UserBundle\Entity\User $createdBy = null) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Kwejk\UserBundle\Entity\User 
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Add comments
     *
     * @param \Kwejk\MemsBundle\Entity\Comment $comments
     * @return Mem
     */
    public function addComment(\Kwejk\MemsBundle\Entity\Comment $comments) {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Kwejk\MemsBundle\Entity\Comment $comments
     */
    public function removeComment(\Kwejk\MemsBundle\Entity\Comment $comments) {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Add ratings
     *
     * @param \Kwejk\MemsBundle\Entity\Rating $ratings
     * @return Mem
     */
    public function addRating(\Kwejk\MemsBundle\Entity\Rating $ratings) {
        $this->ratings[] = $ratings;

        return $this;
    }

    /**
     * Remove ratings
     *
     * @param \Kwejk\MemsBundle\Entity\Rating $ratings
     */
    public function removeRating(\Kwejk\MemsBundle\Entity\Rating $ratings) {
        $this->ratings->removeElement($ratings);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRatings() {
        return $this->ratings;
    }

    public function setImageFile(File $imageFile) {
        $this->imageFile = $imageFile;

        
    }

    public function getImageFile() {
        return $this->imageFile;
    }

}
