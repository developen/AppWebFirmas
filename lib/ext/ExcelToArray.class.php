<?php 
// Lanza todos los errores
error_reporting(E_ALL  | E_STRICT);
// Tiempo ilimitado para el script
set_time_limit(0);
 
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
 
class ExcelToArray
{
    /**
     * Contiene Las Extenciones Permitidas para Excel.
     * @var Array 
     */
    private $_tipoExcel = array('xlsx'  => 'Excel2007',
                                'xls'   => 'Excel5');
 
    /**
     * Contiene la Cantidad de Columnas del Archivo Excel.
     * @var integer 
     */
    private $_columnas  = 0;
 
    /**
     * Contiene la Cantidad de Filas del Archivo Excel.
     * @var integer 
     */
    private $_filas     = 0;
 
    /**
     * Contiene el Titulo que sera el Identificador.
     * @var string 
     */
    private $_id;
 
    /**
     * Contiene el Arreglo Generado a partir del Excel.
     * @var array
     */
    private $_excel     = array();
 
    /**
     * Contiene los Encabezados del Archivo Excel.
     * @var array 
     */
    private $_titulos   = array();
 
    /**
     * Contiene la ruta y nombre del Archivo.
     * @var type 
     */
    private $_file;
 
    /**
     * Contiene el Tipo del Archivo Excel para PHPExcel.
     * @var string 
     */
    private $_tipoPHPExcel;
 
