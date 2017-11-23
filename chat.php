<!DOCTYPE html>
<html>

<style>

</style>

<head>
	<title> Chat Code.bzh de Fleur de Lotus</title>

</head>

<body>

<h1>CHAT Code.bzh</h1>
<div id="main">

	<form action="chat.php" method="POST">
		<fieldset>
			<label>Pseudo :</label>
			<input type="text" name="pseudotxt" id="pseudotxt"/>
			<label>Mail :</label>
			<input type="text" name="mailtxt" id="mailtxt"/>
		</fieldset>
		<fieldset>
			<label>Texte :</label>
			<input type="text" name="messagetxt" id="messagetxt"/>
		</fieldset>
		<input type="submit" value="Envoyez votre message"/>
	</form>
</div>
<h1> Listes des messages du chat </h1>

<?php 
	//on déclare les fonctions qui vont nous servir dans l'exercice
	
	//1ere fonction : fonction d'écriture dans un fichier : on ouvre le fichier, on écrit la ligne et on ferme le fichier
	function ecrireChat($ligneFichier) {
		$fichier = fopen('chat.txt','a');
		fputs($fichier,$ligneFichier);
		fclose($fichier);
	}	
	
	//2nde fonction : fonction d'affichage dans la page web
	function afficherDonneesChat() {
	$fichier = fopen('chat.txt','r+');
	
		while($ligneLue = fgets($fichier)) {
			echo '<div>';
			echo $ligneLue;
			echo '</div>';
		}
		
		//$ligne = fgets($fichier);
		//echo $ligne;	
		fclose($fichier);
	}	
	
	//appel à la fonction d'écriture dans le fichier texte
	
	//Si le POST ne contient aucune donnée, on n'écrit pas dans le fichier texte
	if(!empty($_POST)) {
		ecrireChat("\n");
		ecrireChat($_POST['pseudotxt']." ".$_POST['mailtxt']." ".$_POST['messagetxt']);
	}

	//appel à la fonction d'affichage dans la page
	afficherDonneesChat();

		
	
?>


