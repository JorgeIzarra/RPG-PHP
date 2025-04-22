<?php
/**
 * Clase para habilidades de tipo curativo
 * 
 * @author Gabriel (Estudiante 2)
 */

// Incluir la clase base y la calculadora
require_once __DIR__ . '/Habilidad.php';
require_once __DIR__ . '/CalculadoraDaño.php';

class HabilidadCurativa extends Habilidad {
    /**
     * Constructor para habilidades curativas
     * 
     * @param string $nombre Nombre de la habilidad
     * @param string $descripcion Descripción de la habilidad
     * @param int $coste Coste de mana/energía
     * @param int $curacionBase Cantidad base de curación
     */
    public function __construct($nombre, $descripcion, $coste, $curacionBase) {
        // Las habilidades curativas siempre tienen tipo CURACION
        parent::__construct($nombre, $descripcion, $coste, $curacionBase, TipoDaño::CURACION);
        
        // Las habilidades curativas también pueden ser críticas
        $this->probabilidadCritico = 0.05; // 5% base
        $this->multiplicadorCritico = 1.5; // 150% curación en crítico
    }
    
    /**
     * Aplica la habilidad curativa al objetivo
     * 
     * @param Personaje $origen Personaje que usa la habilidad
     * @param Personaje $objetivo Personaje objetivo de la habilidad
     * @param int $curacionModificada Curación base modificada por el poder de ataque
     * @return string Resultado de la aplicación
     */
    public function aplicar($origen, $objetivo, $curacionModificada) {
        // Verificar si es una curación crítica
        $esCritico = $this->esCritico();
        
        // Para el Sanador, aumentamos la curación según su poder de curación
        if (get_class($origen) === 'Sanador') {
            // Asumimos que el sanador tiene un atributo poderCuracion
            // Esto es una simulación, el sistema real accedería al atributo
            $curacionModificada = round($curacionModificada * 1.8); // 180% de curación
        }
        
        // Si es crítico, aumentar la curación
        if ($esCritico) {
            $curacionModificada = round($curacionModificada * $this->multiplicadorCritico);
        }
        
        // Aplicar la curación al objetivo
        $mensajeResultado = $objetivo->recuperarVida($curacionModificada);
        
        // Construir mensaje completo
        $mensaje = "{$origen->getNombre()} usa {$this->nombre} en {$objetivo->getNombre()}. ";
        
        if ($esCritico) {
            $mensaje .= "¡Curación crítica! ";
        }
        
        $mensaje .= "\n" . $mensajeResultado;
        
        return $mensaje;
    }
}
?>