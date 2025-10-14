<?php //require('models/Address.php'); ?>

<div id="fsPageBodyWrapper" class="fsPageBodyWrapper" style="min-height:500px;">
    <div id="fsPageBody" class="fsStyleAutoclear">

        <main id="fsPageContent" class="fsPageContent">

            <?php //Page Section Start ?>

            <h1 class="fsPageTitle">ZONING SEARCH</h1>

            <div class="fsPageLayout fsLayout fsOneColumnLayout fsStyleAutoclear" id="fsEl_2473" data-use-new="true">
                <div class="fsDiv fsStyleAutoclear" id="fsEl_2474">
                    <div class="fsElement fsContent" id="fsEl_2475" data-use-new="true">
                        <div class="fsElementContent">
                            <p>If you require assistance identifying the zoned school for your address, please contact <a href="">Demographics, Zoning & GIS Department</a> at <a href="">(702) 799-7678</a></p>
                            <p>For Registration assistance please call <a href="">(702) 799-7678</a>.</p>

                            <form action="search.php" method="post">
                                <div id="autocomplete-container" style="position:relative; width:100%;">
                                    <input id="address-input"
                                           type="text"
                                           name="search"
                                           placeholder="ZONING SEARCH"
                                           style="width:100%; height:60px; padding-right:60px; font-size:1.5em; box-sizing:border-box;"
                                           autocomplete="off"/>

                                    <input type="hidden" id="selected-address-value" name="selected_address" value=""/>

                                    <button type="submit"
                                            style="position:absolute; right:0; top:0; height:100%; width:100px; background:#2D5B96; color:#fff; border:none; font-size:1.2em; cursor:pointer;">
                                        Search
                                    </button>

                                    <div id="suggestions"></div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <?php //Page Section End ?>


        </main>
    </div>
</div>

<?php //Address Input // geoapify address auto complete ?>
<script>
    const input = document.getElementById('address-input');
    const suggestions = document.getElementById('suggestions');
    const selectedAddressValue = document.getElementById('selected-address-value');
    const GEOAPIFY_KEY = "93b6baf239004502883ce91c706a42ef";

    function debounce(fn, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    const handleAutocomplete = debounce(function() {
        const query = input.value;
        if (query.length < 3) {
            suggestions.innerHTML = '';
            selectedAddressValue.value = '';
            return;
        }

        fetch(`https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(query)}&bias=proximity:-116.665,39.515&limit=10&apiKey=${GEOAPIFY_KEY}`)
            .then(response => response.json())
            .then(data => {
                suggestions.innerHTML = '';
                let count = 0;
                (data.features || []).forEach(feature => {
                    const props = feature.properties;
                    if (props.state !== "Nevada") return;
                    const formatted = [props.housenumber, props.street, props.state, props.postcode].filter(Boolean).join(' ');
                    if (!formatted) return;
                    const div = document.createElement('div');
                    div.textContent = formatted;
                    div.addEventListener('mousedown', function() {
                        input.value = formatted;
                        selectedAddressValue.value = formatted;
                        suggestions.innerHTML = '';
                    });
                    suggestions.appendChild(div);
                    count++;
                });
                if (count === 0) {
                    const div = document.createElement('div');
                    div.textContent = "No Nevada addresses found.";
                    suggestions.appendChild(div);
                }
            });
    }, 400);

    input.addEventListener('input', handleAutocomplete);

    document.addEventListener('mousedown', function(e) {
        if (!input.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.innerHTML = '';
        }
    });
</script>