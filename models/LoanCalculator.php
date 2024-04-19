<?php

class LoanCalculator {
    public static function calcularCuotaMensual($montoPrestamo, $tasaInteresAnual, $plazoMeses) {
        $tasaInteresMensual = $tasaInteresAnual / 12 / 100;
        $cuotaMensual = ($montoPrestamo * $tasaInteresMensual * pow(1 + $tasaInteresMensual, $plazoMeses)) / (pow(1 + $tasaInteresMensual, $plazoMeses) - 1);
        return $cuotaMensual;
    }

    public static function generarTablaAmortizacion($montoPrestamo, $tasaInteresAnual, $plazoMeses) {
        $tasaInteresMensual = $tasaInteresAnual / 12 / 100;
        $cuotaMensual = self::calcularCuotaMensual($montoPrestamo, $tasaInteresAnual, $plazoMeses);
        $tablaAmortizacion = array();
        $saldoPendiente = $montoPrestamo;
        $totalInteres = 0;

        for ($i = 1; $i <= $plazoMeses; $i++) {
            $interes = $saldoPendiente * $tasaInteresMensual;
            $capital = $cuotaMensual - $interes;
            $saldoPendiente -= $capital;
            $totalInteres += $interes;
            $tablaAmortizacion[] = array(
                'Mes' => $i,
                'Cuota Mensual' => $cuotaMensual,
                'Interés' => $interes,
                'Capital' => $capital,
                'Saldo Pendiente' => $saldoPendiente
            );
        }

        return array('tablaAmortizacion' => $tablaAmortizacion, 'totalInteres' => $totalInteres);
    }
}
?>
