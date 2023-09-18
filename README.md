## About Drops LIMS

Drops LIMS is a web application for the management of clinical laboratories. Drops LIMS establishes well-defined processes in the area of your laboratory from the arrival of the patient to the delivery of results and even their follow-up. We facilitate the most common tasks that are often used in any laboratory, such as:

- Determinations grouped by Biochemical Nomenclator
- List of doctors and prescribers
- Internal worksheets for the laboratory
- Classification of protocols by billing periods
- Practices signed by the biochemical professional
- Generation of PDF reports and sending by email
- Monitoring of payments of social works
- Statistics on patient arrival, most attended social works, composition of patients by sex, billing monitoring, etc.
- Staff permissions
- System activity log and system logs

Drops LIMS is accessible, powerful, and provides the tools you need to bring that peace of mind to your lab.

## Starting 🚀

These instructions will allow you to get a copy of the project running on your local machine or server for development or testing purposes.

### Pre requirements 📋

What things do you need to install the project and how to do it

```
- Composer ^2.2
- NPM
- PHP ^8.1 with mbstring, gd and pdo_pgsql extension
- PostgreSQL
```

### Installation 🔧

1. Clone the repository on your local machine or server

```
$ git clone https://github.com/stefanofabi/drops-lims.git
```

2. Create a copy of the .env.example file and rename it .env. Inside it we will edit the environment variables to establish the connection with the database and mail server

```
$ cd drops-lims
$ cp .env.example .env
$ nano .env
```

3. Proceed to install the dependencies required for the project and generate the javascript files and styles.

```
$ composer install
$ npm install
$ npm run build
```
4. Create the application key that will protect user sessions and other data.

```
$ php artisan key:generate
```
5. Make the storage folder public

```
$ php artisan storage:link
```

6. Finally execute the migrations and seeds

```
$ php artisan migrate
$ php artisan db:seed
```

7. Running the seeds will allow you to log in with some test users.
```
- Administrator 
Email: admin@laboratory
Password: password

- Patient
Email: patient@domain
Password: password
```

Remember to modify passwords in production!

## Security Vulnerabilities

To report a vulnerability please create a new issue for better tracking.

The estimated time to fix such vulnerability, if any, will depend solely on its severity and community support.

## License

The Drops LIMS app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
