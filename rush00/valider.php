<?PHP
session_start();
include ('recup_info.php');

if (!isset($_SESSION['login']) || !isset($_COOKIE["id"]))
{
	$tab = $_SESSION['panier'];
	if ($_POST['submit'] == "Annuler")
	{
		$ville = $_POST["ville"];
		$i = 0;
		while ($tab[$i] != null)
		{
			if ($tab[$i]['ville'] == $ville)
			{
				unset($tab[$i]);
				$tab = array_values($tab);
			}
			$i++;
		}
		unset ($_SESSION['panier']);
		$_SESSION['panier'] = $tab;
		header("Location:panier.php");
		exit();
	}
	else if ($_POST['submit'] == "Payer")
	{
		$_SESSION['ajout'] = 1;
		header("Location:connection.php");
		exit();
	}
	else if ($_POST['submit'] == "Annulertout")
	{
		unset($_SESSION['panier']);
		header("Location:panier.php");
		exit();
	}
}
if ($_POST['submit'] == "Annuler")
{
	if (!empty($_SESSION['login']))
	{
		$ville = $_POST["ville"];
		$add = './commande.csv';
		file_put_contents($add, "", FILE_APPEND);
		$serial = unserialize(file_get_contents($add));
		$i = 0;
		while ($serial[$i])
		{
			if ($serial[$i]['login'] == $_SESSION['login'] && $serial[$i]["ville"] == $ville)
			{
				unset($serial[$i]);
				$serial = array_values($serial);
			}
			$i++;
		}
		$toto = serialize($serial);
		file_put_contents($add, $toto);
		header("Location:panier.php");
		exit();
	}
}
if ($_POST['submit'] == "Annulertout")
{
	if (!empty($_SESSION['login']))
	{
		$add = './commande.csv';
		file_put_contents($add, "", FILE_APPEND);
		$serial = unserialize(file_get_contents($add));
		$i = 0;
		while ($serial[$i])
		{
			if ($serial[$i]['login'] == $_SESSION['login'])
				unset($serial[$i]);
			$i++;
		}
		$serial = array_values($serial);
		$toto = serialize($serial);
		file_put_contents($add, $toto);
		header("Location:panier.php");
		exit();
	}
}

// $_POST['ville'] ontient la ville que lon chercher

/*

METTRE DU CODE POUR LES PERSONNES QUI NE SONT PAS CONNECTER

IL NE PEUVENT PAS VENIR SUR CETTE PAGE SI IL NE SONT PAS CONNECTER

ON LES RENVOIE SUR LA PAGE DE CONNECTION QUI LLE LES RENVERRA ICI GRACE AU VARIABLE DE _POST

 */
?>
<!DOCTYPE html>
<html>
<head>
	<title>Accueil</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="bloc_page">
		<header>
			<a href="index.php" style="color: #000000; text-decoration:none;">
				<div id="titre">
					<div id="logo">
						<img src="img/logo.png" alt="Logo de Voyageons">
						<h1>Voyageons</h1>
					</div>
					<h2 id="toyo">SITE DE VOYAGE</h2>
				</div>
			</a>
			<nav>
				<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="allproducts.php">Tout</a></li>
					<li><a href="derniereminute.php">Dernière minute</a></li>
					<li><a href="promo.php">Promo</a></li>
					<li><a href="panier.php">Panier</a></li>
<?PHP
echo '<li><a href="compte.php">Mon compte</a></li>';
echo '<li><a href="delog.php">Deconnection</a></li>';
?>
				</ul>
			</nav>
		</header>
	</div>
<hr color="black"/>
<br />
<div class="fiche">
	<div class="produit">
	<h1 style="text-align: center"><?PHP  echo name($_POST['ville']) ?></h1>
	<img  src='<?PHP echo photo($_POST['ville'])?>' >
		<p><?PHP  echo descc($_POST['ville']) ?></p>

		<?php
			$i = 0;
			echo '<form method="post" action="payer.php">';
			while ($i < $_POST['nbr'])
			{
					echo '<p id="less">';
					echo '<label for="nom">Nom</label>';
					echo '<input type="text" name="prenom">';
					echo '<label for="prenom">Prenom</label>';
					echo '<input type="text" name="nom">';
					echo '</p';
					echo '<br />';
				$i++;
			}
			echo '<br />';
			echo '<input type="hidden" name="depart" value='.$_POST['depart'].'>';
			echo '<input type="hidden" name="arriver" value='.$_POST['arriver'].'>';
			echo '<input type="hidden" name="nbr" value='.$_POST['nbr'].'>';
			echo '<input type="hidden" name="ville" value='.$_POST['ville'].'>';
			echo '<input class="bouton" style="position: flex;border-radius: 3px; border-style: solid; background-color: rgb(238,238,238);width: 50px;height: 50px "type="submit" name="submit" value="Payer">';
			echo '</form>';

		 ?>
	</div>
</div>











</body>
</html>
