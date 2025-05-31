<x-layout>
    <div class="container">
        <h1 class="title">Meehelpen als vrijwilliger?</h1>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <p class="content-text">
            We zoeken over heel Borgloon, Tongeren en omgeving altijd vrijwilligers. Een grote groep maakt het werk lichter. Zo kunnen we bij echt paddenweer meer mensen inschakelen en dus ook meer padden redden.
        </p>

        <div class="flex-block">
            <div class="image-side">
                <img src="/images/logo/logo pad en co 600x600.jpg" alt="logo pad en co" class="content-image">
            </div>
            <div class="text-side">
                <h3 class="subtitle">Avondploeg</h3>
                <p class="content-text">
                    De paddentrek vindt altijd plaats na valavond. Vanaf het moment dat de zon ondergaat, er geen grondvorst is en het wat vochtig wordt, worden de padden wakker en kruipen ze uit hun holletje. In februari kan dat al rond 18u zijn, maar tegen eind maart eerder rond 20u.
                </p>
            </div>
        </div>

        <div class="flex-block">
            <div class="text-side">
                <h3 class="subtitle">Ochtendploeg</h3>
                <p class="content-text">
                    We zoeken ook steeds vrijwilligers voor de ochtendploeg, voor wie graag vroeg opstaat.
                </p>
                <p class="content-text">
                    Als ochtendvrijwilliger ga je vroeg in de ochtend. Je maakt de emmers leeg, telt wat je vindt, en noteert alles. Een goed gevoel om de dag te starten.
                </p>
            </div>
            <div class="image-side">
                <img src="/images/kikkerdril lw.jpg" alt="kikkerdril" class="content-image">
            </div>
        </div>

        <p class="content-text">
            We werken met beurtrollen, zodat jij zelf kan beslissen wanneer je komt. Kan je enkel laat op de avond, liever tijdens de drukste momenten of vroeg op de avond? Alles is goed — elke helpende hand telt😊.
        </p>

        <h2 class="section-title">Wil jij vrijwilliger worden?</h2>
        <p class="content-text">
            Schrijf je hier in. Wij nemen contact met je op via WhatsApp en gaan de eerste keer samen op pad. Zo kan je eerst eens kijken of het iets is voor jou. Wanneer je graag vaker wilt komen word je toegevoegd aan de WhatsApp-groep en kan je je eigen invoer doen, hier op deze website. Onder dit tabje 'Pad&Co' vind je nog meer uitleg.
        </p>

        <form action="{{ route('vrijwilliger.store') }}" method="POST" class="form">
            @csrf
            <div class="form-group">
                <label for="name" class="box-text">Jouw naam:<span class="required">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="box-text">Jouw email:<span class="required">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefoonnummer" class="box-text">Jouw telefoonnummer:<span class="required">*</span></label>
                <input type="text" name="telefoonnummer" id="telefoonnummer" placeholder="041234567" value="{{ old('telefoonnummer') }}">
                <small class="note">Zonder spaties of streepjes</small>
                @error('telefoonnummer')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="bericht" class="box-text">Jouw bericht:</label>
                <textarea name="bericht" id="bericht"></textarea>
            </div>

            <button type="submit" class="btn-submit">Verstuur</button>
        </form>

        <h2 class="section-title">Wat breng je mee?</h2>
        <ul class="content-list">
            <li><strong>Een fluohesje</strong> is verplicht!</li>
            <li><strong>Een goede hoofdlamp</strong> zodat je handen vrij zijn, of een goede sterke zaklamp. Je lampje op je smartphone is niet voldoende.</li>
            <li><strong>Een emmer</strong>, schoon (zonder detergent of cementresten).</li>
            <li><strong>Handschoenen</strong> mogen, maar zijn niet verplicht. Geen latex handdschoenen</li>
            <li><strong>Iets om te tellen</strong>: pen en papier of je smartphone om te noteren. Je kan ook deze site gebruiken tijdens het rapen.</li>
        </ul>

        <div class="note-block">
            <p class="box-text">Een goede voorbereiding is het halve werk. Zorg dat je materiaal in orde is en kleed je goed naar het weer. Regen of kou houdt de padden niet tegen — ons dus ook niet!</p>
        </div>

        <p class="highlight-text">
            Wil je meedoen of heb je vragen? Neem dan contact met ons op. We kijken ernaar uit om samen de padden een veilige oversteek te geven! 🐸
        </p>

        <img src="/images/logo/logo pad en co 1500x600.jpg" alt="logo pad en co" class="content-60-image">
    </div>
</x-layout>
