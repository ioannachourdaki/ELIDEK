# ΕΛΙΔΕΚ
Εξαμηνιαία εργασία στο πλαίσιο του μαθήματος 'Βάσεις Δεδομένων', ΡΟΗ Λ - ΣΗΜΜΥ ΕΜΠ 6ο εξάμηνο 
## Dependencies:

    • Apache Web Server
    • MySQL 
    • PHP

## Αναλυτικά βήματα εγκατάστασης εφαρμογής

Η εφαρμογή αναπτύχθηκε για λειτουργικό σύστημα Linux (ο χρήστης πρέπει να έχει sudo privileges)

#### Aναλυτικές οδηγίες εγκατάστασης του LAMP stack μπορείτε να βρείτε στον παρακάτω σύνδεσμο:
https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04
 
#### Εγκατάσταση της βάσης
To αρχείo ELIDEK_DDL.sql περιέχει όλο τον κώδικα για τη δημιουργία του σχήματος και των απαραίτητων περιορισμών (tables, triggers, views, καθώς και indexes), ενώ η εισαγωγή των δεδομένων θα γίνει με χρήση του αρχείου dummy_data.sql. Και τα δύο αυτά αρχεία βρίσκονται στον φάκελο elidek_db.
Μετά τη λήψη των παραπάνω αρχείων (υποθέτουμε ότι τα αρχεία αποθηκεύονται στο directory ‘db_directory’), εκτελούμε τις παρακάτω εντολές στο terminal, αφού πρώτα ανοίξουμε τη mysql:

```
mysql> source db_directory/ELIDEK_DDL.sql
mysql> source db_directory/dummy_data.sql
```

## Apache localhost configuration

Τελευταίο βήμα πριν την εκτέλεση της εφαρμογής είναι η αντιγραφή όλων των αρχείων του φακέλου web_app (github repository) στο directory ```/var/www/html``` Εάν υπάρχει αρχείο index.php πριν την αντιγραφή, πρέπει να φροντίσουμε να το αντικαταστήσουμε από το καινούριο index.php (Αν υπάρχει αρχείο index.html πρέπει να απομακρυνθεί από το συγκεκριμένο directory)


