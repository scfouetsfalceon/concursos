<?php

/**
 * Conjunto de Helpers para varios componentes necesarios necesarios
 * <code>
 * - Datagrid Sencillo
 * - Combos
 *  - Sexo
 *  - Tipo de institución
 *  - Estado Civil
 *  - Ocupacion
 *  - Grado de Instrucción
 *  - Tipo de Sangre
 *  - Religión
 *  - Nacionalidad
 *  - Grado Capacitación de Adultos
 * </code>
 *
 * @author jamp
 * @version 0.4
 *
 */
class Registro extends Form {

    /**
     * Helpers para crear un datagrid sencillo a partir de un ActiveRecord
     * Ejemplo:
     * Sin Opciones
     * <code>
     * $campos = array(
     *		'Codigo' => 'id',
     *		'Nombre' => 'nombre',
     *		'Telefono' => 'telefono',
     *		'Direccion' => 'direccion');
     * </code>
     * Con Opciones
     * <code>
     * $campos = array(
     *		'Codigo' => 'id',
     *		'Nombre' => 'nombre',
     *		'Telefono' => 'telefono',
     *		'Direccion' => 'direccion',
     *          'Opciones' => '$');
     *
     * $opciones = array(
     *		'Actulizar' => 'controlador/actualizar/',
     *		'Modificar' => 'controlador/modificar/',
     *		'Detalles' => 'controlador/detalles/',
     *		'Borrar' => 'controlador/borrar/');
     * </code>
     * Adicionales
     * <code>
     * $campos = array(
     *		'sexo' => 'Femenino|Masculino',
     *		'estado' => 'Activo|Inactivo',
     *		't_vivienda' => 'Propia|Alquilada|Heredada|Choza');
     * </code>
     * @param Object/Null $modelo
     * @param Array/Null $campos
     * @param Array/Null $opciones
     * @param Array/Null $adicionales
     * @return String
     */
    public static function datagrid($modelo = NULL, $campos = NULL, $opciones = NULL, $adicionales = NULL) {

        // Agregar el ccs para el datagrid
        Tag::css('datagrid');

        // Cabecera
        $grid = "<div id=\"datagrid\">";
        $grid .= "<table border=\"0px\" cellpadding=\"0px\" cellspacing=\"0px\" align=\"center\">";
        $grid .= "<thead><tr>";

        // Titulo de la tabla
        foreach ($campos as $titulo => $valor):

            // Campo pequeño si es Id o Código
            if ( $titulo == "C&oacute;digo" || $titulo == "Id" ):
                $grid .= "<th width=\"10px\">";
            else:
                $grid .= "<th>";
            endif;

            $grid .= $titulo;
            $grid .= "</th>";

        endforeach;

        $grid .= "</tr></thead><tbody>";
        $i = 1;

        // Datos de la tabla
        if (count($modelo)) :
            foreach ($modelo as $model):

                // Columnas pares o impares
                if ( ($i%2) == 0 ):
                    $colm = 'par';
                else:
                    $colm = 'impar';
                endif;
                $grid .= "<tr class=\"$colm\">";
                $i++;

                // Data
                foreach ($campos as $campo):

                    // Si es activado la fila Opciones
                    if ( $campo == '$' ):

                        $grid .= "<td align=\"center\" width=\"150\">";
                        $cant = count($opciones);
                        $j = 1;

                        foreach ($opciones as $opcion => $link):

                            $link = $link . $model->id;
                            $grid .= Html::link($link, $opcion);

                            if ($cant != $j):
                                 $grid .= " | ";
                            endif;

                            $j++;
                        endforeach;

                        $grid .= "</td>";
                    else:

                        // Centrar si el campo es el id
                        if ( $campo == "id" ):
                            $campoc = "align=\"center\"";
                        else:
                            $campoc = "align=\"left\"";
                        endif;

                        if (count($adicionales)) :
                            if (array_key_exists ($campo, $adicionales)):
                                    $addons = explode("|", $adicionales[$campo]);
                                    $grid .= "<td $campoc>" . $addons[$model->$campo] . "</td>";
                            else:
                                $grid .= "<td $campoc>" . $model->$campo . "</td>";
                            endif;
                        else:
                            $grid .= "<td $campoc>" . $model->$campo . "</td>";
                        endif;

                    endif;
                endforeach;

                $grid .= "</tr>";

            endforeach;
        else:
            $grid .= "<tr><td colspan='" . count($campos) . "' align='center'>No hay registros </td></tr>";
        endif;
        $grid .= "</tbody></table></div>";

        return $grid;
    }

