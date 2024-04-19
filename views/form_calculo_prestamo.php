<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Préstamo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-4xl mx-auto bg-white rounded-lg overflow-hidden shadow-md p-5">
        <div>
            <div class="text-center mb-8">
                <h2 class="text-2xl mb-2">Calculadora de Préstamo</h2>
                <img src="https://images.squarespace-cdn.com/content/v1/584f6704725e254d6b052b4d/3a907dff-a94f-4e1e-b882-f8caa4e6e2d2/Celaqueweb.png?format=1500w" alt="Logo" class="mx-auto max-w-xs">
            </div>
            <div class="flex justify-center">
                <form onsubmit="return validarFormulario()" action="../controllers/calcular_cuota.php" method="post" class="w-full max-w-md">
                    <div class="mb-4">
                        <label for="monto" class="block text-sm font-medium text-gray-700">Monto del préstamo:</label>
                        <input type="number" id="monto" name="monto"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-4 py-2" <?php if (isset($_POST['monto'])) echo 'value="' . $_POST['monto'] . '"'; ?> pattern="[0-9]+" oninput="validity.valid||(value='');">
                    </div>
                    <div class="mb-4">
                        <label for="tasa" class="block text-sm font-medium text-gray-700">Tasa de interés anual (%):</label>
                        <input type="number" id="tasa" name="tasa"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-4 py-2" <?php if (isset($_POST['tasa'])) echo 'value="' . $_POST['tasa'] . '"'; ?> pattern="[0-9]+" oninput="validity.valid||(value='');">
                    </div>
                    <div class="mb-4">
                        <label for="plazo" class="block text-sm font-medium text-gray-700">Plazo del préstamo en meses:</label>
                        <input type="number" id="plazo" name="plazo"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md px-4 py-2" <?php if (isset($_POST['plazo'])) echo 'value="' . $_POST['plazo'] . '"'; ?> pattern="[0-9]+" oninput="validity.valid||(value='');">
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="bg-teal-800 text-white py-2 px-4 rounded-md hover:bg-teal-600 w-4/5 mr-2">Calcular</button>
                        <button type="button" onclick="resetForm()" class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 w-1/5">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-8" id="resultado">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($cuotaMensual)) {
                echo "<div class='bg-gray-200 rounded-lg p-4'>";
                echo "<h3 class='text-lg font-semibold mb-2 text-center'>Resultado del cálculo:</h3>";
                echo "<p class='text-center text-gray-700 mb-2'>La cuota mensual del préstamo es: <span class='font-bold text-xl'>Lps. " . round($cuotaMensual, 2) . "</span></p>";
                if (isset($totalInteres)) {
                    echo "<p class='text-center text-gray-700 mb-2'>Total de intereses pagados: <span class='font-bold text-xl'>Lps. " . round($totalInteres, 2) . "</span></p>";
                }
                echo "</div>";
            }
            ?>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($tablaAmortizacion)) : ?>
                <div class="mt-5">
                    <h3 class="text-lg font-semibold mb-2">Tabla de Amortización:</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mes</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuota Mensual</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interés</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capital</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Pendiente</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($tablaAmortizacion as $row) : ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['Mes']; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo round($row['Cuota Mensual'], 2); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo round($row['Interés'], 2); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo round($row['Capital'], 2); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?php echo round($row['Saldo Pendiente'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                $totalPagar = $montoPrestamo + $totalInteres;
                ?>
                <div class="mt-5">
                    <h3 class="text-lg font-semibold mb-2">Total a Pagar al Final del Período:</h3>
                    <p class="text-center text-gray-700 mb-2">El total a pagar al final del período de <?php echo $plazoMeses; ?> meses es: <span class="font-bold text-xl">Lps. <?php echo round($totalPagar, 2); ?></span></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="../js/scripts.js"></script>
</body>
</html>