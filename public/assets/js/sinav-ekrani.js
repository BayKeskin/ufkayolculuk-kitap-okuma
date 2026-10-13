/**
 * Ufka Yolculuk - Müstakil Online Sınav Sistemi Motoru (sinav-ekrani.js)
 * 3 Aşamalı Mimari: Sınav Öncesi Giriş/Kurallar -> Odak Sınav Motoru -> Detaylı Karne & Çözüm İnceleme
 */

// ==========================================================================
// 1. Zengin Sınav ve Soru Veritabanı (Mock Sınav Havuzu)
// ==========================================================================
const EXAM_DATABASE = {
  'genel': {
    title: 'Genel Deneme Sınavı',
    sub: 'Ufka Yolculuk 2025 - Tüm Düzeyler',
    category: 'Genel Sınav',
    badgeClass: 'bg-success-subtle text-success',
    durationMinutes: 15,
    bookImage: 'assets/images/books/book-genel.svg',
    rules: [
      'Bu sınavda toplam 10 soru yer almaktadır ve sınav süresi 15 dakikadır.',
      'Her soru 10 puan değerindedir. 4 yanlış cevap 1 doğru cevabı götürmektedir.',
      'Soru navigasyon paletini kullanarak dilediğiniz soruya anında geçiş yapabilirsiniz.',
      'Emin olmadığınız soruları "Bayrak / Sonra Bak" butonuyla işaretleyip daha sonra gözden geçirebilirsiniz.',
      'Süre bittiğinde sınav otomatik olarak tamamlanacak ve detaylı analiz raporunuz oluşturulacaktır.'
    ],
    questions: [
      {
        q: 'Tevhid inancının İslam dinindeki en temel ve kapsayıcı anlamı aşağıdakilerden hangisidir?',
        options: [
          'A) Allah’ın birliğini, eşi, benzeri ve ortağı olmadığını kalben kabul edip tasdik etmek',
          'B) Yalnızca zor zamanlarda ve sıkıntılarda ibadet etmek',
          'C) Eski kavimlerin kıssalarını ve tarihlerini ezberlemek',
          'D) Yalnızca dünya hayatı için ticaret ve dünyalık peşinde olmak',
          'E) İbadetleri insanların beğenisi ve gösteriş için yerine getirmek'
        ],
        correct: 0,
        topic: 'İnanç ve İtikat',
        solution: 'Tevhid inancı, Yüce Allah\'ın zatında, sıfatlarında ve fiillerinde tek olduğunu, hiçbir eşi ve benzeri bulunmadığını kabul etmektir (İhlas Suresi).'
      },
      {
        q: 'Peygamber Efendimiz (s.a.v.) Medine\'ye hicret ettikten sonra Mekkeli Muhacirler ile Medineli Ensar arasında tesis ettiği tarihi kardeşlik anlaşmasına ne ad verilir?',
        options: [
          'A) Rıdvan Biatı',
          'B) Muâhât (Kardeşlik Sözleşmesi)',
          'C) Hudeybiye Barış Antlaşması',
          'D) Akabe Biatları',
          'E) Hılfu\'l-Fudûl (Erdemliler İttifakı)'
        ],
        correct: 1,
        topic: 'Siyer-i Nebi',
        solution: 'Peygamber Efendimiz (s.a.v.), Medine\'de toplumsal dayanışmayı kurmak için her Mekkeli Muhacir aileyi bir Medineli Ensar aile ile kardeş ilan etmiştir (Muâhât).'
      },
      {
        q: 'Kur\'an-ı Kerim\'de "İyiliği emretmek ve kötülükten sakındırmak" ilkesi hangi kavram ile ifade edilir?',
        options: [
          'A) Emr-i bi\'l-maruf ve nehy-i ani\'l-münker',
          'B) Sıla-i rahim',
          'C) Hüsn-ü zan',
          'D) Tevekkül-i mutlak',
          'E) İsar ve cömertlik'
        ],
        correct: 0,
        topic: 'Ahlak ve Değerler',
        solution: 'İslam ahlakının temel dinamiklerinden olan "Emr-i bi\'l-maruf nehy-i ani\'l-münker", toplumu iyiliğe yönlendirme ve kötülükten alıkoyma vazifesidir.'
      },
      {
        q: 'Günde 5 vakit olarak farz kılınan namaz ibadeti İslam\'ın hangi temel şartı arasında yer alır ve hangi gecede farz kılınmıştır?',
        options: [
          'A) İslam\'ın 1. şartı - Kadir Gecesi',
          'B) İslam\'ın 2. şartı - Miraç Gecesi',
          'C) İslam\'ın 3. şartı - Berat Gecesi',
          'D) İslam\'ın 4. şartı - Regaip Gecesi',
          'E) İslam\'ın 5. şartı - Mevlid Gecesi'
        ],
        correct: 1,
        topic: 'İbadet Esasları',
        solution: 'Beş vakit namaz, İslam\'ın 5 temel şartından ikincisidir ve Peygamberimiz\'in (s.a.v.) semaya yükseldiği Miraç hadisesinde farz kılınmıştır.'
      },
      {
        q: 'Kendisine "Halilullah" (Allah\'ın Dostu) lakabı verilen ve Kâbe\'yi oğlu Hz. İsmail ile birlikte inşa eden peygamber kimdir?',
        options: [
          'A) Hz. Nuh (a.s.)',
          'B) Hz. Musa (a.s.)',
          'C) Hz. İbrahim (a.s.)',
          'D) Hz. İsa (a.s.)',
          'E) Hz. Davud (a.s.)'
        ],
        correct: 2,
        topic: 'Peygamberler Tarihi',
        solution: 'Hz. İbrahim (a.s.), tevhid mücadelesinin önderi olup "Halilullah" unvanına sahiptir ve Kâbe-i Muazzama\'yı oğlu Hz. İsmail ile yeniden inşa etmiştir.'
      },
      {
        q: 'Bir Müslümanın başka bir Müslüman kardeşi hakkında hüsn-ü zan beslemesi ne anlama gelir?',
        options: [
          'A) Sürekli kusur aramak ve dedikodu yapmak',
          'B) İyi niyetli, olumlu ve güzel düşünce beslemek',
          'C) İnsanlardan uzak durup kimseyle konuşmamak',
          'D) Herkesi şüpheli görmek',
          'E) Emanete hıyanet etmek'
        ],
        correct: 1,
        topic: 'Ahlak ve Değerler',
        solution: 'Hüsn-ü zan; insanlar ve özellikle din kardeşleri hakkında daima iyi, hayırlı ve müspet kanaat beslemek demektir; su-i zannın zıddıdır.'
      },
      {
        q: 'İslam medeniyetinde ilk düzenli eğitim kurumu kabul edilen ve Mescid-i Nebevi\'nin bitişiğinde yer alan ilim meclisine ne ad verilir?',
        options: [
          'A) Beytü\'l-Hikme',
          'B) Daru\'l-Erkam',
          'C) Suffe Mektebi',
          'D) Nizamiye Medresesi',
          'E) Daru\'l-Hikme'
        ],
        correct: 2,
        topic: 'Genel Kültür ve Tarih',
        solution: 'Suffe, Mescid-i Nebevi yanında ilim tahsil eden ve Ashab-ı Suffe olarak anılan talebelerin kaldığı ilk İslam akademisidir.'
      },
      {
        q: 'Kur\'an-ı Kerim\'in kalbi olarak nitelendirilen ve toplam 83 ayetten oluşan mübarek sure hangisidir?',
        options: [
          'A) Mülk Suresi',
          'B) Rahman Suresi',
          'C) Yasin Suresi',
          'D) Fatiha Suresi',
          'E) İhlas Suresi'
        ],
        correct: 2,
        topic: 'Kur\'an-ı Kerim ve Meal',
        solution: 'Hadis-i şeriflerde "Her şeyin bir kalbi vardır, Kur\'an\'ın kalbi de Yasin\'dir" buyurulmuştur.'
      },
      {
        q: 'Peygamber Efendimiz\'in (s.a.v.) "Ben güzel ahlakı tamamlamak için gönderildim" hadisi, İslam dininin hangi boyutuna vurgu yapmaktadır?',
        options: [
          'A) Ahlaki olgunluk ve erdemli insan modeline',
          'B) Yalnızca ticari kurallara',
          'C) Savaş stratejilerine',
          'D) Dil bilgisi kurallarına',
          'E) Coğrafi keşiflere'
        ],
        correct: 0,
        topic: 'Ahlak ve Değerler',
        solution: 'İslam dini yalnızca inanç ve ritüellerden ibaret olmayıp, bireyin dürüst, adil, merhametli ve güzel ahlaklı olmasını hedefler.'
      },
      {
        q: 'İslam dini açısından "Kul Hakkı" ile ilgili aşağıdaki yargılardan hangisi doğrudur?',
        options: [
          'A) Kul hakkı sahibi hakkını helal etmedikçe Allah tarafından bağışlanmaz',
          'B) Kul hakkı sadece zenginleri ilgilendirir',
          'C) Başkasının gıybetini yapmak kul hakkına girmez',
          'D) Yalnızca hırsızlık kul hakkı sayılır',
          'E) Kul hakkının ahirette herhangi bir karşılığı yoktur'
        ],
        correct: 0,
        topic: 'İnanç ve İtikat',
        solution: 'İslam\'da kul hakkı en hassas konulardan biridir. Hak sahibi razı olup hakkını helal etmedikçe tövbe ile affolunmaz.'
      }
    ]
  },
  'kuslarin-cagrisi': {
    title: 'Kuşların Çağrısı Deneme Sınavı',
    sub: 'Ufka Yolculuk 12 - İlkokul Düzeyi',
    category: 'İlkokul',
    badgeClass: 'bg-purple-subtle text-purple',
    durationMinutes: 12,
    bookImage: 'assets/images/books/book-kuslarin-cagrisi.svg',
    rules: [
      'Bu sınav ilkokul düzeyi "Kuşların Çağrısı" kitabı kaynak alınarak hazırlanmıştır.',
      'Sınavda 8 soru bulunmakta ve süreniz 12 dakikadır.',
      'Doğru bildiğiniz şıkkı işaretleyip "Sonraki" butonuyla ilerleyebilirsiniz.',
      'Soruları dikkatle okuyunuz ve süreyi verimli kullanınız.'
    ],
    questions: [
      {
        q: 'Kuşların Çağrısı kitabında kuşların bilge önderi olarak bilinen ve onlara yol gösteren kuş hangisidir?',
        options: ['A) Bülbül', 'B) Hüdhüd Kuşu', 'C) Kartal', 'D) Papağan', 'E) Güvercin'],
        correct: 1,
        topic: 'Kuşların Çağrısı',
        solution: 'Hüdhüd kuşu, hikayede bilgeliği ve kılavuzluğu temsil eden rehber kuştur.'
      },
      {
        q: 'Kitapta kuşların çıktığı zorlu yolculuğun nihai amacı nedir?',
        options: [
          'A) Yeni bir orman bulmak',
          'B) Padişahları olan Simurg\'a ulaşmak',
          'C) Sıcak ülkelere göç etmek',
          'D) Yuvalarını korumak',
          'E) Yiyecek aramak'
        ],
        correct: 1,
        topic: 'Kuşların Çağrısı',
        solution: 'Kuşlar, kendilerine hakiki bir rehber ve padişah bulmak için Kaf Dağı\'ndaki Simurg\'a doğru yola çıkarlar.'
      },
      {
        q: 'Kuşların yolculuk sırasında aştığı vadilerden "Aşk Vadisi" neyi simgelemektedir?',
        options: [
          'A) Sevgi ve fedakarlığı',
          'B) Tembelliği ve uyumayı',
          'C) Korkuyu ve kaçışı',
          'D) Hırsı ve açgözlülüğü',
          'E) Şüpheyi'
        ],
        correct: 0,
        topic: 'Kuşların Çağrısı',
        solution: 'Aşk vadisi, hedefe ulaşmak için çekilen zorluklara katlanmayı ve kalpteki halis sevgiyi temsil eder.'
      },
      {
        q: 'Peygamber Efendimiz (s.a.v.) çocuklara ve hayvanlara karşı nasıl davranmamızı öğütlemiştir?',
        options: [
          'A) Sert ve kaba davranmayı',
          'B) Sevgi, merhamet ve şefkat göstermeyi',
          'C) Onları görmezden gelmeyi',
          'D) Sürekli azarlamayı',
          'E) Yalnız bırakmayı'
        ],
        correct: 1,
        topic: 'Ahlak ve Değerler',
        solution: 'Peygamberimiz (s.a.v.) "Merhamet etmeyene merhamet olunmaz" buyurarak herkese şefkatli olmayı emretmiştir.'
      },
      {
        q: 'İslam dininde temizliğin önemi hakkında Peygamberimiz ne buyurmuştur?',
        options: [
          'A) Temizlik imanın yarısıdır',
          'B) Temizlik sadece bayramlarda gereklidir',
          'C) Temizlik sadece el yıkamaktır',
          'D) Temizlik önemsizdir',
          'E) Temizlik yalnızca ev içinde yapılır'
        ],
        correct: 0,
        topic: 'İbadet Esasları',
        solution: 'Peygamber Efendimiz (s.a.v.) "Temizlik imanın yarısıdır" buyurarak maddi ve manevi temizliğin temel olduğunu vurgulamıştır.'
      }
    ]
  },
  'tevhid-muhafizlari': {
    title: 'Tevhid Muhafızları Deneme Sınavı',
    sub: 'Ufka Yolculuk 12 - Ortaokul Düzeyi',
    category: 'Ortaokul',
    badgeClass: 'bg-primary-subtle text-primary',
    durationMinutes: 15,
    bookImage: 'assets/images/books/book-tevhid-muhafizlari.svg',
    rules: [
      'Bu sınav ortaokul düzeyi "Tevhid Muhafızları" kitabı odaklıdır.',
      'Sınavda 8 soru bulunmakta ve süreniz 15 dakikadır.',
      'Soru paletinden işaretli sorularınızı tekrar kontrol edebilirsiniz.'
    ],
    questions: [
      {
        q: 'Tevhid Muhafızları eserinde vurgulanan "Lâ ilâhe illallâh" kelime-i tevhidinin ilk kısmı olan "Lâ ilâhe" neyi ifade eder?',
        options: [
          'A) Bütün sahte ilahları, putları ve batıl otoriteleri kesin olarak reddetmeyi',
          'B) Her şeye boyun eğmeyi',
          'C) Dünyadan tamamen el etek çekmeyi',
          'D) Kararsız kalmayı',
          'E) Sadece bazı peygamberlere inanmayı'
        ],
        correct: 0,
        topic: 'İnanç ve İtikat',
        solution: '"Lâ ilâhe" (Hiçbir ilah yoktur) diyerek önce tüm sahte ilahlar ve batıl inançlar nefiy (red) edilir, ardından "İllallâh" ile yalnızca Allah kabul edilir.'
      },
      {
        q: 'İslam inancında Allah\'ın her şeyi hakkıyla görmesi anlamına gelen subûtî sıfatı hangisidir?',
        options: ['A) Semi (İşitmek)', 'B) Basar (Görmek)', 'C) İlim (Bilmek)', 'D) Kudret (Güç)', 'E) Kelam (Konuşmak)'],
        correct: 1,
        topic: 'İnanç ve İtikat',
        solution: 'Basar sıfatı, Yüce Allah\'ın aydınlıkta ve karanlıkta, gizli veya açık her şeyi eksiksiz ve vasıtasız olarak görmesidir.'
      },
      {
        q: 'Peygamber Efendimiz\'in (s.a.v.) peygamberlik verilmeden önce de toplumda "el-Emin" (Güvenilir İnsan) olarak tanınması hangi ahlaki erdemin göstergesidir?',
        options: [
          'A) Sıdk (Doğruluk) ve Emanet (Güvenilirlik)',
          'B) Cesaret ve güç',
          'C) Zenginlik ve makam',
          'D) Soy üstünlüğü',
          'E) Hitabet sanatı'
        ],
        correct: 0,
        topic: 'Siyer-i Nebi',
        solution: 'Peygamberimiz çocukluğundan itibaren yalan söylememiş, emanete hıyanet etmemiş ve doğruluğuyla herkesin güvenini kazanmıştır.'
      },
      {
        q: 'Kibir ve gururun zıddı olan, kişinin haddini bilip alçakgönüllü olması anlamına gelen güzel ahlak kavramı hangisidir?',
        options: ['A) Tevazu', 'B) Haset', 'C) Cimrilik', 'D) Riya', 'E) Gıybet'],
        correct: 0,
        topic: 'Ahlak ve Değerler',
        solution: 'Tevazu; kişinin kendini başkalarından üstün görmemesi, alçakgönüllü ve samimi olmasıdır.'
      },
      {
        q: 'Oruç ibadetinin farz kılındığı ve Kur\'an-ı Kerim\'in indirilmeye başlandığı mübarek ay hangisidir?',
        options: ['A) Şaban Ayı', 'B) Ramazan Ayı', 'C) Recep Ayı', 'D) Muharrem Ayı', 'E) Zilhicce Ayı'],
        correct: 1,
        topic: 'İbadet Esasları',
        solution: 'Bakara Suresi 185. ayette "Ramazan ayı, insanlara yol gösterici olan Kur\'an\'ın indirildiği aydır" buyurulmuştur.'
      }
    ]
  },
  'gordugume-gormedigime': {
    title: 'Gördüğüme Görmediğime Deneme Sınavı',
    sub: 'Ufka Yolculuk 12 - Lise Düzeyi',
    category: 'Lise',
    badgeClass: 'bg-warning-subtle text-warning',
    durationMinutes: 15,
    bookImage: 'assets/images/books/book-gordugume-gormedigime.svg',
    rules: [
      'Bu sınav lise düzeyi "Gördüğüme Görmediğime" kitabı kaynaklı felsefi ve itikadi analizleri içerir.',
      'Sınavda 6 soru bulunmakta ve süreniz 15 dakikadır.'
    ],
    questions: [
      {
        q: 'Modern materyalist düşüncenin "Yalnızca gözümle gördüğüme inanırım" iddiasına karşı İslam epistemolojisinde bilginin temel kaynakları nelerdir?',
        options: [
          'A) Selim Akıl, Sadık Haber (Vahiy) ve Salim Duyular',
          'B) Sadece laboratuvar deneyleri',
          'C) Sadece rüya ve sezgiler',
          'D) Toplumsal gelenekler ve adetler',
          'E) Mitolojik efsaneler'
        ],
        correct: 0,
        topic: 'İnanç ve Felsefe',
        solution: 'İslam düşüncesinde hakiki bilgi kaynakları üçtür: Selim akıl, Sadık haber (mütevatir haber ve vahiy) ve sağlam işleyen duyulardır.'
      },
      {
        q: 'Evrendeki muazzam nizam, ölçü ve gayelilikten hareketle Yüce Yaratıcı\'nın varlığını ispatlayan klasik kelam delili hangisidir?',
        options: [
          'A) Gaye ve Nizam (Teleolojik) Delili',
          'B) Ontolojik Delil',
          'C) İttifak Delili',
          'D) Kötülük Problemi',
          'E) Temanu Delili'
        ],
        correct: 0,
        topic: 'İnanç ve Felsefe',
        solution: 'Gaye ve Nizam delili, atomdan galaksilere kadar kainattaki kusursuz düzenin bilinçli bir Yaratıcı olmaksızın tesadüfen var olamayacağını ortaya koyar.'
      },
      {
        q: 'İnsanın yaratılışında var olan, Yaratıcı\'yı tanıma ve O\'na yönelme doğuştan gelen eğilimine ne ad verilir?',
        options: ['A) Fıtrat', 'B) Taassup', 'C) İnhiraf', 'D) İllüzyon', 'E) Dogmatizm'],
        correct: 0,
        topic: 'İnanç ve İtikat',
        solution: 'Fıtrat, Allah Teâlâ\'nın insan tabiatına nakşettiği saf, temiz ve hakikati kabule hazır yaratılış programıdır.'
      }
    ]
  },
  'nasil-inanmali': {
    title: 'Nasıl İnanmalı? Deneme Sınavı',
    sub: 'Ufka Yolculuk 12 - Yetişkin Düzeyi',
    category: 'Yetişkin',
    badgeClass: 'bg-info-subtle text-info',
    durationMinutes: 15,
    bookImage: 'assets/images/books/book-nasil-inanmali.svg',
    rules: [
      'Bu sınav yetişkin kategorisi "Nasıl İnanmalı?" eseri kaynaklıdır.',
      'Soru metinlerini dikkatle okuyunuz.'
    ],
    questions: [
      {
        q: 'Tahkiki iman ile taklidi iman arasındaki en belirleyici fark aşağıdakilerden hangisidir?',
        options: [
          'A) Tahkiki imanın delillere, akli ve kalbi sorgulamaya, derin marifete dayanması',
          'B) Taklidi imanın daha üstün olması',
          'C) Tahkiki imanın yalnızca felsefecilere mahsus olması',
          'D) Taklidi imanın şüphelerden tamamen arınmış olması',
          'E) Aralarında hiçbir fark olmaması'
        ],
        correct: 0,
        topic: 'İnanç ve Kelam',
        solution: 'Tahkiki iman; delillere, marifetullaha ve şuurlu bir idrake dayanırken, taklidi iman çevreden görerek sorgulamadan benimsenen imandır.'
      },
      {
        q: 'İslam ahlakında "İhsan" makamı Cibril Hadisi\'nde nasıl tarif edilmiştir?',
        options: [
          'A) Allah\'ı görüyormuş gibi O\'na kulluk etmektir; sen O\'nu görmesen de O seni görmektedir',
          'B) Yalnızca fakirlere sadaka vermektir',
          'C) Sadece bayramlarda hediyeleşmektir',
          'D) İbadetleri en hızlı şekilde bitirmektir',
          'E) İnsanlara gösteriş yapmaktır'
        ],
        correct: 0,
        topic: 'Ahlak ve Değerler',
        solution: 'İhsan, kulun her an Yüce Allah\'ın huzurunda olduğunun ve O\'nun tarafından görüldüğünün bilinciyle huşu içinde yaşamasıdır.'
      }
    ]
  }
};

