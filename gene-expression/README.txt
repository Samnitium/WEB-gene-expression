ALCUNE IMPORTANTI ANNOTAZIONI PER L'UTILIZZO DEL PORTALE Web-Service Gene-Expression:

1) Il super-utente (con tutti i relativi dati) deve essere impostato manualmente sul database del proprio server, 
   mentre gli utenti normali si possono registare tranquillamente sul sito web.
   Fare attenzione a riempire il campo 'type', che deve essere con valore 'superuser' per il super-utente e con valore 'user' per gli utenti normali.
   Il campo 'code' può avere come valore la stringa vuota '' per il super utente, mentre per gli utenti normali, il 
   valore deve corrispondere ad un codice che viene generato in maniera randomica in fase di registrazione.
   
2) E' necessario fare delle piccole configurazioni al proprio server:
   - Per la parte di utilizzo della posta elettronica, utile per la registrazione o per il ricordo della password 
     dimenticata: 
        ° modificare il file php.ini con queste righe
     		* SMTP=smtp.gmail.com
	    	* smtp_port=587
        	* sendmail_from = my-gmail-id@gmail.com
        	* sendmail_path = "\"C:\(nome_server)\sendmail\sendmail.exe\" -t" 
    
        ° modificare il file