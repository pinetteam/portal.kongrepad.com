<?php

namespace Database\Seeders;

use App\Models\Meeting\Survey\Question\Question;
use Illuminate\Database\Seeder;

class MeetingSurveyQuestionSeeder extends Seeder
{
    public function run(): void
    {
        Question::insert([
            [
                'sort_order' => '10',
                'survey_id' => '1',
                'question' => 'Prostat kanserine bağlı ADT alan hastalarda;',
                'status' => 1,
            ],
            [
                'sort_order' => '20',
                'survey_id' => '1',
                'question' => 'Prostat kanseri nedeniyle ADT  alan hastalarda;',
                'status' => 1,
            ],
            [
                'sort_order' => '30',
                'survey_id' => '1',
                'question' => 'ADT alan hastalarda Erkek OP’u açısından DEXA nasıl çekilmelidir?',
                'status' => 1,
            ],
            [
                'sort_order' => '40',
                'survey_id' => '1',
                'question' => 'ADT alan hastalarda hangi durumlarda 25 OH D vitamin düzeyi ne zaman bakılmalıdır?',
                'status' => 1,
            ],
            [
                'sort_order' => '50',
                'survey_id' => '1',
                'question' => 'Hormona duyarlı ya da kastrasyon dirençli metastatik hastalıkta D vit ölçümü ne zaman yapılmalıdır?',
                'status' => 1,
            ],
            [
                'sort_order' => '60',
                'survey_id' => '1',
                'question' => 'Adjuvan tedavide ADT alan hastalarda;',
                'status' => 1,
            ],
            [
                'sort_order' => '70',
                'survey_id' => '1',
                'question' => 'Erkek OP;',
                'status' => 1,
            ],
            [
                'sort_order' => '80',
                'survey_id' => '1',
                'question' => 'Kliniğinizde son 3 ay içerisinde ADT alan metastatik prostat kanseri hastalarınızda bazal DEXA çekimini her hastanıza önerdiniz mi?',
                'status' => 1,
            ],
            [
                'sort_order' => '90',
                'survey_id' => '1',
                'question' => 'Kliniğinizde son 3 ay içerisinde ADT alan metastatik prostat kanseri hastalarınızda kemik sağlığı takibinizde hangi laboratuvar belirteçlerini kullandınız?',
                'status' => 1,
            ],
            [
                'sort_order' => '100',
                'survey_id' => '1',
                'question' => 'Ulusal İmmunonkoloji Kongresi tarihleri içerisinde Dünya Osteporoz Günü hangisidir?',
                'status' => 1,
            ],
            [
                'sort_order' => '10',
                'survey_id' => '2',
                'question' => 'Çalıştığınız kurum',
                'status' => 1,
            ],
            [
                'sort_order' => '20',
                'survey_id' => '2',
                'question' => 'Nadir görülen bir hasta ile karşılaştığınızda ilk bakacağınız kaynak hangisi olur?',
                'status' => 1,
            ],
            [
                'sort_order' => '30',
                'survey_id' => '2',
                'question' => 'Hastalara kemoterapi dozunu planlarken uyguladığınız yöntem hangisidir?',
                'status' => 1,
            ],
            [
                'sort_order' => '40',
                'survey_id' => '2',
                'question' => 'Kemoterapi uygulama şeması ile karar veremediğin bir durum oldu.Mesela mesna uygulaması.Nasıl davranırsın?',
                'status' => 1,
            ],
            [
                'sort_order' => '50',
                'survey_id' => '2',
                'question' => 'Yan etki yönetimi için  kararınızı etkileyen en önemli faktör hangisidir? (mesela hipec kemoterapi şeması veya intratekal kemeoterapi uygulama şemaları)',
                'status' => 1,
            ],
            [
                'sort_order' => '60',
                'survey_id' => '2',
                'question' => 'Klinikte takip etmeği sevdiğiniz tümör grubu hangisidir?',
                'status' => 1,
            ],
            [
                'sort_order' => '70',
                'survey_id' => '2',
                'question' => 'Klinikte takip etmeği en sevdiğiniz yaş grubu hangisidir?',
                'status' => 1,
            ],
            [
                'sort_order' => '80',
                'survey_id' => '2',
                'question' => 'Güncel bilgileri nasıl takip edersiniz?',
                'status' => 1,
            ],
            [
                'sort_order' => '90',
                'survey_id' => '2',
                'question' => 'Kemoterapi şemalarınızı nerden aldınız?',
                'status' => 1,
            ],
            [
                'sort_order' => '100',
                'survey_id' => '2',
                'question' => 'Kemoterapi ünitesine ortalama günde kaç kez çağrılıyorsunuz?',
                'status' => 1,
            ],
        ]);
    }
}
