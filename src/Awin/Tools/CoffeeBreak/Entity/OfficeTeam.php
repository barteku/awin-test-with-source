<?php


namespace Awin\Tools\CoffeeBreak\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table("app_office_team")
 */
class OfficeTeam implements OfficeTeamInterface
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer", name="preferred_contact_service")
     * @var string
     */
    protected $preferredContactService;

    /**
     * @ORM\OneToMany(targetEntity="StaffMember", mappedBy="team")
     * @var ArrayCollection
     */
    private $teamMembers;




    public function __construct(){
        $this->teamMembers = new ArrayCollection();
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
     * @return int
     */
    public function getPreferredContactService()
    {
        return $this->preferredContactService;
    }
    /**
     * @param int $preferredContactService
     */
    public function setPreferredContactService(int $preferredContactService)
    {
        $this->preferredContactService = $preferredContactService;
    }

    /**
     * @return Collection<int, StaffMember>
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMembers;
    }

    public function addTeamMember(StaffMember $teamMember): self
    {
        if (!$this->teamMembers->contains($teamMember)) {
            $this->teamMembers[] = $teamMember;
            $teamMember->setTeam($this);
        }

        return $this;
    }

    public function removeTeamMember(StaffMember $teamMember): self
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            // set the owning side to null (unless already changed)
            if ($teamMember->getTeam() === $this) {
                $teamMember->getTeam(null);
            }
        }

        return $this;
    }


}
