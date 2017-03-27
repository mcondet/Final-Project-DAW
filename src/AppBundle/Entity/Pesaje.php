<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pesaje
 * @ORM\Entity()
 */
class Pesaje
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @var \DateTime
     * @ORM\Column(type="time")
     */
    private $horaInicio;

    /**
     * @var \DateTime
     * @ORM\Column(type="time")
     */
    private $horaFin;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $peso;

    /**
     * @var float
     * @ORM\Column(type="float", precision=2)
     */
    private $rendimiento;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $sancion;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $observaciones;

    /**
     * @var Tipo
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tipo", inversedBy="pesajes")
     */
    private $tipo;

    /**
     * @var Lote
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lote", inversedBy="pesaje")
     */
    private $lote;

    /**
     * @var Bascula
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bascula", inversedBy="pesajes")
     */
    private $bascula;

    /**
     * @var Finca
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Finca", inversedBy="pesajes")
     */
    private $finca;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Pesaje
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
     * Set horaInicio
     *
     * @param \DateTime $horaInicio
     *
     * @return Pesaje
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return \DateTime
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFin
     *
     * @param \DateTime $horaFin
     *
     * @return Pesaje
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    /**
     * Get horaFin
     *
     * @return \DateTime
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * Set peso
     *
     * @param integer $peso
     *
     * @return Pesaje
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return integer
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set rendimiento
     *
     * @param float $rendimiento
     *
     * @return Pesaje
     */
    public function setRendimiento($rendimiento)
    {
        $this->rendimiento = $rendimiento;

        return $this;
    }

    /**
     * Get rendimiento
     *
     * @return float
     */
    public function getRendimiento()
    {
        return $this->rendimiento;
    }

    /**
     * Set sancion
     *
     * @param integer $sancion
     *
     * @return Pesaje
     */
    public function setSancion($sancion)
    {
        $this->sancion = $sancion;

        return $this;
    }

    /**
     * Get sancion
     *
     * @return integer
     */
    public function getSancion()
    {
        return $this->sancion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Pesaje
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set tipo
     *
     * @param \AppBundle\Entity\Tipo $tipo
     *
     * @return Pesaje
     */
    public function setTipo(\AppBundle\Entity\Tipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set lote
     *
     * @param \AppBundle\Entity\Lote $lote
     *
     * @return Pesaje
     */
    public function setLote(\AppBundle\Entity\Lote $lote = null)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return \AppBundle\Entity\Lote
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set bascula
     *
     * @param \AppBundle\Entity\Bascula $bascula
     *
     * @return Pesaje
     */
    public function setBascula(\AppBundle\Entity\Bascula $bascula = null)
    {
        $this->bascula = $bascula;

        return $this;
    }

    /**
     * Get bascula
     *
     * @return \AppBundle\Entity\Bascula
     */
    public function getBascula()
    {
        return $this->bascula;
    }

    /**
     * Set finca
     *
     * @param \AppBundle\Entity\Finca $finca
     *
     * @return Pesaje
     */
    public function setFinca(\AppBundle\Entity\Finca $finca = null)
    {
        $this->finca = $finca;

        return $this;
    }

    /**
     * Get finca
     *
     * @return \AppBundle\Entity\Finca
     */
    public function getFinca()
    {
        return $this->finca;
    }
}
