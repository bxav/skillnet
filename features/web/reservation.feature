# language: fr
Fonctionnalité: Reserver un rendez-vous
  Afin d'obtenir de pouvoir reserver une prestation
  En tant que client
  Je dois être capable d'acceder à la page déservation

  Contexte:
    Etant donné there is 1 business like:
      | name | disponibilityTimeSlot |
      | Béa coiffure | 15 |
    Et the following employee:
      | username | plainPassword | roles | firstname | lastname | business |
      | user | user | ROLE_API | marie | dupond | Béa coiffure |
    Et the following services:
      | business | duration | type |
      | Béa coiffure | 30 | Coiffure |
      | Béa coiffure | 130 | Brushing |
    Et there is 1 customer like:
      | username | plainPassword | firstname | lastname |
      | john | john | John | Duff |
    Et the following bookings:
      | employee | service | customer | startDateTime | endDateTime |
      | user | Coiffure | john | 2042-01-01 13:35:00.0 | 2042-01-01 17:30:00.0 |
      | user | Brushing | john | 2042-01-01 07:30:00.0 | 2042-01-01 09:15:00.0 |
      | user | Brushing | john | 2042-01-01 14:30:00.0 | 2042-01-01 16:20:00.0 |
    Et le business "bea-coiffure" travaile le "wednesday" de "09:00" à "18:00"
    Et je suis loguer entant que "john"

  @ignore
  Scénario: Recherche un rendez-vous pour une coupe/shampooing/Brushing à 16h le 8 septembre autour de chez lui
    Etant donné ma géolocalisation
    Quand je recherche dans un rayon de 5km
       Et je recherche l’ensemble des des prestations correspondant coupe/shampooing/Brushing
       Et je recherche autour de 16h
    Alors je suis sur la page de résultat
       Et je dispose de la liste des salons par pertinence avec le créneau horaire et de distance

  Scénario: Visualisation des disponibilité d'une coupe/shampooing/Brushing à 16h le 8 septembre chez béa coiffure
    Etant donné que je suis sur la page des disponibilités
       Et une liste de prestataires m'est proposé suite à une recherche
    Quand quand je clique sur un prestataire "Béa coiffure"
    Alors je devrais être sur la page du professionnel "Béa coiffure"
       Et je devrais voir les informations sur le salon
       Et je devrais voir ma demande de disponibilité surlignée sur un calendrier

  Scénario: Réservation d'une coupe/shampooing/Brushing à 16h le 8 septembre chez béa coiffure
    Etant donné je suis sur la page du professionnel "Béa coiffure" et que je recherche un rendez-vous pour une "Coiffure", le "2042-01-01"
    Alors je ne devrais pas voir "09:00"
       Et je devrais voir "10:15"
       Et je ne devrais pas voir "16:15"

  Scénario: Réservation d'une coupe/shampooing/Brushing à 16h le 8 septembre chez béa coiffures
    Etant donné je suis sur la page du professionnel "Béa coiffure" et que je recherche un rendez-vous pour une "Coiffure", le "2042-01-01"
    Quand je clique sur "10:15" dans le calendrier
    Alors je devrais voir "Reserver"

  @ignore
  Scénario: Réservation d'une coupe/shampooing/Brushing à 16h le 8 septembre chez béa coiffures
    Etant donné je suis sur la page du professionnel "Béa coiffure" et que je recherche un rendez-vous pour une "Coiffure", le "2042-01-01"
    Quand je clique sur "10:15" dans le calendrier
    Alors je devrais voir "Reserver"
    Alors je vois l’ensemble des données récapitulative apparaît à l’écran (Nom salon,, adresse, soin, date, horaire et employé) avec un bouton validé.
    Et je suis redirigée vers la page d’inscription (pour un non inscrit) ou je rentre directement sur ma page de profil particulier avec le rendez-vous inscrit sur celle-ci