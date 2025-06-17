$(document).ready(function () {
    // Load countries
    $.get("../ajax/get_location.php?type=country", function (data) {
        $("#country").html(data);
    });

    // On country change, load states
    $("#country").on("change", function () {
        let countryId = $(this).val();
        $.get("../api/fetch_states.php?country_id=" + countryId, function (data) {
            $("#state").html(data);
            $("#city").html('<option value="">Select State First</option>');
        });
    });

    // On state change, load cities
    $("#state").on("change", function () {
        let stateId = $(this).val();
        $.get("../api/fetch_cities.php?state_id=" + stateId, function (data) {
            $("#city").html(data);
        });
    });
});
