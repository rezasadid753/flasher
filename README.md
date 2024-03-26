<div align="center">
    <a href="https://github.com/rezasadid753/flasher"><img src="https://rezasadid.com/projects/flasher/favicon.svg" alt="Logo" width="80" height="80"></a>
    <h3 align="center">Flasher</h3>
    <p align="center">
        A simple flashcards website to enhance your learning experience
    </p>
    <a href="https://rsdn.ir/g-fsh">View Demo</a>
    ·
    <a href="https://github.com/rezasadid753/flasher/issues">Report an Issue or Request a Feature</a>
    ·
    <a href="https://github.com/rezasadid753/flasher/pulls">Collaborate</a>
</div>

<br>

## About The Project

Flasher is a simple and modern flashcards website designed to aid in learning and memorizing new English words. It provides users with the ability to view, edit, and categorize flashcards, as well as dynamically retrieve definitions from online dictionaries with a single click.

![Cover Image](https://rezasadid.com/projects/flasher/cover.jpg)

### Built With

Flasher is built using a combination of frontend and backend technologies:

* Frontend: HTML, CSS, JavaScript
* Backend: PHP
* Database: MySQL


## Getting Started

To get started with Flasher, follow these steps:

1. Clone the repository to your local machine.
2. Update the db_connection.php file with your own database information.
3. Create the necessary database tables using the following SQL code:
```
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    access_code VARCHAR(255) NOT NULL
);
```

## Logs

### Version 1.0 (Initial Release)

* Implemented basic functionality for creating, editing, and managing flashcards.
* Integrated database functionality for storing flashcard data.
* Designed a simple and modern user interface for optimal user experience.


## Contributing

Contributions are pivotal to the growth of our project. Your input fuels innovation and enhances the user experience for everyone. Whether it's a bug fix, feature suggestion, or enhancement, your efforts are highly valued. Feel free to fork the repository, create a new branch, and share your ideas. If you have any suggestions to improve the project, don't hesitate to open an issue and tag it as "enhancement". Your contributions will be warmly welcomed, and together, we can make this project even better. Thank you for your support!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/YourFeature`)
3. Commit your Changes (`git commit -m 'Add some YourFeature'`)
4. Push to the Branch (`git push origin feature/YourFeature`)
5. Open a Pull Request


## License

Flasher is licensed under the MIT License. See the `LICENSE` file for details.


## Contact

For any inquiries or support, feel free to contact:
* Email: contact@rezasadid.com, rezasadid753@gmail.com
* Phone: +98 21 9130 2492