// ==========================================================================
// 2. Sınav Durum Yönetimi (State)
// ==========================================================================
let examState = {
  examKey: 'genel',
  data: null,
  currentQuestionIndex: 0,
  userAnswers: {}, // { 0: 2, 1: 0, ... }
  timeRemainingSeconds: 0,
  timerInterval: null,
  totalElapsedSeconds: 0,
  isFinished: false,
  fontSize: 'md' // 'sm', 'md', 'lg'
};

// ==========================================================================
// 3. Başlatma & Sayfa Yükleme
// ==========================================================================
document.addEventListener('DOMContentLoaded', () => {
  parseUrlParamsAndInit();
  initPreExamEvents();
  initExamEngineEvents();
  initReportEvents();
});

function parseUrlParamsAndInit() {
  const urlParams = new URLSearchParams(window.location.search);
  const sinavParam = urlParams.get('sinav') || urlParams.get('book') || 'genel';
  const topicParam = urlParams.get('topic');

  if (EXAM_DATABASE[sinavParam]) {
    examState.examKey = sinavParam;
  } else {
    examState.examKey = 'genel';
  }

  examState.data = EXAM_DATABASE[examState.examKey];

  // Topic filtresi varsa başlığa yansıt
  if (topicParam) {
    examState.data.title = `Konu Testi: ${decodeURIComponent(topicParam)}`;
  }

  renderPreExamScreen();
}

