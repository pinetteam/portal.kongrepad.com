<?php

namespace App\Console\Commands;

use App\Models\Meeting\Announcement\Announcement;
use App\Notifications\AnnouncementNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class PublishAnnouncements extends Command
{
    protected $signature = 'announcements:publish';

    protected $description = 'Publish announcements whose publish time has arrived';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $now = Carbon::now();

        // Yayınlanmamış duyuruları al
        $announcements = Announcement::where('publish_at', '<=', $now)
            ->where('is_published', 0)
            ->get();

        if ($announcements->isEmpty()) {
            $this->info('No announcements to publish...');
            return;
        }

        foreach ($announcements as $announcement) {
            // İlgi alanı oluştur
            $interests = ['meeting-' . $announcement->id . '-announcement'];

            // Bildirim başlık ve içeriği
            $notificationData = [
                'interests' => $interests,
                'title' => $announcement->title,
                'body' => $announcement->title,
            ];

            // Katılımcı türüne göre bildirimi gönder
            $this->sendNotifications($announcement, 'agent', $notificationData, 'agents');
            $this->sendNotifications($announcement, 'attendee', $notificationData, 'attendees');
            $this->sendNotifications($announcement, 'team', $notificationData, 'teams');

            // Duyurunun yayınlandığını işaretle
            $announcement->update(['is_published' => 1]);
            $this->info('Announcement ' . $announcement->id . ' marked as published.');
        }
    }

    /**
     * Katılımcılara bildirim gönderir.
     *
     * @param Announcement $announcement
     * @param string $type Katılımcı türü
     * @param array $notificationData Bildirim verisi
     * @param string $label Log için etiket
     * @return void
     */
    private function sendNotifications(Announcement $announcement, string $type, array $notificationData, string $label): void
    {
        // Önce ilgili meeting kontrol ediliyor
        if (!$announcement->meeting) {
            $this->error('No meeting found for announcement ID: ' . $announcement->id);
            return;
        }

        // Katılımcıları çek
        $participants = $announcement->meeting->participants()->where('type', $type)->get();

        if ($participants->isNotEmpty()) {
            // Katılımcılara bildirim gönder
            Notification::send($participants, new AnnouncementNotification($notificationData));
            $this->info('Announcement ' . $announcement->id . ' sent to ' . $label . '!');
        } else {
            $this->info('No participants of type "' . $type . '" found for announcement ID: ' . $announcement->id);
        }
    }
}
