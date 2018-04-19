<?php
$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
$requete = $bdd->prepare("SELECT * FROM image WHERE Evenement =?");
$requete->execute(array($_GET['numEvent']));
if (is_dir('images\photosEvenement/'.$_GET['numEvent']))
{
	if ($dh = opendir('images\photosEvenement/'.$_GET['numEvent']))
	{
		$dossier = 'images\photosEvenement/'.$_GET['numEvent'];
		if(sizeof(scandir($dossier))>2)
		{
		    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
		    $requete = $bdd->prepare("SELECT * FROM image WHERE Evenement =?");
		    $requete->execute(array($_GET['numEvent']));

		    if(!empty($_GET['numEvent']))
		    {
		        $fileName=$_GET['numEvent'].'.zip';
		        $filePath='images/photosEvenement/'.$fileName;
		        $zip = new ZipArchive();
		        if($zip->open($filePath, ZipArchive::CREATE) == TRUE)
		        {
		            $photoPath='images/photosEvenement/'.$_GET['numEvent'].'/';
		            $dir=opendir($photoPath);
		            while ($folder = readdir($dir))
		            {
		                if(is_file($photoPath.$folder))
		                {
		                    $zip->addFile($photoPath.$folder, $folder);
		                }
		            }
		            $zip->close();
		        }
		        if(!empty($fileName) AND file_exists($filePath))
		        {
		            header('Content-Description: File Transfer');
		            header('Content-Type: application/zip');
		            header('Content-Disposition: attachment; filename="PhotosEvenement_'.basename($fileName).'"');
		            header('Expires: 0');
		            header('Cache-Control: must-revalidate');
		            header('Pragma: public');
		            header('Content-Length: '.filesize($filePath));
		            header('Content-Transfer-Encoding: binary');
		            readfile($filePath);
		        }
		        unlink($filePath); //Suppresion de l'archive zip après téléchargement
	    	}
		}
		else 
		{
			echo "Il n'y a aucune photo pour cette ";
		}
	}
}
else 
{
	echo "Il n'y a aucune photo pour cette ";
}
?>