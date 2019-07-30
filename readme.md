<h1>Instructions On How To Install</h1>
<h3>What you will need</h3>
<ul>
    <li>Text Editor e.g. Atom, VSCode or Notepad++</li>
    <li>Download & Install Composer Globally from https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos</li>
    <li>Download & install Node.js from https://nodejs.org/en/download/</li>
    <li>A terminal tool such as Command Prompt or Powershell</li>
</ul>
<h3>How to Download and Install the project</h3>
<h4>Install Dependecy Programs</h4>
<ol>
    <li>Download and install composer from the above link</li>
    <li>Download and install Node.js from the above link</li>
</ol>
<h4>Download and Unzip the Project</h4>
<ol>
    <li>Download the project by clicking on 'Clone or Download' and click on the 'Download Zip' button and save the zip file to a folder of your choosing</li>
    <li>Wait for the file to download. Once the file has finished downloading, unzip the file to the folder</li>
</ol>
<h4>Install Dependencies & Start the Project</h4>
<ol>
    <li>Open up your terminal tool i.e Powershell and navigate to the folder you have downloaded <br> e.g. <code>cd path/to/the/folder/lsapp </code> and press enter</li>
    <li>Once in the folder type in <code>composer install</code> and press enter. This will install all the dependencies</li>
    <li>
        Once the process has finished type in the following command to finalize the install<br>
        <code>php artisan key:install</code>
    </li>
    <li>Next, make sure that a .env file is created, if not get the .env.example file,  copy it and rename it to .env</li>
</ol>
<h4>Creating the Database & Migrating the Tables</h4>
<ol>
    <li>Now, go to PHPMyAdmin and create a database called 'osc-blog'</li>
    <li>Next, create a username and password and link it the database we have just created, making sure this user has all priveleges to access the database</li>
    <li>Update these credentials in the .env file</li>
</ol>

<h4>Further notes</h4>
<p>Make sure that you create a virtual host for this project, making sure to restart your server to allow the change to take effect.</p>
<p>Thank you for downloading</p>

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Pulse Storm](http://www.pulsestorm.net/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
