# FontAwesome Pro Token

Bu proje FontAwesome Pro kullanmaktadır. 

## Token Bilgileri

**FontAwesome Pro Token:** `6F973B60-7D66-4F90-A064-31147F13EA86`

## Kurulum Talimatları

### Yeni bir bilgisayarda kurulum için:

1. **NPM Registry ayarlama:**
```bash
echo "//npm.fontawesome.com/:_authToken=6F973B60-7D66-4F90-A064-31147F13EA86" >> .npmrc
echo "@fortawesome:registry=https://npm.fontawesome.com/" >> .npmrc
```

2. **Paket kurulumu:**
```bash
npm install @fortawesome/fontawesome-pro @fortawesome/pro-solid-svg-icons @fortawesome/pro-regular-svg-icons @fortawesome/pro-light-svg-icons @fortawesome/pro-duotone-svg-icons @fortawesome/pro-thin-svg-icons
```

## Kullanım

### JavaScript'te:
```javascript
import { library, dom } from '@fortawesome/fontawesome-pro';
import { faUsers } from '@fortawesome/pro-solid-svg-icons';

library.add(faUsers);
dom.watch();
```

### HTML'de:
```html
<!-- Solid Icons -->
<i class="fas fa-users"></i>

<!-- Regular Icons -->
<i class="far fa-heart"></i>

<!-- Light Icons -->
<i class="fal fa-star"></i>

<!-- Duotone Icons -->
<i class="fad fa-calendar pro-icon-duotone"></i>

<!-- Thin Icons -->
<i class="fat fa-code pro-icon-thin"></i>
```

## Özel Sınıflar

- `.pro-icon-duotone` - Duotone iconlar için renk ayarları
- `.icon-gradient` - Gradient efekti
- `.icon-shadow` - Gölge efekti
- `.icon-bounce` - Animasyon efekti
- `data-icon-animate="spin"` - Hover animasyonu

## Performans

FontAwesome Pro SVG iconları kullanılarak daha iyi performans sağlanmaktadır:
- Daha küçük dosya boyutu
- Tree-shaking desteği
- Sadece kullanılan iconlar yüklenir
- Daha hızlı render 