<?php
/**
 * Clase abstracta base para todos los personajes
 * 
 * Define la estructura y comportamiento común para todos los tipos de personajes
 * en el sistema de combate RPG.
 * 
 * @author Jorge Izarra
 */

// Incluir las excepciones necesarias
require_once __DIR__ . '/../excepciones/PersonajeExcepciones.php';

/**
 * Clase abstracta que define la base para todos los personajes
 */
abstract class Personaje {
    // Atributos básicos
    protected $nombre;          // Nombre del personaje
    protected $vidaMaxima;      // Puntos de vida máximos
    protected $vidaActual;      // Puntos de vida actuales
    protected $manaMaximo;      // Puntos de mana/energía máximos
    protected $manaActual;      // Puntos de mana/energía actuales
    
    // Estadísticas de combate
    protected $poderAtaque;     // Multiplicador de daño base
    protected $poderDefensa;    // Reducción porcentual de daño recibido
    
    // Sistema de niveles
    protected $nivel = 1;       // Nivel actual del personaje
    protected $experiencia = 0; // Experiencia actual
    protected $expSiguienteNivel = 100; // Experiencia para subir al siguiente nivel
    
    // Colección de habilidades aprendidas (array asociativo)
    protected $habilidades = []; // ['nombreHabilidad' => objetoHabilidad]

    /**
     * Constructor para inicializar el personaje
     * 
     * @param string $nombre Nombre del personaje
     */
    public function __construct($nombre) {
        $this->nombre = $nombre;
        // Las estadísticas base se definen en las subclases
        
        // Inicializar con vida y mana completos
        $this->vidaActual = $this->vidaMaxima;
        $this->manaActual = $this->manaMaximo;
    }

    /**
     * Añade una nueva habilidad al repertorio del personaje
     * 
     * @param Habilidad $habilidad Objeto habilidad a aprender
     * @return string Mensaje de confirmación
     */
    public function aprenderHabilidad($habilidad) {
        // Almacenar la habilidad en el array usando su nombre como clave
        $this->habilidades[$habilidad->getNombre()] = $habilidad;
        
        // Devolver mensaje de confirmación para la interfaz
        return "{$this->nombre} aprendió: {$habilidad->getNombre()}";
    }

    /**
     * Ejecuta una habilidad contra un objetivo
     * 
     * @param string $nombreHabilidad Nombre de la habilidad a ejecutar
     * @param Personaje $objetivo Personaje objetivo de la habilidad
     * @throws HabilidadInexistenteException Si la habilidad no existe
     * @throws ManaInsuficienteException Si no hay suficiente mana
     * @throws PersonajeMuertoException Si el personaje está muerto
     * @return string Resultado de la ejecución
     */
    public function ejecutarHabilidad($nombreHabilidad, Personaje $objetivo) {
        // Verificar si el personaje está vivo
        if (!$this->estaVivo()) {
            throw new PersonajeMuertoException("{$this->nombre} está derrotado y no puede usar habilidades.");
        }
        
        // Verificar si la habilidad existe
        if (!isset($this->habilidades[$nombreHabilidad])) {
            throw new HabilidadInexistenteException("La habilidad $nombreHabilidad no existe en el repertorio de {$this->nombre}.");
        }
        
        $habilidad = $this->habilidades[$nombreHabilidad];
        
        // Verificar si hay suficiente mana
        if ($this->manaActual < $habilidad->getCoste()) {
            throw new ManaInsuficienteException("Mana insuficiente para usar $nombreHabilidad. Se requiere: {$habilidad->getCoste()}, Disponible: {$this->manaActual}");
        }
        
        // Reducir el mana
        $this->manaActual -= $habilidad->getCoste();
        
        // Calcular el daño base modificado por el poder de ataque
        $dañoBase = $habilidad->getDañoBase();
        $dañoModificado = round($dañoBase * $this->poderAtaque);
        
        // Aplicar la habilidad (esto conectará con el sistema de daño desarrollado por el Estudiante 2)
        // Nota para Estudiante 2: Aquí deberás implementar la lógica del tipo de daño
        $resultadoHabilidad = $habilidad->aplicar($this, $objetivo, $dañoModificado);
        
        return $resultadoHabilidad;
    }

    /**
     * Recibe daño y actualiza la vida del personaje
     * 
     * @param int $cantidad Cantidad de daño a recibir
     * @return string Mensaje describiendo el resultado
     */
    public function recibirDaño($cantidad) {
        // Aplicar reducción de daño según la defensa
        $dañoReducido = $cantidad * (1 - $this->poderDefensa);
        $dañoFinal = max(1, round($dañoReducido)); // Al menos 1 de daño siempre
        
        // Reducir la vida actual
        $this->vidaActual -= $dañoFinal;
        
        // No permitir vida negativa
        if ($this->vidaActual < 0) {
            $this->vidaActual = 0;
        }
        
        // Generar mensaje de resultado
        $mensaje = "{$this->nombre} recibió {$dañoFinal} de daño. Vida restante: {$this->vidaActual}";
        
        // Verificar si el personaje ha sido derrotado
        if (!$this->estaVivo()) {
            $mensaje .= "\n¡{$this->nombre} ha sido derrotado!";
        }
        
        return $mensaje;
    }