// ==========================================================================
// 4. Aşama 1: Sınav Öncesi Bilgilendirme Ekranı Fonksiyonları
// ==========================================================================
function renderPreExamScreen() {
  const data = examState.data;
  if (!data) return;

  // Başlıklar & Bilgiler
  document.getElementById('preExamTitle').textContent = data.title;
  document.getElementById('preExamSub').textContent = data.sub;
  document.getElementById('preExamCategoryBadge').textContent = data.category;
  
  // Kitap Görseli
  const bookImg = document.getElementById('preExamBookImg');
  if (bookImg && data.bookImage) {
    bookImg.src = data.bookImage;
    bookImg.alt = data.title;
  }

  // Metrik Kutuları
  document.getElementById('preExamQuestionCount').textContent = `${data.questions.length} Soru`;
  document.getElementById('preExamDuration').textContent = `${data.durationMinutes} Dakika`;
  document.getElementById('preExamPoints').textContent = `${data.questions.length * 10} Puan`;

  // Kurallar Listesi
  const rulesListEl = document.getElementById('preExamRulesList');
  if (rulesListEl) {
    rulesListEl.innerHTML = '';
    data.rules.forEach(rule => {
      const li = document.createElement('li');
      li.className = 'pre-exam-rule-item';
      li.innerHTML = `<i class="fa-solid fa-circle-check"></i> <span>${rule}</span>`;
      rulesListEl.appendChild(li);
    });
  }

  // Header mini rozet
  document.getElementById('headerExamBadgeTitle').textContent = data.title;
}

