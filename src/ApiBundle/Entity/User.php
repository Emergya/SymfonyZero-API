<?php

namespace ApiBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Exclude;

/**
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
    * @var \Datetime
    *
    * @ORM\Column(name="registrationDate", type="datetime", nullable=true)
    * @SerializedName("registrationDate")
    */
    protected $registrationDate;

    /**
     * @ORM\OneToMany(targetEntity="OauthBundle\Entity\AccessToken", mappedBy="user", cascade={"remove"})
     *
     * @Exclude
     */
    protected $accessToken;

    /**
     * @ORM\OneToMany(targetEntity="OauthBundle\Entity\RefreshToken", mappedBy="user", cascade={"remove"})
     *
     * @Exclude
     */
    protected $refreshToken;

    /**
     * @ORM\OneToMany(targetEntity="OauthBundle\Entity\AuthCode", mappedBy="user", cascade={"remove"})
     *
     * @Exclude
     */
    protected $AuthCode;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime 
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Returns if the user is indexable for elastic
     *
     * @return boolean
     */
    public function isIndexable()
    {
    	if ($this->getEmailCanonical() == 'admin@test.com') {
    		return false;
    	} else {
    		return true;
    	}
    }
    
    
    public function setExpiresAt(\DateTime $date = null)
    {
    	parent::setExpiresAt($date);
    }
    public function getExpiresAt()
    {
    	return $this->expiresAt;
    }
    public function setCredentialsExpireAt(\DateTime $date = null)
    {
    	parent::setCredentialsExpireAt($date);
    }
    public function getCredentialsExpireAt()
    {
    	return $this->credentialsExpireAt;
    }
}
