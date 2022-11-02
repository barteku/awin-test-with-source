<?php
namespace Awin\Tools\CoffeeBreak\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table("staff_member")
 * @ORM\Entity(repositoryClass="Awin\Tools\CoffeeBreak\Repository\StaffMemberRepository")
 */
class StaffMember
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    /**
     * @ORM\Column(name="name", length=255)
     * @Assert\NotBlank
     * @var string
     */
    private $name;
    /**
     * @ORM\Column(name="email", length=255)
     * @Assert\NotBlank
     * @var string
     */
    private $email;
    /**
     * @ORM\Column(name="hip_chat_identifier", length=255, nullable=true)
     * @var string
     */
    private $SlackIdentifier;

    /**
     * @ORM\OneToMany(targetEntity="CoffeeBreakPreference", mappedBy="requestedBy", cascade={"all"})
     * @var ArrayCollection
     */
    private $preferences;

    /**
     * @var OfficeTeam $team
     *
     * @ORM\ManyToOne(targetEntity="OfficeTeam", inversedBy="teamMembers")
     * @Assert\NotBlank
     */
    private $team;



    public function __construct()
    {
        $this->preferences = new ArrayCollection();
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getSlackIdentifier()
    {
        return $this->SlackIdentifier;
    }
    /**
     * @param string $SlackIdentifier
     */
    public function setSlackIdentifier(string $SlackIdentifier = null)
    {
        $this->SlackIdentifier = $SlackIdentifier;
    }
    /**
     * @return ArrayCollection
     */
    public function getPreferences()
    {
        return $this->preferences;
    }
    /**
     * @param ArrayCollection $preferences
     */
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;
    }

    public function setTeam(OfficeTeam $team){
        $this->team = $team;
        return $this;
    }

    public function getTeam(){
        return $this->team;
    }
}
