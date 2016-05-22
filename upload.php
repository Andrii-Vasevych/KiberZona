<?php
    error_reporting(E_ALL);
    
    require_once 'vendor\autoload.php';
    use WindowsAzure\Common\ServicesBuilder;
    use WindowsAzure\Common\ServiceException;
    
    if ( array_key_exists( "testfile", $_FILES ) )
    {
        if ( $_FILES["testfile"]["error"]!=0 )
        {
            print_r($_FILES);
            exit("<br>Помилка завантаження файлу. Перевірте розмір файлу і параметри сервера.");
        }
        else
        {
            $connectionString = getenv("CUSTOMCONNSTR_blobConnection");
            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
            $content = fopen($_FILES["testfile"]["tmp_name"], "r");
            $blob_name = hash( "sha256", uniqid("awu4hzkf29384hf", true)."jd9hr123794hrf", false );
            $container_name= "storage";
            $url = "https://kiberzonastorage.blob.core.windows.net/storage/".$blob_name;
            
            try
            {
                //Upload blob
                $blobRestProxy->createBlockBlob($container_name, $blob_name, $content);
                
                exit('Uploaded as <a href="'.$url.'">file</a>');
            }
            catch(ServiceException $e){
                // Handle exception based on error codes and messages.
                // Error codes and messages are here:
                // http://msdn.microsoft.com/library/azure/dd179439.aspx
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code.": ".$error_message."<br />";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <meta charset="UTF-8"></meta>
    <meta name="viewport" content="width=device-width, initial-scale=1"></meta>
    <link rel="stylesheet" href="w3.css"></link>
    <link rel="stylesheet" href="w3-theme-light-blue.css"></link>
    <body>
        <header class="w3-container w3-card-4 w3-theme">
            <title>KiberZona</title>
            <h1>KiberZona</h1>
        </header>
        
        <div class="w3-container" id="itemcontainer">
        </div>
        
        	
		<footer class="w3-container w3-center w3-theme w3-bottom"> 
		<h5>© 2016 | Андрій Васевич</h5> 
		</footer>
		
        <div class="w3-card-4 w3-margin">

            <div class="w3-container w3-light-blue">
				<center><h2>Форма для завантаження</h2></center>
            </div>

            <form class="w3-container" method="POST" action="upload.php" enctype="multipart/form-data">

            <label>Файл для завантаження</label>
            <input class="w3-input" type="file" id="testfile" name="testfile" required>

            <input class="w3-input w3-light-blue" type="submit" Value="OK"> <br>

            </form>

        </div>
    </body>
</html>