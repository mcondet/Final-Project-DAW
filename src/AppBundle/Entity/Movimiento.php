<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Movimiento
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovimientoRepository")
 */
class Movimiento
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $concepto;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $cantidad;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @var Temporada
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Temporada", inversedBy="movimientos")
     */
    private $temporada;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     *
     * @return Movimiento
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set cantidad
     *
     * @param float $cantidad
     *
     * @return Movimiento
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return float
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Movimiento
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set temporada
     *
     * @param \AppBundle\Entity\Temporada $temporada
     *
     * @return Movimiento
     */
    public function setTemporada(\AppBundle\Entity\Temporada $temporada = null)
    {
        $this->temporada = $temporada;

        return $this;
    }

    /**
     * Get temporada
     *
     * @return \AppBundle\Entity\Temporada
     */
    public function getTemporada()
    {
        return $this->temporada;
    }
}
