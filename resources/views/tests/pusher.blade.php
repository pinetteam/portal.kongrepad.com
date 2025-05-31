<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pusher Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Pusher Test</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <button id="testButton" class="btn btn-success">Test Event Gönder</button>
                        </div>
                        
                        <div class="mb-3">
                            <h5>Durum:</h5>
                            <div id="connectionStatus" class="alert alert-info">Bağlanıyor...</div>
                        </div>
                        
                        <div class="mb-3">
                            <h5>Pusher Yapılandırması:</h5>
                            <pre id="configInfo" class="bg-light p-3">Kontrol ediliyor...</pre>
                        </div>
                        
                        <div class="mb-3">
                            <h5>Alınan Eventler:</h5>
                            <div id="events" class="bg-light p-3" style="max-height: 300px; overflow-y: auto;">
                                <div class="text-muted">Henüz event alınmadı...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        $(document).ready(function() {
            // Pusher konfigürasyonu kontrol ediliyor
            $.get('/api/pusher-config', function(data) {
                if (data.success) {
                    $('#configInfo').html(
                        'APP_ID: ' + (data.config.app_id ? '✅ Var' : '❌ Yok') + '\n' +
                        'APP_KEY: ' + (data.config.key ? '✅ Var' : '❌ Yok') + '\n' +
                        'APP_SECRET: ' + (data.config.secret ? '✅ Var (gizli)' : '❌ Yok') + '\n' +
                        'APP_CLUSTER: ' + (data.config.options && data.config.options.cluster ? '✅ Var (' + data.config.options.cluster + ')' : '❌ Yok')
                    );
                    
                    // Pusher bağlantısını başlat
                    initPusher(data.config.key, data.config.options.cluster);
                } else {
                    $('#configInfo').html('❌ Yapılandırma bilgileri alınamadı: ' + data.message);
                    $('#connectionStatus').removeClass('alert-info').addClass('alert-danger').text('Yapılandırma hatası!');
                }
            }).fail(function(xhr) {
                $('#configInfo').html('❌ Yapılandırma bilgileri alınamadı: Sunucu hatası');
                $('#connectionStatus').removeClass('alert-info').addClass('alert-danger').text('Sunucu hatası!');
            });
            
            // Test butonuna tıklandığında
            $('#testButton').click(function() {
                $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Gönderiliyor...');
                
                $.post('/api/send-test-event', function(data) {
                    if (data.success) {
                        addEventLog('✅ Test eventi gönderildi: ' + data.message);
                    } else {
                        addEventLog('❌ Test eventi gönderilemedi: ' + data.message);
                    }
                    $('#testButton').prop('disabled', false).text('Test Event Gönder');
                }).fail(function(xhr) {
                    addEventLog('❌ Test eventi gönderilemedi: Sunucu hatası');
                    $('#testButton').prop('disabled', false).text('Test Event Gönder');
                });
            });
            
            function initPusher(key, cluster) {
                try {
                    // Pusher nesnesini başlat
                    const pusher = new Pusher(key, {
                        cluster: cluster,
                        forceTLS: true
                    });
                    
                    // Bağlantı durumlarını dinle
                    pusher.connection.bind('connecting', function() {
                        $('#connectionStatus').removeClass('alert-success alert-danger').addClass('alert-info').text('Bağlanıyor...');
                    });
                    
                    pusher.connection.bind('connected', function() {
                        $('#connectionStatus').removeClass('alert-info alert-danger').addClass('alert-success').text('Bağlandı! Pusher çalışıyor.');
                        addEventLog('🟢 Pusher bağlantısı kuruldu.');
                    });
                    
                    pusher.connection.bind('failed', function() {
                        $('#connectionStatus').removeClass('alert-info alert-success').addClass('alert-danger').text('Bağlantı başarısız!');
                        addEventLog('🔴 Pusher bağlantısı başarısız oldu.');
                    });
                    
                    pusher.connection.bind('disconnected', function() {
                        $('#connectionStatus').removeClass('alert-info alert-success').addClass('alert-danger').text('Bağlantı kesildi!');
                        addEventLog('🟠 Pusher bağlantısı kesildi.');
                    });
                    
                    pusher.connection.bind('error', function(err) {
                        $('#connectionStatus').removeClass('alert-info alert-success').addClass('alert-danger').text('Bağlantı hatası!');
                        addEventLog('🔴 Pusher bağlantı hatası: ' + JSON.stringify(err));
                    });
                    
                    // Test kanalını dinle
                    const channel = pusher.subscribe('pusher-test-channel');
                    
                    channel.bind('pusher-test-event', function(data) {
                        addEventLog('📥 Test event alındı: ' + JSON.stringify(data));
                    });
                    
                    channel.bind('pusher:subscription_succeeded', function() {
                        addEventLog('🟢 Kanal aboneliği başarılı: pusher-test-channel');
                    });
                    
                    channel.bind('pusher:subscription_error', function(status) {
                        addEventLog('🔴 Kanal aboneliği başarısız: ' + status);
                    });
                    
                } catch (error) {
                    $('#connectionStatus').removeClass('alert-info alert-success').addClass('alert-danger').text('Pusher başlatılamadı!');
                    addEventLog('🔴 Pusher başlatma hatası: ' + error.message);
                    console.error('Pusher initialization error:', error);
                }
            }
            
            function addEventLog(message) {
                const time = new Date().toLocaleTimeString();
                $('#events').prepend(`<div class="mb-1">[${time}] ${message}</div>`);
                
                // İlk event alındığında varsayılan mesajı kaldır
                $('#events .text-muted').remove();
            }
        });
    </script>
</body>
</html> 