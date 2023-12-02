<?php

namespace App\Console\Commands;

use App\Models\Meeting\Announcement\Announcement;
use App\Notifications\AnnouncementNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PublishAnnouncements extends Command
{
    protected $signature = 'announcements:publish';

    protected $description = 'Publish announcements whose publish time has arrived';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $announcements = Announcement::where('publish_at', '<=', $now)->where('is_published', 0)->get();
       foreach ($announcements as $announcement){
           $meeting = $announcement->meeting;
            //todo will open this on prod
            if ($meeting->participants->where('type', 'attendee')->count() > 0){
                $meeting->participants->where('type', 'attendee')->first()->notify(new AnnouncementNotification($announcement));
            }
            if ($meeting->participants->where('type', 'agent')->count() > 0) {
                $meeting->participants->where('type', 'agent')->first()->notify(new AnnouncementNotification($announcement));
            }
            if ($meeting->participants->where('type', 'team')->count() > 0) {
                $meeting->participants->where('type', 'team')->first()->notify(new AnnouncementNotification($announcement));
            }
           $announcement->is_published = 1;
           $announcement->save();
       }

        Log::info("Announcements published: ".date('d/m/Y H:i:s'));
        Log::info("---------------------------------------------------------");
    }
}
