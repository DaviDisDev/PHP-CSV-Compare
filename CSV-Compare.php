<?php
class SWB_CSV
{
    protected $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function readCSV(): array
    {
        $file = fopen($this->file, "r");

        $data = array();

        if ($file !== FALSE) {

            while (($datos = fgetcsv($file, 0, ";")) !== FALSE) {

                $registro = array();
                $registro['Email'] = $datos[0];
                $data[] = $registro;
            }
            fclose($file);

            return $data;
        } else {
            return array();
        }
    }

    public function writeCSV($email): string
    {
        $file = fopen($this->file, 'a');

        if (!is_array($email)) {

            $datos = array($email);
        } else {
            $datos = $email;
        }

        fputcsv($file, $datos, ";");

        fclose($file);

        return 'Csv update';
    }

    //metodo para obtener la diferancia entre los ficheros in y out 
    public function diffCSV($arrIn, $arrOut): array
    {
        $arrDiff = array();

        // Recorre el primer array de usuarios totales
        foreach ($arrIn as $item1) {

            $encontrado = false;
            // Recorre el segundo array para buscar coincidencias
            foreach ($arrOut as $item2) {
                if ($item1['Email'] == $item2['Email']) {
                    $encontrado = true;
                    break;
                }
            }
            // Si no se encuentra se agrega el elemento al array de diferencias
            if (!$encontrado) {
                $arrDiff[] = $item1;
            }
        }
        return $arrDiff;
    }
}
