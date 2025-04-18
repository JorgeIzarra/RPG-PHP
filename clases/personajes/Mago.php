<?php
/**
 * Clase Mago - Personaje especializado en daño mágico
 * 
 * @author Estudiante 1
 */

// Incluir la clase base
require_once __DIR__ . '/Personaje.php';

/**
 * Clase Mago - Especializado en daño mágico
 */
class Mago extends Personaje {
    protected $manaRegen = 5; // Regeneración de mana por turno
    
    /**
     * Constructor específico para personajes tipo Mago
     * 
     * @param string $nombre Nombre del personaje
     */
    public function __construct($nombre) {
        // Definir las estadísticas base del mago
        $this->vidaMaxima = 80;    // Vida baja
        $this->manaMaximo = 200;   // Mana muy alto
        $this->poderAtaque = 1.5;  // Daño muy alto (150% del normal)
        $this->poderDefensa = 0.1; // Defensa baja (reduce 10% del daño)
        
        // Llamar al constructor padre
        parent::__construct($nombre);
    }
    
    /**
     * Regenera mana al inicio del turno
     * 
     * @return string Mensaje de regeneración
     */
    public function regenerarMana() {
        $this->recuperarMana($this->manaRegen);
        return "{$this->nombre} regenera {$this->manaRegen} de mana. Mana actual: {$this->manaActual}";
    }
    
    /**
     * Amplifica temporalmente el poder mágico
     * 
     * @param int $turnos Duración del efecto
     * @return string Mensaje del efecto
     */
    public function amplificarMagia($turnos = 2) {
        // Esta es una implementación básica. Para una versión completa,
        // se necesitaría un sistema de efectos temporales (Estudiante 3/4)
        $ataqueOriginal = $this->poderAtaque;
        $this->poderAtaque *= 1.4; // 40% más de poder mágico
        
        return "{$this->nombre} amplifica su poder mágico por {$turnos} turnos.";
    }
}
?>