    /**
     * Contiene el objeto tipo Hoja de calculo.
     * @var PHPExcel_Worksheet
     */
    private $_objWorksheet;
 
 
    /**
     * Constructor de Clase.
     * @param   string  $file   Ruta y nombre del Archivo.
     * @throws  Exception       Lanza exepcion si el archivo no existe o si,
     *                          no es de una extencion valida.
     */
    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception('Error : El archivo no pudo ser Encontrado');
        }
 
        $this->_file= $file;
        $ext        = substr(strrchr($file, '.'), 1);
 
        if (!isset($this->_tipoExcel[$ext])) {
            throw new Exception('Error : El archivo no es de un tipo Valido');
        }
        $this->_tipoPHPExcel    = $this->_tipoExcel[$ext];
 
    }
 
    /**
     * Carga la Hoja Excel y Retorna el Arreglo.
     * @param string $id    Contiene el nombre del encabezado que sera tomado como Id.
     *                      Si no se proporciona o no existe sera la primera columnas.
     * @return array
     */
    public function loadExcel($id = '')
    {
        $this->_createObjWorksheet();
        // Extraigo los Titulos
        for ($i=0; $i<= $this->_columnas-1; $i++) {
            $this->_titulos[$i] = $this->_objWorksheet->getCellByColumnAndRow($i, 1)->getCalculatedValue();
        }
        // Verifica el Campo Identificador
        $this->_id      = (in_array($id, $this->_titulos))? $id : $this->_titulos[0];
 
        // Levanto todos los Datos
        for ($fila = 2; $fila <= $this->_filas; $fila++) {
            $dFilas = array();
            for ($columna = 0; $columna <= $this->_columnas-1; $columna++) {
                $dFilas[$this->_titulos[$columna]] = 
                        $this->_objWorksheet->getCellByColumnAndRow($columna, $fila)->getCalculatedValue();
            }
            //$this->_excel[$dFilas[$this->_id]] = $dFilas; 
            $this->_excel[$fila-1] = $dFilas; 
        }
 
        return $this->_excel;
    }
 
    /**
     * Metodo Privado que crea el Objeto WorkSheet.
     * @return PHPExcel_Worksheet
     */
    private function _createObjWorksheet()
    {
 
        if (!$this->_objWorksheet instanceof  PHPExcel_Worksheet) {
            // Creo un objeto de Lectura con el tipo de Archivo Correcto Excel20007(xlsx), Excel5(xls)
            $objReader  = PHPExcel_IOFactory::createReader($this->_tipoPHPExcel);
            // Configuro que sera solo para leer el archivo
            $objReader	->setReadDataOnly(true);
            // Cargo el Archivo
            $objPHPExcel            = $objReader->load($this->_file);
            $this->_objWorksheet    = $objPHPExcel->getActiveSheet();
            $this->_columnas        = PHPExcel_Cell::columnIndexFromString($this->_objWorksheet->getHighestColumn());
            $this->_filas           = $this->_objWorksheet->getHighestRow();            
        } 
        return $this->_objWorksheet;
    }
 
    /**
     * Retorna el Campo seleccionado como Identificador.
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
 
    /**
     * Retorna la Cantidad de Columnas del Archivo Excel.
     * @return integer
     */
    public function countColumns()
    {
        return $this->_columnas;
    }
 
    /**
     * Retorna la Cantidad de Filas del Archivo Excel.
     * @return integer
     */
    public function countRows()
    {
        return $this->_filas;
    }
 
    /**
     * Retorna si una Columna Existe o no.
     * @param   string  $nombreColumna  Nombre de la columna.
     * @return  boolean
     */
    public function isColumn($nombreColumna) 
    {
        return isset($this->_titulos[$nombreColumna]);
    }
 
    /**
     * Retorna el Arreglo Generado.
     * @return array
     */
    public function getArray()
    {
        return $this->_excel;
    }
 
    /**
     * Retorna los Titulos del Archivo Excel.
     * @return array
     */
    public function getTitulos()
    {
        return $this->_titulos;
    }
 
    /**
     * Retorna el registro para el id establecido.
     * @param   string  $id     Nombre del Identificador.
     * @return  array
     */
    public function findId($id)
    {
        $retorno    = false;
        if (isset($this->_excel[$id])) {
            $retorno = $this->_excel[$id];
        }
 
        return $retorno;
    }
 
    /**
     * Retorna un arreglo con el valor buscado en la columna indicada.
     * Busqueda Exacta.
     * @param   string  $titulo     Titulo de la Columna
     * @param   string  $valor      Valor a buscar
     * @return  array
     */
    public function findByColumn($titulo, $valor)
    {
       return $this->_search($this->_excel, $titulo, $valor);
    }
 
    /**
     * Extraida de :
     * @link http://php.net/manual/es/function.array-search.php
     */
    private function _search($array, $key, $value)
    {
        $results = array();
        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value ) {
                $results[] = $array;
            }  
            foreach ($array as $subarray) {
                $results = array_merge($results, $this->_search($subarray, $key, $value));
            }  
        }
        return $results;
    }  
 
    /**
     * Retorna un arreglo con el valor buscado en la columna indicada o no y la cantidad 
     * de veces que aparece el valor en las columnas si no se indica la misma.
     * La busqueda es por valor aproximado.
     * @param   string  $buscar     Valor a Buscar
     * @param   string  $calve      Titulo de La columna donde se buscara o nada por Cualquiera.
     * @return  array
     */
    public function findByCount($buscar, $titulo = null) 
    {
        return $this->_recursiveArraySearchAll($this->_excel, $buscar, $titulo);
    }
 
    /**
     * Extraida de :
     * @link http://php.net/manual/es/function.array-search.php
     */        
    private function _recursiveArraySearchAll($haystack, $needle, $index = null)
    {
        $arrIterator    = new RecursiveArrayIterator($haystack);
        $recIterator    = new RecursiveIteratorIterator($arrIterator);
        $resultkeys     = array();
 
        while($recIterator->valid()) {
            if (!is_array($recIterator->current())) {
                if ((isset($index) AND $recIterator->key() == $index  AND strpos($recIterator->current(), $needle) !== false ) 
                    OR (!isset($index) AND strpos($recIterator->current(), $needle) !== false)) {
 
                    $resultkeys[$arrIterator->key()] = isset($resultkeys[$arrIterator->key()])?  $resultkeys[$arrIterator->key()] + 1 : 1;
                }
            }            
            $recIterator->next();
        }
        arsort($resultkeys);
        return $resultkeys;               
    }    
 
 
    /**
     * Metodo ordenar.
     * Ordena los resultados de acuerdo a la clave elegida.
     * @param   string  $clave  Clave por la cual se quiere ordenar(titulo de columna).
     * @param   boolean $asc    true para ascendente, false para descendente.
     * @return  array
     */
    public function sort($campo = 'name', $asc = true)
    {
        if (empty($this->_excel)) {
            throw new Exception('Primero debe usar la funcion loadExcel');
        }
        $arrSort    = $this->_excel;
 
        $ordenarPor = (in_array($campo, $this->_titulos))? $campo : $this->_id;
        $ascDesc    = ($asc)? SORT_ASC : SORT_DESC;
        $caracter   = 0;
 
        foreach ($arrSort as $ordenado) {
            $tmpArray[] = $ordenado[$ordenarPor];
            $caracter   = is_string($ordenado[$ordenarPor])? $caracter+1 : $caracter;
        }
 
        $numero     = ($caracter)? SORT_STRING : SORT_NUMERIC;
 
        array_multisort($tmpArray, $ascDesc, $numero, $arrSort);
        return $arrSort;
    } 
 
    /**
     * Retorna el Valor para una Celda Dada, buscando por el Array.
     * @param   string  $celda  Celda Excel tipo A1
     * @return  mixed   Valor de la Celda
     */
    public function getValueCellFromArray($celda)
    {
        $excelOriginal  = array_values($this->_excel);
        list($columna, $fila) = PHPExcel_Cell::coordinateFromString($celda);
        $columna        = PHPExcel_Cell::columnIndexFromString($columna);
 
        if ( ($fila) > $this->_filas || ($columna) > $this->_columnas ) {
            return null;
        }
 
        $retorno    = null;
        if ($fila == 1) {
            $retorno    = $this->_titulos[$columna - 1];
        } else {
            $excelOriginal  = array_values($excelOriginal[$fila - 2]);
            $retorno   = $excelOriginal[$columna - 1];
        }
       return $retorno ;
    }
 
    /**
     * Retorna el Valor de una Celda Especifica, sin tener que realizar la 
     * carga del Arreglo.
     * @param   string  $celda  Referencia de Celda tipo A1
     * @return  mixed
     */
    public function getValueCellFromExcel($celda)
    {
        list($columna, $fila) = PHPExcel_Cell::coordinateFromString($celda);
        $columna    = PHPExcel_Cell::columnIndexFromString($columna);
 
        return $this->_createObjWorksheet()->getCellByColumnAndRow($columna - 1, $fila)->getCalculatedValue();
    }
}