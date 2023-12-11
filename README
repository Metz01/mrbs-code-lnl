Meeting Room Booking System
http://mrbs.sourceforge.net/
-------------------------------

The Meeting Room Booking System (MRBS) is a PHP-based application for
booking meeting rooms (surprisingly!). I got annoyed with the piles of books
which were being used to book meetings. They were slow, hard to edit and only
at the reception desk. I thought that a nice web-based system would be much
nicer.

Some parts of this are based on WebCalender 0.9.4 by Craig Knudsen
(http://www.radix.net/~cknudsen/webcalendar/) but there is now very little
which is similar. There are fundamental design goal differences between
WebCalendar and MRBS - WC is for individuals, MRBS is for meeting rooms.

------
To Use
------
See the INSTALL file for installation instructions.

Once it's installed try going to http://yourhost/mrbs/

If you're using the default authentication type ('db') the first thing you'll
be prompted to do is to create an admin user.  Once you've done that you'll
need to login using the credentials you've just specified.

Once you have logged in as an administrator you can click on "Rooms" and
create first an "Area", and then a "Room" within that area.

There are other ways to configure authentication in MRBS, see the
file AUTHENTICATION for a more complete description.

It should be pretty easy to adjust it to your corporate colours - you can
modify the themes under "Themes" or (preferably) copy an existing theme
to a new directory and modify the new theme.

See LICENSE for licensing info.

See NEWS for a history of changes.

See AUTHENTICATION for information about user authentication/passwords.

-------------
Requirements:
-------------
- PHP 7.2 or above with MySQL and/or PostgreSQL support
- MySQL (5.5.3 and above) or PostgreSQL 8.2 or above.
- Any web server that is supported by PHP

Recommended:
- JavaScript-enabled browser
- PHP module connection to the server (also called SAPI) if you want to use any
  of the basic http authentication schemes provided.

(If you are considering porting MRBS to another database, see README.sqlapi)


---

# MODICFICHE CODICE MRBS PER RICHIESTE LNL
# ----

## IMPOSTAZIONI FILE DI CONFIG
PATH: `web/`
FILE: `config.inc.php`

Creiamo 2 nuove sezioni come quelle Timezone e DataBase settings prima di queste e dopo le informazioni su MRBS:

/******
 * LDAP
 ******/
```
/************
 * USER ROLES
 ************/
```

### LDAP LOGIN
Aggiungere nella sezione LDAP:
```
$auth["type"] = "ldap";

// 'auth_ldap' configuration settings
// Where is the LDAP server
$ldap_host = "ldaps://imap.lnl.infn.it";
// If you have a non-standard LDAP port, you can define it here
$ldap_port = 636;
// If you want to use LDAP v3, change the following to true
$ldap_v3 = false;
// If you want to use TLS, change following to true
$ldap_tls = false;
// LDAP base distinguish name
// See AUTHENTICATION for details of how check against multiple base dn's
$ldap_base_dn = "dc=lnl,dc=infn,dc=it";
// Attribute within the base dn that contains the username
$ldap_user_attrib = "uid";
```
Questo permette di impostare l'autenticazione al sito tramite LDAP, collegandosi al server LDAP dei laboratori.

### AUTENTICAZIONE SOLO TRAMITE LOGIN
Per impostare l'accesso al sito solo tramite login aggiungiamo nella sezione USER ROLES la linea:
`$auth['deny_public_access'] = TRUE;`
In questo modo la prima pagina che verrà mostrata sarà quella di login.

#### USER ROLES LEVEL
I ruoli che può avere un utente al momento si dividono in 3:
    - admin (3)
    - user (2)
    - spectator (1)
Quindi dobbiamo impostare i livelli massimi per azioni admin. Aggiungiamo nella sezione USER ROLES le righe:
```
$max_level = 3;
$min_booking_admin_level = 3;
$min_level_to_book = 2;
```
Si ha che `max_level` indica il livello massimo che una persona registrata può ottenere, mentre `min_booking_admin_level`
indica il livello minimo perchè un utente abbia la possibilità di modificare le prenotazioni anche degli altri. 
`min_level_to_book`indica il livello minimo che un utente deve avere per poter prenotare uan stanza.

### USER ROLES
Per aggiungere nuovi users alla lista di utenti speciali che possono modificare o creare riunioni la sintassi è:
`$auth["role_name"][] = "User_uid";`
Questi vanno aggiunti nella sezione USER ROLES.
I casi classici di `role_name` sono:
    - `"admin"` con il permesso di modificare e creare sale e prenotazioni di tutti gli users.
    - `"user"` con il permesso di creare e modificare solo le proprie prenotazioni.
Tutti gli user che non rientrano in nessuna di queste liste (e che quindi non sono specificati nel file di config
ma sono registrati nel server LDAP) sono considerati spettatori, ovvero possono solo vedere le prenotazioni che sono
state effettuate dagli altri users.

### TIMEZONE
$timezone = "Europe/Rome";

### DATABASE SETTINGS
Da tenere in considerazione che se si sta usando docekr con container separati per web e database, e sono nella stessa
network allora il `$db_host` dovrà essere lo stesso del nome del container docker del database.

## MODIFICHE FILE AUTENTICAZIONE LDAP
PATH: `web/lib/MRBS/Auth/`
FILE: `AuthLdap.php`

### IMPOSTARE LIVELLO PER USER ROLES
Dobbiamo aggiungere un metodo per impostare i livelli per ogni role che abbiamo creato nel config file.
All'interno della funzione `getUserCallBack` prima di `if(isset ($user['groups']))` 
(Circa in riga 479 (Con la versione di MRBS con cui sto lavorando al momento MRBS 1.11.4)) aggiungiamo un controllo
del tipo:
```
if(in_array($user['username'], $auth['role_name'])){
    $user['level'] = role_level;
}
```
per ogni nuovo ruolo che vogliamo aggiungere. Quidni con i 3 standard risulterà qualcosa come:
```
if(in_array($user['username'], $auth['admin'])){
    $user['level'] = $max_level;
}else if(in_array($user['username'], $auth['user'])){
    $user['level'] = 2;
}else{
    $user['level'] = 1;
}
```

## MODIFICHE FILE LIVELLI DI ACCESSO
PATH: `web/`
FILE: `mrbs_auth.inc`

### LIVELLO MINIMO PER PRENOTARE
Per modificare il livello minimo per prenotare una stanza dobbiamo modificare la funzione `booking_level()`:
    - Nella dichiarazione delle variabili globali aggiungiamo $min_level_to_book: `global $auth, $min_level_to_book;`
    - Come ultimo return della funzione (Quello che esegue se i casi prima non sono validi) mettiamo: `return $min_level_to_book;`

### LIVELLO MINIMO PER ACCESSO ALLE PAGINE
Per modificare il livello minimo per l'accesso alle varie pagine del sito si va a modificare la funzione `get_page_level($page)`.
In base a quale vogliamo sia il livello minimo necessario per poter vedere una pagina dobbiamo andare a modificare i `$result = role_level`
che troviamo nello switch case. Consideriamo che ogni  `$result = role_level; break;` che troviamo è il livello minimo di accesso
alle pagine che si trovano sopra di lui (fino al precedente break;).
Nel caso standard:

|$result = 1;| $result = $max_level; | return booking_level(); | $result = $max_level; |
|----------|----------|----------|----------|
| help.php | admin.php | check_slot.php | add.php |
| index.php | approve_entry_handler.php | del_entry.php | del.php |
| search.php | edit_room.php | edit_entry.php | del_entries.php |
|  | edit_users.php | edit_entry_handler.php | edit_area.php |
|  | pending.php |  | edit_room_handler.php |
|  | registration_handler.php | | import.php |
|  | usernames.php |  | kiosk.php |
|  |  |  | report.php |
