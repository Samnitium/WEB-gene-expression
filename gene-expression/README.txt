ALCUNE IMPORTANTI ANNOTAZIONI PER L'UTILIZZO DEL PORTALE Web-Service Gene-Expression:

1) Il super-utente (con tutti i relativi dati) deve essere impostato manualmente sul database del proprio server, 
   mentre gli utenti normali si possono registare tranquillamente sul sito web.
   Fare attenzione a riempire il campo 'type', che deve essere con valore 'superuser' per il super-utente e con valore 'user' per gli utenti normali.
   Il campo 'code' può avere come valore la stringa vuota '' per il super utente, mentre per gli utenti normali, il 
   valore deve corrispondere ad un codice che viene generato in maniera randomica in fase di registrazione.
   
2) E' necessario fare delle piccole configurazioni al proprio server:

	NOTE IMPORTANTE: Queste sono un esempio di modifiche da fare per chi usa il server apache di XAMPP
	
	
   -A) Per la parte di utilizzo della posta elettronica, utile per la registrazione o per il remind della password 
       dimenticata: 
     	
     	
     	
        ° modificare il file 'C:\xampp\php\php.ini' 
        	
        	in php.ini file trovare [mail function] and modificare le seguenti righe 
        	
     		* SMTP=smtp.gmail.com
	    	* smtp_port=587
        	* sendmail_from = my-gmail-id@gmail.com
        	* sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
    
        ° modificare il file 'C:\xampp\sendmail\sendmail.ini'
        
			in sendmail.ini file trovare [sendmail] and modificare le seguenti righe 
			
			* smtp_server=smtp.gmail.com
			* smtp_port=587
			* error_logfile=error.log
			* debug_logfile=debug.log
			* auth_username=my-gmail-id@gmail.com
			* auth_password=my-gmail-password
			* force_sender=my-gmail-id@gmail.com
			
			
	-B) Per la avere la possibilità di caricare/scaricare (upload/download) file di grandi dimensioni:
		
		° modificare il file 'C:\xampp\php\php.ini' 
			
			impostare i valori alle seguenti voci:
				
				* upload_max_filesize= xxM (esempio: 50M)
				* post_max_size = xxM (esempio: 50M)
				* max_execution_time = xxxx (espresso in secondi. Ex: max_execution_time = 2800)
				
				
3) Aprire il file 'WEB-gene-expression/gene-expression/view/login.html':
	
	modificare la riga '<a href="/workspace/WEB-gene-expression/DNA/DNA.html" >' in <a href="(nome del percorso della directory 'WEB-gene-expression')/WEB-gene-expression/DNA/DNA.html">
	Questo è molto utile per la visualizzazione dell'animazione del DNA.html in three js.
	
4) Nella cartella Web-gene-expression/gene-expression/view, in tutti i file html che includono nella parte '<head>' tutti i tag del tipo
	
	"<link href="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/CSS/bootstrap.min.css" rel="stylesheet" media="screen"/>
	<link href="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/CSS/bootstrap.css" rel="stylesheet" media="screen"/>
	<script src="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/js/bootstrap.js"></script>
	<script src="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/js/bootstrap.min.js"></script>"
	
		RIMPIAZZARLI CON:
	
	"<link href="http://(nome del percorso della directory 'Web-gene-expression')/WEB-gene-expression/gene-expression/bootstrap/CSS/bootstrap.min.css" rel="stylesheet" media="screen"/>
	<link href="http://(nome del percorso della directory 'Web-gene-expression')/WEB-gene-expression/gene-expression/bootstrap/CSS/bootstrap.css" rel="stylesheet" media="screen"/>
	<script src="http://(nome del percorso della directory 'Web-gene-expression')/WEB-gene-expression/gene-expression/bootstrap/js/bootstrap.js"></script>
	<script src="http://(nome del percorso della directory 'Web-gene-expression')/WEB-gene-expression/gene-expression/bootstrap/js/bootstrap.min.js"></script>"
	
5) Nella cartella Web-gene-expression/gene-expression/view, in tutti file html che includono nella parte finale del 'body' e quindi prima del tag
   di chiusura '</body>', la parte di codice:
    
    	"<div id ="footer" style="margin-top:90px;" align="center" >
				<img src="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/img/footer.jpg">
		</div>"
		
			RIMPIAZZARLA CON:
			
		"<div id ="footer" style="margin-top:90px;" align="center" >
				<img src="http://(nome del percorso della directory 'Web-gene-expression')/WEB-gene-expression/gene-expression/bootstrap/img/footer.jpg">
		</div>"
		
		
6) Nel file Web-gene-expression/gene-expression/view/login.html sostituire la parte di codice:


		"<div id="credits" style="text-align:right; margin-right:20px; margin-top:2px;"><a href="/workspace/WEB-gene-expression/DNA/DNA.html" >Credits</a>
			<footer>
 			<small>  &copy;2014 Chiara Bartalotta, Davide Bernardini, Dario Santilli.  </small> 		
			</footer>
		</div>"
			
			CON
			
		"<div id="credits" style="text-align:right; margin-right:20px; margin-top:2px;"><a href="(nome del percorso della directory Web-gene-expression)/WEB-gene-expression/DNA/DNA.html" >Credits</a>
			<footer>
 			<small>  &copy;2014 Chiara Bartalotta, Davide Bernardini, Dario Santilli.  </small> 		
			</footer>
		</div>"
		
7) Nel file Web-gene-expression/gene-expression/view/signIn.html sostituire la parte di codice:


		"<div id="logo">
			<img src="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/img/logoMendel.png" style="margin-left:600px;margin-top:-350px;">
		</div>"
			
			CON
			
		"<div id="logo">
			<img src="http://(nome del percorso della directory Web-gene-expression)/WEB-gene-expression/gene-expression/bootstrap/img/logoMendel.png" style="margin-left:600px;margin-top:-350px;">
		</div>"
		
		

8) Il file di inizio del sito web è Web-gene-expression/gene-expression/init.php


		