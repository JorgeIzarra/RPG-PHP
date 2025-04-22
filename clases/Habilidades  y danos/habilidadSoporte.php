<?php
/**
 * Clase para habilidades de tipo soporte (buffs/debuffs)
 * 
 * @author Gabriel (Estudiante 2)
 */

// Incluir la clase base y el sistema de efectos
require_once __DIR__ . '/Habilidad.php';
require_once __DIR__ . '/EfectoTemporal.php';

class HabilidadSoporte extends Habilidad {
    protected $tipoEfecto;      // Tipo de efecto (buff o debuff)
    protected $atributoAfectado; // Atributo que se modifica
    protected $valorModificador; // Valor de modificación (porcentaje)
    protected $duracion;        // Duración en turnos
    
    /**
     * Constructor para habilidades de soporte
     * 
     * @param string $nombre Nombre de la habilidad
     * @param string $descripcion Descripción de la habilidad
     * @param int $coste Coste de mana/energía
     * @param string $tipoEfecto Tipo de efecto ('buff' o 'debuff')
     * @param string $atributoAfectado Atributo afectado ('ataque', 'defensa', etc.)
     * @param float $valorModificador Valor de modificación (ej: 0.2 para +20%)
     * @param int $duracion Duración en turnos
     */
    public function __construct($nombre, $descripcion, $coste, $tipoEfecto, $atributoAfectado, $valorModificador, $duracion) {
        // Las habilidades de soporte no tienen daño base
        parent::__construct($nombre, $descripcion, $coste, 0, 'soporte');
        
        $this->tipoEfecto = $tipoEfecto;
        $this->atributoAfectado = $atributoAfectado;
        $this->valorModificador = $valorModificador;
        $this->duracion = $duracion;
    }
    
    /**
     * Aplica la habilidad de soporte al objetivo
     * 
     * @param Personaje $origen Personaje que usa la habilidad
     * @param Personaje $objetivo Personaje objetivo de la habilidad
     * @param int $ignorado Este parámetro no se usa en habilidades de soporte
     * @return string Resultado de la aplicación
     */
    public function aplicar($origen, $objetivo, $ignorado) {
        // Crear un nuevo efecto temporal
        $efecto = new EfectoTemporal(
            $this->nombre,
            $this->tipoEfecto,
            $this->atributoAfectado,
            $this->valorModificador,
            $this->duracion
        );
        
        // Aplicar el efecto al objetivo
        // Nota: Esta es una implementación simulada, ya que el sistema de efectos
        // temporales sería implementado por el Estudiante 3/4
        
        // Construir mensaje según el tipo de efecto
        if ($this->tipoEfecto === 'buff') {
            $mensaje = "{$origen->getNombre()} fortalece a {$objetivo->getNombre()} con {$this->nombre}. ";
            $mensaje .= "Su {$this->atributoAfectado} aumenta un " . ($this->valorModificador * 100) . "% por {$this->duracion} turnos.";
        } else {
            $mensaje = "{$origen->getNombre()} debilita a {$objetivo->getNombre()} con {$this->nombre}. ";
            $mensaje .= "Su {$this->atributoAfectado} disminuye un " . ($this->valorModificador * 100) . "% por {$this->duracion} turnos.";
        }
        
        return $mensaje;
    }
}
?>
