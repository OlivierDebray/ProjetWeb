<?php

// Si le chemin indique bien un dossier
if (is_dir('images\photosEvenement/'.$_GET['numEvent']))
{
    /*
     * Si on peut ouvrir le dossier indiqué
     * On le stocke dans une variable
    */
	if ($dh = opendir('images\photosEvenement/'.$_GET['numEvent']))
	{
		$dossier = 'images\photosEvenement/'.$_GET['numEvent'];
        /*
         * S'il y a au moins un fichier, dans le dossier indiqué
         * On récupère toutes les images qui correspondent à l'évènement
         */
		if(sizeof(scandir($dossier))>2)
		{
		    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
		    $requete = $bdd->prepare("SELECT * FROM image WHERE Evenement =?");
		    $requete->execute(array($_GET['numEvent']));

            /*
             * S'il y a un paramètre envoyé en GET à la fonction : ID de l'événement
             * On stocke le nom du dossier dans une variable
             * On instancie la classe ZipArchive
             */
		    if(!empty($_GET['numEvent']))
		    {
		        $fileName=$_GET['numEvent'].'.zip';
		        $filePath='images/photosEvenement/'.$fileName;
		        $zip = new ZipArchive();

                /*
                 * Si le zip n'existe pas
                 * On stocke le chemin des images dans une variable
                 * On stocke l'ouverture du dossier dans une variable
                 */
		        if($zip->open($filePath, ZipArchive::CREATE) == TRUE)
		        {
		            $photoPath='images/photosEvenement/'.$_GET['numEvent'].'/';
		            $dir=opendir($photoPath);

                    /*
                     * Lecture de tout les fichiers contenu dans le dossier
                     * On ferme après la lecture du dernier fichier
                     */
		            while ($folder = readdir($dir))
		            {
                        /*
                         * S'il y a bien des fichiers dans le dossier
                         * On insère ces fichiers dans le zip
                         */
		                if(is_file($photoPath.$folder))
		                {
		                    $zip->addFile($photoPath.$folder, $folder);
		                }
		            }
		            $zip->close();
		        }

                /*
                 * Si le zip existe au chemin indiqué
                 * On propose son téléchargement
                 * Puis, on supprime le zip d'origine
                 */
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