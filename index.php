<!DOCTYPE html>
<html>

<head>

</head>
<body>
<?php
/**
 * @param string $aInitialImageFilePath - строка, представляющая путь к обрезаемому изображению
 * @param string $aNewImageFilePath - строка, представляющая путь куда нахо сохранить выходное обрезанное изображение
 */
function cropImage($aInitialImageFilePath, $aNewImageFilePath) {


    // Массив с поддерживаемыми типами изображений
    $lAllowedExtensions = array(1 => "gif", 2 => "jpeg", 3 => "png");

    // Получаем размеры и тип изображения в виде числа


    list($lInitialImageWidth, $lInitialImageHeight, $lImageExtensionId) = getimagesize($aInitialImageFilePath);




    if (!array_key_exists($lImageExtensionId, $lAllowedExtensions)) {
        return false;
    }

    $lImageExtension = $lAllowedExtensions[$lImageExtensionId];


    // Получаем название функции, соответствующую типу, для создания изображения
    $func = 'imagecreatefrom' . $lImageExtension;


    // Создаём дескриптор исходного изображения
    $lInitialImageDescriptor = $func($aInitialImageFilePath);

    // Определяем отображаемую область


    $Width=$lInitialImageWidth/2;
    $Height=$lInitialImageHeight/2;



    // Создаём дескриптор для выходного изображения
    $lNewImageDescriptor = imagecreatetruecolor($Width, $Height);


    $img = imagecrop($lInitialImageDescriptor, ['x' => $Width, 'y' => $Height, 'width' => $Width, 'height' => $Height]);


    imagecopymerge($lInitialImageDescriptor,$img,$Width,0,0,0,$Width,$Height,100);
    imagecopymerge($lInitialImageDescriptor,$img,0,0,0,0,$Width,$Height,100);
    imagecopymerge($lInitialImageDescriptor,$img,0,$Height,0,0,$Width,$Height,100);


    $func = 'image' . $lImageExtension;

    // сохраняем полученное изображение в указанный файл
    return $func($lInitialImageDescriptor, $aNewImageFilePath);

}
cropImage($_SERVER['DOCUMENT_ROOT'] . "/1.jpg", $_SERVER['DOCUMENT_ROOT'] . "/1_cropped.jpg");
?>
<img src="/1_cropped.jpg">
</body>
</html>
