<?php
/**
 * Clase Tanque - Personaje especializado en absorber daño
 * 
 * @author Estudiante 1
 */

// Incluir la clase base
require_once __DIR__ . '/Personaje.php';

/**
 * Clase Tanque - Especializado en absorber daño
 */
class Tanque extends Personaje {
    /**
     * Constructor específico para personajes tipo Tanque
     * 
     * @param string $nombre Nombre del personaje
     */
    public function __construct($nombre) {
        // Definir las estadísticas base del tanque
        $this->vidaMaxima = 200;   // Alta vida
        $this->manaMaximo = 50;    // Bajo mana
        $this->poderAtaque = 0.8;  // Daño reducido (80% del normal)
        $this->poderDefensa = 0.4; // Alta defensa (reduce 40% del daño)
        
        // Llamar al constructor padre
        parent::__construct($nombre);
    }
    
    /**
     * Habilidad especial del Tanque: Aumentar defensa temporalmente
     * 
     * @param int $turnos Duración del efecto
     * @return string Mensaje describiendo el efecto
     */
    public function aumentarDefensa($turnos = 3) {
        // Esta es una implementación básica. Para una versión completa,
        // necesitaríamos un sistema de efectos temporales (Estudiante 3/4)
        $defensaOriginal = $this->poderDefensa;
        $this->poderDefensa *= 1.5; // Aumenta 50% la defensa
        
        return "{$this->nombre} adopta una postura defensiva, aumentando su defensa por {$turnos} turnos.";
    }
    
    /**
     * Habilidad de provocación para atraer ataques enemigos
     * 
     * @param Personaje $objetivo Enemigo a provocar
     * @return string Mensaje de la provocación
     */
    public function provocar($objetivo) {
        // Esta es una implementación básica. Para una versión completa,
        // se necesitaría implementar un sistema de agro (Estudiante 3/4)
        return "{$this->nombre} provoca a {$objetivo->getNombre()}, atrayendo su atención.";
    }
}
?>