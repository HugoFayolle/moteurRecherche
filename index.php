<?php
    $boolSiSiteExiste = false;
    
    if (isset($_POST['searchBox']) && isset($_POST['nbResultBox']))
    {
        if (strpos($_POST['searchBox'],"http://") !== false)
        {
            //URL
            $fichier = fopen('urlAEnvoyer.txt', 'a+');
            fputs($fichier, $_POST['searchBox'] . PHP_EOL);

            fclose($fichier);

            $db=mysqli_connect("localhost","root","","projetfinanneee");

            //Récupérer le titre pour la BDD (exemple : Google pour http://google.com)
            $splitURL = "";
            $tabSplitSlash = explode('/', $_POST['searchBox']);
            $splitURL = $tabSplitSlash[2];
            $tabSplitPoint = explode('.', $splitURL);
            $titre = ucfirst($tabSplitPoint[0]);

            $siSiteExiste = 'SELECT * FROM resources WHERE url = "' . $_POST['searchBox'] . '"';
            $siSiteExiste = mysql_query($siSiteExiste);
        
            //Check si la requete est vide ou non
            while ($dataSiSiteExiste = mysql_fetch_assoc($siSiteExiste))
            {
                $boolSiSiteExiste = true;
            }

            //Si la requete n'est pas vide -> insertion de l'URL
            if ($boolSiSiteExiste == false)
            {
                $insertSite="INSERT INTO resources (url, titre) VALUES ('" . $_POST['searchBox'] . "', '" . $titre . "')";
            }

            if (!mysqli_query($db,$insertSite))
            {
              die('Error: ' . mysqli_error($db));
            }

            mysqli_close($db);
        } 
        else
        {
            //RECHERCHE
            header('Location: resultats.php?search_keyword=' . $_POST['searchBox'] . '&res=' . $_POST['nbResultBox'] . '&p=1');
        }
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Supinfo Search Engine</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body id="page-top" data-spy="scroll" data-target="navbar-fixed-top">

<!--////////////// NAVBAR ///////////////-->
    <nav class="navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button> 
            <div class="page-scroll">  
                <a class="navbar-brand" href="#home">SUPINOF</a>
            </div> 
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="page-scroll"><a href="#about">About</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
        </li> 
          </ul>
        </div>
      </div>
    </nav>
<!--/////////////////////// HOME SECTION ////////////////////////////////// -->
    <section id="home" class="home-section">
    <div class="jumbotron text-center">
      <div class="container-fluid">
        <h1>SUPINOF<small> Search engine</small></h1>
      </div>
        <div class="container text-center">
            <div id="searchbar" class="row">
              <div class="col-lg-12 col-md-12">
                <div class="input-group">
                    <form name="queryBar" action="index.php" method="post">
                      <input type="text" class="form-control" name="searchBox">
                        <span class="input-group-btn">
                            <a href="resultats.php"><button class="btn btn-default" type="submit">Search</button></a>
                        </span>
                        <label for="nbResuParPage">Nombre de r&eacutesultats par page : </label>
                        <input type="text" class="form-control" name="nbResultBox" value="1" style="text-align:center">
                    </form>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 hidden-sm hidden-xs">
                <div class="jumbotron text-center">
                  <h2>Search</h2>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  </p>                 
                </div>
            </div>
            <div class="col-lg-6 col-md-12 hidden-sm hidden-xs">
                <div class="jumbotron text-center">
                  <h2>Crawl</h2>
                  <p>
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                  </p>                 
                </div>   
            </div>
            <div class="col-md-12 visible-sm visible-xs">
                <div class="jumbotron text-center">
                  <h2>Search and Crawl</h2>
                  <p>
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                  </p>                 
                </div>   
            </div>
        </div>
    </div>
        <!-- FOOTER -->
   <div class="footer text-right navbar-fixed-bottom">
        <div class="container">
            <p class="text-muted credit">built with Bootstrap3 | No rights reserved</p>
        </div>
    </div>
    </section>
<!--/////////////////////// ABOUT SECTION ////////////////////////////////// -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
            </div> 
        </div>
            <div class="container text-center">
                <div class="jumbotron">
                  <h1>SALUE SAVA</h1>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    <br>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                  </p>                 
                </div>
            </div>
                   <div class="container">
                   <div class="page-scroll">
                        <a href="#home"><span class="glyphicon glyphicon-chevron-up"></span></a>
                    </div>
                </div> 
    </section>
<!--/////////////////////// END OF HTML ////////////////////////////////// -->

    <!-- Core JavaScript Files -->
    <!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>
</body>
</html>


