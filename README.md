## About SrLab

SrLab is a web application for the management of clinical laboratories. SrLab establishes well-defined processes in the area of your laboratory from the arrival of the patient to the delivery of results and even their follow-up. We facilitate the most common tasks that are often used in any laboratory, such as:

- Internal worksheets for the laboratory
- Monitoring of social works debt
- Statistics on patient flow
- Generation of PDF reports
- User permissions for internal administration
- System activity log and system logs

SrLab is accessible, powerful, and provides the tools you need to bring that peace of mind to your lab.

## Starting 🚀

These instructions will allow you to get a copy of the project running on your local machine or server for development or testing purposes.

### Pre requirements 📋

What things do you need to install the project and how to do it

```
- Composer
- NPM
- PHP 8
- Relational database (MySQL, Mariadb, etc.)
```

### Installation 🔧

1. Clone the repository on your local machine or server

```
# git clone https://github.com/stefanofabi/srlab.git
```

2. Create a copy of the .env.example file and rename it to .env. Inside it we will edit the environment variables to establish the connection to the database.

```
# cd srlab
# cp .env.example .env
# vim .env
```

3. Proceed to install the dependencies required for the project and generate the javascript files and styles.

```
# composer install
# npm install
# npm run dev
```
4. Create a link to the storage folder that contains everything related to the application.

```
# php artisan storage:link
```

5. Finally execute the migrations and seeds

```
# php artisan migrate
# php artisan db:seed
```

6. Running the seeds will allow you to log in with some test users.
```
- Administrator 
Email: admin@company
Password: password

- Patient
Email: user@domain
Password: password
```

Remember to modify passwords in development!

## Contributing

Thank you for considering contributing to the SrLab app! You can do it in:
- [MercadoPago](https://www.mercadopago.com/mla/debits/new?preapproval_plan_id=2c93808477025e4f017704a6960805b5)
- [PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UHXMAB3HMS9CG)
- Bitcoin Wallet: 1BxrkKPuLTkYUAeMrxzLEKvr5MGFu3NLpU

## Security Vulnerabilities

To report a vulnerability you can do so directly to the creator's email stefanofabi96@gmail.com . If it is something very punctual, please create a new issue to give it a better follow-up.

The estimated time to fix such vulnerability if it exists will depend exclusively on its severity and the help of the community.

## License

The SrLab app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