    /**
     * Verifica si el personaje tiene vida
     * 
     * @return bool true si el personaje está vivo, false si está derrotado
     */
    public function estaVivo() {
        return $this->vidaActual > 0;
    }

    /**
     * Recupera una cantidad de mana
     * 
     * @param int $cantidad Cantidad de mana a recuperar
     * @return void
     */
    public function recuperarMana($cantidad) {
        $this->manaActual += $cantidad;
        
        // No exceder el máximo de mana
        if ($this->manaActual > $this->manaMaximo) {
            $this->manaActual = $this->manaMaximo;
        }
    }

    /**
     * Recupera una cantidad de vida
     * 
     * @param int $cantidad Cantidad de vida a recuperar
     * @return string Mensaje describiendo el resultado
     */
    public function recuperarVida($cantidad) {
        // Solo recuperar vida si el personaje está vivo
        if (!$this->estaVivo()) {
            return "{$this->nombre} está derrotado y no puede recuperar vida.";
        }
        
        $this->vidaActual += $cantidad;
        
        // No exceder el máximo de vida
        if ($this->vidaActual > $this->vidaMaxima) {
            $this->vidaActual = $this->vidaMaxima;
        }
        
        return "{$this->nombre} recuperó {$cantidad} de vida. Vida actual: {$this->vidaActual}";
    }

    /**
     * Devuelve las estadísticas actuales del personaje
     * 
     * @return array Array asociativo con las estadísticas
     */
    public function getEstadisticas() {
        return [
            'nombre' => $this->nombre,
            'nivel' => $this->nivel,
            'experiencia' => $this->experiencia,
            'expSiguienteNivel' => $this->expSiguienteNivel,
            'vidaActual' => $this->vidaActual,
            'vidaMaxima' => $this->vidaMaxima,
            'manaActual' => $this->manaActual,
            'manaMaximo' => $this->manaMaximo,
            'poderAtaque' => $this->poderAtaque,
            'poderDefensa' => $this->poderDefensa,
            'habilidades' => array_keys($this->habilidades) // Solo los nombres de las habilidades
        ];
    }

    /**
     * Devuelve el nombre del personaje
     * 
     * @return string Nombre del personaje
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Devuelve la vida actual del personaje
     * 
     * @return int Vida actual
     */
    public function getVidaActual() {
        return $this->vidaActual;
    }

    /**
     * Devuelve el mana actual del personaje
     * 
     * @return int Mana actual
     */
    public function getManaActual() {
        return $this->manaActual;
    }
    
    /**
     * Añade experiencia al personaje y comprueba si sube de nivel
     * 
     * @param int $cantidad Cantidad de experiencia a añadir
     * @return string Mensaje describiendo el resultado
     */
    public function ganarExperiencia($cantidad) {
        $this->experiencia += $cantidad;
        $mensaje = "{$this->nombre} ganó {$cantidad} de experiencia.";
        
        // Comprobar si el personaje sube de nivel
        if ($this->experiencia >= $this->expSiguienteNivel) {
            $mensaje .= "\n" . $this->subirNivel();
        }
        
        return $mensaje;
    }
    
    /**
     * Sube de nivel al personaje y mejora sus estadísticas
     * 
     * @return string Mensaje describiendo el resultado
     */
    protected function subirNivel() {
        $this->nivel++;
        
        // Calcular experiencia para el siguiente nivel (aumenta con cada nivel)
        $this->experiencia -= $this->expSiguienteNivel;
        $this->expSiguienteNivel = round($this->expSiguienteNivel * 1.5);
        
        // Mejorar estadísticas base (cada clase puede sobrescribir este método)
        $aumentoVida = round($this->vidaMaxima * 0.1); // +10% de vida máxima
        $aumentoMana = round($this->manaMaximo * 0.1); // +10% de mana máximo
        
        $this->vidaMaxima += $aumentoVida;
        $this->manaMaximo += $aumentoMana;
        
        // Recuperar vida y mana al subir de nivel
        $this->vidaActual = $this->vidaMaxima;
        $this->manaActual = $this->manaMaximo;
        
        // Pequeña mejora en daño y defensa
        $this->poderAtaque *= 1.05; // +5% de poder de ataque
        $this->poderDefensa *= 1.05; // +5% de poder de defensa
        
        return "¡{$this->nombre} subió a nivel {$this->nivel}!";
    }
    
    /**
     * Devuelve el nivel actual del personaje
     * 
     * @return int Nivel actual
     */
    public function getNivel() {
        return $this->nivel;
    }
    
    /**
     * Devuelve la experiencia actual del personaje
     * 
     * @return int Experiencia actual
     */
    public function getExperiencia() {
        return $this->experiencia;
    }
}
?>