    public static function contentgrid($contenido = NULL, $campos = NULL, $opciones = NULL, $adicionales = NULL) {

        // Agregar el ccs para el datagrid
        Tag::css('datagrid');

        // Cabecera
        $grid = "<div id=\"datagrid\">";
        $grid .= "<table border=\"0px\" cellpadding=\"0px\" cellspacing=\"0px\">";
        $grid .= "<thead><tr>";

        // Titulo de la tabla
        foreach ($campos as $titulo):

            // Campo pequeño si es Id o Código
            if ( $titulo == "C&oacute;digo" || $titulo == "Id" ):
                $grid .= "<th width=\"10px\">";
            else:
                $grid .= "<th>";
            endif;

            if ( $item == '$' ):
                $grid .= 'Opciones';
            else:
                $grid .= $titulo;
            endif;

            $grid .= "</th>";

        endforeach;

        $grid .= "</tr></thead><tbody>";
        $i = 1;

        // Datos de la tabla
        foreach ($contenido as $id => $item):

            // Columnas pares o impares
            if ( ($i%2) == 0 ):
                $colm = 'par';
            else:
                $colm = 'impar';
            endif;
            $grid .= "<tr class=\"$colm\">";
            $i++;

            // Si es activado la fila Opciones
            if ( $i == count($contenido) ):

                $grid .= "<td align=\"center\" width=\"150\">";
                $cant = count($opciones);
                $j = 1;

                foreach ($opciones as $opcion => $link):

                    $link = $link . $model->id;
                    $grid .= Html::link($link, $opcion);

                    if ($cant != $j):
                         $grid .= " | ";
                    endif;

                    $j++;
                endforeach;

                $grid .= "</td>";
            else:

                // Centrar si el campo es el id
                if ( $item == "id" ):
                    $campoc = "align=\"center\"";
                else:
                    $campoc = "align=\"left\"";
                endif;

                if (count($adicionales)) :
                    if (array_key_exists ($item, $adicionales)):
                            $addons = explode("|", $adicionales[$item]);
                            $grid .= "<td $campoc>" . $addons[$item] . "</td>";
                    else:
                        $grid .= "<td $campoc>" . $item . "</td>";
                    endif;
                else:
                    $grid .= "<td $campoc>" . $item . "</td>";
                endif;

            endif;

            $grid .= "</tr>";

        endforeach;

        $grid .= "</tbody></table></div>";

        return $grid;
    }

    /**
     * Helpers para crear un campo select para el tipo de institución educativa
     * @param String $field
     * @return String
     */
    public static function cmbEstudios($field, $attrs = NULL, $checked = NULL) {
        $data = array(
            0 => 'Público',
            1 => 'Privado'
        );
        return parent::select($field, $data, $attrs, $checked);
    }

    public static function linkAgregar($where = NULL) {
        if ( $where == '' ) {
            $where = $_SERVER['PHP_SELF'];
        }
        return Html::link($where, '<img src="' . PUBLIC_PATH . 'img/empty.png" class="add" border="0">');

    }

    /**
     * Campo numerico (html5)
     *
     * @param String $field
     * @param String $attrs
     * @param String $value
     * @return String
     */
    public static function number($field, $attrs = NULL, $value = NULL ) {
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);

