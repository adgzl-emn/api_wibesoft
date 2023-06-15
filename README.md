Projede kurgu su sekildedir

1- Kullanici ekleme => http://127.0.0.1:8000/api/add-user
2- Admin ekleme => http://127.0.0.1:8000/api/add-admin
3- Gorev Ekleme (token gerekli)  => http://127.0.0.1:8000/api/add-task
    3.a- sadece yonetici ekler
    3.b- Mail icin ben localde mailtrap denedim eger sizde mailtrap kullanmak isterseniz
     env ayarlarini degistirin
     '
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
'
4- Gorev Guncelleme  (token gerekli) => http://127.0.0.1:8000/api/update-task
 4.a eger user ise  gorevin status unu guncelleyebilir

5- Gorev Silme  (token gerekli) => http://127.0.0.1:8000/api/delete-task
 5.a - sadece admin silebilir

6- User Detail  (token gerekli)  =>http://127.0.0.1:8000/api/user-info
