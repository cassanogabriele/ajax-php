<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=c0passionate', 'c0pass', 'wtngkHXD_H6');
	$bdd->exec('SET NAMES utf8');
} catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
}

include_once("core/classes/Chat.php");
?>	

<!DOCTYPE html>
	<html > 
		<head>				
			<title>Passionate Tchat</title>			
			<link rel="stylesheet" href="css/style.css">	
			<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		</head>	
		
		<body class="bdy">
			<div id="banniere"></div>
			
			<div class="chat">				
				<div class="messages"></div>			
				
				
				<div class="jumbotron" id="identifiants">
					<form action="index.php" method="post" name="formChat">
					<label for="user">Utilisateur migré</label>
					<br/>
					<input type="text" class="form-control" id="username" name="username" placeholder="Entrez votre nom d'utilisateur">
					<br>
					<label for="message">Message</label>
					<br/>
					<textarea class="entry form-control" id="message" name="message" placeholder="Entrez votre message"></textarea>
					<br/><br/>				
					<input type="submit" id="soumission" class="btn btn-primary" value="Envoyer">
					</form>
				</div>	
			</div>
			
			<?php
			// Récupération du message envoyé dans le formulaire.
			$user = isset($_POST['username']) ? $_POST['username'] : NULL;					
			$msg = isset($_POST['message']) ? $_POST['message'] : NULL;	
						
			// Insertion de chaque nouvel utilisateur dans la table "users"
			$create_user = $bdd->prepare('INSERT INTO users(username) VALUES(:username)')or die('Erreur SQL !'.mysql_error());
			
			$create_user->execute(array(
				'username' => $user					
			));	
			
			// Sélection de l'utilisateur courant pour insérer l'user_id dans la table "chat".
			$users = $bdd->query("SELECT * FROM users WHERE username='".$user."'");
			$fetch_user = $users->fetch();
			$user_id = $fetch_user["user_id"];	
			
			$timestamp = time();
			
			$message = $bdd->prepare('INSERT INTO chat(user_id, message, timestamp) VALUES(:user_id, :message, :timestamp)')or die('Erreur SQL !'.mysql_error());
			
			$message->execute(array(
				'user_id' => $user_id,
				'message' => $msg,
				'timestamp'=> $timestamp,
			));										
			?>	

			<a href="http://icyber-corp.gabriel-cassano.be/" style="display:none;">Icyber-Corp.</a>	
			<a href="http://homesweethomedesign.gabriel-cassano.be/" style="display:none;">Home Sweet Home Design</a>
			<a href="http://invokingdemons.gabriel-cassano.be/" style="display:none;">invoking demons</a>
				
			<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
			<script src="js/chat.js"></script>		
		</body>			
	</html>