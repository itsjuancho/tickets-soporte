<?php

if (isset($_POST['id'])) {
	if (!empty($_POST['id'])) {
		include '../config/funciones.php';
		$id = limpiarData($_POST['id']);
		if (is_numeric($id)) {
			include '../config/database.php';
			$sql = "SELECT idSistema,sistema FROM sistema WHERE idDepartamento = $id";
			$exe = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));

			if (mysqli_num_rows($exe) > 0) {
				//$lista = "";
				while ($s = mysqli_fetch_assoc($exe)) {
					//$lista += "<option value='".$s['idSistema']."'>".$s['sistema']."</option>";
					$result["data"][] = $s; 
				}
				$result['status'] = 1;
				echo json_encode($result);
			}else{
				$result['status'] = 2;
				$result['code_error'] = 20;
				$result['mensaje'] = "Ha ocurrido un error al cargar los sistemas";
				echo json_encode($result);
			}
		}else{
			$result['status'] = 3;
			$result['code_error'] = 18;
			$result['mensaje'] = "Ha ocurrido un error al cargar los sistemas";
			echo json_encode($result);
 		}
	}else{
		$result['status'] = 4;
		$result['code_error'] = 13;
		$result['mensaje'] = "Ha ocurrido un error al cargar los sistemas";
		echo json_encode($result);
	}
}else{
	header('location: ../soporte/nuevo');
}


?>