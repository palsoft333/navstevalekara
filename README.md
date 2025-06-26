# navstevalekara
EN: Doctor schedule checker and mail notification for navstevalekara.sk website

SK: Kontrola dostupnosti voľných termínov u doktora a následné e-mailové upozornenie zo stránok navstevalekara.sk

## Requirements
- PHP >=5.3
- PHP mail function
- setting up cron

## Installation
1. Copy navstevalekara.php on your server
2. Change "dc" parameter in $postData on line 10 for your doctor's ID (you can get doctor's ID from his URL at navstevalekara as shown here):
![image](https://github.com/user-attachments/assets/93b3be3e-e9cb-4a35-8022-9f1a4a08c7b0)
3. Change your email on line 56
4. Set up cron for periodic running of the script
5. If there will be an available schedule, you will receive an email

<a href="https://www.buymeacoffee.com/palsoft" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a>
