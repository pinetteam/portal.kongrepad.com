php artisan make:model Meeting/Announcement/Announcement -m
php artisan make:request Portal/Meeting/Announcement/AnnouncementRequest
php artisan make:resource Portal/Meeting/Announcement/AnnouncementResource
php artisan make:controller Portal/Meeting/Announcement/AnnouncementController --resource
---
php artisan make:model Program/Session/Document/ProgramSessionDocument -m
php artisan make:model Program/Session/Presenter/ProgramSessionPresenter -m
php artisan make:model Program/Moderator/ProgramModerator -m

gh repo clone pinetteam/KongrePad-Web
mv KongrePad-Web app.kongrepad.com
chown -R app.kongrepad.com:app.kongrepad.com app.kongrepad.com
cd app.kongrepad.com
cp .env.KongrePad-Web .env
chmod -R 777 storage
composer update
php artisan optimize
npm install
npm run build
php artisan storage:link
