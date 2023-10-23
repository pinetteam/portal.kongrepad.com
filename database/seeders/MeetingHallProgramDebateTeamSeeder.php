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
                'logo_name' => '7c1cf410-e53f-4bd3-bb9f-33dc7a4f69ab',
                'logo_extension' => 'png',
                'description' => 'Mentorlar: Naziye Ak, Özgecan Dülgar, Ali Alkan'."\n".'Takım 1: Alper Türkel, Esma Uğuztemur, Hakan Yücel, Buket Şahin Çelik'
            ],
            [
                'debate_id' => '1',
                'title' => 'Adjuvan',
                'logo_name' => '291a3752-39a6-47e2-b1bd-20120f9631c6',
                'logo_extension' => 'png',
                'description' => 'Mentorlar: Atike Pınar Erdoğan, Bekir Hacıoğlu, Özlem Ercelep'."\n".'Takım 2: Melek Çağlayan, Mustafa Emre Duygulu, Şeyma Eroğlu Savaş, Yaşar Çulha'
            ],
            [
                'debate_id' => '2',
                'title' => 'Gelecektir',
                'logo_name' => '86db4094-5d14-435d-ad1b-d7bef231bb6a',
                'logo_extension' => 'png',
                'description' => 'Mentorlar: Murat Araz, Birol Yıldız, Nail Paksoy'."\n".'Takım 1: Azer Gökmen, Gonca Akdere, Murat Eser, Serhat Demirer'
            ],
            [
                'debate_id' => '2',
                'title' => 'Tehdittir',
                'logo_name' => 'dd6c6c35-345c-4075-8911-7b5f8edfb407',
                'logo_extension' => 'png',
                'description' => 'Mentorlar: Deniz Can Güven, Melek Karakurt Eryılmaz, Serkan Akın'."\n".'Takım 2: Neşe Alyıldız, Kübra Canaslan, Ömer Genç, Taliha Güçlü Kantar'
            ],
        ]);
    }
}
