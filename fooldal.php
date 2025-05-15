<?php
session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kezdőlap - Vaszilij EDC</title>
    <link rel="stylesheet" href="szepike.css">
    <link rel="stylesheet" href="bej.css">
    <link rel="icon" type="image/png" href="https://vaszilijedc.hu/wp-content/uploads/2018/05/Vaszilij-EDC.jpg.webp">
</head>
<body class="page1">
    <div class="bg-pan-tl"></div>
    
    <?php if (isset($_SESSION['welcome_message'])): ?>
        <div class="welcome-message">
            <?php 
            echo $_SESSION['welcome_message']; 
            unset($_SESSION['welcome_message']);
            ?>
        </div>
    <?php endif; ?>

    <nav>
        <ul>
            <li><a href="fooldal.php" class="active">Kezdőlap</a></li>
            <li><a href="tamogatas.html">Támogatás</a></li>
            <li><a href="uzenetkuldes.html">Üzenetküldés</a></li>
            <li><a href="blog.html">Blog</a></li>
            <li><a href="irasok.html">Írások</a></li>
            <li><a href="kilepes.php">Kilépés</a></li>
        </ul>
    </nav>
    
    <img src="Vaszilij.webp" alt="Vaszilij" class="fixed-image mirror-horizontal">
    <button id="scrollToTop">⬆️ Vissza az elejére</button>
    
    <div class="container">
        <div class="content">
            <h2>Naplónak indult.<br>Bemutató bloggá vált.</h2>
            <p>Aztán átalakult valami mássá. Ablakká, amelyben kitekintek a világra, a világ meg betekinthet a gondolataimba: késekről, every day carry felszerelésekről, és az ezek mögött meghúzódó filozófiáról.
            <br><br>Aztán ennél is több lett. Egy közösség, amelyben együtt, hasonló értékek mentén dolgozunk azért, hogy egy minőségi, kissé talán régimódi találkahely legyen ez az online térben.
            <br><br>Balogh József vagyok, és azon dolgozom, hogy ez a közösség egyre nagyobbá váljon, és együtt adhassuk tovább ezek az értékeket. Tarts velünk te is!</p>
        
            <h2>De mi az az EDC?</h2>
            <p>Egy angol betűszó, amely kibontva az every day carry kifejezést takarja. Ez szó szerinti fordításban azokat a holmikat jelenti, amelyeket nap mint nap magunknál hordunk. A közkeletű tévhittel ellentétben nem szükséges az, hogy mindig minden nap nálunk legyen: inkább egyfajta készletről, gyűjteményről van szó, amelynek elemeit az adott szituációnak megfelelően váltogathatjuk. Más holmikat pakolunk el, ha egy irodába megyünk dolgozni, mást, ha egy építkezésen melózunk, és akkor is, amikor hétvégén rokonlátogatóba megyünk.
            <br><br> Ezen a blogon főképp késekről olvashatsz, mert hozzám ezek az eszközök állnak legközelebb, de szó esik néha másról is. Multiszerszámokról, táskákról, egyéb kiegészítőkről. És nem csak bemutatókat készítek: ahogy már írtam, sokféle aspektusa érdekel ennek a világnak.
            <br><br>Az every day carry tehát sok minden lehet. Életmód, filozófia, hobbi, vagy akár egy gyűjtőszenvedély alapja. Mindegy, hogy téged melyik része érdekel, remélem, találsz itt értékes olvasnivalót.</p>
            
            <center>
                <a href="https://www.bladeshop.hu/"><img src="bladeshop.webp" alt="Bladeshop"></a>
                <p>Késes webshop gyakori akciókkal és vevőbarát hozzáállással. Ha új kés kell, ne hagyd ki!</p>
                
                <a href="https://elemlampablog.hu/"><img src="elemlámpa blog.webp" alt="elemlámpa blog"></a>
                <p>Minden, amit az elemlámpákról tudni szeretnél. Cikkek, bemutatók, illetve kuponok gyűjtőhelye.</p>
                
                <a href="https://www.kesvilag.hu/"><img src="késvilág.webp" alt="Késvilág"></a>
                <p>Hazai bolt és webáruház, rendkívül széles termékválasztékkal. Debrecenben személyesen is válogathatsz!</p>
                
                <a href="https://www.magyarkesek.hu/"><img src="magyar kések.webp" alt="Magyar kések"></a>
                <p>Webshop és közösség. Elsősorban a hazai készítők termékeivel foglalkozik, de nyitott egyéb irányokba is.</p>
                
                <a href="https://kesportal.hu/"><img src="késportál.webp" alt="Késportál"></a>
                <p>Magyarország legnagyobb késes tudásbázisa. Érdemes csatlakoznod a fórumhoz is!</p>
                
                <a href="https://www.zboss.hu/"><img src="zboss.webp" alt="ZBOSS"></a>
                <p>Kések, edc felszerelések, túra és sok egyéb. Hazai webáruház, ahol a vevők elégedettsége a legfontosabb.</p>
            </center>
        </div>
    </div>
    
      <footer class="transparent-footer">
        <p>&copy; Készítette: [Hunyadi Krisztofer & Kirilla József & Nagy Kristóf] - Neptun kód: [LE3O8X-FWN10Y-S1LGWD]</p>
    </footer>

<!-- Social Media Menu -->
<div class="social-menu-container">
  <div class="social-menu">
    <div class="toggle">
        <img src="images/share.png" alt="" style="height: 50px; width: auto;">
    </div>
    <ul>
  <li style="--i:2;"><a href="https://www.facebook.com/VaszilijEdc" aria-label="Facebook"></a></li>
  <li style="--i:1;"><a href="#" aria-label="Instagram"></a></li>
  <li style="--i:0;"><a href="#" aria-label="Twitter"></a></li>
  <li style="--i:3;"><a href="#" aria-label="YouTube"></a></li>
</ul>
  </div>
</div>

<script>
    // Social menu toggle
    const socialMenu = document.querySelector('.social-menu');
    const toggle = socialMenu.querySelector('.toggle');
    
    toggle.addEventListener('click', () => {
        socialMenu.classList.toggle('active');
    });
</script>

<script src="script.js"></script>
</body>
</html>