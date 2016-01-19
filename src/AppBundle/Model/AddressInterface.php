<?php

namespace AppBundle\Model;

interface AddressInterface
{
    const TYPE_BILLING  = 1;
    const TYPE_DELIVERY = 2;
    const TYPE_CONTACT  = 3;


    /**
     * @return string return the address name
     */
    public function getName();

    /**
     * @return string return the address firstname
     */
    public function getFirstname();

    /**
     * @return string return the address lastname
     */
    public function getLastname();

    /**
     * @return string return the address (line 1)
     */
    public function getAddress1();

    /**
     * @return string return the address (line 2)
     */
    public function getAddress2();

    /**
     * @return string return the address (line 3)
     */
    public function getAddress3();

    /**
     * @return string return the postcode
     */
    public function getPostcode();

    /**
     * @return string return the city
     */
    public function getCity();

    /**
     * @return string return the ISO country code
     */
    public function getCountryCode();

    /**
     * @return string return the phone number linked to the address
     */
    public function getPhone();

    /**
     * @return bool Is it the current address?
     */
    public function isCurrent();

    /**
     * Sets if this address is the current
     *
     * @param boolean $current
     */
    public function setCurrent($current);

    public function getBusiness();

    /**
     */
    public function setBusiness($business);

    /**
     * @return int Address' type
     */
    public function getType();

    /**
     * Returns the HTML string representation of the address
     *
     * @return string
     */
    public function getFullAddressHtml();
}
