<?php

        $folderPath = '../../download/';

        $image_parts = explode(";base64,", $_POST['image']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath.'icon.png';

        file_put_contents($file, $image_base64);
        echo json_encode(["image uploaded successfully."]);
?>