</body>
<footer>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
		
			//le fonctionnement que j'ai choisi ici prend un div contenant un texte et une image
			//ce div est positionné par dessus le reste du site : voir plus bas : "position abscolute"
			//et voir aussi le z-index
			
			//on peut faire plus simple sur la position !!! Ce n'était pas demandé !
			
			
			//si le document est chargé, on associe des évènements aux champs textes
			// 1 / un évèénement lorsque le champ prend le focus 
			// c'est à dire lorsqu'il est sélectionné
			// 2 / un événement lorsque du texte est écrit
			$( document ).ready(function() {
				modifierPersonnage('neutre',120,300,"Bienvenue ! Je suis le super-outil-d'aide-à-la-saisie");
				$("#pseudotxt").focusin(function(){surveillance(this);}); // il fait le focus et met un message neutre
				$("#mailtxt").focusin(function(){surveillance(this);});
				$("#messagetxt").focusin(function(){surveillance(this);});
				$("#pseudotxt").keyup(function(){validerTexte(this);});  // une action est faite sur le champs
				$("#mailtxt").keyup(function(){validerTexte(this);});
				$("#messagetxt").keyup(function(){validerTexte(this);});
			});

			
			// 3 fonctions sont déclarées ici : surveillance(champ)
			
			function surveillance(champ) {
				var top = $(champ).position().top-40; // position de l'image
				var left = $(champ).position().left+$(champ).width()+120; // position de l'image
				if($(champ).attr('id')=="mailtxt" && $(champ).val()=="") {
				  modifierPersonnage('neutre',top,left,"Ok je me pousse !");
				}
				else
				if($(champ).val()=="") {
				modifierPersonnage('neutre',top,left,"Je vais vous aider en gênant l'accès au champ mail !");
				} else {
				validerTexte(champ);
				}
			}

			//la fonction prend un style (content, neutre, triste), une position haut et gauche et un message à afficher
			function modifierPersonnage(style,top,left,msg) {
				// si le personnage n'existe pas, on le crée
				if ($("#personnage").length==0) {
				//un div particulier avec id "personnage"
					$( "#main" ).append( "<div id='personnage'></div>" );

					// ses propriétés de style : pas obligatoires ici
					$( "#personnage").css( "z-index", "1000" ); //position z grande pour qu'il soit devant
					$( "#personnage").css( "position", "absolute" ); // on lui donne une valeur absolu
					$( "#personnage").css( "top", top+"px" ); //position/au top
					$( "#personnage").css( "left", left+"px" ); //position/a gauche
				} else {
					//si le personnage existe on le bouge à sa nouvelle position
					$("#personnage").animate({"top":top+"px", "left":left+"px"},"fast"); //on peut rajouter la vitesse d 'animaion
				}

				// le message, contenu dans une balise span est ensuite stocké dans la variable message
				var message = "<span id='personnage-message'>"+msg+"</span>";

				// Modification de l'image en fonction du style donné
				// j'ai indiqué une couleur dans le css à l'aide du site http://www.code-couleur.com/
				if(style=="content") {
					$( "#personnage" ).html( "<img src='images/content.png' />"+message );
					$( "#personnage-message").css( "background-color", "#ADF6B6" );
				} else if(style== "triste") { 
					$( "#personnage" ).html( "<img src='images/triste.png' />"+message );
					$( "#personnage-message").css( "background-color", "#EF4747" );
				} else { //sinon : si neutre
					$( "#personnage" ).html( "<img src='images/neutre.png' />"+message );
					$( "#personnage-message").css( "background-color", "#eee" );
				}

				$( "#personnage-message").css( "border", "dotted 1px grey"  //déco pas indispensable
				$( "#personnage-message").css( "padding", "5px" );
				//image centrée en hauteur sur le texte
				$( "#personnage img" ).css("vertical-align","middle");
			}
	
			//fonction que l'on appelle pour valider le texte d'un champ,
			//cette fonction fait appel à la fonction modifierPersonnage pour le repositionner
			//et lui appliquer un nouveau message
			function validerTexte(champ) {
				//calcul de la nouvelle position du personnage en fonction de celle du champ,
				//pas obligatoire pour l'exercice
				var top = $(champ).position().top-40;
				var left = $(champ).position().left+$(champ).width()+120;
				
				//dans le cas du pseudo (et les autres), on vérifie si le champ contient quelque chose
				//la méthode .val() permet de récupérer la valeur d'un champ
				//l'attribut .length contient sa taille
				if($(champ).attr('id')== "pseudotxt") {
					if ($(champ).val()=="") {
						modifierPersonnage('triste',top,left,"COMMENT TU T'APPELLES ?");
					} else {
						modifierPersonnage('content',top,left,"C'est un peu nul comme pseudo");
					}
				}
				else if ($(champ).attr('id')== "messagetxt") {
					if ($(champ).val()=="") {
						modifierPersonnage('triste',top,left,"Vous devez entrer un texte...");
					} else {
						modifierPersonnage('content',top,left,"ça roule, mais je n'aurais pas écrit ça");
					}
				}
				else if ($(champ).attr('id')== "mailtxt") {
					//ici j'ai récupéré sur le net une manière de tester une adresse mail
					//la variable regex est ce qu'on appelle une "expression régulière" : c'est un outil qui permet
					//d'effectuer des recherches évoluées sur des chaines de caractères
					var regex = /\S+@\S+\.\S+/;    
					//si le champ n'est pas vide et qu'il répond à l'expression régulière, le mail est bon
					if ($(champ).val()!="" && regex.test($(champ).val())) {
						modifierPersonnage('content',top,left,"Email valide. Je vais l'enregistrer en base pour vous spammer");
					} else {
						modifierPersonnage('triste',top,left,"Email invalide. Je fais mieux que ça avec un clavier");
					}
				}
			}

		</script>
</footer>
</html>