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
                'question' => 'Branşınız nedir',
                'status' => 1,
            ],
            [
                'sort_order' => '20',
                'survey_id' => '1',
                'question' => 'Onkoloji alanında pozisyonunuz/rolünüz nedir?',
                'status' => 1,
            ],
            [
                'sort_order' => '30',
                'survey_id' => '1',
                'question' => 'Çalıştığınız kurumu en iyi hangisi tanımlar? (Yarı zamanlı çalıştığınız farklı kurumlar var ise birden fazla seçenek işaretleyebilirsiniz)',
                'status' => 1,
            ],
            [
                'sort_order' => '40',
                'survey_id' => '1',
                'question' => 'Çalıştığınız kurumdaki medikal onkolog sayısı kaçtır? (Fellow hekim sayısı dahil edilmemelidir)',
                'status' => 1,
            ],
            [
                'sort_order' => '50',
                'survey_id' => '1',
                'question' => 'Haftalık mesai süreniz kaç saattir?',
                'status' => 1,
            ],
            [
                'sort_order' => '60',
                'survey_id' => '1',
                'question' => 'Yıllık bazda, mesai saatlerinizin ne kadarını sağlık hizmeti vermek için ne kadarını bilimsel aktiviteler için (toplantı, ders, yayın vb) ayırıyorsunuz?',
                'status' => 1,
            ],
            [
                'sort_order' => '70',
                'survey_id' => '1',
                'question' => 'Bir önceki ay elde ettiğiniz net kazancınızı Türk Lirası biriminde belirtiniz.',
                'status' => 1,
            ],
            [
                'sort_order' => '80',
                'survey_id' => '1',
                'question' => 'Size müracat eden, ayaktan (muayenehane veya hastane polikliniği) yeni hasta sayısını belirtiniz.(Yeni hasta; son 3 yıl içerisinde herhangi bir kuruluşta aynı yandal branşından profesyonel sağlık hizmeti almamış olan hasta olarak tanımlanır)',
                'status' => 1,
            ],
            [
                'sort_order' => '90',
                'survey_id' => '1',
                'question' => 'Size müracat eden, yataklı serviste değerlendirdiğiniz yeni hasta sayısını belirtiniz.',
                'status' => 1,
            ],
            [
                'sort_order' => '100',
                'survey_id' => '1',
                'question' => 'Değerlendirdiğiniz konsültasyon sayısını belirtiniz. (Yataklı hizmetler ve poliklinik toplamı olarak)',
                'status' => 1,
            ],
            [
                'sort_order' => '110',
                'survey_id' => '1',
                'question' => 'Yeni hasta tanımına uymayan, yüzyüze görüşme ile değerlendirdiğiniz ve yönetim sürecine katkıda bulunduğunuz ayaktan (muayenehane veya hastane polikliniği) hasta sayısını belirtiniz.',
                'status' => 1,
            ],
            [
                'sort_order' => '120',
                'survey_id' => '1',
                'question' => 'Yeni hasta tanımına uymayan, yüzyüze görüşme ile değerlendirdiğiniz ve yönetim sürecine katkıda bulunduğunuz yatan hasta sayısını belirtiniz. ',
                'status' => 1,
            ],
            [
                'sort_order' => '130',
                'survey_id' => '1',
                'question' => 'Sizin onayınız ve sorumluluğunuz ile uygulanan infüzyonel kemoterapi/özellikli kanser tedavisi sayısını belirtiniz',
                'status' => 1,
            ],
            [
                'sort_order' => '140',
                'survey_id' => '1',
                'question' => 'Sizin onayınız ve sorumluluğunuz ile uygulanan kemoterapi ve özellikli kanser tedavisi dışında, diğer parenteral tedavilerin sayısını belirtiniz.',
                'status' => 1,
            ],
            [
                'sort_order' => '10',
                'survey_id' => '2',
                'question' => 'Yaşınız?',
                'status' => 1,
            ],
            [
                'sort_order' => '20',
                'survey_id' => '2',
                'question' => 'Ünvanınız nedir?',
                'status' => 1,
            ],
            [
                'sort_order' => '30',
                'survey_id' => '2',
                'question' => 'Onkolojide görev süreniz?',
                'status' => 1,
            ],
            [
                'sort_order' => '40',
                'survey_id' => '2',
                'question' => 'Çalıştığınız kurumunuz?',
                'status' => 1,
            ],
            [
                'sort_order' => '50',
                'survey_id' => '2',
                'question' => 'Pratiğinizde ayda kaç DCIS hastası değerlendiriyorsunuz? ',
                'status' => 1,
            ],
            [
                'sort_order' => '60',
                'survey_id' => '2',
                'question' => 'DCIS  yönetimi konusunda kendinizi ne kadar yetkin görüyorsunuz?',
                'status' => 1,
            ],
            [
                'sort_order' => '70',
                'survey_id' => '2',
                'question' => 'DCIS adjuvant tedavi kararı alırken hangi histopatolojik parametreleri dikkate alıyorsunuz?',
                'status' => 1,
            ],
            [
                'sort_order' => '80',
                'survey_id' => '2',
                'question' => 'Hormon reseptör pozitif  postmenopozal  DCIS vakalarında, kontraendike bir durum yoksa,  öncelikli adjuvant tedavi seçeneğiniz ne oluyor?',
                'status' => 1,
            ],
            [
                'sort_order' => '90',
                'survey_id' => '2',
                'question' => 'ER veya PR negatif DCIS’da  adjuvant tedavi seçeneğiniz ne oluyor?',
                'status' => 1,
            ],
            [
                'sort_order' => '100',
                'survey_id' => '2',
                'question' => 'ER/ PR negatif DCIS vakalarında hasta izlemini nasıl yapıyorsunuz?',
                'status' => 1,
            ],
            [
                'sort_order' => '10',
                'survey_id' => '3',
                'question' => 'Çalıştığınız kurum?',
                'status' => 1,
            ],
            [
                'sort_order' => '20',
                'survey_id' => '3',
                'question' => 'Medikal onkolojide ne kadar süredir çalışmaktasınız?',
                'status' => 1,
            ],
            [
                'sort_order' => '30',
                'survey_id' => '3',
                'question' => 'Kurumunuzda multidisipliner tedavi  yaklaşımı (tm konsey) yapılıyor mu?',
                'status' => 1,
            ],
            [
                'sort_order' => '40',
                'survey_id' => '3',
                'question' => 'Yapılıyorsa hangi konseyler yapılmakta?',
                'status' => 1,
            ],
            [
                'sort_order' => '50',
                'survey_id' => '3',
                'question' => 'Yapılıyorsa düzenli yapılıyor mu?',
                'status' => 1,
            ],
            [
                'sort_order' => '60',
                'survey_id' => '3',
                'question' => 'Yapılan konsey, tedavi kararınızı değiştiriyor mu?',
                'status' => 1,
            ],
            [
                'sort_order' => '70',
                'survey_id' => '3',
                'question' => 'Konsey kararları ile kliniğinizin kararı çeliştiğinde hangi kararı uygulamaktasınız?',
                'status' => 1,
            ],
            [
                'sort_order' => '80',
                'survey_id' => '3',
                'question' => 'Konseylerinizde genetik kliniği rutin olarak katılmakta mı?',
                'status' => 1,
            ],
            [
                'sort_order' => '90',
                'survey_id' => '3',
                'question' => 'Genetik kliniği katılıyorsa, nerden katılmakta?',
                'status' => 1,
            ],
            [
                'sort_order' => '100',
                'survey_id' => '3',
                'question' => 'Konsey kararı ile tedavi ettiğiniz hastalar, tedavi sonrası tekrar konseyde değerlendiriliyor mu?',
                'status' => 1,
            ],
        ]);
    }
}