function initPreExamEvents() {
  const agreeCheck = document.getElementById('chkAgreeRules');
  const btnStart = document.getElementById('btnStartExamNow');

  if (agreeCheck && btnStart) {
    agreeCheck.addEventListener('change', () => {
      btnStart.disabled = !agreeCheck.checked;
    });

    btnStart.addEventListener('click', () => {
      startLiveExamSession();
    });
  }
}

// ==========================================================================
// 5. Aşama 2: Canlı Sınav Motoru (Active Exam Engine)
// ==========================================================================
function startLiveExamSession() {
  // Ekran Geçişi
  document.getElementById('screenPreExam').classList.add('d-none');
  document.getElementById('screenExamRunning').classList.remove('d-none');
  document.getElementById('screenPostExamReport').classList.add('d-none');

  // Header zamanlayıcı ve kontrolleri aç
  document.getElementById('headerExamTimer').classList.remove('d-none');
  document.getElementById('headerExamControls').classList.remove('d-none');

  // Sınav State Sıfırlama
  examState.currentQuestionIndex = 0;
  examState.userAnswers = {};
  examState.isFinished = false;
  examState.totalElapsedSeconds = 0;
  examState.timeRemainingSeconds = examState.data.durationMinutes * 60;

  // Kronometre Başlat
  startTimer();

  // Soru ve Paleti Çiz
  renderQuestion(0);
  renderPalette();

  // Sayfanın en üstüne kaydır
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function startTimer() {
  if (examState.timerInterval) clearInterval(examState.timerInterval);

  updateTimerDisplay();

  examState.timerInterval = setInterval(() => {
    examState.timeRemainingSeconds--;
    examState.totalElapsedSeconds++;

    updateTimerDisplay();

    if (examState.timeRemainingSeconds <= 0) {
      clearInterval(examState.timerInterval);
      finishExamSession(true); // Otomatik bitir
    }
  }, 1000);
}

function updateTimerDisplay() {
  const timerTextEl = document.getElementById('timerTextDisplay');
  const timerCardEl = document.getElementById('headerExamTimer');
  if (!timerTextEl || !timerCardEl) return;

  const mins = Math.floor(examState.timeRemainingSeconds / 60);
  const secs = examState.timeRemainingSeconds % 60;
  const formatted = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;

  timerTextEl.textContent = formatted;

  // Renk Uyarı Durumları
  if (examState.timeRemainingSeconds <= 120) { // Son 2 dakika
    timerCardEl.className = 'sinav-timer-card danger';
  } else if (examState.timeRemainingSeconds <= 300) { // Son 5 dakika
    timerCardEl.className = 'sinav-timer-card warning';
  } else {
    timerCardEl.className = 'sinav-timer-card';
  }
}

function renderQuestion(index) {
  const questions = examState.data.questions;
  if (index < 0 || index >= questions.length) return;

  examState.currentQuestionIndex = index;
  const qData = questions[index];

  // Soru Meta Bilgileri
  document.getElementById('qCurrentNumberBadge').textContent = `Soru ${index + 1} / ${questions.length}`;
  document.getElementById('qTopicBadge').textContent = qData.topic || 'Genel';
  
  // Soru Metni
  document.getElementById('qBodyText').textContent = qData.q;

  // Şıklar Listesi
  const choicesWrap = document.getElementById('qChoicesList');
  choicesWrap.innerHTML = '';

  const selectedAnswer = examState.userAnswers[index];

  qData.options.forEach((optText, optIdx) => {
    const letter = ['A', 'B', 'C', 'D', 'E'][optIdx] || optText.charAt(0);
    const cleanText = optText.replace(/^[A-E]\)\s*/, '');

    const choiceEl = document.createElement('div');
    choiceEl.className = `exam-choice-item ${selectedAnswer === optIdx ? 'selected' : ''}`;
    choiceEl.innerHTML = `
      <div class="choice-circle-letter">${letter}</div>
      <div class="choice-text-content">${cleanText}</div>
    `;

    choiceEl.addEventListener('click', () => {
      selectOption(index, optIdx);
    });

    choicesWrap.appendChild(choiceEl);
  });

  // Önceki / Sonraki Buton Durumları
  const btnPrev = document.getElementById('btnPrevQuestion');
  const btnNext = document.getElementById('btnNextQuestion');
  if (btnPrev) btnPrev.disabled = (index === 0);
  if (btnNext) {
    if (index === questions.length - 1) {
      btnNext.innerHTML = 'Gözden Geçir <i class="fa-solid fa-list-check ms-1"></i>';
    } else {
      btnNext.innerHTML = 'Sonraki Soru <i class="fa-solid fa-arrow-right ms-1"></i>';
    }
  }

  // Palet Vurgusunu Güncelle
  updatePaletteHighlight();
}

