<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankController extends Controller
{
    public function validaIBAN($iban)
    {
        $iban = strtoupper(str_replace(' ', '', $iban));  // Elimina espacios y convierte a mayúsculas
        if (strlen($iban) < 15 || strlen($iban) > 34) {
            return false;
        }

        // Mueve los 4 primeros caracteres al final
        $ibanRearranged = substr($iban, 4) . substr($iban, 0, 4);

        // Reemplaza letras por números (A = 10, B = 11, ..., Z = 35)
        $ibanNumeric = preg_replace_callback('/[A-Z]/', function ($matches) {
            return ord($matches[0]) - 55;
        }, $ibanRearranged);

        // Realiza la validación del módulo 97
        return bcmod($ibanNumeric, '97') == '1';
    }


    public function validaCCC($ccc)
    {
        // Elimina cualquier espacio y guión que pueda tener el CCC para la comprobación
        $ccc = str_replace([' ', '-'], '', $ccc);

        // Verificar la estructura básica y longitud
        if (!preg_match('/^ES\d{2}(\d{4})(\d{4})(\d{2})(\d{10})$/', $ccc, $matches)) {
            return false;
        }

        // Descomponer el CCC en sus partes
        $banco = $matches[1];
        $sucursal = $matches[2];
        $dc = $matches[3];
        $cuenta = $matches[4];

        // Función para calcular los dígitos de control
        $calcularDC = function ($valores) {
            $pesos = [1, 2, 4, 8, 5, 10, 9, 7, 3, 6];  // Pesos para el cálculo de los dígitos de control
            $suma = 0;
            for ($i = 0; $i < count($valores); $i++) {
                $suma += $valores[$i] * $pesos[$i];
            }
            $resto = $suma % 11;
            $digito = 11 - $resto;
            if ($digito == 10) {
                $digito = 1;
            } elseif ($digito == 11) {
                $digito = 0;
            }
            return $digito;
        };

        // Calcular dígitos de control
        $valoresBancoSucursal = array_map('intval', str_split($banco . $sucursal));
        $dcCalculado1 = $calcularDC($valoresBancoSucursal);

        $valoresCuenta = array_map('intval', str_split($cuenta));
        $dcCalculado2 = $calcularDC($valoresCuenta);

        // Comprobar si los dígitos de control calculados coinciden con los proporcionados
        if ($dc == sprintf('%d%d', $dcCalculado1, $dcCalculado2)) {
            return true;
        } else {
            return false;
        }
    }

    public function descobreixIBAN($iban)
    {
        $baseIban = substr($iban, 0, -2);  // Elimina los dos últimos dígitos
        for ($i = 0; $i < 100; $i++) {
            $testIban = $baseIban . str_pad($i, 2, '0', STR_PAD_LEFT);
            if ($this->validaIBAN($testIban)) {
                return $testIban;
            }
        }
        return null;  // Retorna null si no encuentra un IBAN válido
    }
}
