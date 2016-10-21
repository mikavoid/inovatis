<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva
 *
 * @ORM\Table(name="tva")
 * @ORM\Entity
 */
class Tva
{
    /**
     * @var float
     *
     * @ORM\Column(name="amount_tva", type="float", precision=10, scale=0, nullable=false)
     */
    private $amountTva;

    /**
     * @var string
     *
     * @ORM\Column(name="country_tva", type="string", length=50, nullable=false)
     */
    private $countryTva;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tva", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTva;



    /**
     * Set amountTva
     *
     * @param float $amountTva
     *
     * @return Tva
     */
    public function setAmountTva($amountTva)
    {
        $this->amountTva = $amountTva;

        return $this;
    }

    /**
     * Get amountTva
     *
     * @return float
     */
    public function getAmountTva()
    {
        return $this->amountTva;
    }

    /**
     * Set countryTva
     *
     * @param string $countryTva
     *
     * @return Tva
     */
    public function setCountryTva($countryTva)
    {
        $this->countryTva = $countryTva;

        return $this;
    }

    /**
     * Get countryTva
     *
     * @return string
     */
    public function getCountryTva()
    {
        return $this->countryTva;
    }

    /**
     * Get idTva
     *
     * @return integer
     */
    public function getIdTva()
    {
        return $this->idTva;
    }
}
