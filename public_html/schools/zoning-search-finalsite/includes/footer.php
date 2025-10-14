<footer id="fsFooter" class="fsFooter">
    <div class=" fsBanner fsStyleAutoclear" id="fsEl_9" data-settings-id="9" data-use-new="true">

        <section class="fsElement fsLocationElement fsSingleItem footer-logo   fsThumbnailOriginal fsThumbnailFull"
                 id="fsEl_3971" data-use-new="true">

            <header>
                <h2 class="fsElementTitle">Location</h2>
            </header>
            <div class="fsElementContent">
                <article class="fsLocationSingleItem">
                    <div class="fsThumbnail fsThumbnailLogo"><a class="fsLocationLink"
                                                                href="https://ccsdnet-22-us-west1-01.preview.finalsitecdn.com"><img
                                alt="Clark County School District" data-aspect-ratio="0.5689655172413793"
                                data-image-sizes="[{%22url%22:%22https://resources.finalsite.net/images/v1747399221/ccsdnet/hgdmtyowvd0mk62qx2bf/header-district-logo.svg%22,%22width%22:116}]"></a>
                    </div>
                </article>
            </div>
        </section>
        <section
            class="fsElement fsLocationElement fsSingleItem footer-address   fsThumbnailOriginal fsThumbnailFull"
            id="fsEl_3972" data-use-new="true">

            <header>
                <h2 class="fsElementTitle">Get in Touch</h2>
            </header>
            <div class="fsElementContent">
                <article class="fsLocationSingleItem">
                    <div class="fsLocationAddress fsLocationAddress-1">5100 W Sahara Ave.</div>
                    <div class="fsLocationCity">Las Vegas</div>
                    <div class="fsLocationState">NV</div>
                    <div class="fsLocationZip">89146</div>
                    <div class="fsLocationCountry">USA</div>
                    <div class="fsLocationPhone"><a href="tel:702-799-CCSD">702-799-CCSD</a></div>
                </article>
            </div>
        </section>
        <section class="fsElement fsNavigation fsList useful-links" id="fsEl_4004" data-use-new="true">
            <header>
                <h2 class="fsElementTitle">Useful Links</h2>
            </header>
            <div class="fsElementContent">
                <nav>
                    <ul class="fsNavLevel1">
                        <li><a href="/calendar1">Calendar</a></li>
                        <li><a href="/careers1">Careers</a></li>
                        <li><a href="/enroll1">Enroll</a></li>
                        <li><a href="/hcm">HCM</a></li>
                        <li><a href="/infinite-campus1">Infinite Campus</a></li>
                        <li><a href="/legal-notices">Legal Notices</a></li>
                        <li><a href="/meals1">Meals</a></li>
                        <li><a href="/news1">News</a></li>
                        <li><a href="/safe-voice">Safe Voice</a></li>
                        <li><a href="/transportation1">Transportation</a></li>
                    </ul>
                </nav>
            </div>
        </section>
        <section class="fsElement fsNavigation fsList nav-social" id="fsEl_3973" data-use-new="true">
            <header>
                <h2 class="fsElementTitle">Connect & Share</h2>
            </header>
            <div class="fsElementContent">
                <nav aria-label="social media">
                    <ul class="fsNavLevel1">
                        <li><a href="http://www.facebook.com" target="_blank">Facebook<span class="fsStyleSROnly">(opens in new window/tab)</span></a>
                        </li>
                        <li><a href="http://www.twitter.com" target="_blank">Twitter<span class="fsStyleSROnly">(opens in new window/tab)</span></a>
                        </li>
                        <li><a href="https://www.instagram.com/" target="_blank">Instagram<span
                                    class="fsStyleSROnly">(opens in new window/tab)</span></a></li>
                        <li><a href="https://www.linkedin.com/" target="_blank">Linkedin<span class="fsStyleSROnly">(opens in new window/tab)</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
        <section class="fsElement fsNavigation fsList footer-utility" id="fsEl_4005" data-use-new="true">

            <header>
                <h2 class="fsElementTitle">Navigation</h2>
            </header>
            <div class="fsElementContent">
                <nav>
                    <ul class="fsNavLevel1">
                        <li><a href="/privacy-policy">Privacy Policy</a></li>
                        <li><a href="/site-map">Site Map</a></li>
                        <li><a href="/accessibility-statement">Accessibility</a></li>
                    </ul>
                </nav>
            </div>
        </section>
        <div id="fsPoweredByFinalsite" role="complementary">
            <div>
                <a href="https://www.finalsite.com/districts" title="Powered by Finalsite opens in a new window"
                   target="_blank">Powered by Finalsite</a>
            </div>
        </div>
    </div>
</footer>
</div>

<script src="../js/app.js"></script>

<script src="../js/main.js"></script>




<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('map');
        if (!input) return;

        // Create suggestion box and style it
        const suggestionBox = document.createElement('div');
        suggestionBox.style.position = 'absolute';
        suggestionBox.style.background = '#fff';
        suggestionBox.style.border = '1px solid #ccc';
        suggestionBox.style.width = '100%';
        suggestionBox.style.zIndex = '1000';
        suggestionBox.style.maxHeight = '200px';
        suggestionBox.style.overflowY = 'auto';
        suggestionBox.style.display = 'none';

        // Ensure parent's position is relative for correct suggestion positioning
        input.parentNode.style.position = 'relative';
        input.parentNode.appendChild(suggestionBox);

        input.addEventListener('input', function() {
            const query = input.value.trim();
            if (query.length < 3) {
                suggestionBox.style.display = 'none';
                return;
            }
            // Fetch address suggestions from Photon API
            fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
                .then(response => response.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    data.features.forEach(feature => {
                        const item = document.createElement('div');
                        item.style.padding = '8px';
                        item.style.cursor = 'pointer';
                        item.textContent = feature.properties.label;
                        item.addEventListener('mousedown', () => {
                            input.value = feature.properties.label;
                            suggestionBox.style.display = 'none';
                        });
                        suggestionBox.appendChild(item);
                    });
                    suggestionBox.style.display = data.features.length ? 'block' : 'none';
                });
        });

        input.addEventListener('blur', () => {
            setTimeout(() => suggestionBox.style.display = 'none', 100);
        });
    });
</script>

</body>
</html>