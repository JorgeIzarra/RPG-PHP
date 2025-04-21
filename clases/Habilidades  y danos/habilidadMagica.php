<?php
/**
 * Clase para habilidades de tipo mágico
 * 
 * @author Gabriel (Estudiante 2)
 */

// Incluir la clase base y la calculadora
require_once __DIR__ . '/Habilidad.php';
require_once __DIR__ . '/CalculadoraDaño.php';

class HabilidadMagica extends Habilidad {
    /**
     * Constructor para habilidades mágicas
     * 
     * @param string $nombre Nombre de la habilidad
     * @param string $descripcion Descripción de la habilidad
     * @param int $coste Coste de mana/energía
     * @param int $dañoBase Daño base de la habilidad
     * @param string $tipoDaño Tipo de daño mágico (magico, fuego, hielo, rayo)
     */
    public function __construct($nombre, $descripcion, $coste, $dañoBase, $tipoDaño) {
        // Verificar que el tipo de daño sea válido para magia
        $tiposDañoValidos = [TipoDaño::MAGICO, TipoDaño::FUEGO, TipoDaño::HIELO, TipoDaño::RAYO];
        
        if (!in_array($tipoDaño, $tiposDañoValidos)) {
            $tipoDaño = TipoDaño::MAGICO; // Valor por defecto si no es válido
        }
        
        parent::__construct($nombre, $descripcion, $coste, $dañoBase, $tipoDaño);
        
        // Las habilidades mágicas tienen menor probabilidad de crítico pero mayor daño
        $this->probabilidadCritico = 0.05; // 5% base
        $this->multiplicadorCritico = 2.0; // 200% daño en crítico
    }
    
    /**
     * Aplica la habilidad mágica al objetivo
     * 
     * @param Personaje $origen Personaje que usa la habilidad
     * @param Personaje $objetivo Personaje objetivo de la habilidad
     * @param int $dañoModificado Daño base modificado por el poder de ataque
     * @return string Resultado de la aplicación
     */
    public function aplicar($origen, $objetivo, $dañoModificado) {
        // Verificar si es un golpe crítico
        $esCritico = $this->esCritico();
        
        // Para el Mago, aumentamos el daño si está amplificado
        // Esto es solo un ejemplo, ya que la amplificación real se manejaría con el sistema de efectos
        if (get_class($origen) === 'Mago') {
            // Asumimos que el mago tiene un 20% más de daño cuando usa amplificarMagia
            // Esto es solo una simulación, el sistema real usaría efectos temporales
            $dañoModificado = round($dañoModificado * 1.2);
        }
        
        // Calcular daño final
        $resultado = CalculadoraDaño::calcularDaño(
            $origen, 
            $objetivo, 
            $dañoModificado, 
            $this->tipoDaño, 
            $esCritico, 
            $this->multiplicadorCritico
        );
        
        // Aplicar el daño al objetivo
        $mensajeResultado = $objetivo->recibirDaño($resultado['daño']);
        
        // Construir mensaje completo
        $mensaje = "{$origen->getNombre()} lanza {$this->nombre} a {$objetivo->getNombre()}. ";
        
        if (!empty($resultado['mensaje'])) {
            $mensaje .= $resultado['mensaje'];
        }
        
        $mensaje .= "\n" . $mensajeResultado;
        
        return $mensaje;
    }
}
?>