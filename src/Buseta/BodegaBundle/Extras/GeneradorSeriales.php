<?php

namespace Buseta\BodegaBundle\Extras;

class GeneradorSeriales
{
    const CANTIDAD_MAXIMA_SERIALES = 10000;
    const LONGITUD_MAXIMA_SERIAL_NUM = 10;

    const TOKEN_FIJO = 1;
    const TOKEN_RANGO = 2;
    const TOKEN_ERROR = 3;

    const EXPRESION_UNICA = 1;
    const EXPRESION_DERANGOS = 2;

    const MSG_TOKEN_ERROR = 'Existen elementos no validos';
    const MSG_ORDEN_ERROR = 'Error en el orden de los elementos';
    const MSG_COMPAR_ERROR = 'Existe un rango no valido';
    const MSG_MAXIM_ERROR = 'Fue Sobrepasado el limite maximo de seriales permitido';    //los Token de rango no son consecutivos, ej. ,58-60,+hgf5, 5-89, no puede haber alfa entre 2 rangos numericos
    const MSG_LENGTH_ERROR = 'Fue Sobrepasado el limite de caracteres permitido para un serial';
    const MSG_OTRO_ERROR = 'Existen Errores'; //error de comparacion, dentro de un token rango,ej. 568-510

    //cadena entrada paraseparar en array de seriales
    private $str_serial = '';
    //para conocer el error
    private $last_error = '';

    private $car_sep_tokens_rango = ';';  //caracter separador de tokens de rango
    private $car_indic_token_fijo = '+';  //caracter indicador de token fijo

    private $car_separacion_rango = '-';  //caracter de separacion de rango
    private $car_separador_expres = ',';  //caracter separador de expresiones

    private $cantidadSeriales = 0;
    private $cantidadDuplicados = 0;

    public function __construct($str_serial = '')
    {
        $this->setStrSerial($str_serial);
    }

    /**
     * @param $str
     * @return int
     */
    public function getTipoExpresion($str)
    {
        $pos1 = strpos($str, $this->car_sep_tokens_rango /*','*/);
        $pos2 = strpos($str, $this->car_separacion_rango /*'-'*/);
        if (($pos1 === false) && ($pos2 === false)) {
            return $this::EXPRESION_UNICA;
        } else {
            return $this::EXPRESION_DERANGOS;
        }
    }


