<?php
require_once '../models/LoanCalculator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["monto"]) && isset($_POST["tasa"]) && isset($_POST["plazo"]) &&
        is_numeric($_POST["monto"]) && is_numeric($_POST["tasa"]) && is_numeric($_POST["plazo"]) &&
        $_POST["monto"] > 0 && $_POST["tasa"] > 0 && $_POST["plazo"] > 0) {
        $montoPrestamo = $_POST["monto"];
        $tasaInteresAnual = $_POST["tasa"];
        $plazoMeses = $_POST["plazo"];
        $cuotaMensual = LoanCalculator::calcularCuotaMensual($montoPrestamo, $tasaInteresAnual, $plazoMeses);
        $resultado = LoanCalculator::generarTablaAmortizacion($montoPrestamo, $tasaInteresAnual, $plazoMeses);
        $tablaAmortizacion = $resultado['tablaAmortizacion'];
        $totalInteres = $resultado['totalInteres'];
        include '../views/form_calculo_prestamo.php';
    } else {
        $error_message = "Por favor, ingresa valores válidos para el monto, la tasa de interés y el plazo.";
        include '../views/form_calculo_prestamo.php';
    }
} else {
    header("Location: ../views/form_calculo_prestamo.php");
    exit();
}
?>
