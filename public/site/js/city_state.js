$('#state').change(function() {
    var state = $(this).val();
    // Clear city dropdown
    $('#city').html('<option value="">Select City</option>');
    if (state !== '') {
        // Fetch cities based on the selected state
        fetchCities(state)
            .then(function(cities) {
                // Populate city dropdown with fetched cities
                if (cities.length > 0) {
                    $.each(cities, function(index, city) {
                        $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                } else {
                    // No cities found for the selected state
                    $('#city').append('<option value="">No cities found</option>');
                }
                $('#city').selectpicker('refresh');
            })
            .catch(function(error) {
                console.error(error);
                // Handle error
            });
    }
});

function fetchCities(state) {
    return new Promise(function(resolve, reject) {
        // AJAX request to fetch cities based on the selected state
        $.ajax({
            url: "/get_cities",
            type: 'GET',
            dataType: 'json',
            data: {state: state},
            success: function(response) {
                resolve(response);
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    });
}
