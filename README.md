# 🧠 Flasher – Smart Flashcards for Language Learning

A clean and modern flashcard web app to help you **learn, review, and remember** English vocabulary — faster and smarter.

## 🚀 About

Flasher is built to make vocabulary learning intuitive and frictionless.

You can create, edit, and organize flashcards with ease — and instantly pull definitions from online sources. It’s responsive, fast, and built with simplicity in mind. Whether you’re a student, language learner, or just love new words — **Flasher is your digital memory aid.**

---

## 🛠️ Features

- ✏️ Add and edit flashcards in a few clicks  
- 📂 Organize by category  
- 🌐 Auto-fetch definitions (soon!)  
- 📱 Fully responsive design — mobile & desktop friendly  
- 📤 Export/import flashcards via CSV  
- 🔒 Simple login system (demo-ready)

---

## ⚙️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  

---

## 📦 Getting Started

1. **Clone the repo:**
   ```bash
   git clone https://github.com/rezasadid753/flasher.git
   cd flasher
   ```

2. **Configure the database:**
   - Open `db_connection.php`
   - Enter your DB credentials:
     ```php
     $servername = "localhost";
     $username = "your_username";
     $password = "your_password";
     $dbname = "your_database";
     ```

3. **Import the database:**
   - Use the included `flasher_database_backup.sql` file to set up the schema

4. **Launch it in the browser:**
   - Access locally at: `http://localhost/flasher`
   - Or upload to your server

---

## 📁 Project Structure

```bash
flasher/
├── about.php
├── create_flashcard.php
├── create_flashcard_process.php
├── db_connection.php
├── delete_all_flashcards.php
├── edit_flashcard.php
├── export_csv.php
├── flasher_database_backup.sql
├── footer.php
├── header.php
├── favicon.svg
├── icon192.png
├── icon512.png
├── import_csv.php
├── index.php
├── list.php
├── login.php
├── login_process.php
├── manifest.json
├── offline.php
├── play.php
├── register.php
├── register_process.php
├── service-worker.js
└── style.css
```

---

## 🧬 Roadmap

- ✅ Basic flashcard creation, editing, deleting
- ✅ Responsive layout
- ⏳ **Auto-fetch definitions** from dictionary APIs  
- ⏳ **Dark mode & modern redesign**  
- ⏳ **Progress tracker + streak system**  
- ⏳ **Friend leaderboard & social flashcard stats**

---

## 🤝 Contributing

Want to help improve Flasher?  
Bug reports, feature suggestions, or PRs are always welcome!

---

## 📜 License

This project is open-source under the MIT License.
