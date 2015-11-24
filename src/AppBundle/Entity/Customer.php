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

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Customer.
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity
 * @Hateoas\Relation("self", href = "expr('/api/customers/' ~ object.getId())")
 */
class Customer extends \Sylius\Component\User\Model\Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $lastName;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="employee")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;

    public function __toString()
    {
        return (string) $this->getUser()->getUsername();
    }
}
