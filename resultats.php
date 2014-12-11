<!DOCTYPE html>
<html>
	<head>
		<title>Search engine - R&eacutesultats</title>
		<meta char-set=utf8>
	</head>
	<body>
		<a href="index.php">Retour &agrave l'accueil</a>

		<center><h1>Page de r&eacutesultats</h1></center>

		<p><?php echo 'R&eacutesultats pour : <b>' . $_GET['search_keyword'] . '</b>'?></p>

		<?php

			$IDDictionnaire = null;
			$IDPage;
			//Textbox récupérée de l'URL
			$searchKeyWord = $_GET['search_keyword'];
			//Booléen vérifie si la requete n'est pas vide
			$bool = false;

			try
			{
				$db = mysql_connect('localhost', 'root', '');
				mysql_select_db('projetfinanneee', $db);
				
				//Recherche de l'ID du mot dans la table dictionary
				$rechercheID = mysql_query("SELECT * FROM dictionary WHERE word = '" . $searchKeyWord . "'");

				while($dataRechercheID = mysql_fetch_assoc($rechercheID))
			    {
				    $IDDictionnaire = $dataRechercheID['id'];
			    }

			    if ($IDDictionnaire != null)
			    {
			    	//Recherche du nombre total t'enregistrements
			    	$rechercheNbEnreg = 'SELECT COUNT(id) as nbResult FROM content WHERE dictionaryID = ' . $IDDictionnaire;
			    	$rechercheNbEnreg = mysql_query($rechercheNbEnreg);
			    	$dataRechercheNbEnr = mysql_fetch_assoc($rechercheNbEnreg);

		    		$nbTot = $dataRechercheNbEnr['nbResult'];

		    		//Check sur variable URL 'res'
		    		if (isset($_GET['res']) && $_GET['res']>0 && $_GET['res']<=$nbTot)
			    	{
		    			$perPage = $_GET['res'];
			    	}
			    	else
			    	{
			    		$perPage = 5;
			    	}

					$nbPage = ceil($nbTot/$perPage);

					//Check sur variable URL 'p'
			    	if (isset($_GET['p']) && $_GET['p']>0 && $_GET['p']<=$nbPage)
			    	{
		    			$cPage = $_GET['p'];
			    	}
			    	else
			    	{
			    		$cPage = 1;
			    	}

				    //Recherche du pageID du site corresponant au mot trouvé
				    $recherchePageID = mysql_query('SELECT * FROM content WHERE dictionaryID = ' . $IDDictionnaire . ' ORDER BY note ASC');// . 'ORDER BY note ASC'
				    $tabIDPage = array();

			    	while ($dataRecherchePageID = mysql_fetch_assoc($recherchePageID))
				    {
				    	$IDPage = $dataRecherchePageID['pageID'];
				    	//Ajoute tous les pageID correspondant dans un tableau
				    	array_push($tabIDPage, $IDPage);
				    }

		        	$stringQuery = $tabIDPage[0];

		        	//Parcours le tableau contenant les pageID pour les ajouter à une string
		        	for ($i=1; $i < count($tabIDPage); $i++)
		        	{ 
		        		$stringQuery = $stringQuery . "," . $tabIDPage[$i];
		        	}

	        		$rechercheSite = 'SELECT * FROM resources WHERE id IN (' . $stringQuery . ') LIMIT ' . (($cPage-1)*$perPage) . ',' . $perPage;
				    $rechercheSite = mysql_query($rechercheSite);
		        
		        	//Afficher tous les liens correspondant à la recherche
		            while ($dataRechercheSite = mysql_fetch_assoc($rechercheSite))
				    {
				    	$bool = true;

				    	echo '<a href="' . $dataRechercheSite['url'] . '">' . $dataRechercheSite['titre'] . '</a><br>' . $dataRechercheSite['url'] . '<br><br>';
				    }
	
				    if ($bool == false)
				    {
			    		echo "Aucun r&eacutesultat pour cette recherche";
					}


					//Pagination
				    for ($i=1; $i <= $nbPage; $i++)
				    {
				    	//Condition pour ne pas afficher de lien quand on est sur la page courante
				    	if ($i==$cPage)
				    	{
				    		echo " $i /";
				    	}
				    	else
				    	{
				    		echo " <a href=\"resultats.php?search_keyword=$searchKeyWord&res=$perPage&p=$i\">$i</a> /";
				    	}
				    }
			    }
			    else
			    {
			    	throw new Exception("Error Processing Request", 1);
			    }

			    mysql_close(); 
			}
			catch (Exception $e)
			{
				echo "Aucun r&eacutesultat pour cette recherche";
			}

			
		?>
		
	</body>
</html>