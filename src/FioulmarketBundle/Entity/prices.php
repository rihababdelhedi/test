<?php

namespace FioulmarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;

/**
 * prices
 *
 * @ORM\Table(name="prices")
 * @ORM\Entity(repositoryClass="FioulmarketBundle\Repository\pricesRepository")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class prices {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="postal_code_id", type="integer")
     * @JMSSerializer\Expose
     */
    private $postalCodeId;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="string", length=255)
     * @JMSSerializer\Expose
     */
    private $amount;

    /**
     * @var \date
     *
     * @ORM\Column(name="date", type="date")
     * @JMSSerializer\Expose
     */
    private $date;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set postalCodeId
     *
     * @param integer $postalCodeId
     *
     * @return prices
     */
    public function setPostalCodeId($postalCodeId) {
        $this->postalCodeId = $postalCodeId;

        return $this;
    }

    /**
     * Get postalCodeId
     *
     * @return int
     */
    public function getPostalCodeId() {
        return $this->postalCodeId;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return prices
     */
    public function setAmount($amount) {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \date $date
     *
     * @return prices
     */
    public function setDate($date) {

        $this->date = \DateTime::createFromFormat("Y-m-d", $date);

        return $this;
    }

    /**
     * Get date
     *
     * @return \date
     */
    public function getDate() {
        return $this->date;
    }

}