function selectOption(qIndex, optionIndex) {
  examState.userAnswers[qIndex] = optionIndex;
  renderQuestion(qIndex);
  renderPalette();
}

function clearOption(qIndex) {
  delete examState.userAnswers[qIndex];
  renderQuestion(qIndex);
  renderPalette();
}

function renderPalette() {
  const paletteMatrix = document.getElementById('paletteMatrix');
  if (!paletteMatrix) return;

  const totalQuestions = examState.data.questions.length;
  paletteMatrix.innerHTML = '';

  let answeredCount = 0;

  for (let i = 0; i < totalQuestions; i++) {
    const isAnswered = examState.userAnswers[i] !== undefined;
    const isCurrent = (i === examState.currentQuestionIndex);

    if (isAnswered) answeredCount++;

    const nodeBtn = document.createElement('button');
    nodeBtn.type = 'button';
    nodeBtn.className = `btn-palette-grid-node ${isAnswered ? 'answered' : ''} ${isCurrent ? 'current' : ''}`;
    nodeBtn.textContent = i + 1;
    nodeBtn.title = `Soru ${i + 1}`;

    nodeBtn.addEventListener('click', () => {
      renderQuestion(i);
    });

    paletteMatrix.appendChild(nodeBtn);
  }

  // Sayaçları güncelle
  const emptyCount = totalQuestions - answeredCount;
  const answeredEl = document.getElementById('paletteAnsweredCount');
  const emptyEl = document.getElementById('paletteEmptyCount');
  if (answeredEl) answeredEl.textContent = answeredCount;
  if (emptyEl) emptyEl.textContent = emptyCount;
}

