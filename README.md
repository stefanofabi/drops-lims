## About Drops LIMS

Drops LIMS is a web application for the management of clinical laboratories. Drops LIMS establishes well-defined processes in the area of your laboratory from the arrival of the patient to the delivery of results and even their follow-up. We facilitate the most common tasks that are often used in any laboratory, such as:

- Internal worksheets for the laboratory
- Monitoring of social works debt
- Statistics on patient flow
- Generation of PDF reports
- User permissions for internal administration
- System activity log and system logs

Drops LIMS is accessible, powerful, and provides the tools you need to bring that peace of mind to your lab.

## Starting 🚀

These instructions will allow you to get a copy of the project running on your local machine or server for development or testing purposes.

### Pre requirements 📋

What things do you need to install the project and how to do it

```
- Composer
- NPM
- PHP 8.x with mbstring, gd and pdo_pgsql extension
- PostgreSQL
```

### Installation 🔧

1. Clone the repository on your local machine or server

```
# git clone https://github.com/stefanofabi/drops-lims.git
```

2. Create a copy of the .env.example file and rename it to .env. Inside it we will edit the environment variables to establish the connection to the database.

```
# cd drops-lims
# cp .env.example .env
# vim .env
```

3. Proceed to install the dependencies required for the project and generate the javascript files and styles.

```
# composer install
# npm install
# npm run dev
```
4. Create a link to the storage folder that contains everything related to the application and create the application key that will protect user sessions and other data.

```
# php artisan key:generate
```

5. Finally execute the migrations and seeds

```
# php artisan migrate
# php artisan db:seed
```

6. Running the seeds will allow you to log in with some test users.
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
