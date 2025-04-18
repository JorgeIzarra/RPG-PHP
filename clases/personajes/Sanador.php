<?php
/**
 * Clase Sanador - Personaje especializado en curación y soporte
 * 
 * @author Estudiante 1
 */

// Incluir la clase base
require_once __DIR__ . '/Personaje.php';

/**
 * Clase Sanador - Especializado en curación y soporte
 */
class Sanador extends Personaje {
    protected $poderCuracion = 1.8; // Efectividad de las habilidades de curación
    
    /**
     * Constructor específico para personajes tipo Sanador
     * 
     * @param string $nombre Nombre del personaje
     */
    public function __construct($nombre) {
        // Definir las estadísticas base del sanador
        $this->vidaMaxima = 100;   // Vida media
        $this->manaMaximo = 180;   // Mana alto
        $this->poderAtaque = 0.6;  // Daño bajo (60% del normal)
        $this->poderDefensa = 0.15;// Defensa baja-media (reduce 15% del daño)
        
        // Llamar al constructor padre
        parent::__construct($nombre);
    }
    
    /**
     * Cura a un personaje objetivo
     * 
     * @param Personaje $objetivo Personaje a curar
     * @param int $cantidad Cantidad base de curación
     * @return string Resultado de la curación
     * @throws ManaInsuficienteException Si no hay suficiente mana
     */
    public function curar($objetivo, $cantidad = 30) {
        // Costo de mana para curar
        $costeMana = 15;
        
        // Verificar si hay suficiente mana
        if ($this->manaActual < $costeMana) {
            throw new ManaInsuficienteException("Mana insuficiente para curar. Se requiere: {$costeMana}, Disponible: {$this->manaActual}");
        }
        
        // Reducir el mana
        $this->manaActual -= $costeMana;
        
        // Calcular la curación final con el poder de curación
        $curacionFinal = round($cantidad * $this->poderCuracion);
        
        // Aplicar la curación al objetivo
        $resultado = $objetivo->recuperarVida($curacionFinal);
        
        return "{$this->nombre} cura a {$objetivo->getNombre()} por {$curacionFinal} de vida.";
    }
    
    /**
     * Intenta revivir a un personaje caído
     * 
     * @param Personaje $objetivo Personaje a revivir
     * @return string Resultado del intento de resurrección
     * @throws ManaInsuficienteException Si no hay suficiente mana
     */
    public function resucitar($objetivo) {
        // Costo de mana alto para resucitar
        $costeMana = 50;
        
        // Verificar si hay suficiente mana
        if ($this->manaActual < $costeMana) {
            throw new ManaInsuficienteException("Mana insuficiente para resucitar. Se requiere: {$costeMana}, Disponible: {$this->manaActual}");
        }
        
        // Solo funciona en personajes muertos
        if ($objetivo->estaVivo()) {
            return "{$objetivo->getNombre()} ya está vivo, no se puede resucitar.";
        }
        
        // Reducir el mana
        $this->manaActual -= $costeMana;
        
        // Resucitar con un 30% de la vida máxima (esto requerirá ajustes en la clase Personaje)
        // Esta es una implementación básica. Para una versión completa,
        // se necesitaría un sistema de vida/muerte más elaborado (Estudiante 3/4)
        
        // En esta versión simulada, solo devolvemos el mensaje
        return "{$this->nombre} intenta resucitar a {$objetivo->getNombre()} pero necesita implementación adicional.";
    }
}
?>