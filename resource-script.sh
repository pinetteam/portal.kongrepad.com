php artisan make:model Participant/Participant -m
php artisan make:request Portal/Participant/ParticipantRequest
php artisan make:resource Portal/Participant/ParticipantResource
php artisan make:controller Portal/Participant/ParticipantController --resource

php artisan make:request Portal/AttendeeAndTeam/AttendeeAndTeamRequest
php artisan make:resource Portal/AttendeeAndTeam/AttendeeAndTeamResource
php artisan make:controller Portal/AttendeeAndTeam/AttendeeAndTeamController --resource