        $id = self::_getIdClean($id);
        return "<input id=\"$id\" name=\"$name\" type=\"number\" value=\"$value\" $attrs/>";
    }

    /**
     * Campo telefono (html5)
     *
     * @param String $field
     * @param String $attrs
     * @param String $value
     * @return String
     */
    public static function tel($field, $attrs = NULL, $value = NULL ) {
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);

        $id = self::_getIdClean($id);
        return "<input id=\"$id\" name=\"$name\" type=\"tel\" value=\"$value\" data-type=\"local\" $attrs/>";
    }

    /**
     * Campo celular (html5)
     *
     * @param String $field
     * @param String $attrs
     * @param String $value
     * @return String
     */
    public static function cel($field, $attrs = NULL, $value = NULL ) {
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);

        $id = self::_getIdClean($id);
        return "<input id=\"$id\" name=\"$name\" type=\"tel\" value=\"$value\" data-type=\"celular\" $attrs/>";
    }

    /**
     * Campo email (html5)
     *
     * @param String $field
     * @param String $attrs
     * @param String $value
     * @return String
     */
    public static function email($field, $attrs = NULL, $value = NULL ) {
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);

        $id = self::_getIdClean($id);
        return "<input id=\"$id\" name=\"$name\" type=\"email\" value=\"$value\" $attrs/>";
    }



    /**
     * Campo calendario de fechas desde el actual hasta 100 años anteriores
     * Un datepicker jquery-ui
     *
     * @param String $field
     * @param String $attrs
     * @param String $value
     * @param Boolean $month
     * @param Boolean $year
     * @return String
     */
    public static function fecha($field, $attrs = NULL, $value = NULL ) {
        $actual = date('Y');
        $rangoano = ($actual - 100)  . ':' . $actual;  //yearRange: '2000:2010'
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        $value = ($value) ? strftime("%d/%m/%Y", strtotime($value)) : "";

        $id = self::_getIdClean($id);
        return "<input id=\"$id\" name=\"$name\" type=\"date\" value=\"$value\" $attrs/>";
    }

    /**
     * Campo almanaque posee los 10 años anteriores y posteriores al actual
     * Un datepicker con jquery-ui
     *
     * @param String $field
     * @param String $value
     * @param String $attrs
     * @param Boolean $month
     * @param Boolean $year
     * @return String
     */
    public static function almanaque($field, $attrs = NULL, $value = NULL) {
        $actual = date('Y');
        $rangoano = ($actual - 10)  . ':' . ($actual + 10);  //yearRange: '2000:2010'


        //$campo = "<input type=\"text\" value=\"$value\" name=\"$field\" id=\"$field\" $attrs size=\"12\" />"
        $campo = parent::text($field, $attrs, $value);
        $campo .= "\r\n<script>
	$(function() {
                $( \"#$field\" ).datepicker({
			showOn: \"button\",
			buttonImage: \"" . PUBLIC_PATH .  "img/calendario.gif\",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '$rangoano'
		});
                $.datepicker.setDefaults( $.datepicker.regional[ \"es\" ] );
                $.datepicker.formatDate(\"dd/mm/yy\");

	});
	</script>\r\n";

        return $campo;
    }

    /**
     * Campo calendario de fecha
     * Un datepicker con jquery-ui
     *
     * @param String $field
     * @param String $value
     * @param String $attrs
     * @param Boolean $month
     * @param Boolean $year
     * @return String
     */
    public static function calendario($field, $value = NULL,  $attrs = NULL) {
        $campo = "<input type=\"text\" value=\"$value\" name=\"$field\" id=\"$field\" $attrs size=\"12\" />

        <script>
	$(function() {
                $( \"#$field\" ).datepicker({
			showOn: \"button\",
			buttonImage: \"" . PUBLIC_PATH .  "img/calendario.gif\",
			buttonImageOnly: true,
			changeMonth: true,
		});
                $.datepicker.setDefaults( $.datepicker.regional[ \"es\" ] );
                $.datepicker.formatDate(\"dd/mm/yy\");

	});
	</script>";

        return $campo;
    }


    /**
     * Helpers para crear un campo select para el tipo de institución educativa
     * @param String $field
     * @return String
     */
    public static function cmbSexo($field, $attrs = NULL, $value = NULL) {
        $data = array(
            0 => 'Femenino',
            1 => 'Masculino'
        );
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para el estado civil
     * @param String $field
     * @return String
     */
    public static function cmbCivil($field, $attrs = NULL, $value = NULL) {
        $estados = "NO REFIRIO|SOLTERO(A)|CASADO(A)|DIVORCIADO(A)|CONCUBINATO|SEPARADO(A)|VIUDO(A)";
        $data = explode("|", $estados);
         if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para la ocupación
     * @param String $field
     * @return String
     */
    public static function cmbOcupacion($field, $attrs = NULL, $value = NULL) {
        $estados = "NO REFIRIO|ABOGADO|ADMINISTRADOR|ADUANA|AGENTE DE VIAJES|AGRICULTOR|AGRICULTOR|AGRONOMO|ALBAÑIL|ALGODONERO|ANALISTA DE SISTEMA|ARQUITECTO|ARTESANO|ARTISTA|ASEGURADOR|ASESOR DE SEGUROS|ASIST. ADMINISTRACION|AUDITOR|AUX. CONTABILIDAD|AUXILIAR PREESCOLAR|BIBLIOTECARIA|BIOANALISTA|BIOLOGO|BIONALISTA|BOMBERO|CHOFER|COMERCIANTE|COMUNICADOR SOCIAL|CONSERJE|CONSTRUCTOR|CONSULTANTE|CONSULTORA DE BELLEZA|CONTADOR|CORREDOR(A) DE SEGUROS|COSTURERA|DEFENSORA PUBLICA|DEL HOGAR|DESEMPLEADO|DIPUTADO|DISEÑADOR|DISEÑADOR DE GRAFICO|DOCENTE|ECONOMISTA|EJECUTIVO|EMBAJADOR|EMPLEADO|EMPRESARIO|ENFERMERA|ESCRITORA|ESTUDIANTE|FARMACEUTA|FISCAL|FISCAL DE TRANSITO|FOTOGRAFO|GEOLOGO|GERENTE|GERENTE|GERENTE DE PROYECTOS|GERENTE PREESCOLAR|INGENIERO|INGENIERO CIVIL|INGENIERO DE SISTEMA|INGENIERO ELECTRICO|INGENIERO HIDRAULICO|INGENIERO MECANICO|INGENIERO METALURGICO|INSTRUCTOR DEPORTE|INSTRUMENTISTA|JUBILADO(A)|JUEZ|LICENCIADO(A)|MAESTRO(A)|MANICURISTA|MECANICO|MEDICO|MILITAR|MINISTRO(A)|MODISTA|MOTORIZADO|OBRERO|ODONTOLOGO|OFICINISTA|OPERADOR DE MAQ.|ORTOPEDISTA|PASTOR|PELUQUERA(O)|PILOTO|POLICIA|POLITICO|PRESIDENTE|PRODUCTOR|PROFESOR|PROGRAMADOR ANALISTA|PSICOLOGA|PSICOPEDAGOGA|PUBLICISTA|QUIMICO|RECEPCIONISTA|SACERDOTE|SASTRE|SECRETARIA|SUPERVISOR|TECNICO|TECNICO MECANICO|TECNICO RADIOLOGO|TOPOGRAFO|TRABAJADOR(A) SOCIAL.|TRAUMATOLOGO|TSU ADMINISTRACION|TSU ELECTRONICA|TSU INFORMATICA|TSU MERCADEO|TUTORA|URBANISTA|VENDEDOR|VETERINARIO|VICE-PRESIDENTE";
        $data = explode("|", $estados);
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para el nivel de instruccion
     * @param String $field
     * @return String
     */
    public static function cmbInstruccion($field, $attrs = NULL, $value = NULL) {
        $estados = "NO REFIRIO|1ER GRADO|2DO GRADO|3ER GRADO|4TO GRADO|5TO GRADO|6TO GRADO|7MO GRADO|8VO GRADO|9NO GRADO|1ER AÑO CIENCIAS|1ER AÑO HUMANIDADES|1ER AÑO INDUSTRIAL|2DO AÑO CIENCIAS|2DO AÑO HUMANIDADES|2DO AÑO INDUSTRIAL|3ER AÑO INDUSTRIAL|BACHILLER CIENCIAS|BACHILLER HUMANIDADES|BACHILLER INDUSTRIAL|ABOGADO|BIOANALISTA|DOCTORADO|ESPECIALIZACIÓN|ESTUDIANTE UNIVERSITARIO|INGENIERO|LICENCIADO|MAESTRÍA|MÉDICO|ODONTOLOGO|PSICOLOGO|TÉCNICO MEDIO|TÉCNICO SUPERIOR|TÉCNICO SUPERIOR UNIVERSITARIO";
        $data = explode("|", $estados);
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para el tipo de sangre
     * @param String $field
     * @return String
     */
    public static function cmbSangre($field, $attrs = NULL, $value = NULL) {
        $estados = "NO REFIRIO|A RH POSITIVO|B RH POSITIVO|AB RH POSITIVO|O RH POSITIVO|A RH NEGATIVO|B RH NEGATIVO|AB RH NEGATIVO|O RH NEGATIVO";
        $data = explode("|", $estados);
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para la religión
     * @param String $field
     * @return String
     */
    public static function cmbReligion($field, $attrs = NULL, $value = NULL) {
        $estados = "NO REFIRIO|ADVENTISTA|ARECRISNA|ATEO|BUDISTA|CATOLICO|CRISTIANO|EVANGELICO|JUDIO|LUTERANO|MORMON|MUSULMAN|PROTESTANTE|TESTIGO DE JEHOVA|LA FUERZA";
        $data = explode("|", $estados);
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para la nacionalidad
     * @param String $field
     * @return String
     */
    public static function cmbNacionalidad($field, $attrs = NULL, $value = NULL) {
        $estados = "NO REFIRIO|ARGENTINA|BRASILEÑA|BRITANICO|CHILENA|CHINA|COLOMBIANA|DOMINICANO|ECUATORIANO|ESPAÑOL|ESTADOUNIDENSE|GUYANA|INDIA|ITALIANA|MEXICANA|PERUANA|PORTUGUES|TRINITARIO|URUGUAYO|VENEZOLANA";
        $data = explode("|", $estados);
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * @param String $field
     * @return String
     */
    public static function cmbCapacitacion($field, $attrs = NULL, $value = NULL) {
        $estados = "AYUDANTE DE DIRECTOR DE CURSO (3 TACOS)|CURSO DE PLANIFICACION Y PROGRAMACION|DIRECTOR DE CURSO (4 TACOS)|NIVEL AVANZADO ADULTOS (I.M.)|NIVEL AVANZADO CLAN (I.M.)|NIVEL AVANZADO INSTITUCIONAL (I.M.)|NIVEL AVANZADO MANADA (I.M.)|NIVEL AVANZADO TROPA (I.M.)|NIVEL AVANZADO UNICO (I.M.)|NIVEL BASICO|NIVEL ESPECIALIZADO|NIVEL INTERMEDIO ADULTOS|NIVEL INTERMEDIO CLAN|NIVEL INTERMEDIO INSTITUCIONAL|NIVEL INTERMEDIO MANADA|NIVEL INTERMEDIO TROPA|OTRO TIPO DE CURSO|TALLER DE JUEGOS Y CANCIONES SCOUTS";
        $data = explode("|", $estados);
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para la nacionalidad (V,E)
     * @param String $field
     * @param String/Nulll Optional $attrs
     * @param String/Nulll Optional $value
     * @return String
     */
    public static function cmbNac($field, $attrs = NULL, $value = NULL) {
        $data = Array('V'=>'V', 'E'=>'E');
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }


    //////////// CONCURSOS //////////////////////

    /**
     * Helpers para crear un campo select para la tipo de concursos
     * @param String $field
     * @param String/Nulll Optional $attrs
     * @param String/Nulll Optional $value
     * @return String
     */
    public static function selectTipo($field, $attrs = NULL, $value = NULL) {
        $data = Array('1'=>'CVAL', '2'=>'CAC');
        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        extract(self::_getFieldData($field, $value), EXTR_OVERWRITE);
        return parent::select($field, $data, $attrs, $value);
    }

    /**
     * Helpers para crear un campo select para la tipo de concursos
     * @param String $field
     * @param String/Nulll Optional $attrs
     * @param String/Nulll Optional $value
     * @return String
     */
    public static function selectNones($field, $attrs = NULL, $value = NULL) {
        $data = Array('1'=>'1', '2'=>'2', '3'=>'3', '5'=>'5');

        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        // Obtiene name, id y value (solo para autoload) para el campo y los carga en el scope
        extract(self::_getFieldData($field, $value === NULL), EXTR_OVERWRITE);

        $options = '';
        foreach ($data as $k => $v) {
            $k = htmlspecialchars($k, ENT_COMPAT, APP_CHARSET);
            $options .= "<option value=\"$k\"";
            // Si es array $value para select multiple se seleccionan todos
            if (is_array($value)) {
                if (in_array($k, $value)) {
                    $options .= ' selected="selected"';
                }
            } else {
                if ($k == $value) {
                    $options .= ' selected="selected"';
                }
            }
            $options .= '>' . htmlspecialchars($v, ENT_COMPAT, APP_CHARSET) . '</option>';
        }

        $id = self::_getIdClean($id);
        return "<select id=\"$id\" name=\"$name\" $attrs>$options</select>";
    }


    /**
     * Helpers para crear un campo select para la tipo de concursos
     * @param String $field
     * @param String/Nulll Optional $attrs
     * @param String/Nulll Optional $value
     * @return String
     */
    public static function selectPares($field, $attrs = NULL, $value = NULL) {
        $data = Array('2'=>'2', '4'=>'4', '6'=>'6', '8'=>'8');

        if (is_array($attrs)) {
            $attrs = Tag::getAttrs($attrs);
        }

        // Obtiene name, id y value (solo para autoload) para el campo y los carga en el scope
        extract(self::_getFieldData($field, $value === NULL), EXTR_OVERWRITE);

        $options = '';
        foreach ($data as $k => $v) {
            $k = htmlspecialchars($k, ENT_COMPAT, APP_CHARSET);
            $options .= "<option value=\"$k\"";
            // Si es array $value para select multiple se seleccionan todos
            if (is_array($value)) {
                if (in_array($k, $value)) {
                    $options .= ' selected="selected"';
                }
            } else {
                if ($k == $value) {
                    $options .= ' selected="selected"';
                }
            }
            $options .= '>' . htmlspecialchars($v, ENT_COMPAT, APP_CHARSET) . '</option>';
        }

        $id = self::_getIdClean($id);
        return "<select id=\"$id\" name=\"$name\" $attrs>$options</select>";
    }

    protected static function _getIdClean($id){
        return strtr($id, array(']'=>'', '['=>'_'));
    }

}

?>
