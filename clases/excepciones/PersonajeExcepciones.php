<?php
/**
 * Excepciones personalizadas para el sistema de personajes
 * 
 * Este archivo contiene todas las excepciones relacionadas con 
 * el manejo de personajes en el sistema de combate RPG.
 * 
 * @author Jorge Izarra
 */

/**
 * Excepción lanzada cuando se intenta usar una habilidad que no existe en el repertorio
 */
class HabilidadInexistenteException extends Exception {
    public function __construct($mensaje = "La habilidad no existe", $codigo = 0, Exception $anterior = null) {
        parent::__construct($mensaje, $codigo, $anterior);
    }
}

/**
 * Excepción lanzada cuando no hay suficiente mana para ejecutar una habilidad
 */
class ManaInsuficienteException extends Exception {
    public function __construct($mensaje = "No hay suficiente mana", $codigo = 0, Exception $anterior = null) {
        parent::__construct($mensaje, $codigo, $anterior);
    }
}

/**
 * Excepción lanzada cuando se intenta realizar una acción con un personaje derrotado
 */
class PersonajeMuertoException extends Exception {
    public function __construct($mensaje = "El personaje está derrotado", $codigo = 0, Exception $anterior = null) {
        parent::__construct($mensaje, $codigo, $anterior);
    }
}
?>