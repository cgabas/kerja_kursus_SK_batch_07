# TEMA TUGASAN SAINS KOMPUTER SPM 2024

## SISTEM REKOD KEHADIRAN : PENGESAHAN DIHUJUNG JARI

**Rekod kehadiran individu merupakan maklumat penting bagi sesebuah organisasi sebagai bukti penglibatan atau kehadiran individu dalam setiap  aktiviti yang dianjurkan. Perekodan kehadiran secara manual sering menyebabkan beberapa kesukaran seperti maklumat yang diperoleh kurang tepat, tercicir, bertindih, tidak jelas dan lain-lain. Sebagai seorang pembangun sistem, anda dikehendaki membangunkan  satu aplikasi berasaskan web yang dapat merekod atau mengesahkan kehadiran individu dalam setiap aktiviti yang dianjurkan oleh organisasi. Sistem yang dibangunkan mestilah boleh dicapai menggunakan pelayar web dari  mana-mana komputer dalam rangkaian setempat (LAN).**

## TEMA TUGASAN TAMAT

# SYSTEM

## Table Of Contents
- [Description](#description)
- [Installation](#installation)

### Description
__Malay__: Sistem ini dengan namanya "__Sistem Program Intervensi__" boleh melakukan perekodan kehadiran yang hanya boleh dilakukan oleh guru yang telah didaftarkan oleh admin (PKHEM) di dalam pangkalan data guru. Fungsi sistem yang diberi kepada guru termasuklah melihat senarai nama murid yang telah didaftarkan ke pangkalan data sistem, melihat kehadiran murid yang telah direkodkan oleh guru, melihat kesemua senarai program yang pernah diadakan, merekod kehadiran murid yang terlibat pada program tertentu dan mencetak senarai-senarai seperti kehadiran murid, murid yang pernah didaftarkan ke dalam pangkalan data dan senarai program sama ada yang tertentu mahupun kesemuanya.

Sementara itu, admin pula iaitu PKHEM mempunyai kesemua fungsi sistem yang diberikan oleh guru kecuali merekod kehadiran murid. Walau bagaimanapun, admin mempunyai kelebihan fungsi sistem berbanding guru iaitu admin dapat menyunting mana-mana data program, murid dan guru yang pernah didaftarkan secara satu per satu.

__English__: This system with the name "__Intervention Program System__" can record attendance which can only be done by teachers who have been registered by the admin (PKHEM) in the teacher's database. The functions of the system given to the teacher include viewing the list of students' names that have been registered to the system database, viewing the attendance of students that have been recorded by the teacher, viewing all lists of programs that have been held, recording the attendance of students involved in certain programs and printing lists such as student attendance, students who have been registered in the database and the list of programs either specific or all.

Meanwhile, the admin, which is PKHEM, has all the functions of the system provided by the teacher except for recording student attendance. However, the admin has the advantage of the system function compared to the teacher, which is that the admin can edit any program data, students and teachers that have been registered one by one.

### Installation

**Target Audience**: This installation guide is designed for beginners who are unfamiliar with server hosting.

1. Ensure you have the following software installed on your computer:
   - [XAMPP Server](https://www.apachefriends.org/download.html)
   - [VS Code](https://code.visualstudio.com/download) or your preferred code editor.

2. Start the Apache and MySQL services in XAMPP:
   - Open the XAMPP Control Panel.
   - Click the "Start" button next to "Apache" and "MySQL" modules.

   ![Start Apache and MySQL](style/image/XAMPP.JPG "XAMPP Control Panel")

3. Verify that XAMPP is running:
   - Open your web browser and go to `localhost/` or `127.0.0.1/`. You should see the Apache default page, confirming that the server is running.

   ![Apache Running](style/image/PHPMYADMIN.JPG "Apache Default Page")

4. Access PhpMyAdmin:
   - Navigate to `localhost/phpmyadmin` or `127.0.0.1/phpmyadmin` in your browser, or click the "Admin" button in the XAMPP Control Panel.

   ![PhpMyAdmin](style/image/PHPMYADMIN1.JPG "PhpMyAdmin Login")

5. You should now see the PhpMyAdmin dashboard where you can manage your databases.

   ![PhpMyAdmin Dashboard](style/image/PHPMYADMIN2.JPG "PhpMyAdmin Dashboard")

6. Troubleshooting Tips:
   - If you encounter issues, consider:
     - [Installing MySQL Manually](https://www.mysql.com/downloads/)
     - Reinstalling XAMPP
     - Restarting your computer
     - Restarting Apache and MySQL services

   **Note**: For additional help, consult relevant online resources or use tools like ChatGPT for assistance.