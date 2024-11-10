# FeedProduct

FeedProduct, ürün verilerinin JSON ve XML formatlarında çıktısını veren bir ürün besleme API’sidir. Bu proje, ürün verilerini farklı formatlarda dışa aktarmak isteyen geliştiriciler için basit ve anlaşılır bir çözüm sunar.

## Özellikler

- JSON ve XML formatlarında çıktı sağlama
- Kolay Docker kurulumu ile hızlı entegrasyon
- Basit, RESTful API endpoint’i

## Gereksinimler

- Docker ve Docker Compose kurulu olmalıdır.
- Proje dizininde terminal kullanarak kurulum yapabilirsiniz.

## Kurulum

1. Repoyu indirdikten sonra ana dizine geçiş yapın:
   ```bash
   cd FeedProduct
2. md/docker klasörüne girin:
   ```bash
   cd md/docker
3. Docker Compose ile uygulamayı başlatmak için aşağıdaki komutu çalıştırın:
    ```bash
   docker-compose up -d --build

Kurulum işlemi tamamlandığında, uygulama aşağıdaki URL üzerinden erişilebilir olacaktır:

URL: http://localhost:8080
Kullanım
Ana dizindeki index.php dosyası, ürün verilerini JSON veya XML formatlarında görüntülemek için iki farklı link sunmaktadır:

JSON: http://localhost:8080/?format=JSON
XML: http://localhost:8080/?format=XML
Herhangi bir tarayıcı veya API istemcisi (Postman gibi) üzerinden bu URL'lere ulaşarak çıktıları görüntüleyebilirsiniz.

Proje Yapısı
md/docker/: Docker dosyalarını içerir.
src/: API işleyişine yardımcı olan ana kod dosyalarını içerir.
ConverterFactory/: Veri dönüştürme işlemlerini yapan sınıfları içerir.
Geliştirme
Projeyi geliştirmek veya üzerinde değişiklik yapmak istiyorsanız, src klasöründe gerekli düzenlemeleri yapabilirsiniz. Docker üzerinde çalıştığınız için her kod değişikliğinde Docker konteynerinizi yeniden başlatmanız gerekebilir.
