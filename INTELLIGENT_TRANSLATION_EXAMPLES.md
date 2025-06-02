# Akıllı Çeviri Sistemi Örnekleri

Bu sistem, anahtar isimlerini akıllıca anlamlı çevirilere dönüştürür.

## 🤖 Nasıl Çalışır?

### 1. **Anahtar Tanıma**
Sistem şu tür anahtarları tanır:
- `virtual-stands-management-subtitle`
- `participant-logs-description`
- `there-is-not-active-keypad`
- `meeting-hall-management`

### 2. **Anlamlı Metne Dönüştürme**
```
virtual-stands-management-subtitle → Virtual Stands Management Subtitle
participant-logs-description → Participant Logs Description
there-is-not-active-keypad → There is no active keypad
```

### 3. **Akıllı Çeviri**
```
Virtual Stands Management Subtitle → Sanal Standlar Yönetimi Alt Başlık
Participant Logs Description → Katılımcı Kayıtlar Açıklama
There is no active keypad → Burada hiç aktif tuş takımı değil
```

## 📋 Çeviri Örnekleri

### Özel Anahtar Çevirileri:
| Anahtar | İngilizce | Türkçe |
|---------|-----------|--------|
| `virtual-stands-management-subtitle` | Virtual Stands Management Subtitle | Sanal Standlar Yönetimi Alt Başlık |
| `participant-logs-description` | Participant Logs Description | Katılımcı Kayıtlar Açıklama |
| `meeting-hall-management` | Meeting Hall Management | Toplantı Salon Yönetimi |
| `user-management-system` | User Management System | Kullanıcı Yönetimi Sistem |
| `document-sharing-platform` | Document Sharing Platform | Belge Paylaşım Platform |
| `live-streaming-service` | Live Streaming Service | Canlı Yayın Hizmet |
| `poll-voting-system` | Poll Voting System | Anket Oylama Sistem |
| `qa-session-management` | Q&A Session Management | Soru Cevap Oturum Yönetimi |

### Genel Dönüşüm Kuralları:
| Kural | Örnek |
|-------|-------|
| Tire/Alt çizgi → Boşluk | `user_management` → `User Management` |
| İlk harfler büyük | `api integration` → `API Integration` |
| Kısaltma düzeltme | `qa system` → `Q&A System` |

### Kelime Kelime Çeviri:
| İngilizce Kelime | Türkçe Karşılık |
|------------------|-----------------|
| virtual | sanal |
| stands | standlar |
| management | yönetimi |
| participant | katılımcı |
| logs | kayıtlar |
| description | açıklama |
| meeting | toplantı |
| hall | salon |
| user | kullanıcı |
| system | sistem |
| document | belge |
| sharing | paylaşım |
| platform | platform |
| live | canlı |
| streaming | yayın |
| service | hizmet |

## 🔄 Çeviri Sırası

1. **Akıllı Anahtar Çevirisi** (Öncelik 1)
   - Özel anahtar tanıma
   - Anlamlı metne dönüştürme
   - Kelime kelime çeviri

2. **MyMemory API** (Öncelik 2)
   - Ücretsiz çeviri servisi
   - Günde 10,000 karakter

3. **Google Translate API** (Öncelik 3)
   - Ücretli ama kaliteli
   - API key gerekli

4. **Fallback Çeviri** (Öncelik 4)
   - Basit sözlük çevirisi
   - Her zaman çalışır

## 🎯 Avantajlar

### ✅ Ücretsiz
- Google Translate API gerekmez
- MyMemory API ücretsiz limit
- Fallback sistem her zaman çalışır

### ✅ Akıllı
- Anahtar isimlerini anlar
- Bağlam farkındalığı
- Özel terimler için optimize

### ✅ Genişletilebilir
- Yeni kelimeler eklenebilir
- Özel kurallar tanımlanabilir
- Farklı diller desteklenebilir

### ✅ Güvenilir
- Çoklu fallback sistemi
- Hata toleransı
- Her zaman bir sonuç döner

## 🔧 Özelleştirme

### Yeni Kelime Ekleme:
`LanguageController.php` dosyasında `$wordTranslations` dizisine yeni kelimeler ekleyebilirsiniz:

```php
'new-word' => 'yeni-kelime',
'custom-term' => 'özel-terim',
```

### Özel Anahtar Ekleme:
`$specialKeys` dizisine özel anahtarlar ekleyebilirsiniz:

```php
'your-custom-key' => 'Your Custom Translation',
```

### Yeni Dil Desteği:
`wordByWordTranslation` metodunu genişleterek yeni diller ekleyebilirsiniz.

## 🚀 Kullanım

1. Dil yönetimi sayfasına gidin
2. "Auto Translate" butonuna tıklayın
3. Sistem otomatik olarak:
   - Anahtarları tanır
   - Anlamlı metne çevirir
   - Türkçe karşılığını bulur
   - Dosyaya kaydeder

Bu sistem sayesinde `virtual-stands-management-subtitle` gibi karmaşık anahtarlar bile doğru şekilde çevrilir! 