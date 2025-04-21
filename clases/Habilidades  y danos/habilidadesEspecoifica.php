<?php
/**
 * Habilidades específicas para cada tipo de personaje
 * 
 * @author Gabriel (Estudiante 2)
 */

// Incluir las clases de habilidades
require_once __DIR__ . '/HabilidadFisica.php';
require_once __DIR__ . '/HabilidadMagica.php';
require_once __DIR__ . '/HabilidadCurativa.php';
require_once __DIR__ . '/HabilidadSoporte.php';
require_once __DIR__ . '/TipoDaño.php';

/**
 * Clase para crear y gestionar habilidades específicas para cada personaje
 */
class HabilidadesEspecificas {
    /**
     * Crea las habilidades básicas para un Tanque
     * 
     * @return array Array de objetos Habilidad
     */
    public static function crearHabilidadesTanque() {
        $habilidades = [];
        
        // Habilidad física básica
        $habilidades[] = new HabilidadFisica(
            "Golpe Escudo",
            "Golpea al enemigo con el escudo causando daño moderado",
            5, // coste mana
            20  // daño base
        );
        
        // Habilidad de provocación
        $habilidades[] = new HabilidadSoporte(
            "Provocar",
            "Provoca al enemigo para que te ataque a ti",
            10, // coste mana
            'debuff', // tipo efecto
            'objetivo', // atributo afectado (simulado)
            0.0, // valor modificador (no aplica)
            2  // duración
        );
        
        // Habilidad de defensa
        $habilidades[] = new HabilidadSoporte(
            "Postura Defensiva",
            "Aumenta tu defensa temporalmente",
            15, // coste mana
            'buff', // tipo efecto
            'defensa', // atributo afectado
            0.5, // +50% defensa
            3  // duración
        );
        
        // Habilidad de área
        $habilidades[] = new HabilidadFisica(
            "Golpe Atronador",
            "Golpea el suelo causando daño a todos los enemigos cercanos",
            25, // coste mana
            30  // daño base
        );
        
        return $habilidades;
    }
    
    /**
     * Crea las habilidades básicas para un Guerrero
     * 
     * @return array Array de objetos Habilidad
     */
    public static function crearHabilidadesGuerrero() {
        $habilidades = [];
        
        // Habilidad física básica
        $habilidades[] = new HabilidadFisica(
            "Tajo Rápido",
            "Ataque rápido que causa daño moderado",
            5, // coste mana
            25  // daño base
        );
        
        // Habilidad de furia
        $habilidades[] = new HabilidadFisica(
            "Golpe Crítico",
            "Concentra tu furia para aumentar la probabilidad de crítico",
            15, // coste mana
            35  // daño base
        );
        
        // Habilidad de daño alto
        $habilidades[] = new HabilidadFisica(
            "Golpe Devastador",
            "Ataque poderoso que causa gran daño",
            20, // coste mana
            50  // daño base
        );
        
        // Habilidad de buff
        $habilidades[] = new HabilidadSoporte(
            "Furia Berserker",
            "Aumenta tu poder de ataque temporalmente",
            25, // coste mana
            'buff', // tipo efecto
            'ataque', // atributo afectado
            0.3, // +30% ataque
            3  // duración
        );
        
        return $habilidades;
    }
    
    /**
     * Crea las habilidades básicas para un Mago
     * 
     * @return array Array de objetos Habilidad
     */
    public static function crearHabilidadesMago() {
        $habilidades = [];
        
        // Habilidad mágica básica
        $habilidades[] = new HabilidadMagica(
            "Proyectil Arcano",
            "Lanza un proyectil de energía arcana",
            10, // coste mana
            30, // daño base
            TipoDaño::MAGICO  // tipo daño
        );
        
        // Habilidad de fuego
        $habilidades[] = new HabilidadMagica(
            "Bola de Fuego",
            "Lanza una bola de fuego que causa daño por quemadura",
            20, // coste mana
            40, // daño base
            TipoDaño::FUEGO  // tipo daño
        );
        
        // Habilidad de hielo
        $habilidades[] = new HabilidadMagica(
            "Rayo de Hielo",
            "Lanza un rayo helado que ralentiza al enemigo",
            20, // coste mana
            35, // daño base
            TipoDaño::HIELO  // tipo daño
        );
        
        // Habilidad de rayo
        $habilidades[] = new HabilidadMagica(
            "Relámpago",
            "Invoca un relámpago que causa gran daño",
            30, // coste mana
            50, // daño base
            TipoDaño::RAYO  // tipo daño
        );
        
        // Habilidad de amplificación
        $habilidades[] = new HabilidadSoporte(
            "Amplificar Magia",
            "Aumenta tu poder mágico temporalmente",
            25, // coste mana
            'buff', // tipo efecto
            'ataque', // atributo afectado
            0.4, // +40% poder mágico
            2  // duración
        );
        
        return $habilidades;
    }
    
    /**
     * Crea las habilidades básicas para un Sanador
     * 
     * @return array Array de objetos Habilidad
     */
    public static function crearHabilidadesSanador() {
        $habilidades = [];
        
        // Habilidad curativa básica
        $habilidades[] = new HabilidadCurativa(
            "Curación Menor",
            "Cura una pequeña cantidad de vida a un aliado",
            15, // coste mana
            30  // curación base
        );
        
        // Habilidad curativa avanzada
        $habilidades[] = new HabilidadCurativa(
            "Curación Mayor",
            "Cura una gran cantidad de vida a un aliado",
            30, // coste mana
            60  // curación base
        );
        
        // Habilidad de buff
        $habilidades[] = new HabilidadSoporte(
            "Bendición",
            "Aumenta la defensa de un aliado temporalmente",
            20, // coste mana
            'buff', // tipo efecto
            'defensa', // atributo afectado
            0.2, // +20% defensa
            3  // duración
        );
        
        // Habilidad de ataque
        $habilidades[] = new HabilidadMagica(
            "Castigo Divino",
            "Causa daño mágico moderado a un enemigo",
            20, // coste mana
            25, // daño base
            TipoDaño::MAGICO  // tipo daño
        );
        
        // Habilidad de resurrección
        $habilidades[] = new HabilidadSoporte(
            "Resurrección",
            "Revive a un aliado caído con un porcentaje de su vida",
            50, // coste mana
            'buff', // tipo efecto
            'vida', // atributo afectado
            0.3, // 30% de vida máxima
            1  // duración (instantáneo)
        );
        
        return $habilidades;
    }
}
?>