function updatePaletteHighlight() {
  const nodes = document.querySelectorAll('.btn-palette-grid-node');
  nodes.forEach((node, idx) => {
    if (idx === examState.currentQuestionIndex) {
      node.classList.add('current');
    } else {
      node.classList.remove('current');
    }
  });
}

function initExamEngineEvents() {
  // Önceki / Sonraki Butonları
  const btnPrev = document.getElementById('btnPrevQuestion');
  const btnNext = document.getElementById('btnNextQuestion');
  const btnClear = document.getElementById('btnClearChoice');
  const btnFinishTrigger = document.getElementById('btnTriggerFinishExam');
  const btnModalConfirmFinish = document.getElementById('btnModalConfirmFinish');
  const btnLeaveExam = document.getElementById('btnLeaveExam');
  const btnModalConfirmLeave = document.getElementById('btnModalConfirmLeave');

  if (btnPrev) {
    btnPrev.addEventListener('click', () => {
      if (examState.currentQuestionIndex > 0) {
        renderQuestion(examState.currentQuestionIndex - 1);
      }
    });
  }

  if (btnNext) {
    btnNext.addEventListener('click', () => {
      if (examState.currentQuestionIndex < examState.data.questions.length - 1) {
        renderQuestion(examState.currentQuestionIndex + 1);
      } else {
        openFinishConfirmModal();
      }
    });
  }

  if (btnClear) {
    btnClear.addEventListener('click', () => {
      clearOption(examState.currentQuestionIndex);
    });
  }

  if (btnFinishTrigger) {
    btnFinishTrigger.addEventListener('click', () => {
      openFinishConfirmModal();
    });
  }

  if (btnModalConfirmFinish) {
    btnModalConfirmFinish.addEventListener('click', () => {
      const modalEl = document.getElementById('finishConfirmModal');
      if (modalEl) {
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
      }
      finishExamSession(false);
    });
  }

  // Sınavdan Ayrıl Butonu (Aktif sınavda onay modalı açar)
  if (btnLeaveExam) {
    btnLeaveExam.addEventListener('click', (e) => {
      e.preventDefault();
      const examRunningScreen = document.getElementById('screenExamRunning');
      const isExamActive = examRunningScreen && !examRunningScreen.classList.contains('d-none');

      if (isExamActive) {
        const leaveModalEl = document.getElementById('leaveConfirmModal');
        if (leaveModalEl) {
          const leaveModal = bootstrap.Modal.getOrCreateInstance(leaveModalEl);
          leaveModal.show();
        }
      } else {
        window.location.href = 'deneme-sinavlari.html';
      }
    });
  }

  if (btnModalConfirmLeave) {
    btnModalConfirmLeave.addEventListener('click', () => {
      if (examState.timerInterval) clearInterval(examState.timerInterval);
      window.location.href = 'deneme-sinavlari.html';
    });
  }

  // Yazı Boyutu Değiştirme
  const fontBtns = document.querySelectorAll('.btn-font-size');
  fontBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const size = btn.getAttribute('data-size') || 'md';
      fontBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const card = document.getElementById('examQuestionCard');
      if (card) {
        card.classList.remove('font-size-sm', 'font-size-md', 'font-size-lg');
        card.classList.add(`font-size-${size}`);
      }
    });
  });

  // Tam Ekran Modu
  const btnFullScreen = document.getElementById('btnToggleFullScreen');
  if (btnFullScreen) {
    btnFullScreen.addEventListener('click', () => {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(() => {});
        btnFullScreen.innerHTML = '<i class="fa-solid fa-compress"></i>';
      } else {
        if (document.exitFullscreen) document.exitFullscreen();
        btnFullScreen.innerHTML = '<i class="fa-solid fa-expand"></i>';
      }
    });
  }
}