    /**
     * @param string $str_serial
     * @return array|bool
     */
    public function getListaDeSeriales($str_serial = '')
    {
        try {
            //Quito la string de los errores anteriores
            $this->last_error = '';
            //Quito la asignacion que tenga la variable $cantidadSeriales y $cantidadDuplicados
            $this->cantidadSeriales = 0;
            $this->cantidadDuplicados = 0;

            $lista_seriales = array();
            //si viene sin parametros, tomar el establecido mediante SET o el _contructor
            $str = $str_serial !== '' ? $str_serial : $this->str_serial;

            $expresiones = explode($this->car_separador_expres /*';'*/, trim($str));

            foreach ($expresiones as $expresion) {
                if ($this->getTipoExpresion($expresion) == $this::EXPRESION_UNICA) {

                    if ($this->validarSerialUnico($expresion)) {
                        $lista_seriales[] = $expresion;//agregar al array
                    } else {
                        return false;
                    }

                } else {

                    $listaSerialesRangos = $this->getListaDeSerialesRango($expresion);
                    if ($listaSerialesRangos) {
                        $lista_seriales = array_merge($lista_seriales, $listaSerialesRangos);
                    } else {
                        return false;
                    }
                }
                //comprobar maximo
                if (count($lista_seriales) > $this::CANTIDAD_MAXIMA_SERIALES) {
                    $this->setLastError($this::MSG_MAXIM_ERROR);
                    return false;
                }

            }

            $cantidad_seriales_sin_array_unique = count($lista_seriales);

            //quitar los elementos repetidos del array de resultados
            $lista_seriales = array_unique($lista_seriales);

            //ordeno el array
            sort($lista_seriales, SORT_NATURAL | SORT_FLAG_CASE);

            //se lo asigno a la variable global para llamar al metodo getCantidadSeriales().
            $this->cantidadSeriales = count($lista_seriales);

            //establezco cantidad de duplicados
            $this->cantidadDuplicados = $cantidad_seriales_sin_array_unique - $this->cantidadSeriales;

            return $lista_seriales;

        } catch (\Exception $e) {
            $this->setLastError($this::MSG_OTRO_ERROR);
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function normalizarStr($val)
    {
        //llevar a mayusculas y quitar espacios en blanco
        return preg_replace('/\s+/', '', strtoupper($val));
    }

    /**
     * @param $serial
     * @return bool
     */
    public function validarSerialUnico($serial)
    {

        if (!preg_match('/^([a-zA-Z0-9]+)$/', $serial)) {
            $this->setLastError($this::MSG_TOKEN_ERROR);
            return false;
        }

        //valido la longitud de cualquier serial, sea numero entero o string
        if (strlen($serial) >= $this::LONGITUD_MAXIMA_SERIAL_NUM) {
            $this->setLastError($this::MSG_LENGTH_ERROR);
            return false;
        }

        return true;
    }

    /**
     * @param $str_serial
     */
    public function setStrSerial($str_serial)
    {
        $this->str_serial = $this->normalizarStr($str_serial);
    }

    /**
     * @return string
     */
    public function getLastError()
    {
        return $this->last_error;
    }

    /**
     * @param $last_error
     */
    public function setLastError($last_error)
    {
        $this->last_error = $last_error;
    }

    /**
     * @param $str
     * @return array|bool
     */
    public function getListaDeSerialesRango($str)
    {
        $lista_tokens = array();

        //validacion de orden de los seriales
        $tokens = $this->separarEnTokens($str);

        $tokenAlfaInicial = '';
        $tokenAlfaFinal = '';

        $total = count($tokens);

        $limiteArrayInicial = 0;
        $limiteArrayFinal = $total;

        if ($this->getTipoToken($tokens[0]) == $this::TOKEN_FIJO) {
            $limiteArrayInicial = 1;
            $tokenAlfaInicial = $this->normalizarTokenFijo($tokens[0]);
        };

        if ($this->getTipoToken($tokens[$total - 1]) == $this::TOKEN_FIJO) {
            $limiteArrayFinal = $total - 1;
            $tokenAlfaFinal = $this->normalizarTokenFijo($tokens[$total - 1]);
        }

        $cantidad_total = 0;
        //ciclo a traves de la secuencia de tokens de rangos numericos
        for ($i = $limiteArrayInicial; $i < $limiteArrayFinal; $i++) {

            // echo $this->validartipotoken( $tokens[$i] );
            $nextToken = $this->getTipoToken($tokens[$i]);
            if ($nextToken == $this::TOKEN_RANGO) {

                $tokenSerializado = $this->generarSerialesDesdeTokenRango($tokens[$i]);

                foreach ($tokenSerializado as $token) {
                    $lista_tokens[] = $tokenAlfaInicial . '' . $token . '' . $tokenAlfaFinal;
                    $cantidad_total++;
                    if ($cantidad_total > $this::CANTIDAD_MAXIMA_SERIALES) {
                        $this->setLastError($this::MSG_MAXIM_ERROR);
                        return false;
                    }
                }

            } elseif ($nextToken == $this::TOKEN_FIJO) {
                $this->setLastError($this::MSG_ORDEN_ERROR);
                return false;
            } else {
                $this->setLastError($this::MSG_TOKEN_ERROR);
                return false;
            }
        }

        return ($lista_tokens);
    }

    /**
     * @param $str
     * @return array
     */
    public function separarEnTokens($str)
    {
        return explode($this->car_sep_tokens_rango/*','*/, $str);
    }

    /**
     * @return string
     */
    public function getSerial()
    {
        return $this->str_serial;
    }

    /**
     * @param $token
     * @return int
     */
    public function getTipoToken($token)
    {

        // if (preg_match('/^[\d]{1,10}[-]?[\d]{1,10}$/i', $token)) {
        if (preg_match('/^[\d]{1,20}[' . $this->car_separacion_rango . ']?[\d]{1,20}$/i', $token)) {
            return $this::TOKEN_RANGO;
        }

        //un token numerico tambien lo devuelvo como rango ( un rango de uno solo )
        if (preg_match('/^[\d]{1,20}$/i', $token)) {
            return $this::TOKEN_RANGO;
        }

        //if (preg_match('/^([+][a-zA-Z0-9]+)$/', $token)) {
        if (preg_match('/^([' . $this->car_indic_token_fijo . '][a-zA-Z0-9]+)$/', $token)) {
            return $this::TOKEN_FIJO;
        }

        $this->setLastError($this::MSG_TOKEN_ERROR);
        return $this::TOKEN_ERROR;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function normalizarTokenFijo($token)
    {
        //quitar el signo + y otros que interese quitar mas adelante
        //return preg_replace('/\+/', '', strtoupper($token));
        return preg_replace('/\\' . $this->car_indic_token_fijo . '/', '', strtoupper($token));
    }

    /**
     * @param $token
     * @return array|bool
     */
    public function generarSerialesDesdeTokenRango($token)
    {
        $result = array();
        if (strpos($token, '-') === false) {
            $result[0] = $token;
            //  return $token; //poner en array
        } else {
            $str = explode('-', $token);
            $num_ini = $str[0];
            $num_fin = $str[1];

            if (strlen($num_fin) >= $this::LONGITUD_MAXIMA_SERIAL_NUM) {
                $this->setLastError($this::MSG_LENGTH_ERROR);
                return false;
            }

            if ($num_ini < $num_fin) {
                $j = 0;
                for ($i = $num_ini; $i <= $num_fin; $i++) {
                    $result[$j++] = $i;
                };
            } else {
                $this->setLastError($this::MSG_ORDEN_ERROR);
                return false;
            }
        }
        return $result;
    }

    /**
     * @return int
     */
    public function getCantidadSeriales()
    {
        return $this->cantidadSeriales;
    }

    /**
     * @return int
     */
    public function getCantidadDuplicados()
    {
        return $this->cantidadDuplicados;
    }


    public function  getListaDeSerialesImprimir($seriales)
    {
        $str='';
        foreach ($seriales as $serial){
            $str.=$serial.',';
        }
        return $str;
    }

}


/////////////////////////////////
//Ejemplo de uso
/*$cas = new GeneradorSeriales();

$seriales = $cas->getListaDeSeriales('565-700;+aw,566-700');

if ($seriales) {
    //array con listado de seriales
    echo('<pre>');
    var_dump($seriales);
    echo sprintf('Cantidad de elementos: %s con: %s duplicados', $cas->getCantidadSeriales() ,$cas->getCantidadDuplicados() );  //para verificar coincidencias
    echo $cas->getListaDeSerialesImprimir($seriales);
} else {
    echo 'Ocurrieron Errores-> ' . $cas->getLasterror();
}*/
