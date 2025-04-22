<?php 
//Gabriel Garcia 8-962-407

abstract class Habilidades {
    protected $nombre; //nombre de la habilidad
    protected $descripcion;
    protected$coste;
    protected $danoBase;
    protected $tipoDano;
    protected $probabilidadCritico =0.05; // 5%
    protected $multiplicadorCritico = 1.5 ; //150%

        /**
     * Constructor para inicializar la habilidad
     * 
     * @param string $nombre Nombre de la habilidad
     * @param string $descripcion Descripción de la habilidad
     * @param int $coste Coste de mana/energía
     * @param int $dañoBase Daño base de la habilidad
     * @param string $tipoDaño Tipo de daño
     */

     public function __construct($nombre, $descripcion, $coste, $dañoBase, $tipoDaño) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->coste = $coste;
        $this->dañoBase = $dañoBase;
        $this->tipoDaño = $tipoDaño;
    }

        /**
     * Método abstracto para aplicar la habilidad
     * Debe ser implementado por las clases hijas
     * 
     * @param Personaje $origen Personaje que usa la habilidad
     * @param Personaje $objetivo Personaje objetivo de la habilidad
     * @param int $dañoModificado Daño base modificado por el poder de ataque
     * @return string Resultado de la aplicación
     */
    abstract public function aplicar($origen, $objetivo, $dañoModificado);
    
    /**
     * Calcula si un ataque es crítico
     * 
     * @param float $bonusCritico Bonus adicional a la probabilidad de crítico
     * @return bool true si es crítico, false si no
     */
    protected function esCritico($bonusCritico = 0) {
        $probabilidadTotal = $this->probabilidadCritico + $bonusCritico;
        return mt_rand(1, 100) <= ($probabilidadTotal * 100);
    }
    
    /**
     * Getters para los atributos
     */
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function getCoste() {
        return $this->coste;
    }
    
    public function getDañoBase() {
        return $this->dañoBase;
    }
    
    public function getTipoDaño() {
        return $this->tipoDaño;
    }
    
    /**
     * Devuelve la información completa de la habilidad
     * 
     * @return array Array asociativo con la información
     */
    public function getInfo() {
        return [
            'nombre' => getNombre(),
            'descripcion' => getDescripcion(),
            'coste' => getCoste(),
            'dañoBase' => getDañoBase(),
            'tipoDaño' => getTipoDaño()
        ];
    }
}

?>