<?php
session_start();
include('../conexion.php');

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] !== 'ADMIN' && $_SESSION['rol'] !== 'PROFESOR')) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['importar']) && isset($_FILES['archivo_excel'])) {
    $fileTmpPath = $_FILES['archivo_excel']['tmp_name'];
    $fileName = $_FILES['archivo_excel']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (empty($fileTmpPath) || !is_uploaded_file($fileTmpPath)) {
        header("Location: captura_calificaciones.php?tab=masiva&status=error");
        exit();
    }

    $registrosProcesados = 0;

    if ($fileExtension === 'csv' || $fileExtension === 'txt') {
        if (($handle = fopen($fileTmpPath, "r")) !== FALSE) {
            // Omitir fila de encabezados
            fgetcsv($handle, 1000, ",");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($data) >= 3) {
                    $nocontrol = trim($data[0]);
                    $id_unidad = intval(trim($data[1]));
                    $calificacion = floatval(trim($data[2]));

                    if (!empty($nocontrol) && $id_unidad > 0 && $calificacion >= 0) {
                        $query_alumno = "SELECT id FROM alumnos WHERE nocontrol = '$nocontrol' AND (estatus != 'BAJA' OR estatus IS NULL) LIMIT 1";
                        $res_alumno = mysqli_query($conexion, $query_alumno);

                        if ($res_alumno && mysqli_num_rows($res_alumno) > 0) {
                            $alumno = mysqli_fetch_assoc($res_alumno);
                            $id_alumno = $alumno['id'];

                            $query_check = "SELECT id FROM calificaciones WHERE id_alumno = '$id_alumno' AND id_unidad = '$id_unidad'";
                            $res_check = mysqli_query($conexion, $query_check);

                            if ($res_check && mysqli_num_rows($res_check) > 0) {
                                $query_update = "UPDATE calificaciones SET calificacion = '$calificacion' WHERE id_alumno = '$id_alumno' AND id_unidad = '$id_unidad'";
                                mysqli_query($conexion, $query_update);
                            } else {
                                $query_insert = "INSERT INTO calificaciones (id_alumno, id_unidad, calificacion) VALUES ('$id_alumno', '$id_unidad', '$calificacion')";
                                mysqli_query($conexion, $query_insert);
                            }
                            $registrosProcesados++;
                        }
                    }
                }
            }
            fclose($handle);
            header("Location: captura_calificaciones.php?tab=masiva&status=success&count=" . $registrosProcesados);
            exit();
        }
    }
}
header("Location: captura_calificaciones.php?tab=masiva&status=error");
exit();
?>