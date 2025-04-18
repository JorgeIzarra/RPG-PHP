<?php
/**
 * Clase Guerrero - Personaje especializado en daño físico
 * 
 * @author Estudiante 1
 */

// Incluir la clase base
require_once __DIR__ . '/Personaje.php';

/**
 * Clase Guerrero - Especializado en daño físico
 */
class Guerrero extends Personaje {
    protected $furia = 0; // Recurso especial del guerrero
    
    /**
     * Constructor específico para personajes tipo Guerrero
     * 
     * @param string $nombre Nombre del personaje
     */
    public function __construct($nombre) {
        // Definir las estadísticas base del guerrero
        $this->vidaMaxima = 150;   // Vida media-alta
        $this->manaMaximo = 70;    // Mana medio-bajo
        $this->poderAtaque = 1.3;  // Daño alto (130% del normal)
        $this->poderDefensa = 0.2; // Defensa media (reduce 20% del daño)
        
        // Llamar al constructor padre
        parent::__construct($nombre);
    }
    
    /**
     * Sobrescribir recibirDaño para acumular furia
     * 
     * @param int $cantidad Cantidad de daño a recibir
     * @return string Mensaje describiendo el resultado
     */
    public function recibirDaño($cantidad) {
        // Acumular furia al recibir daño (10% del daño)
        $this->furia += round($cantidad * 0.1);
        
        // Llamar al método padre para el resto de la lógica
        return parent::recibirDaño($cantidad);
    }
    
    /**
     * Habilidad especial: Golpe Crítico con mayor probabilidad
     * 
     * @param Personaje $objetivo Objetivo del golpe
     * @return string Resultado del golpe
     */
    public function golpeCritico($objetivo) {
        // Consumir furia para aumentar probabilidad de crítico
        $bonusCritico = min(30, $this->furia); // Máximo 30% adicional
        $this->furia = 0; // Consumir toda la furia
        
        // Esta es una implementación básica. Para la versión completa,
        // necesitaría integrarse con el sistema de daño (Estudiante 2)
        return "{$this->nombre} concentra su furia en un golpe poderoso contra {$objetivo->getNombre()} (+" . $bonusCritico . "% probabilidad crítica).";
    }
    
    /**
     * Obtener la furia actual
     * 
     * @return int Cantidad de furia acumulada
     */
    public function getFuria() {
        return $this->furia;
    }
}
?>