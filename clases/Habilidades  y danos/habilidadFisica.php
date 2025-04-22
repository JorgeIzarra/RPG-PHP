<?php
/**
 * Clase para habilidades de tipo físico
 * 
 * @author Gabriel (Estudiante 2)
 */

// Incluir la clase base y la calculadora
require_once __DIR__ . '/Habilidad.php';
require_once __DIR__ . '/CalculadoraDaño.php';

class HabilidadFisica extends Habilidad {
    /**
     * Constructor para habilidades físicas
     * 
     * @param string $nombre Nombre de la habilidad
     * @param string $descripcion Descripción de la habilidad
     * @param int $coste Coste de mana/energía
     * @param int $dañoBase Daño base de la habilidad
     */
    public function __construct($nombre, $descripcion, $coste, $dañoBase) {
        // Las habilidades físicas siempre tienen tipo de daño físico
        parent::__construct($nombre, $descripcion, $coste, $dañoBase, TipoDaño::FISICO);
        
        // Las habilidades físicas tienen mayor probabilidad de crítico
        $this->probabilidadCritico = 0.1; // 10% base
    }
    
    /**
     * Aplica la habilidad física al objetivo
     * 
     * @param Personaje $origen Personaje que usa la habilidad
     * @param Personaje $objetivo Personaje objetivo de la habilidad
     * @param int $dañoModificado Daño base modificado por el poder de ataque
     * @return string Resultado de la aplicación
     */
    public function aplicar($origen, $objetivo, $dañoModificado) {
        // Verificar si es un golpe crítico
        // Para el Guerrero, obtenemos su furia como bonus de crítico
        $bonusCritico = 0;
        if (get_class($origen) === 'Guerrero') {
            $bonusCritico = $origen->getFuria() / 100; // Convertir furia a porcentaje
        }
        
        $esCritico = $this->esCritico($bonusCritico);
        
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
        $mensaje = "{$origen->getNombre()} usa {$this->nombre} contra {$objetivo->getNombre()}. ";
        
        if (!empty($resultado['mensaje'])) {
            $mensaje .= $resultado['mensaje'];
        }
        
        $mensaje .= "\n" . $mensajeResultado;
        
        return $mensaje;
    }
}
?>