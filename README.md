SIS
===

School Information Service

Files
-----


* /app/   
  -> relevante Dateien für die App   
* /backend/   
  -> Eingabebereich   
  * ./absentees/
    -> Fehlende-Menü    
    * ./classes/    
      -> fehlende Klassen    
    * ./teachers/   
      -> fehlende Lehrer   
  * ./administration/   
    -> Administrattions-Menü   
    * ./classes/   
      -> Klassen verändern   
    * ./hours/   
      -> Zeiten verändern   
    * ./lessons/   
      -> Stundenpläne verändern   
    * ./rooms/   
      -> Räume verändern   
    * ./sections/   
      -> Abteilungen verändern   
    * ./subjects/   
      -> Fächer verändern   
    * ./teachers/   
      -> Lehrer verändern   
  * ./monitors/   
    -> Monitore verwalten
  * ./news/   
    -> News verwalten   
  * ./substitudes/   
    -> Supplierungs-Menü   
    * ./form/   
      -> Formular für Supplierungen   
* /cookies/   
  -> Cookies-Akzeptier-Seite
* /data/   
  * ./ajax/   
    -> generelle AJAX-Scripts (serverseitig)
  * ./fonts/   
    -> Schriftarten
  * ./images/   
    -> Bilder   
    -> (hier gibt es noch weitere Unterordner)   
  * ./scripts/   
    -> Javascripts
  * ./styles/   
    -> Stylesheets (CSS)
* /doc/   
  -> Gesamtdokumentation
  * ./instructions/   
    -> Anleitungen
* /impressum/   
  -> Impressum, Datenschutzbestimmungen, Nutzungsbedingungen   
* /login/   
  -> Login-Frontend   
* /logout/   
  -> Logout   
* /logs/   
  -> Sonstige Logs   
* /mobile/   
  -> mobile Seite   
* /modules/   
  * ./api/   
    -> Weitere Dateien für die App-API   
  * ./database/   
    -> Weitere Dateien für den Zugriff auf die Datenbank   
  * ./design/   
    -> Designs als HTML-Dateien   
  * ./form/   
    -> Dateien zum Generieren von Formularen   
  * ./general/   
    -> Allgemeine Includes für LDAP, DB, HTTPS, etc.   
  * ./menu/   
    -> Daten für das Generieren des Hauptmenüs   
  * ./monitors/   
    -> Weitere Dateien für die Monitore   
  * ./other/   
    -> Sonstiges   
* /monitors/   
  -> Frontend für die Monitore
  * ./api/   
    -> Dateien für die Monitore   
  * ./media/
    -> Medien-Dateien für die Monitore   
* /news/   
  -> Frontend für die News   
* /substitudes/   
  -> Supllierungen   
* /timetables/   
  -> Stundenpläne   
* /tmp/
  -> temporärer Ordner   


Installation
------------

/{config.def.php -> config.php}   
/modules/general/{MySQLpassword.def.php -> MySQLpassword.php}   
/modules/general/{LDAPpassword.def.php -> LDAPpassword.php}   
/modules/external/fpdf -> fpdf.zip unzip ( from fpdf.org)
