php artisan make:model Program/Session/ProgramSession -m
php artisan make:request Portal/Program/Moderator/ProgramModeratorRequest
php artisan make:resource Portal/Program/Moderator/ProgramModeratorResource
php artisan make:controller Portal/Program/Moderator/ProgramModeratorController --resource
---
php artisan make:model Program/Session/Document/ProgramSessionDocument -m
php artisan make:model Program/Session/Presenter/ProgramSessionPresenter -m
php artisan make:model Program/Moderator/ProgramModerator -m
