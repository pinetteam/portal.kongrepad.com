<?php

namespace Database\Seeders;


use App\Models\Meeting\Hall\Program\Debate\Team\Team;
use Illuminate\Database\Seeder;

class MeetingHallProgramDebateTeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::insert([
            [
                'debate_id' => '1',
                'title' => 'Neoadjuvan',
                'description' => 'Mentorlar: Naziye Ak, Özgecan Dülgar, Ali Alkan'."\n".'Takım 1: Alper Türkel, Esma Uğuztemur, Hakan Yücel, Buket Şahin Çelik'
            ],
            [
                'debate_id' => '1',
                'title' => 'Adjuvan',
                'description' => 'Mentorlar: Atike Pınar Erdoğan, Bekir Hacıoğlu, Özlem Ercelep'."\n".'Takım 2: Melek Çağlayan, Mustafa Emre Duygulu, Şeyma Eroğlu Savaş, Yaşar Çulha'
            ],
            [
                'debate_id' => '2',
                'title' => 'Gelecektir',
                'description' => 'Mentorlar: Murat Araz, Birol Yıldız, Nail Paksoy'."\n".'Takım 1: Azer Gökmen, Gonca Akdere, Murat Eser, Serhat Demirer'
            ],
            [
                'debate_id' => '2',
                'title' => 'Tehdittir',
                'description' => 'Mentorlar: Deniz Can Güven, Melek Karakurt Eryılmaz, Serkan Akın'."\n".'Takım 2: Neşe Alyıldız, Kübra Canaslan, Ömer Genç, Taliha Güçlü Kantar'
            ],
        ]);
    }
}