function openFinishConfirmModal() {
  const total = examState.data.questions.length;
  const answered = Object.keys(examState.userAnswers).length;
  const empty = total - answered;

  const answeredEl = document.getElementById('modalStatAnswered');
  const emptyEl = document.getElementById('modalStatEmpty');
  if (answeredEl) answeredEl.textContent = answered;
  if (emptyEl) emptyEl.textContent = empty;

  const modalEl = document.getElementById('finishConfirmModal');
  if (modalEl) {
    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
    modalInstance.show();
  }
}

// ==========================================================================
// 6. Aşama 3: Detaylı İstatistik, Karne & Çözüm İnceleme (Post-Exam Analytics)
// ==========================================================================
function finishExamSession(isAutoTimeout = false) {
  clearInterval(examState.timerInterval);
  examState.isFinished = true;

  // Header kontrollerini gizle
  document.getElementById('headerExamTimer').classList.add('d-none');
  document.getElementById('headerExamControls').classList.add('d-none');

  // Ekran Geçişi
  document.getElementById('screenPreExam').classList.add('d-none');
  document.getElementById('screenExamRunning').classList.add('d-none');
  document.getElementById('screenPostExamReport').classList.remove('d-none');

  // Sonuçları Hesapla
  calculateAndRenderReport(isAutoTimeout);

  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function calculateAndRenderReport(isAutoTimeout) {
  const questions = examState.data.questions;
  let correctCount = 0;
  let wrongCount = 0;
  let emptyCount = 0;
  
  // Konu Bazlı İstatistik
  const topicStats = {}; // { 'İnanç': { total: 2, correct: 2 } }

  questions.forEach((q, idx) => {
    const topic = q.topic || 'Genel';
    if (!topicStats[topic]) topicStats[topic] = { total: 0, correct: 0 };
    topicStats[topic].total++;

    const userAns = examState.userAnswers[idx];
    if (userAns === undefined) {
      emptyCount++;
    } else if (userAns === q.correct) {
      correctCount++;
      topicStats[topic].correct++;
    } else {
      wrongCount++;
    }
  });

  // Net & Puan Hesabı (4 yanlış 1 doğru)
  const netScore = Math.max(0, correctCount - (wrongCount * 0.25)).toFixed(2);
  const totalScore = ((netScore / questions.length) * 100).toFixed(1);
  const successPercentage = Math.round((correctCount / questions.length) * 100);

  // Süre Formatı
  const elapsedMins = Math.floor(examState.totalElapsedSeconds / 60);
  const elapsedSecs = examState.totalElapsedSeconds % 60;
  const elapsedStr = `${elapsedMins} Dk ${elapsedSecs} Sn`;
  const avgSecPerQ = Math.round(examState.totalElapsedSeconds / questions.length);

  // Rapor Başlık Kartı
  document.getElementById('reportExamTitle').textContent = examState.data.title;
  document.getElementById('reportTotalScore').textContent = totalScore;
  document.getElementById('reportNetScore').textContent = netScore;
  document.getElementById('reportSuccessRate').textContent = `%${successPercentage}`;

  // 4 Metrik Kutusu
  document.getElementById('reportCorrectCount').textContent = correctCount;
  document.getElementById('reportWrongCount').textContent = wrongCount;
  document.getElementById('reportEmptyCount').textContent = emptyCount;
  document.getElementById('reportTimeSpent').textContent = elapsedStr;

  // Başarı Mesajı & Rozet
  const feedbackEl = document.getElementById('reportFeedbackMessage');
  if (feedbackEl) {
    if (successPercentage >= 80) {
      feedbackEl.textContent = 'Harika bir başarı! Konuları çok iyi kavramışsın, bu tempoyla devam et.';
    } else if (successPercentage >= 50) {
      feedbackEl.textContent = 'Tebrikler! İyi bir performans sergiledin. Eksik konuları tamamlayarak daha da yükselebilirsin.';
    } else {
      feedbackEl.textContent = 'Deneme tamamlandı. Aşağıdaki konu analizinden eksik olduğun alanları tekrar etmeni öneririz.';
    }
  }

  // Konu Bazlı Başarı Çubukları
  renderTopicAnalysis(topicStats);

  // Soru Çözümleri & Cevap Anahtarı Listesi
  renderSolutionReviewList(questions);
}

function renderTopicAnalysis(topicStats) {
  const wrap = document.getElementById('reportTopicBarsWrap');
  if (!wrap) return;

  wrap.innerHTML = '';

  Object.keys(topicStats).forEach(topicName => {
    const stat = topicStats[topicName];
    const pct = Math.round((stat.correct / stat.total) * 100);

    let barColor = 'bg-primary';
    if (pct >= 80) barColor = 'bg-success';
    else if (pct < 50) barColor = 'bg-danger';
    else barColor = 'bg-warning';

    const itemEl = document.createElement('div');
    itemEl.className = 'topic-bar-item';
    itemEl.innerHTML = `
      <div class="topic-bar-meta">
        <span class="text-dark"><i class="fa-solid fa-book-bookmark text-primary me-2"></i>${topicName}</span>
        <span class="fw-bold ${pct >= 70 ? 'text-success' : 'text-dark'}">${stat.correct}/${stat.total} Doğru (%${pct})</span>
      </div>
      <div class="progress rounded-pill" style="height: 8px; background-color: #e2e8f0;">
        <div class="progress-bar ${barColor} rounded-pill" role="progressbar" style="width: ${pct}%;"></div>
      </div>
    `;
    wrap.appendChild(itemEl);
  });
}

function renderSolutionReviewList(questions) {
  const wrap = document.getElementById('solutionReviewList');
  if (!wrap) return;

  wrap.innerHTML = '';

  questions.forEach((q, idx) => {
    const userAns = examState.userAnswers[idx];
    const isCorrect = (userAns === q.correct);
    const isEmpty = (userAns === undefined);

    let statusClass = 'is-correct';
    let chipClass = 'correct';
    let statusText = '<i class="fa-solid fa-check me-1"></i> Doğru';

    if (isEmpty) {
      statusClass = 'is-empty';
      chipClass = 'empty';
      statusText = '<i class="fa-regular fa-circle me-1"></i> Boş Bırakıldı';
    } else if (!isCorrect) {
      statusClass = 'is-wrong';
      chipClass = 'wrong';
      statusText = '<i class="fa-solid fa-xmark me-1"></i> Yanlış';
    }

    const card = document.createElement('div');
    card.className = `solution-card-item ${statusClass}`;

    let optionsHtml = '';
    q.options.forEach((optText, optIdx) => {
      const letter = ['A', 'B', 'C', 'D', 'E'][optIdx];
      let rowClass = '';

      if (optIdx === q.correct) {
        rowClass = 'correct-ans';
      } else if (optIdx === userAns && !isCorrect) {
        rowClass = 'user-wrong-ans';
      }

      optionsHtml += `
        <div class="solution-opt-row ${rowClass}">
          <span class="badge bg-secondary-subtle text-dark">${letter}</span>
          <span>${optText.replace(/^[A-E]\)\s*/, '')}</span>
          ${optIdx === q.correct ? '<i class="fa-solid fa-circle-check text-success ms-auto"></i>' : ''}
          ${(optIdx === userAns && !isCorrect) ? '<i class="fa-solid fa-circle-xmark text-danger ms-auto"></i>' : ''}
        </div>
      `;
    });

    card.innerHTML = `
      <div class="solution-card-top">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-primary text-white fw-bold">Soru ${idx + 1}</span>
          <span class="text-muted small fw-semibold">${q.topic || 'Genel'}</span>
        </div>
        <span class="solution-status-chip ${chipClass}">${statusText}</span>
      </div>

      <div class="fw-bold text-dark mb-3" style="font-size: 0.95rem;">${q.q}</div>

      <div class="solution-options-mini">
        ${optionsHtml}
      </div>

      <div class="solution-explanation-box">
        <div class="fw-bold mb-1"><i class="fa-solid fa-lightbulb me-1"></i> Çözüm ve Açıklama:</div>
        <div>${q.solution || 'Bu soru ile ilgili detaylı açıklama metni.'}</div>
      </div>
    `;

    wrap.appendChild(card);
  });
}

function initReportEvents() {
  const btnRestart = document.getElementById('btnRestartExam');
  if (btnRestart) {
    btnRestart.addEventListener('click', () => {
      document.getElementById('chkAgreeRules').checked = false;
      document.getElementById('btnStartExamNow').disabled = true;
      document.getElementById('screenPostExamReport').classList.add('d-none');
      document.getElementById('screenPreExam').classList.remove('d-none');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
}
