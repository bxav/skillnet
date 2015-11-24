<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use AppBundle\Model\AddressInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Address implements AddressInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="is_current")
     */
    protected $current;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $lastname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $address1;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address2;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address3;

    /**
     * @var string
     * @ORM\Column(type="string", length=12)
     */
    protected $postcode;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    protected $countryCode;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="addresses")
     * @ORM\JoinColumn(name="business_id",referencedColumnName="id")
     */
    protected $business;

    /**
     * @var datetime
     */
    protected $updatedAt;

    /**
     * @var datetime
     */
    protected $createdAt;

    /**
     * Formats an address in an array form.
     *
     * @param array  $address The address array (required keys: firstname, lastname, address1, postcode, city, country_code)
     * @param string $sep     The address separator
     *
     * @return string
     */
    public static function formatAddress(array $address, $sep = ', ')
    {
        $address = array_merge(
            array(
                'firstname' => '',
                'lastname' => '',
                'address1' => '',
                'address2' => '',
                'address3' => '',
                'postcode' => '',
                'city' => '',
                'country_code' => '',
            ),
            $address
        );

        $values = array_map('trim', array(
            sprintf('%s %s', $address['firstname'], $address['lastname']),
            $address['address1'],
            $address['address2'],
            $address['address3'],
            $address['postcode'],
            $address['city'],
        ));

        foreach ($values as $key => $val) {
            if (!$val) {
                unset($values[$key]);
            }
        }

        $fullAddress = implode($sep, $values);

        if ($countryCode = trim($address['country_code'])) {
            if ($fullAddress) {
                $fullAddress .= ' ';
            }

            $fullAddress .= sprintf('(%s)', $countryCode);
        }

        return $fullAddress;
    }

    public function __construct()
    {
        $this->setCurrent(false);
    }

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    public static function getTypesList()
    {
        return array(
            self::TYPE_BILLING => 'type_billing',
            self::TYPE_DELIVERY => 'type_delivery',
            self::TYPE_CONTACT => 'type_contact',
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set current.
     *
     * @param bool $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * Get current.
     *
     * @return bool
     */
    public function isCurrent()
    {
        return (bool) $this->current;
    }

    /**
     * Set type.
     *
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getTypeCode()
    {
        $types = self::getTypesList();

        return isset($types[$this->getType()]) ? $types[$this->getType()] : null;
    }
    /**
     * Get type.
     *
     * @return int $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set firstname.
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set address1.
     *
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * Get address1.
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2.
     *
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * Get address2.
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set address3.
     *
     * @param string $address3
     */
    public function setAddress3($address3)
    {
        $this->address3 = $address3;
    }

    /**
     * Get address3.
     *
     * @return string
     */
    public function getAddress3()
    {
        return $this->address3;
    }

    /**
     * Set postcode.
     *
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * Get postcode.
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city.
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set countryCode.
     *
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * Get countryCode.
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set phone.
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set updatedAt.
     *
     * @param \Datetime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt.
     *
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt.
     *
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt.
     *
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param mixed $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
    }

    /**
     * @param string $sep
     *
     * @return string
     */
    public function getFullAddress($sep = ', ')
    {
        return self::formatAddress($this->getAddressArrayForRender(), $sep);
    }

    /**
     * @return array
     */
    public function getAddressArrayForRender()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'firstname' => $this->getFirstName(),
            'lastname' => $this->getLastname(),
            'address1' => $this->getAddress1(),
            'address2' => $this->getAddress2(),
            'address3' => $this->getAddress3(),
            'postcode' => $this->getPostcode(),
            'city' => $this->getCity(),
            'country_code' => $this->getCountryCode(),
        );
    }

    /**
     * @return string
     */
    public function getFullAddressHtml()
    {
        return $this->getFullAddress('<br/>');
    }

    public function __toString()
    {
        return $this->getName();
    }
}
